<template>
    <div title="User" class="flex items-center">
        <i class="far fa-user mr-2 text-zinc-500" />
        {{ user.name }}
    </div>
</template>
<script>
// TODO: Support avatar icon
export default {
    props: {
        user: Object,
    }
}
</script>
