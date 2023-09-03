<template>
    <div class="flex items-center">
        {{ status.status }} {{ status.creator.name }} {{ status.created_at }}
    </div>
</template>
<script>
export default {
    props: {
        status: Object,
    },
}
</script>
