<template>
    <div>
        <div :title="titleCaseStatus" v-if="iconOnly">
            <i class="rounded-full my-auto" :class="statusIconClasses" />
        </div>
        <div class="px-2 rounded" :class="statusBadgeClasses"  v-else>
            {{ titleCaseStatus }}
        </div>
    </div>
</template>
<script>
import CurrentStatusBadge from "../CurrentStatusBadge.vue";

export default {
    components: {CurrentStatusBadge},
    props: {
        project: Object,
        iconOnly: { type: Boolean, default: false }
    },
    computed: {
        statusIconContainerClasses() {

        },
        statusIconClasses() {
            switch (this.project.status) {
                case 'abandoned':
                    return 'fas fa-ban text-orange-800 dark:text-orange-400';
                case 'late':
                    return 'fas fa-clock text-red-800 dark:text-red-400';
                case 'in_progress':
                    return 'fas fa-clock text-blue-800 dark:text-blue-400';
                case 'complete':
                    return 'fas fa-check-circle text-emerald-800 dark:text-emerald-400';
                case 'pending':
                    return 'fas fa-circle text-purple-800 dark:text-purple-400';
                case 'idea':
                default:
                    return 'fas fa-lightbulb text-zinc-800 dark:text-zinc-400';
            }
        },
        statusBadgeClasses() {
            switch (this.project.status) {
                case 'abandoned':
                    return 'bg-orange-100 text-orange-800';
                case 'late':
                    return 'bg-red-100 text-red-800';
                case 'in_progress':
                    return 'bg-blue-100 text-blue-800';
                case 'complete':
                    return 'bg-emerald-100 text-emerald-800';
                case 'pending':
                    return 'bg-purple-100 text-purple-800';
                case 'idea':
                    default:
                    return 'bg-zinc-100 text-zinc-800';
            }
        },
        titleCaseStatus() {
            return this.project.status.replace('_', ' ')
                .split(' ')
                .map(w => `${w[0].toUpperCase()}${w.slice(1)}`)
                .join(' ')
        },
    }
}
</script>
