<template>
    <div>
        <div class="border-b flex items-center justify-between mb-4">
            <div class="flex items-center">
                <a class="p-2" href="/">
                    BC PMKB
                </a>
            </div>

            <div class="flex items-center">
                <!--a class="p-2 hover:bg-zinc-100" href="#">People</a-->
                <a class="p-2 hover:bg-zinc-100" href="#">Projects</a>
                <!--a class="p-2 hover:bg-zinc-100" href="#">Knowledge</a-->
                <!--a class="p-2 hover:bg-zinc-100" href="#">Requests</a-->
                <!--a class="p-2 hover:bg-zinc-100" href="#">Things</a-->
                <a class="p-2 hover:bg-zinc-100" href="#">Admin</a>
            </div>

            <div>
                <button type="button" class="p-2">
                    Sign out
                </button>
            </div>
        </div>
        <div class="mx-10 pb-10">
            <slot />
        </div>
    </div>
</template>
<script>

</script>
