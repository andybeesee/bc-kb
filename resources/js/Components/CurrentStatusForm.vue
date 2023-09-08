<template>
    <div>
        <div v-if="current" class="bg-blue-800 text-white p-3 mb-4 rounded">
            <div class="font-semibold text-sm mb-1">Current status is:</div>
            {{ current.status }}
        </div>

        <form @submit.prevent="saveNew">
            <Textarea v-model="newStatus" label="New Status" />

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                    Update Status
                </button>
                <button type="button" class="ml-3 btn btn-white">
                    Nevermind
                </button>
            </div>
        </form>
    </div>
</template>
<script>
import Textarea from "./Form/Textarea.vue";
import axios from "axios";

export default {
    components: {Textarea},
    emits: ['change', 'cancel', 'status-updated'],
    props: {
        type: String,
        current: { type: Object, default: null },
        id: [String, Number],
    },
    beforeMount() {
        if(!this.current) {
            this.loadCurrent()
        } else {
            this.currentStatus = Object.assign({}, this.current);
        }
    },
    data() {
        return {
            currentStatus: null,
            saving: false,
            newStatus: '',
        };
    },
    methods: {
        loadCurrent() {
            axios.get(route('api.current-statuses.current', [this.type, this.id]))
                .then((r) => this.current = r.data);
        },
        saveNew() {
            axios.post(route('api.current-statuses.store', [this.type, this.id]), {
                status: this.newStatus,
            })
            .then((r) => {
                this.$emit('change', r.data);
                this.$emit('status-updated', { type: this.type, id: this.id, status: r.data });
            });
        },
    },
}
</script>
