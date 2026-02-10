<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    company: Object,
    reviews: Array,
});

// Функция для форматирования даты
const formatDate = (dateString) => {
    const date = new Date(dateString);
    const day = date.getDate().toString().padStart(2, '0');
    const month = (date.getMonth() + 1).toString().padStart(2, '0');
    const year = date.getFullYear();
    const hours = date.getHours().toString().padStart(2, '0');
    const minutes = date.getMinutes().toString().padStart(2, '0');
    return `${day}.${month}.${year} ${hours}:${minutes}`;
};

// Функция для отображения звезд рейтинга
const getStars = (rating) => {
    return Array(5).fill(0).map((_, i) => i < rating);
};
</script>

<template>
    <Head title="Отзывы" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Beauty Flow
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <!-- Боковое меню и контент -->
                        <div class="flex gap-8">
                            <!-- Левая панель навигации -->
                            <div class="w-48 flex-shrink-0">
                                <nav class="space-y-2">
                                    <a 
                                        href="#" 
                                        class="block rounded-md px-3 py-2 text-sm font-medium text-gray-900 bg-gray-100"
                                    >
                                        Отзывы
                                    </a>
                                    <a 
                                        href="#" 
                                        class="block rounded-md px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50"
                                    >
                                        Отзывы
                                    </a>
                                    <a 
                                        :href="route('company.settings')"
                                        class="block rounded-md px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50"
                                    >
                                        Настройки
                                    </a>
                                </nav>
                            </div>

                            <!-- Основной контент -->
                            <div class="flex-1">
                                <!-- Заголовок -->
                                <div class="mb-6 flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        <h3 class="text-lg font-semibold text-gray-900">
                                            Яндекс бренд
                                        </h3>
                                    </div>
                                </div>

                                <!-- Блок рейтинга -->
                                <div class="mb-8 flex items-center justify-between">
                                    <div class="flex-1">
                                        <div class="space-y-4">
                                            <!-- Отзывы -->
                                            <div 
                                                v-for="review in reviews" 
                                                :key="review.id" 
                                                class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm"
                                            >
                                                <div class="mb-2 flex items-start justify-between">
                                                    <div class="flex items-center gap-2">
                                                        <span class="font-medium text-gray-900">
                                                            {{ review.author_name }}
                                                        </span>
                                                        <svg class="h-4 w-4 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                        </svg>
                                                    </div>
                                                    <div class="flex items-center gap-1">
                                                        <span 
                                                            v-for="(filled, index) in getStars(review.rating)" 
                                                            :key="index"
                                                        >
                                                            <svg 
                                                                class="h-5 w-5" 
                                                                :class="filled ? 'text-yellow-400' : 'text-gray-300'"
                                                                fill="currentColor" 
                                                                viewBox="0 0 20 20"
                                                            >
                                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                            </svg>
                                                        </span>
                                                    </div>
                                                </div>
                                                <p class="text-sm text-gray-600 mb-2">
                                                    {{ review.text }}
                                                </p>
                                                <p class="text-xs text-gray-400">
                                                    {{ formatDate(review.review_date) }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Блок общего рейтинга (справа) -->
                                    <div class="ml-8 w-48 flex-shrink-0 rounded-lg border border-gray-200 bg-gray-50 p-6 text-center">
                                        <div class="mb-4 text-5xl font-bold text-gray-900">
                                            {{ company.rating }}
                                        </div>
                                        <div class="mb-2 flex justify-center gap-1">
                                            <span 
                                                v-for="(filled, index) in getStars(Math.round(company.rating))" 
                                                :key="index"
                                            >
                                                <svg 
                                                    class="h-6 w-6" 
                                                    :class="filled ? 'text-yellow-400' : 'text-gray-300'"
                                                    fill="currentColor" 
                                                    viewBox="0 0 20 20"
                                                >
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-600">
                                            Всего отзывов: {{ company.reviews_count }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
