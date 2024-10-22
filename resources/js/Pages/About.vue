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
                                Get To Know Your System Makers
                            </h1>
                            <p class="text-lg font-normal text-gray-600 mb-4">
                                Our team consists of multitalented individuals each
                                with unique expertise in different software
                                engineering aspects. Get to know us more as well as
                                how you could reach us.
                            </p>
                            <a class="btn btn-primary text-white text-lg bg-blue-500 hover:bg-blue-600 px-5 py-3 rounded-lg" href="#scroll-target">
                                Get To Know Us!
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
                        <img class="w-full rounded mb-5 lg:mb-0" src="https://dummyimage.com/600x400/343a40/6c757d" alt="..." />
                    </div>
                    <div class="lg:w-1/2">
                        <h2 class="font-bold text-2xl">Our founding</h2>
                        <p class="text-lg font-normal text-gray-600 mt-4">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            Iusto est, ut esse a labore aliquam beatae expedita.
                            Blanditiis impedit numquam libero molestiae et fugit
                            cupiditate, quibusdam expedita, maiores eaque quisquam.
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
                        <h2 class="font-bold text-2xl">Others 😂</h2>
                        <p class="text-lg font-normal text-gray-600 mt-4">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            Iusto est, ut esse a labore aliquam beatae expedita.
                            Blanditiis impedit numquam libero molestiae et fugit
                            cupiditate, quibusdam expedita, maiores eaque quisquam.
                        </p>
                    </div>

                    <div class="lg:w-1/2 order-first lg:order-last">
                        <img class="w-full rounded mb-5 lg:mb-0" src="https://dummyimage.com/600x400/343a40/6c757d" alt="..." />
                    </div>
                </div>
            </div>
        </section>

        <!-- Leaders Section -->
        <section class="py-5 bg-gray-100">
            <div class="container mx-auto px-5 my-5">
                <div class="text-center">
                    <h2 class="text-3xl font-bold mb-3">Our Leaders</h2>
                    <p class="text-lg text-gray-600 mb-5">
                        Dedicated to quality and your success
                    </p>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 justify-center">
                    <div class="text-center mb-5">
                        <img
                            class="w-36 h-36 rounded-full mx-auto mb-4"
                            src="https://dummyimage.com/150x150/ced4da/6c757d"
                            alt="Ibbie Eckart" />
                        <h5 class="text-xl font-semibold">Ibbie Eckart</h5>
                        <p class="italic text-gray-500">Founder &amp; CEO</p>
                    </div>
                    <div class="text-center mb-5">
                        <img
                            class="w-36 h-36 rounded-full mx-auto mb-4"
                            src="https://dummyimage.com/150x150/ced4da/6c757d"
                            alt="Arden Vasek" />
                        <h5 class="text-xl font-semibold">Arden Vasek</h5>
                        <p class="italic text-gray-500">CFO</p>
                    </div>
                    <div class="text-center mb-5">
                        <img
                            class="w-36 h-36 rounded-full mx-auto mb-4"
                            src="https://dummyimage.com/150x150/ced4da/6c757d"
                            alt="Toribio Nerthus" />
                        <h5 class="text-xl font-semibold">Toribio Nerthus</h5>
                        <p class="italic text-gray-500">Operations Manager</p>
                    </div>
                    <div class="text-center mb-5">
                        <img
                            class="w-36 h-36 rounded-full mx-auto mb-4"
                            src="https://dummyimage.com/150x150/ced4da/6c757d"
                            alt="Malvina Cilla" />
                        <h5 class="text-xl font-semibold">Malvina Cilla</h5>
                        <p class="italic text-gray-500">CTO</p>
                    </div>
                </div>
                <div class="text-center mt-8">
                    <div class="text-xl font-semibold mb-3">Follow us</div>
                    <a class="text-2xl text-gray-700 mx-2" href="https://x.com/eucossake" target="_blank">
                        <i class="bi-twitter"></i>
                    </a>
                    <a class="text-2xl text-gray-700 mx-2" href="https://www.instagram.com/eucossake?igsh=MTEwaGx2NzF2d3B6ZA%3D%3D" target="_blank" >
                        <i class="bi-instagram"></i>
                    </a>
                    <a class="text-2xl text-gray-700 mx-2" href="https://www.youtube.com/@eucossake2200" target="_blank" >
                        <i class="bi-youtube"></i>
                    </a>
                    <a class="text-2xl text-gray-700 mx-2" href="mailto:eucossake@gmail.com" target="_blank">
                        <i class="bi-envelope"></i>
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
