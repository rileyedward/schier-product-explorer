<script setup lang="ts">
import { Product, Favorite } from '@/types';
import { computed } from 'vue';
import {
    Dialog as UiDialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
    DialogDescription,
    DialogFooter,
    DialogClose
} from '@/components/ui/dialog';
import { Button as UiButton } from '@/components/ui/button';
import { Heart, HeartOff } from 'lucide-vue-next';
import { router } from '@inertiajs/vue3';

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
    return props.favorites.some(favorite => favorite.product_id === props.selectedProduct?.id);
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
            }
        );
    }
};

const closeModal = () => {
    emit('update:isOpen', false);
};
</script>

<template>
    <ui-dialog :open="isOpen" @update:open="emit('update:isOpen', $event)">
        <dialog-content class="max-w-4xl max-h-[90vh] overflow-y-auto">
            <!-- Header -->
            <dialog-header>
                <div class="flex justify-between items-center">
                    <div>
                        <dialog-title class="text-2xl">{{ selectedProduct?.short_name }}</dialog-title>
                        <dialog-description>{{ selectedProduct?.name }}</dialog-description>
                    </div>
                </div>
            </dialog-header>

            <div v-if="selectedProduct" class="space-y-6">
                <!-- Add to Favorites -->
                <ui-button
                    v-if="selectedProduct"
                    @click="toggleFavorite"
                    :variant="isFavorite ? 'destructive' : 'default'"
                    class="w-full"
                >
                    <heart v-if="isFavorite" class="h-4 w-4" />
                    <heart-off v-else class="h-4 w-4" />
                    {{ isFavorite ? 'Remove from Favorites' : 'Add to Favorites' }}
                </ui-button>

                <!-- Image -->
                <div v-if="selectedProduct.images?.primary?.lg" class="flex justify-center">
                    <img
                        :src="selectedProduct.images.primary.lg"
                        :alt="selectedProduct.name"
                        class="max-h-80 object-contain rounded-lg"
                    />
                </div>

                <!-- Part Number -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="border rounded-lg p-4">
                        <h3 class="text-lg font-semibold mb-2">SKU (Part Number)</h3>
                        <p>{{ selectedProduct.part_number }}</p>
                    </div>

                    <!-- Price if available -->
                    <div v-if="selectedProduct.price?.list" class="border rounded-lg p-4">
                        <h3 class="text-lg font-semibold mb-2">Price</h3>
                        <p>${{ selectedProduct.price.list }}</p>
                    </div>
                </div>

                <!-- Description -->
                <div v-if="selectedProduct.description || selectedProduct.short_description" class="border rounded-lg p-4">
                    <h3 class="text-lg font-semibold mb-2">Description</h3>
                    <p v-if="selectedProduct.description" v-html="selectedProduct.description"></p>
                    <p v-else-if="selectedProduct.short_description" v-html="selectedProduct.short_description"></p>
                </div>

                <!-- Dimensions -->
                <div v-if="selectedProduct.base_dimensions" class="border rounded-lg p-4">
                    <h3 class="text-lg font-semibold mb-2">Product Dimensions</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h4 class="font-medium">Standard</h4>
                            <ul class="list-disc list-inside space-y-1">
                                <li>Length: {{ selectedProduct.base_dimensions.standard.length.value }} {{ selectedProduct.base_dimensions.standard.length.unit }}</li>
                                <li>Width: {{ selectedProduct.base_dimensions.standard.width.value }} {{ selectedProduct.base_dimensions.standard.width.unit }}</li>
                                <li>Height: {{ selectedProduct.base_dimensions.standard.height.value }} {{ selectedProduct.base_dimensions.standard.height.unit }}</li>
                                <li>Weight: {{ selectedProduct.base_dimensions.standard.weight.value }} {{ selectedProduct.base_dimensions.standard.weight.unit }}</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-medium">Metric</h4>
                            <ul class="list-disc list-inside space-y-1">
                                <li>Length: {{ selectedProduct.base_dimensions.metric.length.value }} {{ selectedProduct.base_dimensions.metric.length.unit }}</li>
                                <li>Width: {{ selectedProduct.base_dimensions.metric.width.value }} {{ selectedProduct.base_dimensions.metric.width.unit }}</li>
                                <li>Height: {{ selectedProduct.base_dimensions.metric.height.value }} {{ selectedProduct.base_dimensions.metric.height.unit }}</li>
                                <li>Weight: {{ selectedProduct.base_dimensions.metric.weight.value }} {{ selectedProduct.base_dimensions.metric.weight.unit }}</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Types -->
                <div v-if="selectedProduct.types && selectedProduct.types.length > 0" class="border rounded-lg p-4">
                    <h3 class="text-lg font-semibold mb-2">Product Types</h3>
                    <div class="flex flex-wrap gap-2">
                        <span
                            v-for="type in selectedProduct.types"
                            :key="type"
                            class="px-2 py-1 bg-muted rounded-full text-sm"
                        >
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
