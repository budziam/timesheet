window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

window.$ = window.jQuery = require('jquery');

require('bootstrap-sass');
require('select2/dist/js/select2.full');
require('select2/dist/js/i18n/pl');

window.moment = require('moment');
require('./functions');

/**
 * Vue is a modern JavaScript library for building interactive web interfaces
 * using reactive data binding and reusable components. Vue's API is clean
 * and simple, leaving you to focus on building your next great project.
 */

window.Vue = require('vue');
require('./common/event');

window.axios = require('axios');
window.axios.defaults.headers.common = {
    'X-CSRF-TOKEN': Laravel.csrfToken,
    'X-Requested-With': 'XMLHttpRequest',
};


Vue.component('v-select', require('./common/components/select'));
Vue.component('v-form', require('./common/components/form'));
Vue.component('v-calendar', require('./common/components/calendar/core'));

Vue.use(require('./common/translation'), {
    url: Laravel.url + '/api/translations'
});