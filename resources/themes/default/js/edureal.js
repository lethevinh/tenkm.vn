console.log('Edureal init');

import $ from 'jquery';

window.$ = window.jQuery = $;
window.Swal = require('sweetalert2');
require('jquery-countdown');
require('waypoints/lib/jquery.waypoints.min');
require('lightbox2');
require('jquery-countto');
require('owl.carousel');
require('bootstrap');
require('@housfy/x-editable/dist/bootstrap3-editable/js/bootstrap-editable.min');
window.AOS = require('aos');
window._ = require('lodash');
window.edureal = window.edureal ? window.edureal : {};
/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */
$.ajaxSetup({
    headers: {
        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
    }
});
try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
    window.Swal = require('sweetalert2');
    require('jquery-countdown');
    require('waypoints/lib/jquery.waypoints.min');
    require('lightbox2');
    require('jquery-countto');
    require('owl.carousel');
    require('bootstrap');
    window._ = require('lodash');
} catch (e) {}

const keyLang = '__lang';
window.edureal.checkLogin = function () {
    return localStorage.getItem('__token');
};
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

let lang = window.edureal.language = document.querySelector('html').lang??'vi';
let csrf = document.head.querySelector('meta[name="csrf-token"]');
let token = window.edureal.checkLogin();

if (csrf) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = csrf.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
if (token) {
    window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
} else {
// console.error('Authorization token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
window.axios.defaults.withCredentials = true;

async function loadLang() {
    let langStorage = await localStorage.getItem(keyLang);
    if (langStorage) {
        window.langs = JSON.parse(langStorage);
        return;
    }
    let response = await axios.get('/lang/' + lang + '.json');
    await localStorage.setItem(keyLang, JSON.stringify(response.data))
    window.langs = response.data;
    location.reload();
}

loadLang().then(r => {});
window.trans = function (key) {
    if (!window.langs) return key;
    let keys = key.split('.');
    let item = window.langs;
    let value = key;
    keys.forEach((k, i) => {
        if (item[k]) {
            item = item[k];
        }
    });
    if (typeof item === "string") {
        value = item;
    }
    return value;
};
(function () {
    // Timer Count Down
    let $eventTimer = $('#event__timer');
    let $eventStartDate = $('[data-event-date]');
    if ($eventTimer.length > 0 && $eventTimer.text() === '' && $eventStartDate.length > 0) {
        $eventTimer.countdown($eventStartDate.attr('data-event-date'), function (event) {
            if (event.type === 'update') {
                let $this = $(this).html(event.strftime(''
                    + '<span>%w</span> Tuần '
                    + '<span>%d</span> Ngày '
                    + '<span>%H</span> Giờ '
                    + '<span>%M</span> Phút '
                    + '<span>%S</span> Giây'));
            }
        });
    }
    // Map
    let mapContent = $('#map');
    if (mapContent.length > 0 && mapContent.attr('data-lat-long')) {
        let latlong = mapContent.attr('data-lat-long').split(',');
        let myLatLng = {lat: parseFloat(latlong[0]), lng:  parseFloat(latlong[1])};
        let styleArray = [
            {
                "featureType": "all",
                "stylers": [
                    {
                        "saturation": 0
                    },
                    {
                        "hue": "#e7ecf0"
                    }
                ]
            },
            {
                "featureType": "road",
                "stylers": [
                    {
                        "saturation": -70
                    }
                ]
            },
            {
                "featureType": "transit",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "poi",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "water",
                "stylers": [
                    {
                        "visibility": "simplified"
                    },
                    {
                        "saturation": -60
                    }
                ]
            }
        ];
        let mapOptions = {
            zoom: 12,
            center: myLatLng,
            styles: styleArray,
            scrollwheel: false
        };
        let map = new google.maps.Map(document.getElementById('map'), mapOptions);
        let image = 'assets/img/map_marker.png';
        let marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            icon: image,
            title: 'Edureal'
        });
    }
})();
/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });

