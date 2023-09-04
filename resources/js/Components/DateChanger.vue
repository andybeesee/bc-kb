<template>
    <div>
        <VueDatePicker
            :model-value="date"
            :range="false"
            :time-picker="false"
            :hide-navigation="['time']"
            auto-apply
            :month-change-on-scroll="false"
            @update:model-value="handleDateChange"
        >
            <template #trigger>
                <button class="px-2 border rounded border-zinc-300 hover:bg-zinc-100" type="button">
                    <span v-if="dateSelected">
                        {{ prefix }} {{ $filters.date(date) }}
                        <span title="Remove Date" class="ml-1 text-red-500 hover:text-red-600" @click.stop="remove">
                            <i class="fas fa-times-circle" ></i>
                        </span>
                    </span>
                    <span v-else>
                        {{ placeholder }}
                    </span>
                </button>
            </template>
            default slot?
        </VueDatePicker>
    </div>
</template>
<script>
import VueDatePicker from '@vuepic/vue-datepicker';
export default {
    components: {
        VueDatePicker,
    },
    props: {
        placeholder: { default: 'Select Date', type: String },
        date: { default: null },
        prefix: { default: '', type: String },
    },
    methods: {
        handleDateChange(e) {
            this.$emit('change', e.toISOString().slice(0, 10));
        },
        remove() {
            this.$emit('change', null);
        },
    },
    computed: {
        dateSelected() {
            return this.date;
        }
    }
}
</script>
