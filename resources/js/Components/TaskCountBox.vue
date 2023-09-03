<template>
    <div class="grid grid-cols-5 text-xs text-center">
        <div
            title="Total tasks"
            class="bg-white border-y truncate border-x"
            :class="{
                'bg-white': counts.tasks_count > 0,
                'bg-zinc-800 text-white': counts.tasks_count === 0,
            }"
        >
            {{ counts.tasks_count }}
        </div>
        <div
            title="Incomplete"
            class="border-y truncate border-x"
            :class="{
                'bg-zinc-300 text-black': counts.incomplete_tasks_count > 0,
                'bg-zinc-100 text-zinc-400': counts.incomplete_tasks_count === 0,
            }"
        >
            {{ counts.incomplete_tasks_count }}
        </div>
        <div
            title="Past Due"
            class="bg-red-100 border-y truncate"
            :class="{
                'bg-red-800 text-white': counts.past_due_tasks_count > 0,
                'bg-red-100 text-red-300': counts.past_due_tasks_count === 0,
            }"
        >
            {{ counts.past_due_tasks_count }}
        </div>
        <div title="Your Incomplete Tasks"
             :class="{
                'bg-blue-800 text-white': counts.incomplete_user_tasks_count > 0,
                'bg-blue-100 text-blue-300': counts.incomplete_user_tasks_count === 0,
            }" class="border-y truncate border-x">{{ counts.incomplete_user_tasks_count }}</div>
    </div>
</template>
<script>
export default {
    props: {
        counts: Object,
    }
}
</script>
