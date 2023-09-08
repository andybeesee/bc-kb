<template>
    <div>
        <input
            :id="uid"
            type="radio"
            :name="name"
            :value="value"
            :checked="value === modelValue"
            @change="$emit('update:modelValue', value)"
        />

        <label class="ml-1.5" :for="uid">{{ label }}</label>
    </div>
</template>
<script>
export default {
    props: {
        label: { type: String, default: 'Select' },
        value: { default: 'on' },
        modelValue: [String, Number],
        uid: { default: () => Math.random() },
        name: String,
    },

}
</script>
