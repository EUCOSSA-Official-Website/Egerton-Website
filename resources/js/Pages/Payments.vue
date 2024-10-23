<template>

    <Head title="Payments" />

    <AuthenticatedLayout>
        <!-- Welcome Section -->
        <section class="min-h-[80vh] relative bg-gray-200 px-5 py-10 sm:px-20 mx-auto">

            <!-- The Registration Part -->
            <div id="registration" class="bg-white shadow-lg p-8 sm:p-12 rounded-md mb-20 sm:mb-10 ">
                <h1 class="text-3xl font-bold mb-4">Club Registration</h1>

                <p class="text-gray-800 mb-6">
                    Thanks for signing up to the site. <span class="text-xs text-red-500">(If not signed up, do so <Link :href="route('register')" class="text-indigo-500 underline">Here</Link>)!</span> EUCOSSA's activites are mostly funded by 
                    the students themselves, for this purpose, we only charge a one time fee of 
                    <span class="px-1 font-black font-sans">50sh (Or more if you wish to be generous)</span>  to be a part of the club and support 
                    its activites. 
                </p>

                <h2 class="text-2xl font-semibold mb-3">To Get Started, Make The One Time Payment Below</h2>

                <form @submit.prevent="submitForm" class="max-w-lg mx-auto p-4 bg-slate-100 shadow-xl rounded sm:my-5 mb-6 border">
                    <h3 class="text-2xl text-green-500 font-semibold mb-3">M-PESA</h3>
                    <!-- Phone Number -->
                    <div class="mb-4">
                        <label for="phone" class="block font-medium text-gray-700">Phone Number</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 mr-3">+254</span>
                            <input type="number" id="phone" v-model="form.phone" class="form-input pl-14" placeholder="Enter Your Phone Number" />
                        </div>
                        <div v-if="form.errors.phone" class="input-error"> {{ form.errors.phone }} </div>
                    </div>

                    <!-- Amount -->
                    <div class="mb-4">
                        <label for="amount" class="block font-medium text-gray-700">Enter Amount <span class="text-xs ml-3 text-red-400">(50 minimum)</span></label>
                        <input type="number" id="amount" v-model="form.amount" class="form-input" placeholder="Enter The Amount" />
                        <div v-if="form.errors.amount" class="input-error"> {{ form.errors.amount }} </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="submit-button">
                        Register
                    </button>
                </form>

            </div>

            <!-- Semester Subscriptions Part -->
            <div id="subscriptions" class="bg-white shadow-lg p-8 sm:p-12 rounded-md mb-20 sm:mb-10">
                <h2 class="text-2xl font-bold mb-4">Semester Subscriptions</h2> 

                <p class="text-gray-800 mb-6">
                    EUCOSSA is an independent organization and with this we rely on students
                    donations to run our activities such as this sites hosting. As per our 
                    constitution members are required to subscribe with 
                    <span class="px-1 font-black font-sans">50sh (Or more if you wish to be generous)</span> 
                    per semester to keep our clubs accounts a float.                  
                </p>

                <h2 class="text-2xl font-semibold mb-6">To Make This semester's Subscription Please Pay Below: <span class="text-xs ml-3 text-green-500">Make Sure You're Registered First</span></h2>

                <form  class="max-w-lg mx-auto p-4 bg-slate-100 shadow-xl rounded sm:my-5 mb-6 border">

                    <h3 class="text-2xl text-green-500 font-semibold mb-3">M-PESA</h3>
                    <!-- Phone Number -->
                    <div class="mb-4">
                        <label for="phone" class="block font-medium text-gray-700">Phone Number</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 mr-3">+254</span>
                            <input type="text" id="phone" v-model="formDeleted" class="form-input pl-14" placeholder="Enter Your Phone Number" />
                        </div>
                        <div v-if="form.errors.phone" class="input-error"> {{ form.errors.phone }} </div>
                    </div>

                    <!-- Amount -->
                    <div class="mb-4">
                        <label for="amount" class="block font-medium text-gray-700">Enter Amount <span class="text-xs ml-3 text-red-400">(50 minimum)</span></label>
                        <input type="number" id="amount" v-model="form.amount" class="form-input" placeholder="Enter The Amount" />
                        <div v-if="form.errors.amount" class="input-error"> {{ form.errors.amount }} </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="submit-button">
                        Make Payment
                    </button>
                </form>
            </div>

            <!-- Donations Section -->
            <div id="donations" class="bg-white shadow-lg p-8 sm:p-12 rounded-md mb-10">
                <h2 class="text-2xl font-bold mb-4">Donations <svg class="inline" fill="#ff0000" width="35px" height="35px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M17.726 13.02 14 16H9v-1h4.065a.5.5 0 0 0 .416-.777l-.888-1.332A1.995 1.995 0 0 0 10.93 12H3a1 1 0 0 0-1 1v6a2 2 0 0 0 2 2h9.639a3 3 0 0 0 2.258-1.024L22 13l-1.452-.484a2.998 2.998 0 0 0-2.822.504zm1.532-5.63c.451-.465.73-1.108.73-1.818s-.279-1.353-.73-1.818A2.447 2.447 0 0 0 17.494 3S16.25 2.997 15 4.286C13.75 2.997 12.506 3 12.506 3a2.45 2.45 0 0 0-1.764.753c-.451.466-.73 1.108-.73 1.818s.279 1.354.73 1.818L15 12l4.258-4.61z"></path></g></svg></h2>

                <p class="mb-10 font">
                    EUCOSSA is dedicated to empowering the next generation of tech innovators 
                    at Egerton University. By fostering a vibrant community of learners and 
                    supporting specialized groups like <span class="font-bold"> Frontend, Blockchain, Backend, Data 
                    Science, Machine Learning, and 3D </span>, we're creating a space where ideas can 
                    flourish and careers can take flight.

                    <br><br>
                    
                    <span class="font-bold"> Your generous donation will help us continue this important work. </span>
                    Together, we can shape the future of technology. 

                    <br><br>

                    We are currenlty supporting <span class="font-semibold">Card</span> and <span class="font-semibold">MPesa</span> Payments for any other means, 
                    please contact us <Link :href="route('faqs')" class="text-indigo-500 font-semibold">Here!</Link>
                </p>

                <div class="flex flex-col sm:flex-row justify-center sm:space-x-10">
                    <div class="sm:min-w-[450px]">
                        <h3 class="text-2xl text-green-500 font-semibold mb-5">M-PESA</h3>
                        <form  class="max-w-lg min-w-lg p-4 bg-slate-100 shadow-xl rounded sm:my-5 mb-6 border">
                            <!-- Phone Number -->
                            <div class="mb-4">
                                <label for="phone" class="block font-medium text-gray-700">Phone Number</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 mr-3">+254</span>
                                    <input type="number" id="phone" v-model="formDeleted" class="form-input pl-14" placeholder="Enter Your Phone Number" />
                                </div>
                                <div v-if="form.errors.phone" class="input-error"> {{ form.errors.phone }} </div>
                            </div>

                            <!-- Amount -->
                            <div class="mb-4">
                                <label for="amount" class="block font-medium text-gray-700">Enter Amount </label>
                                <input type="number" id="amount" v-model="form.amount" class="form-input" placeholder="Enter The Amount" />
                                <div v-if="form.errors.amount" class="input-error"> {{ form.errors.amount }} </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="bg-red-500 hover:bg-red-700 submit-button">
                                Make Donation
                            </button>
                        </form>
                    </div>
                    <div class="sm:min-w-[450px]">
                        <h3 class="text-2xl text-blue-500 font-semibold mb-5">VISA / MASTERCARD</h3>
                        <form  class="max-w-lg p-4 bg-slate-100 shadow-xl rounded sm:my-5 mb-6 border">
                            <!-- Phone Number -->
                            <div class="mb-4">
                                <label for="phone" class="block font-medium text-gray-700">Phone Number</label>
                                <input type="text" id="phone" v-model="formDeleted" class="form-input" placeholder="Enter Your Phone Number" />
                                <div v-if="form.errors.phone" class="input-error"> {{ form.errors.phone }} </div>
                            </div>

                            <!-- Amount -->
                            <div class="mb-4">
                                <label for="amount" class="block font-medium text-gray-700">Enter Amount</label>
                                <input type="text" id="amount" v-model="form.amount" class="form-input" placeholder="Enter The Amount" />
                                <div v-if="form.errors.amount" class="input-error"> {{ form.errors.amount }} </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="bg-red-500 hover:bg-red-700 submit-button">
                                Make Donation
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, useForm, Link } from '@inertiajs/vue3';
    import {ref} from 'vue';

    const formDeleted = ref(null);

    const form = useForm({
        phone: '',
        amount: ''
    });

    // Submitting the Form
    const submitForm = () => {      
      form.post(route('register50'));
    };

</script>

<style scoped>
    p {
        font-family: "Georgia", Cambria ui-serif, "Georgia", Cambria, Times New Roman, Times, serif, Proxima Nova;
        color: rgb(31 41 55 / var(--tw-text-opacity)) /* #1f2937 */;
        line-height: 1.625;
    }
</style>
