import $ from 'jquery';
window.$ = window.jQuery = $ = require('jquery');
window.Cookies = require('js-cookie');
window.jRespond = require('jrespond');
window.Swiper = require('swiper').default;
window.skrollr = require('skrollr');
window.Isotope = require('isotope-layout');
window.Instafeed = require('instafeed.js');
window.toastr = require('toastr');

require('sweetalert');
require('jquery-ui');
window._ = require('lodash');

var jQueryBridget = require('jquery-bridget');
var Isotope = require('isotope-layout');
// make Isotope a jQuery plugin
jQueryBridget( 'isotope', Isotope, $ );

import 'owl.carousel';
import 'flexslider'
import 'infinite-scroll'
import 'lazyload'
require('../assets/jquery.appear');
require('../assets/jquery.fitvids');
require('../assets/jquery.jflickrfeed.min.js');
require('../assets/jquery.jribbble');
require('../assets/morphext.min.js');
require('../assets/helper');

import 'magnific-popup'
import 'superfish'
import 'jribbble';
import 'animsition';
import 'jquery-validation'
import 'jquery-form'
import 'theia-sticky-sidebar'
import 'jquery.mb.ytplayer'
import 'jquery-ui/ui/widgets/tabs';
import 'jquery-countto';
import 'easy-pie-chart/dist/jquery.easypiechart.min';
import imagesLoaded from 'imagesloaded';
imagesLoaded.makeJQueryPlugin( $ );
/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
    require('swiper');
    require('owl.carousel');
    require('flexslider');
    require('infinite-scroll');
    require('isotope-layout');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo'

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    encrypted: true
});
