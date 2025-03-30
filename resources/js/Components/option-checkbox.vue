<script setup lang="ts">
const props = defineProps<{
    option: App.Data.MenuItemOptionData;
}>();

const model = defineModel<(number | null)[]>('value', { required: true });

const toggleValue = (valueId: number) => {
    const index = model.value.indexOf(valueId);
    index === -1 ? model.value.push(valueId) : model.value.splice(index, 1);
};
</script>

<template>
    <div class="form-control space-y-2">
        <span class="text-sm font-medium text-gray-700">{{ option.name }}</span>
        <div class="space-y-1.5">
            <label
                v-for="value in option.values"
                :key="value.id"
                class="hover:border-primary flex cursor-pointer items-center gap-3 rounded-lg border p-2 transition-colors"
                :class="{
                    'border-primary bg-primary/10': model.includes(value.id),
                }"
            >
                <input
                    type="checkbox"
                    class="checkbox checkbox-sm checkbox-primary"
                    :checked="model.includes(value.id)"
                    @change="toggleValue(value.id)"
                    :name="`option-${option.id}`"
                    :value="value.id"
                    hidden
                />
                <div class="flex-1">
                    <span class="text-sm font-medium">{{ value.value }}</span>
                    <span
                        v-if="value.price_mod"
                        class="ml-2 text-xs text-gray-500"
                    >
                        +{{ value.price_mod }}
                    </span>
                </div>
                <div
                    class="flex h-4 w-4 items-center justify-center rounded-sm border transition-colors"
                    :class="{
                        'border-primary bg-primary': model.includes(value.id),
                        'border-gray-300': !model.includes(value.id),
                    }"
                >
                    <svg
                        v-if="model.includes(value.id)"
                        class="h-3 w-3 text-white"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5 13l4 4L19 7"
                        />
                    </svg>
                </div>
            </label>
        </div>
    </div>
</template>
