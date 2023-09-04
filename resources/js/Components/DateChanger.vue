<template>
    <div>
        {{ date ?? placeholder }}
    </div>
</template>
<script>
export default {
    props: {
        placeholder: { default: 'Select Date', type: String },
        date: { default: null },
    },
}
</script>
