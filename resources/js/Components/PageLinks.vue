<template>
    <div class="flex items-center">
        <button @click="$emit('change', 1)" class="border rounded-l-md px-2 py-1 hover:bg-zinc-100" v-if="!paginator.on_first_page">
            First page
        </button>
        <div class="border rounded-l-md px-2 py-1 bg-zinc-50" v-else>
            First page
        </div>
        <button class="border-y px-2 py-1" type="button" @click="isOpen = !isOpen">
            Page {{ paginator.current }} of {{ paginator.last_page }}
        </button>
        <button @click="$emit('change', paginator.last_page)" class="border border-r rounded-r-md px-2 py-1 hover:bg-zinc-100" v-if="!paginator.on_last_page">
            Last Page
        </button>
        <div class="border rounded-r-md px-2 py-1 bg-zinc-50" v-else>
            Last page
        </div>
    </div>
</template>
<script>

export default {
    emits: ['change'],
    props: {
        paginator: Object,
    },
    data() {
        return {
            links: [],
            isOpen: false,
        };
    },
    computed: {
        pages() {
            const links = [];
            for(let i = 1; i <= this.paginator.last_page; i++) {
                links.push(i)
            }

            return links;
        }
    }
}
</script>
