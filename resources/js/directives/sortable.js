import Sortable from 'sortablejs';
import axios from 'axios';

export default function(el, { expression }, { evaluate, cleanup }) {
    const data = evaluate(expression);
    // console.log(data.url, data.options);
    const options = Object.assign({
        animation: 120,
        onUpdate: () => {
            // TODO: option for Livewire event?
            const attribute = data.idAttribute ?? 'data-sort-id';
            const items = Array.from(el.querySelectorAll(`[${attribute}]`)).map((el, index) => {
                return {
                    id: el.getAttribute(attribute),
                    sort: index + 1,
                };
            })

            if(data.url) {
                axios.put(data.url, { items });
            } else {
                console.log('event name is ', data.event ?? 'sorted');
                Livewire.emit(data.event ?? 'sorted', items);
            }
        },
        ghostClass: ['dark:bg-zinc-600', 'bg-zinc-100'],
    }, data.options);

    const sortableInstance = new Sortable(el, options);

    cleanup(() => {
        sortableInstance.destroy();
    })
}
