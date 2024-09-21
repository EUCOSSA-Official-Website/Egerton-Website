<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>

        <!-- Page Header -->
        <header class="masthead bg-cover bg-center mt-1" style="background-image: url('/assets/img/home-bg.jpg')">
            <div class="container relative mx-auto px-4 lg:px-5">
                <div class="flex justify-center">
                    <div class="w-full md:w-10/12 lg:w-8/12 xl:w-7/12">
                        <div class="text-center">
                            <h1 class="text-4xl font-bold text-white">Clean Blog</h1>
                            <span class="text-xl text-gray-300">A Blog Theme by Start Bootstrap</span>
                        </div>
                    </div>
                </div>
            </div>
        </header>

    </AuthenticatedLayout>
</template>
