<template>
    <AuthenticatedLayout>

        <Head title="About" />

        <!-- Page content-->
        <!-- About Header-->
        <header class="py-5 my-4">
            <div class="container mx-auto px-4 mt-2 mb-3">
                <div class="flex justify-center">
                    <div class="lg:w-2/3 xl:w-1/2">
                        <div class="text-center my-5">
                            <h1 class="font-bold text-4xl mb-3">
                                Get To Know Your System Maker
                            </h1>
                            <p class="text-lg font-normal text-gray-600 mb-4">
                                Samuel Njau is a skilled Laravel and Vue.js developer with 
                                expertise in design, cloud services, and deployment. Learn 
                                more about his work and how to get in touch with him.
                            </p>
                            <a class="btn btn-primary text-white text-lg bg-blue-500 hover:bg-blue-600 px-5 py-3 rounded-lg" href="#scroll-target">
                                Get To Know!
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- About section one-->
        <section class="py-5 bg-gray-100" id="scroll-target">
            <div class="container mx-auto px-5 my-3">
                <div class="flex flex-col lg:flex-row lg:items-center lg:space-x-5">
                    <div class="lg:w-1/2">
                        <img class="w-full rounded mb-5 lg:mb-0" src="/images/Profile.png" alt="Samuel Njau" />
                    </div>
                    <div class="lg:w-1/2">
                        <h2 class="font-bold text-2xl">About Samuel Njau</h2>
                        <p class="text-lg font-normal text-gray-600 mt-4">
                            I’m Njau, a passionate Laravel developer with a love for building elegant and scalable web applications. 
                            I pursued my Computer Science degree at Egerton University, completing it in 2025. 
                            You can explore some of the Laravel projects I've worked on by checking out my socials — feel free to connect!
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- About section two-->
        <section class="py-5">
            <div class="container mx-auto px-5 my-5">
                <div class="flex flex-col lg:flex-row lg:items-center lg:space-x-5">
                    
                    <div class="lg:w-1/2">
                        <h2 class="font-bold text-2xl">Building With Purpose</h2>
                        <p class="text-lg font-normal text-gray-600 mt-4">
                            As a Builder — someone who believes code isn't just syntax, it's creativity in motion. 
                            With a background in Computer Science, I’ve spent the past few years crafting web experiences that aren’t just functional, but purposeful.
                            Laravel and Vue.js are my go-to tools for turning complex ideas into simple, beautiful interfaces.
                            Whether it's a quick project or a platform that scales, I build with intention — and a bit of fun.
                            Curious about what I’ve built? Check out my socials and let’s connect!
                        </p>
                    </div>

                    <div class="lg:w-1/2 order-first lg:order-last">
                        <img class="w-full rounded mb-5 lg:mb-0" src="images/shubham-dhage-mezoxyJg-xo-unsplash.jpg" alt="..." />
                    </div>
                </div>
            </div>
        </section>

        <!-- Solo Builder Section -->
        <section class="py-5 bg-gray-100">
            <div class="container mx-auto px-5 my-5">
                <div class="text-center">
                    <h2 class="text-3xl font-bold mb-3">Wearing All The Hats</h2>
                    <p class="text-lg text-gray-600 mb-5">
                        Every role, one developer — built with passion, precision, and coffee ☕
                    </p>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 justify-center">
                    <div class="text-center mb-5">
                        <div class="w-36 h-36 rounded-full mx-auto mb-4 flex items-center justify-center bg-white shadow text-blue-600 text-5xl">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <h5 class="text-xl font-semibold">Idea Architect</h5>
                        <p class="italic text-gray-500">Brainstorming & Vision</p>
                    </div>
                    <div class="text-center mb-5">
                        <div class="w-36 h-36 rounded-full mx-auto mb-4 flex items-center justify-center bg-white shadow text-green-600 text-5xl">
                            <i class="fas fa-code"></i>
                        </div>
                        <h5 class="text-xl font-semibold">Lead Developer</h5>
                        <p class="italic text-gray-500">Laravel & Vue Craftsmanship</p>
                    </div>
                    <div class="text-center mb-5">
                        <div class="w-36 h-36 rounded-full mx-auto mb-4 flex items-center justify-center bg-white shadow text-yellow-500 text-5xl">
                            <i class="fas fa-paint-brush"></i>
                        </div>
                        <h5 class="text-xl font-semibold">UI Designer</h5>
                        <p class="italic text-gray-500">Making it look good ✨</p>
                    </div>
                    <div class="text-center mb-5">
                        <div class="w-36 h-36 rounded-full mx-auto mb-4 flex items-center justify-center bg-white shadow text-red-500 text-5xl">
                            <i class="fas fa-rocket"></i>
                        </div>
                        <h5 class="text-xl font-semibold">DevOps</h5>
                        <p class="italic text-gray-500">Deploy & Maintain</p>
                    </div>
                </div>

                <!-- Socials -->
                <div class="text-center mt-8">
                    <div class="text-xl font-semibold mb-3">Follow Me!</div>

                    <!-- GitHub -->
                    <a class="text-2xl text-gray-700 mx-2" href="https://github.com/NjauSamuel" target="_blank">
                        <i class="fab fa-github"></i>
                    </a>

                    <!-- Twitter -->
                    <a class="text-2xl text-gray-700 mx-2" href="https://x.com/XammyBrand" target="_blank">
                        <i class="fab fa-twitter"></i>
                    </a>

                    <!-- Instagram -->
                    <a class="text-2xl text-gray-700 mx-2" href="https://www.instagram.com/xammy_brand/" target="_blank">
                        <i class="fab fa-instagram"></i>
                    </a>

                    <!-- Email -->
                    <a class="text-2xl text-gray-700 mx-2" href="mailto:njaus602@gmail.com" target="_blank">
                        <i class="fas fa-envelope"></i>
                    </a>
                </div>

            </div>
        </section>


    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/vue3';
</script>
