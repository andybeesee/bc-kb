<template>
    <div class="">
        <label v-if="label" class="form-label" for="">{{ label }}</label>
        <textarea
            class="form-control"
            :value="modelValue" @input="$emit('update:modelValue', $event.target.value)"></textarea>
    </div>
</template>
<script>
export default {
    emits: ['update:modelValue'],
    props: {
      modelValue: String,
      label: String,
    },
}
</script>
