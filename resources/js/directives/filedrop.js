import axios from 'axios';

// put on an element like x-filedrop="{}
// pass data to the livewire component by specififcying an array of params like  x-filedrop="{ eventParams: [{{ $task->id }}] }"
// all options...
/*
    {
        eventParams: [],
        dragoverClass: ['bg-indigo-100', 'dark:bg-indigo-700'],
        eventName: 'saveFiles',
    }
 */

// TODO: We need upload progress, indiciators, cancel buttons, all kinds of stuff
export default function(el, { expression }, { evaluate, cleanup }) {

    const baseOptions = {
        eventName: 'saveFiles',
        dragoverClass: ['bg-indigo-100', 'dark:bg-indigo-700'],
        eventParams: [],
    }

    const livewireComponent = Livewire.find([el.closest("[wire\\:id]").getAttribute('wire:id')]);
    const givenOptions = evaluate(expression) ?? {};
    const options = Object.assign(baseOptions, givenOptions);

    const dragoverHandler = (e) => {
        e.preventDefault();
        // we detect if there are files because we don't want to highlight when sortable happens
        const hasFiles = Array.from(e.dataTransfer.items).filter(i => i.kind === 'file').length > 0;

        if(hasFiles) {
            el.classList.add(...options.dragoverClass)
        }
    }

    const dragexitHandler = (e) => {
        e.preventDefault();
        el.classList.remove(...options.dragoverClass);
    }

    const dropHandler = (e) => {
        // TODO: Don't fire when a sortable drop happens...?
        if(e.dataTransfer.files.length === 0) {
            return;
        }
        console.log('dropped', e);
        e.preventDefault();
        el.classList.remove(...options.dragoverClass);
        // console.log('cakked dropHandler', e, e.dataTransfer.files);
        livewireComponent.uploadMultiple('files', e.dataTransfer.files, (succ) => {
            console.log("usccess", succ, options.eventName, ...options.eventParams)
            Livewire.dispatch(options.eventName, options.eventParams);
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
