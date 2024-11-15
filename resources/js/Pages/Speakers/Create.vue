<template>
    <Head title="Speakers" />

    <AuthenticatedLayout>
        <div class="flex items-center justify-center min-h-[100vh] bg-slate-100">

            <div class="w-full max-w-lg p-8 bg-white rounded-lg shadow-md my-3">

                <!-- Form Image Header -->
                <header class="speakers_call bg-cover bg-center my-2" style="background-image: url('/assets/img/Speaker.png')">
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

                <form @submit.prevent="submitForm">
                    <div class="mb-4">
                        <label for="email" class="form-label">Email <span class="text-red-500">*</span></label>
                        <input type="email" id="email" name="email" v-model="form.email" required class="form-input">
                        <div v-if="form.errors.email" class="input-error"> {{ form.errors.email }} </div>
                    </div>

                    <div class="mb-4">
                        <label for="full-name" class="form-label">Your Full Names <span class="text-red-500">*</span></label>
                        <input type="text" id="full-name" name="full_name" v-model="form.name" required class="form-input">
                        <div v-if="form.errors.name" class="input-error"> {{ form.errors.name }} </div>
                    </div>

                    <div class="mb-4">
                        <label for="year-of-study" class="form-label">
                            Year of Study <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-2 space-y-2">
                            <div>
                                <input type="radio" id="year1" value="1" v-model="form.year_of_study" name="year-of-study" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <label for="year1" class="ml-2 text-sm text-gray-700">1st</label>
                            </div>
                            <div>
                                <input type="radio" id="year2" value="2" v-model="form.year_of_study" name="year-of-study" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <label for="year2" class="ml-2 text-sm text-gray-700">2nd</label>
                            </div>
                            <div>
                                <input type="radio" id="year3" value="3" v-model="form.year_of_study" name="year-of-study" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <label for="year3" class="ml-2 text-sm text-gray-700">3rd</label>
                            </div>
                            <div>
                                <input type="radio" id="year4" value="4" v-model="form.year_of_study" name="year-of-study" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <label for="year4" class="ml-2 text-sm text-gray-700">4th</label>
                            </div>
                            <div class="inline my-2">
                                <input type="radio" id="other" value="other" v-model="form.year_of_study" name="year-of-study" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <label for="other" class="ml-2 text-sm text-gray-700">Other</label>
                                <!-- Conditionally show input if "Other" is selected -->
                                <input v-if="form.year_of_study === 'other'" type="text" v-model="form.other_year" required placeholder="Please specify" class="mt-2 inline ml-2 min-w-[290px] sm:min-w-[375px] px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <div v-if="form.errors.other_year" class="input-error"> {{ form.errors.other_year }} </div>
                            </div>

                            <div v-if="form.errors.year_of_study" class="input-error"> {{ form.errors.year_of_study }} </div>
                        </div>
                    </div>



                    <div class="mb-4">
                        <label for="presentation-topic" class="form-label">Presentation Topic? <span class="text-red-500">*</span></label>
                        <input v-model="form.topic" type="text" id="presentation-topic" name="presentation_topic" required class="form-input">
                        <div v-if="form.errors.topic" class="input-error"> {{ form.errors.topic }} </div>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label">Describe Topic: <span class="text-red-500">*</span></label>
                        <input type="text" id="description" name="description" v-model="form.description" required class="form-input">
                        <div v-if="form.errors.description" class="input-error"> {{ form.errors.description }} </div>
                    </div>

                    <div class="mb-4">
                        <label for="stack" class="form-label">What is your stack? (Specialization) <span class="text-red-500">*</span></label>
                        <input type="text" id="stack" name="stack" v-model="form.stack" required class="form-input">
                        <div v-if="form.errors.stack" class="input-error"> {{ form.errors.stack }} </div>
                    </div>

                    <div class="mb-4">
                        <label for="skills" class="form-label">
                            How well are your skills in your mentioned topic? <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-2 space-y-2">
                            <div>
                                <input v-model="form.skill" type="radio" id="beginner" name="skills" value="beginner" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <label for="beginner" class="ml-2 text-sm text-gray-700">Beginner</label>
                            </div>
                            <div>
                                <input v-model="form.skill" type="radio" id="intermediate" name="skills" value="intermediate" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <label for="intermediate" class="ml-2 text-sm text-gray-700">Intermediate</label>
                            </div>
                            <div>
                                <input v-model="form.skill" type="radio" id="pro" name="skills" value="pro" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <label for="pro" class="ml-2 text-sm text-gray-700">Pro</label>
                            </div>
                            <div>
                                <input v-model="form.skill" type="radio" id="not_sure" name="skills" value="not_sure" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <label for="not_sure" class="ml-2 text-sm text-gray-700">Not sure</label>
                            </div>
                        </div>
                        <div v-if="form.errors.skill" class="input-error"> {{ form.errors.skill }} </div>
                    </div>


                    <div class="mb-4">
                        <label for="mobile-number" class="form-label">Fill in your mobile number <span class="text-red-500">*</span></label>
                        <input v-model="form.phone" type="tel" id="mobile-number" name="mobile_number" required class="form-input">
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

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, useForm, usePage } from '@inertiajs/vue3';

    // Getting the current user.  
    const page = usePage();

    const form = useForm({
        email: page.props.auth.user?.email,
        name: page.props.auth.user?.name,
        year_of_study: "",
        other_year: "",
        topic: "",
        description: "",
        stack: "",
        skill: "",
        phone: page.props.auth.user?.mobile
    });

    const submitForm = () => {

        // Checking To See if the user is authenticated to be able to send out the form. 
        if (!page.props.auth.user) {
            alert('Login to Submit Your Speaker Application!');
            return; // Stop further execution if the user is not logged in
        }

        form.post(route('call-for-speakers.store'));
    };
</script>
