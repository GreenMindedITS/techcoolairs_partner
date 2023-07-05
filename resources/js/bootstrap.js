window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
    require('jquery-ui-bundle');
    require('jquery-validation');

    require('bootstrap');
    require('select2');
    
    require('datatables.net'); 
    require('datatables.net-bs4');require('bootstrap');
    require('jsgrid');
       
    // require('bootstrap-datetimepicker-npm');
    window.moment = require('moment');
    require('moment-timezone');
    require('tempusdominus-bootstrap-4');
    require('inputmask');
    require('daterangepicker');

    require('chart.js');

    const toastr = window.toastr = require('toastr');
    const swal = window.swal = require('sweetalert2');
} catch (e) {
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });