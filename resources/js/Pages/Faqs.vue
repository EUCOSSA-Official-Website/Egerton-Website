<template>
    <AuthenticatedLayout>

        <Head title="Faqs" />

        <div class="text-center py-10">
            <h1 class="text-4xl font-bold mt-5">Frequently Asked Questions</h1>

            <p class="text-2xl text-slate-500 py-3">How Can We Help You?</p>
        </div>
        
        <div class="grid grid-cols-12">

            <div class="col-span-11 sm:col-span-7 ml-10">

                <h2 class="font-bold mb-3 text-2xl">Payment Issues</h2>

                
                <!-- Accordion Item 1 -->
                <div class="border rounded-lg">
                    <h3 @click="toggleAccordion(1)" class="flex justify-between items-center cursor-pointer px-4 py-3 bg-gray-100 hover:bg-gray-200">
                    Accordion Item #1
                    <svg class="w-5 h-5" :class="isOpen(1) ? 'rotate-180' : ''" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                    </h3>
                    <div v-if="isOpen(1)" class="px-4 py-3">
                        <div class="accordion-body">
                            <strong>This is the first item's accordion body.</strong>
                            It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element.
                            These classes control the overall appearance, as well as the showing and hiding via CSS transitions.
                            You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just
                            about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                    </div>
                </div>

                <!-- Accordion Item 2 -->
                <div class="border rounded-lg">
                    <h3 @click="toggleAccordion(2)" class="flex justify-between items-center cursor-pointer px-4 py-3 bg-gray-100 hover:bg-gray-200">
                    Accordion Item #2
                    <svg class="w-5 h-5" :class="isOpen(2) ? 'rotate-180' : ''" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                    </h3>
                    <div v-if="isOpen(2)" class="px-4 py-3">
                        <div class="accordion-body">
                            <strong>This is the second item's accordion body.</strong>
                            It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element.
                            These classes control the overall appearance, as well as the showing and hiding via CSS transitions.
                            You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just
                            about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                    </div>
                </div>

                <h2 class="font-bold mb-3 mt-6 text-2xl">Registration</h2>

                <!-- Accordion Item 3 -->
                <div class="border rounded-lg">
                    <h3 @click="toggleAccordion(3)" class="flex justify-between items-center cursor-pointer px-4 py-3 bg-gray-100 hover:bg-gray-200">
                    Accordion Item #3
                    <svg class="w-5 h-5" :class="isOpen(3) ? 'rotate-180' : ''" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                    </h3>
                    <div v-if="isOpen(3)" class="px-4 py-3">
                        <div class="accordion-body">
                            <strong>This is the second item's accordion body.</strong>
                            It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element.
                            These classes control the overall appearance, as well as the showing and hiding via CSS transitions.
                            You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just
                            about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                    </div>
                </div>

                <!-- Accordion Item 4 -->
                <div class="border rounded-lg">
                    <h3 @click="toggleAccordion(4)" class="flex justify-between items-center cursor-pointer px-4 py-3 bg-gray-100 hover:bg-gray-200">
                    Accordion Item #4
                    <svg class="w-5 h-5" :class="isOpen(4) ? 'rotate-180' : ''" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                    </h3>
                    <div v-if="isOpen(4)" class="px-4 py-3">
                        <div class="accordion-body">
                            <strong>This is the second item's accordion body.</strong>
                            It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element.
                            These classes control the overall appearance, as well as the showing and hiding via CSS transitions.
                            You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just
                            about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                    </div>
                </div>

                <h2 class="font-bold mb-3 mt-6 text-2xl">Club's Constitution</h2>

                <!-- Accordion Item 5 -->
                <div class="border rounded-lg">
                    <h3 @click="toggleAccordion(5)" class="flex justify-between items-center cursor-pointer px-4 py-3 bg-gray-100 hover:bg-gray-200">
                    Accordion Item #5
                    <svg class="w-5 h-5" :class="isOpen(5) ? 'rotate-180' : ''" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                    </h3>
                    <div v-if="isOpen(5)" class="px-4 py-3">
                        <div class="accordion-body">
                            <strong>This is the second item's accordion body.</strong>
                            It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element.
                            These classes control the overall appearance, as well as the showing and hiding via CSS transitions.
                            You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just
                            about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                    </div>
                </div>
                
            </div>

            <div class="col-span-10 ml-20 mt-8 sm:col-span-4 sm:col-start-9 sm:mr-10 sm:mt-0">

                <div class="bg-slate-300 py-12 flex flex-col items-center justify-center space-y-2">
                    <strong class="block">Have More Questions?</strong>

                    <p class="text-slate-800 block">Contact us at:</p>

                    <a href="mailto:eucossake@gmail.com" class="text-indigo-500">eucossake@gmail.com</a>
                </div>
            </div>

        </div>
    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/vue3';
    import { ref } from 'vue';

    const openAccordion = ref(null);

    const toggleAccordion = (index) => {
      openAccordion.value = openAccordion.value === index ? null : index;
    };

    const isOpen = (index) => {
      return openAccordion.value === index;
    };
</script>

<style scoped>
    .rotate-180 {
    transform: rotate(180deg);
    }
</style>
