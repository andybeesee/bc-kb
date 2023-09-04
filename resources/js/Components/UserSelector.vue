<template>
    <div>
        {{ user?.name ?? placeholder }}
    </div>
</template>
<script>
export default {
    props: {
        placeholder: { default: 'Select Date', type: String },
        user: { default: null },
    },
}
</script>
