<template>
    <AuthenticatedLayout>

        <Head title="Faqs" />

        <header class="text-center pt-5 pb-2 bg-blue-700 text-white mb-16">
            <h1 class="text-2xl lg:text-4xl font-bold mt-5">Frequently Asked Questions</h1>
            <p class="text-xl lg:text-2xl py-3">How Can We Help You?</p>
        </header>
        
        <div class="grid grid-cols-12">

            <div class="col-span-11 lg:col-span-6 ml-10">

                <h2 class="font-bold mb-3 text-2xl">Payment Issues</h2>

                
                <!-- Accordion Item 1 -->
                <div class="border rounded-lg">
                    <h3 @click="toggleAccordion(1)" class="flex justify-between items-center cursor-pointer px-4 py-3 bg-white hover:bg-gray-200">
                    Accordion Item #1
                    <svg class="w-5 h-5" :class="isOpen(1) ? 'rotate-180' : ''" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                    </h3>
                    <div v-if="isOpen(1)" class="px-4 py-3">
                        <div class="accordion-body bg-white">
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
                    <h3 @click="toggleAccordion(2)" class="flex justify-between items-center cursor-pointer px-4 py-3 bg-white hover:bg-gray-200">
                    Accordion Item #2
                    <svg class="w-5 h-5" :class="isOpen(2) ? 'rotate-180' : ''" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                    </h3>
                    <div v-if="isOpen(2)" class="px-4 py-3">
                        <div class="accordion-body bg-white">
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
                    <h3 @click="toggleAccordion(3)" class="flex justify-between items-center cursor-pointer px-4 py-3 bg-white hover:bg-gray-200">
                    Accordion Item #3
                    <svg class="w-5 h-5" :class="isOpen(3) ? 'rotate-180' : ''" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                    </h3>
                    <div v-if="isOpen(3)" class="px-4 py-3">
                        <div class="accordion-body bg-white">
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
                    <h3 @click="toggleAccordion(4)" class="flex justify-between items-center cursor-pointer px-4 py-3 bg-white hover:bg-gray-200">
                    Accordion Item #4
                    <svg class="w-5 h-5" :class="isOpen(4) ? 'rotate-180' : ''" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                    </h3>
                    <div v-if="isOpen(4)" class="px-4 py-3">
                        <div class="accordion-body bg-white">
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
                    <h3 @click="toggleAccordion(5)" class="flex justify-between items-center cursor-pointer px-4 py-3 bg-white hover:bg-gray-200">
                    Accordion Item #5
                    <svg class="w-5 h-5" :class="isOpen(5) ? 'rotate-180' : ''" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                    </h3>
                    <div v-if="isOpen(5)" class="px-4 py-3">
                        <div class="accordion-body bg-white">
                            <strong>This is the second item's accordion body.</strong>
                            It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element.
                            These classes control the overall appearance, as well as the showing and hiding via CSS transitions.
                            You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just
                            about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                    </div>
                </div>
                
            </div>

            <div class="col-span-10 mx-auto ml-4 mt-8 lg:col-span- lg:col-start-7 lg:mr-10 lg:mt-0 lg:mb-3">

                <!-- Contact Section -->
                <section id="contact" class="flex items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900 mt-1">
                    <div class="w-full max-w-lg p-8 bg-white rounded-lg shadow-lg dark:bg-gray-800">
                        <h2 class="text-3xl font-extrabold text-center text-gray-900 dark:text-white mb-8">Get in Touch</h2>
                        <p class="text-center text-gray-600 dark:text-gray-300 mb-8">We'd love to hear from you. Please fill out the
                            form below.</p>
                        <form @submit.prevent="submitForm" class="space-y-6">
                            <!-- Name Field -->
                            <div class="relative">
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Your Name</label>
                                <input v-model="form.name" type="text" id="name"
                                    class="block w-full mt-1 p-3 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white border-2 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="John Doe" required>
                            </div>

                            <!-- Email Field -->
                            <div class="relative">
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Your Email</label>
                                <input v-model="form.email" type="email" id="email"
                                    class="block w-full mt-1 p-3 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white border-2 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="john@example.com" required>
                            </div>

                            <!-- Message Field -->
                            <div class="relative">
                                <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Message</label>
                                <textarea v-model="form.message" id="message"
                                    class="block w-full mt-1 p-3 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white border-2 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500"
                                    rows="3" placeholder="Your message here..." required></textarea>
                            </div>

                            <!-- Submit Button -->
                            <div class="text-center">
                                <button type="submit"
                                    class="inline-block w-full py-3 px-5 bg-blue-600 text-white font-bold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-blue-700 dark:hover:bg-blue-800">
                                    Send Message
                                </button>
                            </div>
                        </form>

                        <!-- Additional Info -->
                        <div class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400">
                            <p>Or contact us directly via email: <a href="mailto:eucossake@gmail.com"
                                    class="text-blue-600 dark:text-blue-400">eucossake@gmail.com</a>
                            </p>
                        </div>
                    </div>
                </section>
            </div>

        </div>
    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, useForm } from '@inertiajs/vue3';
    import { ref } from 'vue';

    const openAccordion = ref(null);

    const toggleAccordion = (index) => {
      openAccordion.value = openAccordion.value === index ? null : index;
    };

    const isOpen = (index) => {
      return openAccordion.value === index;
    };

    const form = useForm({
        name: '',
        email: '',
        message: ''
    });

    // Submitting the Registration Form
    const submitForm = () => {      
        form.post(route('faqs-send-email'), {
            onSuccess: () => {
                // Show a message that STK Push has been sent
                alert("Your Message Is sent Successfully. 🎉");
            }
        });
    };
</script>

<style scoped>
    .rotate-180 {
    transform: rotate(180deg);
    }
</style>
