<template>

    <GuestLayout>

        <Head title="Mobile" />

        <div
            class="w-full sm:max-w-md mt-6 px-6 py-4  shadow-md overflow-hidden sm:rounded-lg border border-slate-100"
        >        
            
            <h2 class="text-2xl sm:text-3xl text-nowrap mt-2 mb-4 text-gray-900 ">Complete Your Registration</h2>

                <form @submit.prevent="submitForm">
                    
                    <div class="mt-4">
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

                        <!-- Display the error message for mobile number -->
                        <InputError class="mt-2" :message="form.errors.mobile" />
                    </div>
                    <div class="mt-4">
                        <InputLabel for="reg_number" value="Registration Number:" />

                        <TextInput
                            id="reg_number"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.reg_number"
                            placeholder="S13/04319/21"
                            required
                            autofocus
                        />
                        <InputError class="mt-2" :message="form.errors.reg_number" />
                    </div>
                    <div class="mt-4">
                        <InputLabel for="password" value="Password" />

                        <TextInput
                            id="password"
                            type="password"
                            class="mt-1 block w-full"
                            v-model="form.password"
                            required
                            autocomplete="new-password"
                            :showToggle="true"
                        />

                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="password_confirmation" value="Confirm Password" />

                        <TextInput
                            id="password_confirmation"
                            type="password"
                            class="mt-1 block w-full"
                            v-model="form.password_confirmation"
                            required
                            autocomplete="new-password"
                            :showToggle="true"
                        />

                        <InputError class="mt-2" :message="form.errors.password_confirmation" />
                    </div>

                    <PrimaryButton class="mt-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Submit
                    </PrimaryButton>
                    
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
        google_avatar: props.googleAvatar,
        reg_number: '',
        password: '',
        password_confirmation: '',
    });

    // Posting The Form To The Post Route
    const submitForm = () => {
        form.post(route('register.mobile.submit'))
    };
</script>

