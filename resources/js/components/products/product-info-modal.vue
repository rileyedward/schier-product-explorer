<script setup lang="ts">
import { Button as UiButton } from '@/components/ui/button';
import { DialogClose, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle, Dialog as UiDialog } from '@/components/ui/dialog';
import { Favorite, Product } from '@/types';
import { router } from '@inertiajs/vue3';
import { Heart, HeartOff } from 'lucide-vue-next';
import { computed } from 'vue';

interface Props {
    selectedProduct: Product | null;
    isOpen: boolean;
    favorites: Favorite[];
}

interface Emits {
    (e: 'update:isOpen', value: boolean): void;
    (e: 'toggleFavorite', productId: number): void;
}

const props = defineProps<Props>();
const emit = defineEmits<Emits>();

const isFavorite = computed(() => {
    if (!props.selectedProduct) return false;
    return props.favorites.some((favorite) => favorite.product_id === props.selectedProduct?.id);
});

const toggleFavorite = () => {
    if (props.selectedProduct) {
        router.post(
            route('products.toggle-favorite', { product: props.selectedProduct.id }),
            {},
            {
                preserveState: true,
                preserveScroll: true,
                only: ['favorites'],
            },
        );
    }
};

const closeModal = () => {
    emit('update:isOpen', false);
};
</script>

<template>
    <ui-dialog :open="isOpen" @update:open="emit('update:isOpen', $event)">
        <dialog-content class="max-h-[90vh] max-w-4xl overflow-y-auto">
            <!-- Header -->
            <dialog-header>
                <div class="flex items-center justify-between">
                    <div>
                        <dialog-title class="text-2xl">{{ selectedProduct?.short_name }}</dialog-title>
                        <dialog-description>{{ selectedProduct?.name }}</dialog-description>
                    </div>
                </div>
            </dialog-header>

            <div v-if="selectedProduct" class="space-y-6">
                <!-- Add to Favorites -->
                <ui-button v-if="selectedProduct" @click="toggleFavorite" :variant="isFavorite ? 'destructive' : 'default'" class="w-full">
                    <heart v-if="isFavorite" class="h-4 w-4" />
                    <heart-off v-else class="h-4 w-4" />
                    {{ isFavorite ? 'Remove from Favorites' : 'Add to Favorites' }}
                </ui-button>

                <!-- Image -->
                <div v-if="selectedProduct.images?.primary?.lg" class="flex justify-center">
                    <img :src="selectedProduct.images.primary.lg" :alt="selectedProduct.name" class="max-h-80 rounded-lg object-contain" />
                </div>

                <!-- Part Number -->
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div class="rounded-lg border p-4">
                        <h3 class="mb-2 text-lg font-semibold">SKU (Part Number)</h3>
                        <p>{{ selectedProduct.part_number }}</p>
                    </div>

                    <!-- Price if available -->
                    <div v-if="selectedProduct.price?.list" class="rounded-lg border p-4">
                        <h3 class="mb-2 text-lg font-semibold">Price</h3>
                        <p>${{ selectedProduct.price.list }}</p>
                    </div>
                </div>

                <!-- Description -->
                <div v-if="selectedProduct.description || selectedProduct.short_description" class="rounded-lg border p-4">
                    <h3 class="mb-2 text-lg font-semibold">Description</h3>
                    <p v-if="selectedProduct.description" v-html="selectedProduct.description"></p>
                    <p v-else-if="selectedProduct.short_description" v-html="selectedProduct.short_description"></p>
                </div>

                <!-- Dimensions -->
                <div v-if="selectedProduct.base_dimensions" class="rounded-lg border p-4">
                    <h3 class="mb-2 text-lg font-semibold">Product Dimensions</h3>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <h4 class="font-medium">Standard</h4>
                            <ul class="list-inside list-disc space-y-1">
                                <li>
                                    Length: {{ selectedProduct.base_dimensions.standard.length.value }}
                                    {{ selectedProduct.base_dimensions.standard.length.unit }}
                                </li>
                                <li>
                                    Width: {{ selectedProduct.base_dimensions.standard.width.value }}
                                    {{ selectedProduct.base_dimensions.standard.width.unit }}
                                </li>
                                <li>
                                    Height: {{ selectedProduct.base_dimensions.standard.height.value }}
                                    {{ selectedProduct.base_dimensions.standard.height.unit }}
                                </li>
                                <li>
                                    Weight: {{ selectedProduct.base_dimensions.standard.weight.value }}
                                    {{ selectedProduct.base_dimensions.standard.weight.unit }}
                                </li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-medium">Metric</h4>
                            <ul class="list-inside list-disc space-y-1">
                                <li>
                                    Length: {{ selectedProduct.base_dimensions.metric.length.value }}
                                    {{ selectedProduct.base_dimensions.metric.length.unit }}
                                </li>
                                <li>
                                    Width: {{ selectedProduct.base_dimensions.metric.width.value }}
                                    {{ selectedProduct.base_dimensions.metric.width.unit }}
                                </li>
                                <li>
                                    Height: {{ selectedProduct.base_dimensions.metric.height.value }}
                                    {{ selectedProduct.base_dimensions.metric.height.unit }}
                                </li>
                                <li>
                                    Weight: {{ selectedProduct.base_dimensions.metric.weight.value }}
                                    {{ selectedProduct.base_dimensions.metric.weight.unit }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Types -->
                <div v-if="selectedProduct.types && selectedProduct.types.length > 0" class="rounded-lg border p-4">
                    <h3 class="mb-2 text-lg font-semibold">Product Types</h3>
                    <div class="flex flex-wrap gap-2">
                        <span v-for="type in selectedProduct.types" :key="type" class="rounded-full bg-muted px-2 py-1 text-sm">
                            {{ type }}
                        </span>
                    </div>
                </div>
            </div>

            <DialogFooter>
                <DialogClose asChild>
                    <ui-button @click="closeModal">Close</ui-button>
                </DialogClose>
            </DialogFooter>
        </dialog-content>
    </ui-dialog>
</template>
