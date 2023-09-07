<template>
    <div class="relative">
        <button
            @click="openDropdown"
            type="button"
            class="hover:bg-zinc-100 dark:hover:bg-zinc-700 rounded border border-zinc-300 px-2"
        >
            {{ user?.name ?? placeholder }}

            <span  v-if="user" class="text-red-600 hover:text-red-800" @click.stop="selectUser(null)">
                <i class="fas fa-times-circle" />
            </span>
            <i class="ml-1 text-xs fas fa-caret-down" />
        </button>

        <div
            v-if="open"
            v-click-outside="closeDropdown"
            class="absolute bg-white dark:bg-zinc-700 z-10 max-h-[200px] overflow-y-scroll border border-zinc-300 rounded shadow"
        >
            <div
                class="p-1 cursor-pointer truncate hover:bg-zinc-100 dark:hover:bg-zinc-900"
                v-for="opt in options"
                :title="opt.name"
                :class="{
                    'bg-blue-800 text-white': opt.id === user?.id,

                }"
                @click="selectUser(opt.id)"
            >
                {{ opt.name }}
            </div>
            user selecter
        </div>
    </div>
</template>
<script>
export default {
    emits: ['change'],
    props: {
        placeholder: { default: 'Select Date', type: String },
        user: { default: null },
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
