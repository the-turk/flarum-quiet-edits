import app from 'flarum/app';
import QuietEditsSettingsModal from "./modals/QuietEditsSettingsModal";

app.initializers.add('the-turk/quiet-edits', app => {
  app.extensionSettings['the-turk-quiet-edits'] =
    () => app.modal.show(QuietEditsSettingsModal);
});
