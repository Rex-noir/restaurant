<script setup lang="ts">
const inputText = defineModel('inputText', { required: true });

defineProps<{
    label: string;
    placeholder?: string;
    inputType?: string;
    error?: string;
}>();
</script>

<template>
    <div v-bind="$attrs" class="form-control w-full">
        <label class="label">
            <span class="label-text">{{ label }}</span>
        </label>
        <input
            v-model="inputText"
            :type="inputType ?? 'text'"
            :placeholder="placeholder"
            class="input w-full focus-within:outline-none"
            :class="{ 'input-error': error }"
        />
        <label v-if="error" class="label">
            <span class="label-text-alt text-error">{{ error }}</span>
        </label>
    </div>
</template>
