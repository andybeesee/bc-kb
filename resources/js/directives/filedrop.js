import axios from 'axios';

// TODO: We need upload progress, indiciators, cancel buttons, all kinds of stuff
export default function(el, { expression }, { evaluate, cleanup }) {

    const baseOptions = {
        dragoverClass: ['bg-indigo-100'],
        eventParams: [],
    }

    const livewireComponent = Livewire.find([el.closest("[wire\\:id]").getAttribute('wire:id')]);

    const givenOptions = evaluate(expression) ?? {};
    const options = Object.assign(baseOptions, givenOptions);

    const dragoverHandler = (e) => {
        e.preventDefault();
        el.classList.add(...options.dragoverClass)
    }

    const dragexitHandler = (e) => {
        e.preventDefault();
        el.classList.remove(...options.dragoverClass);
    }

    const dropHandler = (e) => {
        e.preventDefault();
        el.classList.remove(...options.dragoverClass);
        console.log('cakked dropHandler', e, e.dataTransfer.files);
        livewireComponent.uploadMultiple('files', e.dataTransfer.files, (succ) => {
            console.log("usccess", succ, ...options.eventParams)
            Livewire.emit('saveFiles', ...options.eventParams);
        }, (err) => {
            console.log('error', err);
        }, (evt) => {
            console.log('pgoress', evt);
        });
    }

    const filesAddedHandler = (e) => {
        e.preventDefault();
    }

    el.addEventListener('dragover', dragoverHandler);
    el.addEventListener('dragexit', dragexitHandler);
    el.addEventListener('drop', dropHandler);

    cleanup(() => {
        el.removeEventListener('dragover', dragoverHandler);
        el.removeEventListener('dragexit', dragexitHandler);
        el.removeEventListener('drop', dropHandler);
    })

}
