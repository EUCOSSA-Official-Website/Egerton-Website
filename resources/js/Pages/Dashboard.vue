<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, Link } from '@inertiajs/vue3';
    import EventCard from '@/Components/EventCard.vue';

    defineProps({
        events: Array,
    })
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

                            <div class="typewriter text-lg sm:text-2xl text-gray-50 my-3">
                                <div>
                                    <p>Egerton Computer Science Students Association</p>
                                </div>
                            </div>
                            <p class="text-xl sm:text-2xl text-gray-50 my-3">
                                 <span class="font-bold bg-white bg-opacity-40 rounded-md">EUCOSSA</span> is a student-led 
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

        <!-- Event Section -->
        <section class="events-section">
            <h1 class="text-2xl font-bold mb-6">Upcoming Events</h1>

            <div class="flex overflow-x-auto space-x-4">
                <EventCard v-for="event in events" :key="event.id" :event="event" class="flex-shrink-0 w-64" />
            </div>
        </section>

    </AuthenticatedLayout>
</template>

<style scoped>
    span {
        color: #1d4ed8 ;
    }
</style>
