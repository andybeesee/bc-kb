<template>
    <div class="relative">
        <button
            @click="openDropdown"
            type="button"
            class="px-0.5 rounded hover:bg-zinc-100 dark:hover:bg-zinc-700"
        >
            {{ user?.name ?? placeholder }}


            <i class="ml-0.5 text-xs fas fa-caret-down" />
        </button>

        <div
            v-if="open"
            v-click-outside="closeDropdown"
            class="absolute bg-white dark:bg-zinc-700 z-10 max-h-[200px] overflow-y-scroll border border-zinc-300 rounded shadow"
        >
            <div  v-if="canRemove && user" class="p-1 cursor-pointer bg-red-100 dark:bg-red-700 dark:hover:bg-red-900" @click.stop="selectUser(null)">
                <i class="fas fa-times-circle" /> Remove
            </div>
            <div
                class="p-1 dark:text-zinc-200 cursor-pointer truncate hover:bg-zinc-100 dark:hover:bg-zinc-900"
                v-for="opt in options"
                :title="opt.name"
                :class="{
                    'bg-blue-800 text-white': opt.id === user?.id,

                }"
                @click="selectUser(opt.id)"
            >
                {{ opt.name }}
            </div>
        </div>
    </div>
</template>
<script>
export default {
    emits: ['change'],
    props: {
        placeholder: { default: 'Select Date', type: String },
        user: { default: null },
        canRemove: { default: true, type: Boolean },
    },
    data() {
        return {
            open: false,
            options: [],
            loading: false,
            search: '',
        };
    },
    methods: {
        closeDropdown() {
            this.open = false;
            this.options = [];
        },
        openDropdown() {
          this.open = true;
          this.loadOptions();
        },
        loadOptions() {
            this.loading = true;
            axios.get(`/api/users`, { params: {
                per_page: 200,
                include: this.user?.id,
                search: this.search
            }}).then((r) => {
                this.options = r.data.data;
                this.loading = false;
            })
        },
        selectUser(id) {
            this.$emit('change', id);
            this.closeDropdown();
        }
    }
}
</script>
