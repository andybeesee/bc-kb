<template>
    <div>
        <Teleport to="body">
        <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-zinc-800 bg-opacity-75 transition-opacity"></div>

            <div  @click.self="sendClose" class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="mx-auto max-w-4xl mt-10">
                    <div class="flex items-center justify-between text-lg mb-2 bg-zinc-900 rounded px-3 py-2">
                        <div class="font-bold text-2xl">
                            <slot name="title">
                                Titel Goes Here
                            </slot>
                        </div>
                        <button @click="sendClose" class="text-4xl text-zinc-100 rounded-full hover:text-zinc-200" type="button">
                            <i class="fas fa-times-circle" />
                        </button>
                    </div>

                    <div class="text-zinc-900">
                        <slot />
                    </div>
                </div>
            </div>
        </div>
        </Teleport>
    </div>
</template>
<script>
export default {
    emits: ['close'],
    methods: {
        sendClose() {
            this.$emit('close');
            console.log('close');
        }
    }
}
</script>
