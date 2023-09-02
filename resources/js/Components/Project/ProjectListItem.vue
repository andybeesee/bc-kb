<template>
    <div class="p-1">
        #{{ project.id }} {{ project.name }}
    </div>
</template>
<script>
export default {
    props: {
        project: Object,
    },
    data() {
        return {
            editing: false,
            updatingStatus: false,
            detailOpen: false,
        };
    },
}
</script>
