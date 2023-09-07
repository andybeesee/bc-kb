<template>
    <div :class="{ 'bg-yellow-100 dark:bg-yellow-500 text-black px-2 rounded': changing }">
        <Modal v-if="changing" @close="changing = false">
            <template #title>Changing Status</template>
            <div class="bg-white p-4 rounded">
                <CurrentStatusForm
                    @change="handleChange"
                    :type="type"
                    :id="id"
                    :current="showStatus"
                />
            </div>
        </Modal>
        <div v-if="showStatus" class="flex items-center">
            Last Update {{ $filters.datetime(showStatus.created_at) }}: {{ showStatus.status }} {{ showStatus.creator.name }}
            <button class="ml-2 px-1 bg-zinc-100 dark:bg-zinc-900 border rounded text-xs hover:bg-zinc-200 dark:hover:bg-zinc-700" type="button" @click="changing = true">Change Status</button>
        </div>
        <div v-else>
            No Status
            <button class="ml-2 px-1 bg-zinc-100 dark:bg-zinc-900 border rounded text-xs hover:bg-zinc-200 dark:hover:bg-zinc-700" @click="changing = true" type="button">Add Status</button>
        </div>
    </div>
</template>
<script>
import Modal from "./Modal.vue";
import CurrentStatusForm from "./CurrentStatusForm.vue";

export default {
    components: {CurrentStatusForm, Modal},
    props: {
        status: Object,
        type: String,
        id: [Number, String],
    },
    data() {
        return {
            changing: false,
            updated: null,
        };
    },
    methods: {
        handleChange(newStatus) {
            this.updated = newStatus;
            this.changing = false;
        }
    },
    computed: {
        showStatus() {
            if(this.updated) {
                return this.updated;
            }

            return this.status;
        }
    }
}
</script>
