import './bootstrap';

// import * as Turbo from '@hotwired/turbo';
import * as htmx from 'htmx.org';
window.htmx = htmx;

import { Application } from '@hotwired/stimulus';
import { registerControllers } from './utils/stimulus-helpers';
import addActiveToLinks from "./utils/add-active-to-links";

const application = Application.start();
const controllers = import.meta.glob('./**/*_controller.js', { eager: true });
registerControllers(application, controllers);


document.addEventListener('turbo:load', addActiveToLinks);


window.onload = function() {
    addActiveToLinks();
}

document.body.addEventListener('htmx:configRequest', (event) => {
    event.detail.headers['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
})

document.addEventListener('htmx:pushedIntoHistory', addActiveToLinks);


