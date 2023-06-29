import { Controller } from "@hotwired/stimulus";
import { useClickOutside } from 'stimulus-use';

export default class extends Controller {
    static targets = [
        'content',
        'openIcon',
        'closedIcon',
        'openHide',
        'openShow',
    ]

    static values = {
        isOpen: Boolean,
        defaultOpen: { type: Boolean, default: false },
        clickOutsideClose: Boolean,
    }

    connect() {
        useClickOutside(this);
    }

    disconnect() {
        // collapse when disconnecting - easier way to work around turbo caching issue
        // we cactually pribably need something more sophisticated, like the toggle isn't updated until after cache?
        this.isOpenValue = this.defaultOpenValue;
    }

    close() {
        this.isOpenValue = false;
    }

    toggle() {
        this.isOpenValue = !this.isOpenValue;


        if(this.isOpenValue && this.hasContentTarget) {
            setTimeout(() => {

                const focusEl = this.contentTarget.querySelector('input[type="text"],textarea');

                if(focusEl) {
                    focusEl.focus();
                }
            }, 75);
        }
    }

    isOpenValueChanged(isOpen) {
        console.log('openv changed!?', isOpen);
        if(this.hasContentTarget) {
            this.contentTarget.style.display = isOpen ? '' : 'none';
        }

        if(this.hasOpenIconTarget) {
            this.openIconTarget.style.display = isOpen ? '' : 'none';
        }

        if(this.hasClosedIconTarget) {
            this.closedIconTarget.style.display = isOpen ? 'none' : '';
        }

        if(this.hasOpenHideTarget) {
            this.openHideTarget.style.display = isOpen ? 'none' : ''
        }
    }

    clickOutside(e) {
        if(this.clickOutsideCloseValue && this.isOpenValue) {
            this.isOpenValue = false;
        }
    }
}
