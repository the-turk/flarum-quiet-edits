<?php
namespace TheTurk\QuietEdits\Listeners;

use Flarum\Post\Event\Revised as PostRevised;
use Flarum\Post\Event\Saving as PostSaving;
use Jfcherng\Diff\DiffHelper;
use Illuminate\Contracts\Events\Dispatcher;
use Flarum\Settings\SettingsRepositoryInterface;
use TheTurk\QuietEdits\Events\PostWasRevisedQuietly;
use TheTurk\QuietEdits\Events\PostWasRevisedLoudly;
use Carbon\Carbon;

class PostActions
{
    /**
     * @var Dispatcher
     */
    protected $events;

    /**
     * @var SettingsRepositoryInterface
     */
    protected $settings;

    /**
     * @var array
     */
    private $oldPost = [];

    /**
     * @param Dispatcher $events
     * @param SettingsRepositoryInterface $settings
     */
    public function __construct(
      Dispatcher $events,
      SettingsRepositoryInterface $settings
    )
    {
        $this->events = $events;
        $this->settings = $settings;
    }

    /**
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(PostRevised::class, [$this, 'whenPostRevised']);
        $events->listen(PostSaving::class, [$this, 'whenPostSaving']);
    }

    /**
     * Catch the content of the old post
     * just before saving the new one
     *
     * @param PostSaving $event
     */
    public function whenPostSaving(PostSaving $event)
    {
        $post = $event->post;
        if ($post->exists) $this->oldPost = $post->getOriginal();
    }

    /**
     * @param PostRevised $event
     */
    public function whenPostRevised(PostRevised $event)
    {
        $post = $event->post;
        $actor = $event->actor;

        $differOptions = [
            'context' => 0,
            'ignoreCase' => $this->settings->get('the-turk-quiet-edits.ignoreCase', true),
            'ignoreWhitespace' => $this->settings->get('the-turk-quiet-edits.ignoreWhitespace', true),
        ];

        $differ = DiffHelper::calculate(
            $post->getContentAttribute($this->oldPost['content']),
            $post->getContentAttribute($post->getOriginal('content')),
            'Json',
            $differOptions
        );

        $diff = json_decode($differ, true);

        $gracePeriod = $this->settings->get('the-turk-quiet-edits.gracePeriod', '120');
        $creationTime = ($this->oldPost['edited_at'] !== null
                          ? new Carbon($this->oldPost['edited_at'])
                          : new Carbon($post->created_at)
                        );

        if ($creationTime->diffInSeconds(Carbon::now()) < $gracePeriod || empty($diff)) {
            if ($this->oldPost['edited_at'] === null) {
                $post->edited_at = null;
            } else {
                $post->edited_at = $this->oldPost['edited_at'];
            }

            if ($this->oldPost['edited_user_id'] === null) {
                $post->edited_user_id = null;
            } else {
                $post->edited_user_id = $this->oldPost['edited_user_id'];
            }

            $post->save();

            $this->events->dispatch(
                new PostWasRevisedQuietly($post, $actor)
            );
        } else {
            $this->events->dispatch(
                new PostWasRevisedLoudly($post, $actor)
            );
        }
    }
}
