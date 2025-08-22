<script setup lang="ts">
import { Label } from '@/components/ui/label';
import { ProductType } from '@/types';
import { ref, watch } from 'vue';

interface Props {
    modelValue?: string;
    productTypes: ProductType[];
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
            class="flex h-9 w-full rounded-md border border-input bg-background px-3 py-1 text-sm ring-offset-background focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:outline-none"
        >
            <option value="">All Types</option>
            <option v-for="type in productTypes" :key="type.id" :value="type.name">
                {{ type.name }}
            </option>
        </select>
    </div>
</template>
