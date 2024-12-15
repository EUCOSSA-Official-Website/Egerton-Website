<template>

    <GuestLayout>

        <Head title="Mobile" />

        <div
            class="w-full sm:max-w-md mt-6 px-6 py-4  shadow-md overflow-hidden sm:rounded-lg border border-slate-100"
        >        
            
            <h2 class="text-2xl sm:text-3xl text-nowrap mt-2 mb-4 text-gray-900 ">Complete Your Registration</h2>

                <form @submit.prevent="submitForm">
                    
                    <InputLabel for="number" value="Phone Number:" />

                    <TextInput
                        id="number"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.mobile"
                        placeholder="0722 000 000"
                        required
                        autofocus
                    />

                    <PrimaryButton class="mt-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Submit
                    </PrimaryButton>

                    <!-- Display the error message for mobile number -->
                    <InputError class="mt-2" :message="form.errors.mobile" />
                </form>
        </div>
    </GuestLayout>
</template>

<script setup>

    import { useForm, Head } from '@inertiajs/vue3';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import TextInput from '@/Components/TextInput.vue';
    import GuestLayout from '@/Layouts/GuestLayout.vue';

    const props = defineProps({
        googleName: String,
        googleEmail: String,
        googleId: String,
        googleAvatar: String,
    });

    // Seting up the form using useForm
    const form = useForm({
        mobile: '',
        name: props.googleName,
        email: props.googleEmail,
        google_id: props.googleId,
        google_avatar: props.googleAvatar
    });

    // Posting The Form To The Post Route
    const submitForm = () => {
        form.post(route('register.mobile.submit'))
    };
</script>

