import { isNull, isString } from 'lodash';

const addClasses = function(el, classList)
{
    if(isNull(classList) || classList === '') {
        return;
    }

    if(isString(classList)) {
        classList = classList.split(' ');
    }

    classList.forEach((c) => el.classList.add(c));
}

const removeClasses = function(el, classList)
{
    if(isNull(classList) || classList === '') {
        return;
    }

    if(isString(classList)) {
        classList = classList.split(' ');
    }

    classList.forEach((c) => el.classList.remove(c));
}

const updateOptionSelected = function(element, isActive)
{
    if(isActive) {
        element.setAttribute('selected', 'selected');
    } else {
        element.removeAttribute('selected');
    }
}

export const updateActiveStateOnElement = function(element, current) {
    // this function adds 'active' class to links on a page
    // console.log('got el', element);
    if(element.getAttribute('data-never-active')) {
        return;
    }

    const href = element.hasAttribute('href') ? element.getAttribute('href') : element.getAttribute('data-href');
    const linkIsActive = element.getAttribute('data-exact-active') ? (current === href) : (current.indexOf(href) > -1);
    const activeClasses = element.hasAttribute('data-active-class') ? element.getAttribute('data-active-class') : 'active';
    const inactiveClasses = element.getAttribute('data-inactive-class');

    if(element.tagName.toLowerCase() === 'option') {
        updateOptionSelected(element, linkIsActive);
        return;
    }

    if(linkIsActive) {
        // console.log('   is active');
        addClasses(element, activeClasses);
        removeClasses(element, inactiveClasses);
    } else {
        // console.log('   not active');
        removeClasses(element, activeClasses);
        addClasses(element, inactiveClasses);
    }
}

export default function(e) {
    const current = e ? e.detail.url : (new URL(window.location)).toString().replace('#', '');
    document.querySelectorAll(`a,[data-href]`).forEach((l) => updateActiveStateOnElement(l, current));
}
