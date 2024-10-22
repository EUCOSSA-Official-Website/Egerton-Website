<template>
    <AuthenticatedLayout>
        <Head title="Terms" />

         <!-- Page Header -->
        <header class="bg-blue-700 py-5 text-white">
            <div class="container mx-auto text-center">
                <h1 class="text-3xl font-bold">Terms and Conditions</h1>
                <p class="mt-2 text-lg">Your privacy and security are our priority</p>
            </div>
        </header>

        <!-- Terms and Conditions Content -->
        <section class="container mx-auto py-10 px-5 lg:px-20">
            <div class="bg-white shadow-lg rounded-lg p-8">
                <h2 class="text-2xl font-semibold mb-4">Introduction</h2>
                <p class="text-gray-600 mb-6">
                    Welcome to EUCOSSA’s website. By accessing or using our website, you agree to the following terms and conditions.
                    We are committed to protecting your privacy and ensuring that your personal information is handled in a safe and responsible manner.
                </p>

                <h2 class="text-2xl font-semibold mb-4">Data Protection</h2>
                <p class="text-gray-600 mb-6">
                    We value your trust and are dedicated to keeping your personal information safe. This includes, but is not limited to, your:
                </p>
                <ul class="list-disc list-inside mb-6 text-gray-600">
                    <li>Contact details (e.g., email address, phone number)</li>
                    <li>Data provided via Google services (e.g., name, profile picture)</li>
                    <li>Other data provided through forms on this website</li>
                </ul>

                <h2 class="text-2xl font-semibold mb-4">Use of Personal Information</h2>
                <p class="text-gray-600 mb-6">
                    Your personal information is collected solely for the purpose of providing services on our website, enhancing your experience, and contacting you if needed. Rest assured that:
                </p>
                <ul class="list-disc list-inside mb-6 text-gray-600">
                    <li>Your data will not be shared outside of EUCOSSA’s website without your explicit consent.</li>
                    <li>We will not sell, lease, or distribute your contact information or any personal data to third parties.</li>
                    <li>Your email address and phone number will be used only for communication purposes related to your interactions with us.</li>
                </ul>

                <h2 class="text-2xl font-semibold mb-4">Google Data Usage</h2>
                <p class="text-gray-600 mb-6">
                    When you sign in with Google or provide data from your Google account, we only access the information necessary to provide our services. Any data received from Google will be protected under this privacy policy and not shared outside our platform.
                </p>

                <h2 class="text-2xl font-semibold mb-4">Security</h2>
                <p class="text-gray-600 mb-6">
                    We are committed to ensuring that your information is secure. We have implemented suitable security measures to safeguard your data and prevent unauthorized access or disclosure.
                </p>

                <h2 class="text-2xl font-semibold mb-4">Changes to These Terms</h2>
                <p class="text-gray-600 mb-6">
                    EUCOSSA reserves the right to update or modify these terms at any time. We will notify you of any significant changes to how we handle personal information.
                </p>

                <h2 class="text-2xl font-semibold mb-4">Contact Us</h2>
                <p class="text-gray-600 mb-6">
                    If you have any questions or concerns regarding our Terms and Conditions or how we handle your data, feel free to contact us at:
                    <a href="mailto:contact@eucossa.com" class="text-indigo-600 hover:text-indigo-400">contact@eucossa.com</a>.
                </p>
            </div>
        </section>
    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/vue3';
</script>
