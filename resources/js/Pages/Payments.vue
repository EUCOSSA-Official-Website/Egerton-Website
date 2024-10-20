<template>

    <Head title="Payments" />

    <AuthenticatedLayout>
        <!-- Welcome Section -->
        <section class="min-h-[80vh] relative bg-gray-50">
            <h1 class="text-5xl text-pink-500">STK PUSH</h1>

            <form @submit.prevent="submitForm" class="max-w-lg mx-auto p-4 bg-white shadow-md rounded sm:my-5">
                <!-- Phone Number -->
                <div class="mb-4">
                    <label for="phone" class="block font-medium text-gray-700">Phone Number</label>
                    <input type="text" id="phone" v-model="form.phone" class="form-input" placeholder="Enter Your Phone Number" />
                    <div v-if="form.errors.phone" class="input-error"> {{ form.errors.phone }} </div>
                </div>

                <!-- Amount -->
                <div class="mb-4">
                    <label for="amount" class="block font-medium text-gray-700">Enter Amount</label>
                    <input type="text" id="amount" v-model="form.amount" class="form-input" placeholder="Enter The Amount" />
                    <div v-if="form.errors.amount" class="input-error"> {{ form.errors.amount }} </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="submit-button">
                    Make Payment
                </button>
            </form>
        </section>
    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, useForm } from '@inertiajs/vue3';

    const form = useForm({
        phone: '',
        amount: ''
    });

    // Submitting the Form
    const submitForm = () => {      
      form.post(route('stkpush'));
    };

</script>
