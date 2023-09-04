<template>
    <div v-if="status" class="flex items-center">
        Last Update {{ $filters.datetime(status.created_at) }}: {{ status.status }} {{ status.creator.name }}
    </div>
    <div v-else>
        No Status
    </div>
</template>
<script>
export default {
    props: {
        status: Object,
    },
}
</script>
