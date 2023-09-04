<template>
    <div v-if="status" class="flex items-center">
        {{ status.status }} {{ status.creator.name }} {{ $filters.datetime(status.created_at) }}
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
