<template>
    <div class="justify-between flex items-center">
        <div class="font-medium text-zinc-600">
            Showing {{ paginator.from }} to {{ paginator.to }} of {{ paginator.total }}
        </div>
        <div class="flex items-center">
            <button title="First Pge" @click="$emit('change', 1)" class="border-l border-y rounded-l-md px-3 py-1 hover:bg-zinc-100" v-if="!paginator.on_first_page">
                <i class="far fa-chevron-double-left"></i>
            </button>
            <div title="First Page" class="border-l border-y rounded-l-md px-3 py-1 bg-zinc-50" v-else>
                <i class="far fa-chevron-double-left"></i>
            </div>
            <button title="Previous Pge" @click="$emit('change', paginator.previous_page)" class="border-l border-y px-3 py-1 hover:bg-zinc-100" v-if="paginator.previous_page">
                <i class="far fa-chevron-left"></i>
            </button>
            <div title="Previous Page" class="border-l border-y px-3 py-1 bg-zinc-50" v-else>
                <i class="far fa-chevron-left"></i>
            </div>
            <div class="relative">
                <button class="border-x border-y px-3 py-1" type="button" @click="isOpen = true">
                    Page {{ paginator.current }} of {{ paginator.last_page }}
                </button>
                <div v-if="isOpen" class="min-w-[100px] divide-y max-h-[200px] grid bg-white overflow-y-scroll absolute rounded-md  shadow" v-click-outside="closeDropdown">
                    <button class="p-1 text-left hover:bg-zinc-100" v-for="link in pages" type="button" @click="$emit('change', link); isOpen = false">
                        {{ link }}
                    </button>
                </div>
            </div>

            <button title="Next Pge" @click="$emit('change', paginator.next_page)" class="border-r border-y px-3 py-1 hover:bg-zinc-100" v-if="paginator.next_page">
                <i class="far fa-chevron-right"></i>
            </button>
            <div title="Next Page" class="border-r border-y px-3 py-1 bg-zinc-50" v-else>
                <i class="far fa-chevron-right"></i>
            </div>
            <button @click="$emit('change', paginator.last_page)" class=" border-y border-r rounded-r-md px-3 py-1 hover:bg-zinc-100" v-if="!paginator.on_last_page">
                <i class="far fa-chevron-double-right"></i>
            </button>
            <div class=" border-y border-r rounded-r-md px-3 py-1 bg-zinc-50" v-else>
                <i class="far fa-chevron-double-right"></i>
            </div>
        </div>
    </div>
</template>
<script>
// TODO: We need icons
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
    methods: {
        closeDropdown() {
            this.isOpen = false
        },
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
