import './bootstrap';

import { createPopper } from '@popperjs/core';
import addActiveToLinks from "./utils/add-active-to-links";
import sortableDirective from './directives/sortable.js';

window.createPopper = createPopper;

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.directive('sortable', sortableDirective)
Alpine.start();

function scrollStuffIntoView() {
    Array.from(document.querySelectorAll('[data-scroll-into-view]'))
        .forEach((el) => {
            console.log('scroll in to view', el);
            el.scrollIntoView();
        })
}

window.onload = function() {
    addActiveToLinks();
    scrollStuffIntoView();
}
