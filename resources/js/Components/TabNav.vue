<template>
    <div class="p-1 bg-zinc-300 dark:bg-zinc-600 rounded-md space-x-1 flex justify-between">
        <button
            v-for="tab in tabs"
            type="button"
            :class="{
                'p-1 flex-grow rounded-md text-center': true,
                'bg-white dark:bg-zinc-900 font-semibold hover:bg-zinc-50 dark:hover:bg-zinc-700': tab.id === active,
                'hover:bg-zinc-50 dark:hover:bg-zinc-700': tab.id !== active,

            }"
            @click="$emit('change', tab.id)"
        >
            {{ tab.name }}
        </button>
    </div>
</template>
<script>
export default {
    emits: ['change'],
    props: {
        tabs: Array,
        active: String,
    }
}
</script>
