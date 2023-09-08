<template>
    <div title="Team" class="flex items-center">
        <i class="far fa-users mr-2 text-zinc-500" />
        {{ team.name }}
    </div>
</template>
<script>
// TODO: Support custom icons
// TODO: Support changing team from here
export default {
    props: {
        team: Object,
    }
}
</script>
