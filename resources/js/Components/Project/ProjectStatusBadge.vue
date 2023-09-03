<template>
    <div>
        <div class="px-2 rounded" :class="statusBadgeClasses">
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
    },
    computed: {
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
