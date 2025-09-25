<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, Link, usePage, router } from '@inertiajs/vue3';
    import EventCard from '@/Components/EventCard.vue';
    import { computed, ref, onMounted, onBeforeUnmount } from 'vue';
    import ImageCarousel from '@/Pages/Home-Page-Items/ImageCarousel.vue'

    // Access the page props using usePage
    const page = usePage();
    const user = computed(() => page.props.auth.user);

    // Props for events array
    defineProps({
        events: Array,
        hImages: Array,
    });

    // Carousel state and quotes array
    const currentIndex = ref(0);
    const quotes = ref([
        {
            text: "Innovation distinguishes between a leader and a follower.",
            author: "Steve Jobs",
            position: "Apple Founder",
            image: "https://dummyimage.com/40x40/ced4da/6c757d",
        },
        {
            text: "Customer satisfaction is the ultimate driver of our success.",
            author: "Samuel Njau",
            position: "TechLead",
            image: "https://dummyimage.com/40x40/ced4da/6c757d",
        },
        {
            text: "Quality is remembered long after the price is forgotten.",
            author: "Gucci Family Slogan",
            position: "Gucci",
            image: "https://dummyimage.com/40x40/ced4da/6c757d",
        },
        {
            text: "Quality is remembered long after the price is forgotten.",
            author: "Gucci Family Slogan",
            position: "Gucci",
            image: "https://dummyimage.com/40x40/ced4da/6c757d",
        },
    ]);

    // Carousel logic
    let carouselInterval;

    const startCarousel = () => {
        carouselInterval = setInterval(() => {
            currentIndex.value = (currentIndex.value + 1) % quotes.value.length;
        }, 3000);
    };

    const stopCarousel = () => {
        clearInterval(carouselInterval);
    };

    const nextQuote = () => {
        currentIndex.value = (currentIndex.value + 1) % quotes.value.length;
    };

    const prevQuote = () => {
        currentIndex.value = (currentIndex.value - 1 + quotes.value.length) % quotes.value.length;
    };

    // Lifecycle hooks
    onMounted(startCarousel);
    onBeforeUnmount(stopCarousel);
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
                                :href="route('payments')" 
                                class="inline-block bg-blue-700 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded mt-2  animate-bounce">
                                Join EUKOSSA Today!
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Event Section -->
        <section class="events-section">
            <button class="wiggle bg-blue-600 text-white text-xl font-semibold px-6 py-2 shadow-md hover:bg-blue-700 transition ml-5 mb-2">
                Upcoming Events
            </button>


            <div class="flex overflow-x-auto space-x-4 pl-3 pr-52">
                <EventCard v-for="event in events" :key="event.id" :event="event" class="flex-shrink-0 w-64" />

                <div class="relative pr-5">
                    <Link :href="route('events.index')">
                        <span class="bg-blue-500 hover:bg-blue-700 absolute top-1/2 block whitespace-nowrap px-5 wiggle mr-8 ml-8 text-white rounded-md py-2">
                            <i class="fas fa-calendar-alt"></i>
                            More Events
                            <i class="fas fa-long-arrow-alt-right"></i>
                        </span>
                    </Link>
                </div>
            </div>
        </section>

        <!-- Hackathon Carousel -->
        <ImageCarousel :hImages="hImages"/>
        
        <!-- The Quotes Carousel Section -->
        <div class="bg-gray-100">
            <div class="container mx-auto px-5 py-20">
                <div class="relative">
                    <!-- Quote Slides -->
                    <div
                    v-for="(quote, index) in quotes"
                    :key="index"
                    v-show="index === currentIndex"
                    class="transition-opacity duration-3000"
                    :class="{ 'opacity-100': index === currentIndex, 'opacity-0': index !== currentIndex }">
                    <div class="text-center">
                        <div class="text-xl lg:text-2xl italic font-light text-gray-800 mb-4">
                            "{{ quote.text }}"
                        </div>
                        <div class="flex items-center justify-center">
                            <img
                                class="w-10 h-10 rounded-full mr-3"
                                :src="quote.image"
                                alt="..." />
                            <div class="font-semibold text-gray-900">
                                {{ quote.author }}
                                <span class="text-blue-500 mx-1">/</span>
                                {{ quote.position }}
                            </div>
                        </div>
                    </div>
                    </div>

                    <!-- Navigation Controls -->
                    <button
                        @click="prevQuote"
                        class="absolute top-1/2 left-0 lg:left-40 transform -translate-y-1/2 p-2 text-gray-500 hover:text-gray-900">
                        <span class="sr-only">Previous</span>
                        <!-- Left Arrow Icon -->
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <button
                        @click="nextQuote"
                        class="absolute top-1/2 right-0 lg:right-40 transform -translate-y-1/2 p-2 text-gray-500 hover:text-gray-900">
                        <span class="sr-only">Next</span>
                        <!-- Right Arrow Icon -->
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>

                    <!-- Dot Indicators -->
                    <div class="flex justify-center mt-6 space-x-2">
                    <button
                        v-for="(quote, index) in quotes"
                        :key="'dot-' + index"
                        @click="currentIndex = index"
                        class="w-3 h-3 rounded-full"
                        :class="{
                        'bg-blue-500': index === currentIndex,
                        'bg-gray-300 hover:bg-gray-500': index !== currentIndex
                        }"
                    ></button>
                    </div>
                    
                </div>
            </div>
        </div>

        <!-- Socials -->
        <section class="bg-white py-16 mx-auto pb-4">
            <div class="text-center">
                <div class="text-xl font-semibold mb-3">Follow Us!</div>
                <a class="text-2xl mx-2 bg-blue-500 text-white rounded-full w-12 h-12 inline-flex items-center justify-center shadow-lg" href="https://x.com/eucossake" target="_blank">
                    <i class="fab fa-twitter"></i>
                </a>
                <a class="text-2xl mx-2 bg-blue-500 text-white rounded-full w-12 h-12 inline-flex items-center justify-center shadow-lg" href="https://www.instagram.com/eucossake?igsh=MTEwaGx2NzF2d3B6ZA%3D%3D" target="_blank">
                    <i class="fab fa-instagram"></i>
                </a>
                <a class="text-2xl mx-2 bg-blue-500 text-white rounded-full w-12 h-12 inline-flex items-center justify-center shadow-lg" href="https://www.youtube.com/@eucossake2200" target="_blank">
                    <i class="fab fa-youtube"></i>
                </a>
                <a class="text-2xl mx-2 bg-blue-500 text-white rounded-full w-12 h-12 inline-flex items-center justify-center shadow-lg" href="mailto:eucossake@gmail.com" target="_blank">
                    <i class="fas fa-envelope"></i>
                </a>
                <a class="text-2xl mx-2 bg-blue-500 text-white rounded-full w-12 h-12 inline-flex items-center justify-center shadow-lg" href="https://github.com/EUCOSSA-Official-Website/Egerton-Website" target="_blank">
                    <i class="fab fa-github"></i>
                </a>

                <div class="py-4 my-4 text-xs italic text-gray-600">Follow us and be part of our growing community!</div>
            </div>
        </section>

    </AuthenticatedLayout>
</template>

<style scoped>
    .bluish {
        color: #1d4ed8 ;
    }

    @keyframes wiggle {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
    }
    .wiggle {
    animation: wiggle 1s ease-in-out infinite;
    }

</style>
