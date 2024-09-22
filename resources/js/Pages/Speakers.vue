<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/vue3';
</script>


<template>
    <Head title="Speakers" />

    <AuthenticatedLayout>
        <div class="flex items-center justify-center min-h-[100vh] bg-slate-100">

            <div class="w-full max-w-lg p-8 bg-white rounded-lg shadow-md my-3">

                <!-- Form Image Header -->
                <header class="speakers_call bg-cover bg-center my-2" style="background-image: url('/assets/img/home-bg.jpg')">
                    <div class="container relative mx-auto px-4 lg:px-5">
                        <div class="flex justify-left">
                            <div class="w-full">
                                <h1 class="text-4xl font-bold text-white mb-3">A <span class="text-blue-300">Call</span> for <span class="text-blue-300">Speakers</span></h1>
                                <p class="text-xl text-gray-100">
                                    The <span class="text-blue-300">EUCOSSA</span> fraternity wishes to inform you that we value and nurture talent. 
                                    For that reason, we are calling upon any interested individual who would like 
                                    to present on any of the Tech Friday events to fill out the form below.
                                </p>
                            </div>
                        </div>
                    </div>
                </header>

                <form action="/submit" method="POST">
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email <span class="text-red-500">*</span></label>
                        <input type="email" id="email" name="email" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    <div class="mb-4">
                        <label for="full-name" class="block text-sm font-medium text-gray-700">Your Full Names <span class="text-red-500">*</span></label>
                        <input type="text" id="full-name" name="full_name" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    <div class="mb-4">
                        <label for="year-of-study" class="block text-sm font-medium text-gray-700">
                            Year of Study <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-2 space-y-2">
                            <div>
                                <input type="radio" id="year1" value="1" v-model="yearOfStudy" name="year-of-study" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <label for="year1" class="ml-2 text-sm text-gray-700">1st</label>
                            </div>
                            <div>
                                <input type="radio" id="year2" value="2" v-model="yearOfStudy" name="year-of-study" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <label for="year2" class="ml-2 text-sm text-gray-700">2nd</label>
                            </div>
                            <div>
                                <input type="radio" id="year3" value="3" v-model="yearOfStudy" name="year-of-study" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <label for="year3" class="ml-2 text-sm text-gray-700">3rd</label>
                            </div>
                            <div>
                                <input type="radio" id="year4" value="4" v-model="yearOfStudy" name="year-of-study" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <label for="year4" class="ml-2 text-sm text-gray-700">4th</label>
                            </div>
                            <div>
                                <input type="radio" id="other" value="other" v-model="yearOfStudy" name="year-of-study" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <label for="other" class="ml-2 text-sm text-gray-700">Other</label>
                            </div>
                        </div>

                        <!-- Conditionally show input if "Other" is selected -->
                        <input v-if="yearOfStudy === 'other'" type="text" v-model="otherYear" placeholder="Please specify" class="mt-2 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>



                    <div class="mb-4">
                        <label for="presentation-topic" class="block text-sm font-medium text-gray-700">Presentation Topic? <span class="text-red-500">*</span></label>
                        <input type="text" id="presentation-topic" name="presentation_topic" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    <div class="mb-4">
                        <label for="stack" class="block text-sm font-medium text-gray-700">What is your stack? (Specialization) <span class="text-red-500">*</span></label>
                        <input type="text" id="stack" name="stack" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    <div class="mb-4">
                        <label for="skills" class="block text-sm font-medium text-gray-700">
                            How well are your skills in the mentioned area? <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-2 space-y-2">
                            <div>
                                <input type="radio" id="beginner" name="skills" value="beginner" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <label for="beginner" class="ml-2 text-sm text-gray-700">Beginner</label>
                            </div>
                            <div>
                                <input type="radio" id="intermediate" name="skills" value="intermediate" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <label for="intermediate" class="ml-2 text-sm text-gray-700">Intermediate</label>
                            </div>
                            <div>
                                <input type="radio" id="pre_intermediate" name="skills" value="pre_intermediate" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <label for="pre_intermediate" class="ml-2 text-sm text-gray-700">Pre-intermediate</label>
                            </div>
                            <div>
                                <input type="radio" id="pro" name="skills" value="pro" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <label for="pro" class="ml-2 text-sm text-gray-700">Pro</label>
                            </div>
                            <div>
                                <input type="radio" id="not_sure" name="skills" value="not_sure" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <label for="not_sure" class="ml-2 text-sm text-gray-700">Not sure</label>
                            </div>
                        </div>
                    </div>


                    <div class="mb-4">
                        <label for="mobile-number" class="block text-sm font-medium text-gray-700">Fill in your mobile number <span class="text-red-500">*</span></label>
                        <input type="tel" id="mobile-number" name="mobile_number" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    <p class="text-xs text-gray-500">Thank You For Your Time!</p>

                    <div class="mt-6">
                        <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
    export default {
        data() {
            return {
            // Component data
            };
        },
        methods: {
            // Component methods
        }
    };
</script>
