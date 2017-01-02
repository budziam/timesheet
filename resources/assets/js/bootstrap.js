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
require('vue-resource');
require('./common/event');

/**
 * We'll register a HTTP interceptor to attach the "CSRF" header to each of
 * the outgoing requests issued by this application. The CSRF middleware
 * included with Laravel will automatically verify the header's value.
 */

Vue.http.interceptors.push((request, next) => {
    request.headers.set('X-CSRF-TOKEN', Laravel.csrfToken);

    next();
});

Vue.http.options.emulateHTTP = true;
Vue.http.options.emulateJSON = true;

Vue.component('v-select', require('./common/components/select'));
Vue.component('v-form', require('./common/components/form'));
Vue.component('v-calendar', require('./common/components/calendar/core'));

Vue.use(require('./common/translation'), {
    url: Laravel.url + '/api/translations'
});