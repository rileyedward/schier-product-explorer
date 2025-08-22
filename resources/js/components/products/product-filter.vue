<script setup lang="ts">
import { ProductType } from '@/types';
import { ref, watch } from 'vue';
import { Label } from '@/components/ui/label';

interface Props {
    modelValue?: string;
    productTypes: ProductType[]
}

interface Emits {
    (e: 'update:modelValue', value: string): void;
    (e: 'filter', value: string): void;
}

const props = defineProps<Props>();
const emit = defineEmits<Emits>();

const selectedType = ref<string>(props.modelValue || '');

watch(selectedType, (newValue) => {
    emit('update:modelValue', newValue);
    emit('filter', newValue);
});
</script>

<template>
    <div class="flex items-center gap-2">
        <Label for="product-type" class="whitespace-nowrap">Filter by Type:</Label>
        <select
            id="product-type"
            v-model="selectedType"
            class="border-input bg-background ring-offset-background focus-visible:ring-ring flex h-9 w-full rounded-md border px-3 py-1 text-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2"
        >
            <option value="">All Types</option>
            <option
                v-for="type in productTypes"
                :key="type.id"
                :value="type.name"
            >
                {{ type.name }}
            </option>
        </select>
    </div>
</template>
