<!-- OptionRadioGroup.vue -->
<script setup lang="ts">
const props = defineProps<{
    option: App.Data.MenuItemOptionData;
}>();
const model = defineModel<(number | null)[]>('value', { required: true });
</script>

<template>
    <div class="form-control">
        <label class="label block py-1">
            <span class="label-text text-sm font-medium">{{
                option.name
            }}</span>
        </label>
        <div class="join join-horizontal gap-1.5">
            <template v-for="value in option.values" :key="value.id">
                <label
                    class="join-item label hover:border-primary cursor-pointer rounded-lg border px-3 py-1.5 transition-all"
                    :class="{
                        'border-primary bg-primary/10': model[0] === value.id,
                    }"
                >
                    <input
                        type="radio"
                        class="radio radio-xs"
                        :value="value.id"
                        v-model="model[0]"
                    />
                    <span class="label-text ml-2 text-sm">{{
                        value.value
                    }}</span>
                </label>
            </template>
        </div>
    </div>
</template>
