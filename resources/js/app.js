/**
 * We'll load Axios and the Bootstrap plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {

	// Axios modules
	window.axios = require('axios');
	window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

	// Popper.js that required by bootstrap popovers and tooltips
	require('@popperjs/core');

	// Bootstrap v5 Vanilla.js
	window.bootstrap = require('bootstrap');

	// UI block
	window.UI = require('./ui-block');

	[].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]')).map(function (el) {
		return new bootstrap.Popover(el, {
			el: 'focus',
			html: true
		});
	});

	[].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]')).map(function (el) {
	    return new bootstrap.Tooltip(el);
	});

	// Tom seelct
	require('tom-select');

	// Custom
	require('./d-bootstrap/sidebar');
	require('./d-bootstrap/daterangepicker');
	require('./custom');

} catch (e) {}
