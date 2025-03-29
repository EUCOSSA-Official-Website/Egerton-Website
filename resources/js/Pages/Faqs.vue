<template>
    <AuthenticatedLayout>

        <Head title="Faqs" />

        <header class="text-center pt-5 pb-2 bg-blue-700 text-white mb-16">
            <h1 class="text-2xl lg:text-4xl font-bold mt-5">Frequently Asked Questions</h1>
            <p class="text-xl lg:text-2xl py-3">How Can We Help You?</p>
        </header>
        
        <div class="grid grid-cols-12">

        <div class="col-span-11 lg:col-span-6 ml-10">
        <div v-for="(category, i) in categories" :key="category">
            <h2 class="font-bold mb-4 mt-8 text-2xl text-gray-800 border-b pb-1">{{ category }}</h2>

            <!-- Check if there are FAQs under this category -->
            <div v-if="props.faqs[category]?.length">
            <div
                v-for="(faq, j) in props.faqs[category]"
                :key="faq.id"
                class="rounded-lg border border-gray-200 mb-4 shadow-sm overflow-hidden transition-all duration-200"
                :class="{
                'border-l-4 border-blue-600 shadow-md': isOpen(`${i}-${j}`),
                'hover:shadow-md': !isOpen(`${i}-${j}`)
                }"
            >
                <h3
                @click="toggleAccordion(`${i}-${j}`)"
                class="flex justify-between items-center cursor-pointer px-4 py-3 bg-white hover:bg-gray-100 font-medium text-gray-900"
                >
                <span>{{ faq.question }}</span>
                <i
                    class="fas fa-chevron-down text-gray-600 transition-transform duration-300"
                    :class="{ 'rotate-180': isOpen(`${i}-${j}`) }"
                ></i>
                </h3>

                <div
                v-if="isOpen(`${i}-${j}`)"
                class="px-4 py-3 bg-gray-50 border-t border-gray-200 text-sm text-gray-700 whitespace-pre-line"
                >
                {{ faq.answer }}
                </div>
            </div>
            </div>

            <!-- No content fallback -->
            <div
            v-else
            class="text-gray-500 italic px-4 py-3 border border-gray-200 rounded-lg bg-white shadow-sm mt-2"
            >
            No content available.
            </div>
        </div>
        </div>

            <div class="col-span-10 mx-auto ml-4 mt-8 lg:col-span- lg:col-start-7 lg:mr-10 lg:mt-0 lg:mb-3">

                <!-- Contact Section -->
                <section id="contact" class="flex items-center justify-center min-h-screen bg-gray-100  mt-1">
                    <div class="w-full max-w-lg p-8 bg-white rounded-lg shadow-lg ">
                        <h2 class="text-3xl font-extrabold text-center text-gray-900  mb-8">Get in Touch</h2>
                        <p class="text-center text-gray-600  mb-8">We'd love to hear from you. Please fill out the
                            form below.</p>
                        <form @submit.prevent="submitForm" class="space-y-6">
                            <!-- Name Field -->
                            <div class="relative">
                                <label for="name" class="block text-sm font-medium text-gray-700 ">Your Name</label>
                                <input v-model="form.name" type="text" id="name"
                                    class="block w-full mt-1 p-3 rounded-lg bg-gray-50  text-gray-900  border-2  focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="John Doe" required>
                            </div>

                            <!-- Email Field -->
                            <div class="relative">
                                <label for="email" class="block text-sm font-medium text-gray-700 ">Your Email</label>
                                <input v-model="form.email" type="email" id="email"
                                    class="block w-full mt-1 p-3 rounded-lg bg-gray-50  text-gray-900  border-2  focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="john@example.com" required>
                            </div>

                            <!-- Message Field -->
                            <div class="relative">
                                <label for="message" class="block text-sm font-medium text-gray-700 ">Message</label>
                                <textarea v-model="form.message" id="message"
                                    class="block w-full mt-1 p-3 rounded-lg bg-gray-50  text-gray-900  border-2  focus:ring-blue-500 focus:border-blue-500"
                                    rows="3" placeholder="Your message here..." required></textarea>
                            </div>

                            <!-- Submit Button -->
                            <div class="text-center">
                                <button type="submit"
                                    class="inline-block w-full py-3 px-5 bg-blue-600 text-white font-bold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500  ">
                                    Send Message
                                </button>
                            </div>
                        </form>

                        <!-- Additional Info -->
                        <div class="mt-6 text-center text-sm text-gray-600 ">
                            <p>Or contact us directly via email: <a href="mailto:eucossake@gmail.com"
                                    class="text-blue-600 ">eucossake@gmail.com</a>
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

    const props = defineProps({
        faqs: Object
    });
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

    // ✅ This was missing
    const categories = [
        'Payment Issues',
        'Registration',
        'Club Constitution',
        'Other'
    ];
</script>

<style scoped>
    .rotate-180 {
    transform: rotate(180deg);
    }
</style>
