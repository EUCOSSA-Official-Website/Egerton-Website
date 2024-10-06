<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>

        <!-- Page Header -->
        <header class="masthead bg-cover bg-center sm:mt-1" style="background-image: url('/assets/img/home-bg.jpg')">
            <div class="container relative mx-auto px-4 lg:px-5">
                <div class="flex justify-center">
                    <div class="w-full max-w-[625px]">
                        <div class="text-center">
                            <h1 class="text-2xl sm:text-4xl font-bold text-white">Accelerating <span>growth</span> and <span>potential</span> of tech enthusiasts</h1>
                            <p class="text-xl sm:text-2xl text-gray-50 my-3">
                                Egerton Computer Science Students Association <span class="font-bold">EUCOSSA</span> is a student-led 
                                computer science organization at Egerton University dedicated to 
                                fostering a vibrant and growing tech community on campus.
                            </p>

                            <Link 
                                :href="route('login')" 
                                class="inline-block bg-blue-700 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded mt-2">
                                Join EUCOSSA
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </header>

    </AuthenticatedLayout>
</template>

<style scoped>
    span {
        color: #1d4ed8 ;
    }
</style>
