window._ = require('lodash');
window.Popper = require('popper.js').default;

try {
    window.$ = window.jQuery = require('jquery');
    require("flatpickr");
    require("flatpickr/dist/l10n/es");
    require('bootstrap');
} catch (e) {
}
