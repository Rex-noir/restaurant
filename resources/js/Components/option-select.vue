<script setup lang="ts">
const props = defineProps<{
    option: App.Data.MenuItemOptionData;
}>();
const model = defineModel<(number | null)[]>('value', { required: true });
</script>

<template>
    <div class="space-y-1">
        <label class="block text-sm font-medium text-gray-700">
            {{ option.name }}
        </label>
        <div class="relative">
            <select
                v-model="model[0]"
                class="focus:border-primary-500 focus:ring-primary-500 block w-full rounded-md border border-gray-300 py-2 pr-8 pl-3 text-sm focus:ring-1 focus:outline-none"
            >
                <option
                    v-for="value in option.values"
                    :key="value.id"
                    :value="value.id"
                    class="text-sm"
                >
                    {{ value.value }}
                </option>
            </select>
            <div
                class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2"
            >
                <svg
                    class="h-5 w-5 text-gray-400"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                >
                    <path
                        fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd"
                    />
                </svg>
            </div>
        </div>
    </div>
</template>
