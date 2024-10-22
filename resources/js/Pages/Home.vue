<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, Link, usePage } from '@inertiajs/vue3';
    import EventCard from '@/Components/EventCard.vue';
    import {computed} from 'vue';

    // Access the page props using usePage
    const page = usePage();
    
    // Compute the user from the auth prop
    const user = computed(() => page.props.auth.user);

    defineProps({
        events: Array,
    })

    // Notification for when a User is already Registered
    // Handle click event
    const handleClick = (e) => {
        if (user) {
            e.preventDefault(); // Prevent the default behavior of the link
            alert('You are already registered!🎉'); // Show notification
        }
    };

</script>

<template>
    <Head title="Home" />

    <AuthenticatedLayout>

        <!-- Page Header -->
        <header class="masthead bg-cover bg-center sm:mt-1" style="background-image: url('/assets/img/home-bg.jpg')">
            <div class="container relative mx-auto px-4 lg:px-5">
                <div class="flex justify-center">
                    <div class="w-full max-w-[625px]">
                        <div class="text-center">
                            <h1 class="text-2xl sm:text-4xl font-bold text-white">Accelerating <span class="bluish">growth</span> and <span class="bluish">potential</span> of tech enthusiasts</h1>

                            <div class="typewriter text-lg sm:text-2xl text-gray-50 my-3">
                                <div>
                                    <p>Egerton <span class="hidden sm:inline">University</span> Computer Science Students Association</p>
                                </div>
                            </div>
                            <p class="text-xl sm:text-2xl text-gray-50 my-3">
                                 <span class="font-bold text-3xl">EUCOSSA</span> is a student-led 
                                computer science organization at Egerton University dedicated to 
                                fostering a vibrant and growing tech community on campus.
                            </p>

                            <Link 
                                :href="user ? null : route('register')" 
                                @click="handleClick"  
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
    .bluish {
        color: #1d4ed8 ;
    }
</style>
