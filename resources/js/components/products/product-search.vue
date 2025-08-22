<script setup lang="ts">
import { Input as UiInput } from '@/components/ui/input';
import { RecentSearch } from '@/types';
import { ClockIcon, SearchIcon, XIcon } from 'lucide-vue-next';
import { computed, ref, watch } from 'vue';

interface Props {
    modelValue?: string;
    recentSearches: RecentSearch[];
}

interface Emits {
    (e: 'update:modelValue', value: string): void;
    (e: 'search', value: string): void;
}

const props = defineProps<Props>();
const emit = defineEmits<Emits>();

const searchQuery = ref<string>(props.modelValue || '');
const showRecentSearches = ref<boolean>(false);

const hasRecentSearches = computed(() => props.recentSearches.length > 0);

const applyRecentSearch = (query: string) => {
    searchQuery.value = query;
    showRecentSearches.value = false;
};

const clearSearch = () => {
    searchQuery.value = '';
};

const handleFocus = () => {
    if (hasRecentSearches.value) {
        showRecentSearches.value = true;
    }
};

const handleBlur = () => {
    setTimeout(() => {
        showRecentSearches.value = false;
    }, 200);
};

watch(searchQuery, (newValue) => {
    emit('update:modelValue', newValue);
    emit('search', newValue);
});
</script>

<template>
    <div class="relative">
        <!-- Search Input -->
        <div class="relative">
            <search-icon class="absolute top-1/2 left-3 h-4 w-4 -translate-y-1/2 text-muted-foreground" />
            <ui-input
                v-model="searchQuery"
                class="pr-10 pl-10"
                placeholder="Search products by name or SKU..."
                @focus="handleFocus"
                @blur="handleBlur"
            />
            <button
                v-if="searchQuery"
                @click="clearSearch"
                class="absolute top-1/2 right-3 -translate-y-1/2 text-muted-foreground hover:text-foreground"
            >
                <x-icon class="h-4 w-4" />
            </button>
        </div>

        <!-- Recent Searches -->
        <div v-if="showRecentSearches && hasRecentSearches" class="absolute z-10 mt-1 w-full rounded-md border bg-card shadow-lg">
            <div class="p-2 text-sm font-medium text-muted-foreground">Recent Searches</div>
            <div class="max-h-60 overflow-auto">
                <button
                    v-for="recentSearch in recentSearches"
                    :key="recentSearch.id"
                    @click="applyRecentSearch(recentSearch.query)"
                    class="flex w-full items-center gap-2 px-3 py-2 text-sm hover:bg-muted"
                >
                    <clock-icon class="h-4 w-4 text-muted-foreground" />
                    <span>{{ recentSearch.query }}</span>
                </button>
            </div>
        </div>
    </div>
</template>
