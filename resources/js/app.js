import axios from 'axios';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Mobile nav toggle (progressive enhancement — navbar works without JS too)
document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.querySelector('[data-mobile-nav-toggle]');
    const menu = document.querySelector('[data-mobile-nav-menu]');

    toggle?.addEventListener('click', () => menu?.classList.toggle('hidden'));
});
