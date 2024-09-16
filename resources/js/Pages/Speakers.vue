<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/vue3';
</script>


<template>
    <Head title="Speakers" />

    <AuthenticatedLayout>
        <div class="flex items-center justify-center min-h-[100vh] bg-slate-100">
            <div class="w-full max-w-lg p-8 bg-white rounded-lg shadow-md">
                <h1 class="text-2xl font-bold mb-4">Call for Speakers</h1>
                <p class="mb-6 text-gray-700">The Eucossa fraternity wishes to inform you that we value and nurture talent. For that reason, we are calling upon any interested individual who would like to present on any of the Tech Friday events to fill out the form below.</p>

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
                        <label for="year-of-study" class="block text-sm font-medium text-gray-700">Year of Study <span class="text-red-500">*</span></label>
                        <select id="year-of-study" v-model="yearOfStudy" name="year_of_study" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="1">1st</option>
                            <option value="2">2nd</option>
                            <option value="3">3rd</option>
                            <option value="4">4th</option>
                            <option value="other">Other</option>
                        </select>
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
                        <label for="skills" class="block text-sm font-medium text-gray-700">How well are your skills in the mentioned area? <span class="text-red-500">*</span></label>
                        <select id="skills" name="skills" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="beginner">Beginner</option>
                            <option value="intermediate">Intermediate</option>
                            <option value="pre_intermediate">Pre-intermediate</option>
                            <option value="pro">Pro</option>
                            <option value="not_sure">Not sure</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="mobile-number" class="block text-sm font-medium text-gray-700">Fill in your mobile number <span class="text-red-500">*</span></label>
                        <input type="tel" id="mobile-number" name="mobile_number" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    <p class="text-xs text-gray-500">Never submit passwords through Google Forms.</p>

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
