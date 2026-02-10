<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    company: Object,
});

const form = useForm({
    yandex_url: props.company?.yandex_url || '',
});

const submit = () => {
    form.post(route('company.save'));
};
</script>

<template>
    <Head title="Настройки компании" />

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
                        <!-- Боковое меню -->
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
                                        href="#" 
                                        class="block rounded-md px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50"
                                    >
                                        Настройки
                                    </a>
                                </nav>
                            </div>

                            <!-- Основной контент -->
                            <div class="flex-1">
                                <div class="mb-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                        Подключить Яндекс
                                    </h3>
                                    <p class="text-sm text-gray-600 mb-4">
                                        Укажите ссылку на Яндекс, пример:
                                    </p>
                                    <div class="space-y-2 mb-4">
                                        <p class="text-xs text-gray-500">
                                            https://yandex.ru/maps/org/beautyflow_salon/1010101010/reviews/
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            https://yandex.ru/maps/org/beautyflow_beauty_bar/2020202020/reviews/
                                        </p>
                                    </div>
                                </div>

                                <form @submit.prevent="submit">
                                    <div>
                                        <InputLabel for="yandex_url" value="Ссылка на Яндекс.Карты" />

                                        <TextInput
                                            id="yandex_url"
                                            type="url"
                                            class="mt-1 block w-full"
                                            v-model="form.yandex_url"
                                            required
                                            placeholder="https://yandex.ru/maps/org/..."
                                        />

                                        <InputError class="mt-2" :message="form.errors.yandex_url" />
                                    </div>

                                    <div class="mt-4">
                                        <PrimaryButton 
                                            class="px-6 py-2" 
                                            :class="{ 'opacity-25': form.processing }" 
                                            :disabled="form.processing"
                                        >
                                            Сохранить
                                        </PrimaryButton>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
