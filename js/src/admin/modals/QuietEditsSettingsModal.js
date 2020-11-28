import app from 'flarum/app';
import SettingsModal from 'flarum/components/SettingsModal';
import Switch from 'flarum/components/Switch';

// just to make things easier
const settingsPrefix = 'the-turk-quiet-edits.';
const localePrefix = settingsPrefix + 'admin.settings.';

export default class QuietEditsSettingsModal extends SettingsModal {
  title() {
    return app.translator.trans(localePrefix + 'title');
  }

  /**
   * Build modal form.
   *
   * @returns {*}
   */
  form() {
    return [
      m('.Form-group', [
          m('label', app.translator.trans(localePrefix + 'gracePeriod')),
          m('.helpText', app.translator.trans(localePrefix + 'gracePeriodHelp')),
              m('div',
                  { className: 'helpText' },
                  m('i', {
                      className: 'quietEditsSettingsIcon fas fa-exclamation-circle'
                  }),
                  m('span', app.translator.trans(localePrefix + 'onlyUnsigned')),
              ),
              m('input[type=text].FormControl', {
                  bidi: this.setting(settingsPrefix + 'gracePeriod', '120'),
                  placeholder: '120'
              })
      ]),
      m('.Form-group', [
          m('label', Switch.component({
              state: this.setting(settingsPrefix + 'ignoreCase', '1')() === '1',
              onchange: value => {
                this.setting(settingsPrefix + 'ignoreCase')(value ? '1' : '0');
              }
          }, app.translator.trans(localePrefix + 'ignoreCase')))
      ]),
      m('.Form-group', [
          m('label', Switch.component({
              state: this.setting(settingsPrefix + 'ignoreWhitespace', '1')() === '1',
              onchange: value => {
                this.setting(settingsPrefix + 'ignoreWhitespace')(value ? '1' : '0');
              }
          }, app.translator.trans(localePrefix + 'ignoreWhitespace')))
      ]),
    ];
  }
}
