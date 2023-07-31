import Sortable from 'sortablejs';
import axios from 'axios';

export default function(el, { expression }, { evaluate, cleanup }) {
    const data = evaluate(expression);

    const pullItems = function(element, attribute) {
        return Array.from(element.querySelectorAll(`[${attribute}]`)).map((el, index) => {
            return {
                id: el.getAttribute(attribute),
                sort: index + 1,
            };
        })
    }

    // console.log(data.url, data.options);
    const options = Object.assign({
        animation: 120,
        onMove(e) {
            console.log('on move called...');
        },
        onAdd(e) {
            console.log('item added from another list', e);
            const itemAttribute = data.idAttribute ?? 'data-sort-id';
            const itemId = e.item.getAttribute(itemAttribute);
            const groupId = e.to.getAttribute('data-group-id') ?? null

            Livewire.dispatch('movedList', [itemId, groupId, pullItems(e.to, itemAttribute)]);
        },
        onEnd(e) {
            if(e.type === 'add') {
                // the onAdd method will handle this
                // return;
            }

            console.log('caught update',{ e })
            // TODO: option for Livewire event?
            const attribute = data.idAttribute ?? 'data-sort-id';

            const groupId = e.to.hasAttribute('data-group-id') ? e.to.getAttribute('data-group-id') : null;

            const items = pullItems(e.target, attribute);

            if(data.url) {
                axios.put(data.url, { items });
            } else {
                console.log('event name is ', data.event ?? 'sorted');
                Livewire.dispatch(data.event ?? 'sorted', [items, groupId]);
            }
        },
        ghostClass: ['dark:bg-zinc-600', 'bg-zinc-100'],
    }, data.options ?? {});

    const sortableInstance = new Sortable(el, options);

    cleanup(() => {
        sortableInstance.destroy();
    })
}
