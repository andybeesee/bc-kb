import Sortable from 'sortablejs';
import axios from 'axios';

export default function(el, { expression }, { evaluate, cleanup }) {
    const data = evaluate(expression);
    // console.log(data.url, data.options);
    const options = Object.assign({
        animation: 120,
        onUpdate: () => {
            // TODO: option for Livewire event?
            const items = Array.from(el.querySelectorAll(`[data-sort-id]`)).map((el, index) => {
                return {
                    id: el.getAttribute('data-sort-id'),
                    sort: index + 1,
                };
            })

            axios.put(data.url, { items });
        },
        ghostClass: ['dark:bg-zinc-600', 'bg-zinc-100'],
    }, data.options);

    const sortableInstance = new Sortable(el, options);

    cleanup(() => {
        sortableInstance.destroy();
    })
}
