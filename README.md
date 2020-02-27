# Quiet Edits for Flarum

[![MIT license](https://img.shields.io/badge/license-MIT-blue.svg)](https://github.com/the-turk/flarum-quiet-edits/blob/master/LICENSE) [![Latest Stable Version](https://img.shields.io/packagist/v/the-turk/flarum-quiet-edits.svg)](https://packagist.org/packages/the-turk/flarum-quiet-edits) [![Total Downloads](https://img.shields.io/packagist/dt/the-turk/flarum-quiet-edits.svg)](https://packagist.org/packages/the-turk/flarum-quiet-edits)

Lately i've been obsessed with edit functions. 😂

As i promised in @Kylo#121339, this is a preparation for next version of my [Diff extension](https://discuss.flarum.org/d/22779-diff-for-flarum). I'm not sure if i picked the right title for this extension 🤔. Anyways, edits made within the grace period immediately after posting will not be considered as formal edits. You can also ignore whitespace and case differences independently from the grace period.

- Then again, it's based on @jfcherng's [diff](https://github.com/jfcherng/php-diff) repository.
- Extension's icon made by [Freepik](https://www.flaticon.com/authors/freepik).

It raises new events for developers, called `PostWasRevisedQuietly` & `PostWasRevisedLoudly`

**! Attention: Diff for Flarum & Edit Notifications extensions are incompatible with this right now and they're planned to be compatible on their next releases.**

![Settings](https://i.ibb.co/nsX8nrX/shsh.png)

## Requirements

![php](https://img.shields.io/badge/php-%5E7.1.3-blue?style=flat-square) ![ext-iconv](https://img.shields.io/badge/ext-iconv-brightgreen?style=flat-square)

You can check your php version by running `php -v` and check if `iconv` is installed by running `php --ri iconv` (which should display `iconv support => enabled`).

## Installation

Use [Bazaar](https://discuss.flarum.org/d/5151) or install manually:

```bash
composer require the-turk/flarum-quiet-edits
```

## Updating

```bash
composer update the-turk/flarum-quiet-edits
php flarum cache:clear
```

## Usage

Enable the extension. The grace period is 120 seconds, whitespace and case differences will be ignored by default.

## Links

- [Flarum Discuss post](https://discuss.flarum.org/d/22916-quiet-edits)
- [Source code on GitHub](https://github.com/the-turk/flarum-quiet-edits)
- [Changelog](https://github.com/the-turk/flarum-quiet-edits/blob/master/CHANGELOG.md)
- [Report an issue](https://github.com/the-turk/flarum-quiet-edits/issues)
- [Download via Packagist](https://packagist.org/packages/the-turk/flarum-quiet-edits)
