import { Controller } from '@hotwired/stimulus';
import Sortable from 'sortablejs';
import axios from 'axios';

export default class extends Controller {
    static values = {
        handleSelector: String,
        draggableSelector: String,
        url: String,
        autoSave: { type: Boolean, default: true },
    }

    static targets = [
        'item',
    ]

    connect() {
        if(!this.sortable) {
            const options = {
                animation: 120,
                onUpdate: this.handleUpdate.bind(this),
                ghostClass: ['dark:bg-zinc-600', 'bg-zinc-100'],
                // chosenClass: 'bg-brand-200',
                // dragClass: 'bg-gray-600',
            };

            if(this.draggableSelectorValue) {
                options.draggable = this.draggableSelectorValue;
            }

            if(this.handleSelectorValue) {
                console.log('we got handle selector...', this.handleSelectorValue);
                options.handle = this.handleSelectorValue;
            }

            this.sortable = new Sortable(this.element, options);
        }

        console.log(this.selectorValue, this.urlValue, this.sortable);
    }

    disconnect() {
        if(this.sortable) {
            this.sortable.destroy();
        }
    }

    handleUpdate() {
        if(this.autoSaveValue) {
            const items = this.itemTargets.map((el, index) => {
                return {
                    id: el.getAttribute('data-id'),
                    sort: index + 1,
                };
            });

            axios.put(this.urlValue, { items });
        }
    }
}
