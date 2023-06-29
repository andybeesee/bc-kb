import './bootstrap';

import { Application } from '@hotwired/stimulus';
import { registerControllers } from './utils/stimulus-helpers';
import addActiveToLinks from "./utils/add-active-to-links";

const application = Application.start();
const controllers = import.meta.glob('./**/*_controller.js', { eager: true });
registerControllers(application, controllers);


function scrollStuffIntoView() {
    Array.from(document.querySelectorAll('[data-scroll-into-view]'))
        .forEach((el) => {
            console.log('scroll in to view', el);
            el.scrollIntoView();
        })
}

// document.addEventListener('turbo:load', addActiveToLinks);

window.onload = function() {
    addActiveToLinks();
    scrollStuffIntoView();

}

document.body.addEventListener('htmx:configRequest', (event) => {
    event.detail.headers['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
})

document.addEventListener('htmx:pushedIntoHistory', () => {
    addActiveToLinks();
    // scrollStuffIntoView();
});


