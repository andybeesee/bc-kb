import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static values = {
        isOpen: { type: Boolean, default: false },
    }

    static targets = [
        'content',
        'closedIcon',
        'openIcon',
    ]

    disconnect() {
        document.removeEventListener('click', this.handleClick.bind(this));
    }

    toggle(e) {
        this.isOpenValue = !this.isOpenValue;
    }

    isOpenValueChanged(isOpen) {
        this.contentTarget.style.display = isOpen ? '' : 'none';

        if(this.hasOpenIconTarget) {
            this.openIconTarget.style.display = isOpen ? '' : 'none'
        }

        if(this.hasClosedIconTarget) {
            this.closedIconTarget.style.display = isOpen ? 'none' : '';
        }

        if(isOpen) {
            document.addEventListener('click', this.handleClick.bind(this));
        } else {
            document.removeEventListener('click', this.handleClick.bind(this));
        }
    }

    handleClick(e) {
        if(!this.element.contains(e.target)) {
            this.isOpenValue = false;
        }
    }
}
