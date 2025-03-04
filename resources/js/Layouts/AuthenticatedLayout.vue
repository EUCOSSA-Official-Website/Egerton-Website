<script setup>
    import { ref, computed, watch, onMounted } from 'vue';
    import ApplicationLogo from '@/Components/ApplicationLogo.vue';
    import Dropdown from '@/Components/Dropdown.vue';
    import DropdownLink from '@/Components/DropdownLink.vue';
    import NavLink from '@/Components/NavLink.vue';
    import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
    import { Link, usePage } from '@inertiajs/vue3';
    import Swal from 'sweetalert2';
    import Echo from 'laravel-echo';


    const showingNavigationDropdown = ref(false);

    // Access the page props using usePage
    const page = usePage();
    
    // Compute the user from the auth prop
    const user  = computed(() => page.props.auth.user);
    
    
    // Passing the unread messages count to the view!
    const unreadMessages = computed(
        () => Math.min(page.props.messages.unreadMessages, 99)
    )

    // Passing the Un Approved Speakers Count
    const pendingApproval = computed(
        () => Math.min(page.props.messages.pendingSpeakerApproval, 99)
    )
    // Passing Count of Notifications In the System
    const notificationCount = computed(
        () => Math.min(page.props.messages.notificationCount, 99)
    )

    // Consoling the User Component
    // console.log(user.value);

    // PASSING THE TOAST MESSAGES

    // A ref to hold the flash message
    const flashMessage = ref(null);

    // Watch for changes to the flash message in Inertia's props
    watch(
        () => page.props.flash.success, // Observe the raw message from Inertia
        (newMessage) => {
            // Only update if there is a new message
            if (newMessage) {
                Swal.fire({
                    title: "Success!",
                    text: newMessage,
                    icon: "success",
                    confirmButtonText: "OK",
                });
            }
        },
        { immediate: true }
    );

    // Watch for error messages
    watch(
        () => page.props.flash.error,
        (newMessage) => {
            if (newMessage) {

                Swal.fire({
                    title: "Error!",
                    text: newMessage,
                    icon: "error",
                    confirmButtonText: "OK",
                });
            }
        },
        { immediate: true }
    );

    /* 
        *************************
        The Notifications Section
        *************************
    */
    const notifications = ref(page.props.notifications || []);

    onMounted(() => {

        if (window.Echo) {

            window.Echo.private(`App.Models.User.${page.props.auth.user.id}`)
                .notification((notification) => {
                    notifications.value.push(notification);

                    // Trigger SweetAlert when a new payment notification is received
                    Swal.fire({
                        title: "Payment Succeeded",
                        text: `Your payment of KSH ${notification.amount} was successful. Ticket Number: ${notification.receipt_number}. The Ticket will soon be sent to your email.`,
                        icon: "success",
                        confirmButtonText: "OK",
                    });
                });
        } else {
            console.error("Echo is not defined. Check if Laravel Echo is properly initialized.");
        }
    });



</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100 ">


             <!-- Ribbon -->
            <div class="hidden bg-gradient-to-r from-white via-blue-500 to-blue-600 text-white py-2 px-4 sm:flex justify-evenly items-center">
                <div class="flex items-center">
                    <!-- Logo -->
                    <Link :href="route('home')" class="flex items-center">
                        <ApplicationLogo
                            :height="40" :width="80" class="block h-12 w-auto fill-current text-gray-800 "
                        />
                    </Link>
                </div>
                <div class="text-center">
                    <span class="text-sm font-semibold">Together We Learn, Together We Grow.</span>
                </div>
                <div class="text-right">
                    <!-- Logo (You can replace with your logo image) -->
                     <a href="/payments#register">
                        <img src="/assets/img/register.png" alt="Site Logo" href="#register" class="h-10">
                    </a>
                </div>
            </div>


            <nav class="bg-white  border-b border-gray-100 sticky top-0 z-10">
                <!-- Primary Navigation Menu For Desktop -->
                <div class="max-w-7xl mx-auto pl-4 sm:px-6 lg:pl-6">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('home')" class="flex items-center">
                                    <ApplicationLogo
                                        :height="40" :width="80" class="block h-9 w-auto fill-current text-gray-800 "
                                    />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-4 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink :href="route('home')" :active="route().current('home')">
                                    Home
                                </NavLink>
                                <NavLink :href="route('payments')" :active="route().current('payments')">
                                    Payments
                                </NavLink>
                                <NavLink :href="route('events.index')" :active="route().current().startsWith('events')">
                                    Events
                                </NavLink>
                                <NavLink :href="route('call-for-speakers.create')" :active="route().current('call-for-speakers.create')">
                                    Speakers
                                </NavLink>
                                <NavLink :href="route('faqs')" :active="route().current('faqs')">
                                    FAQs
                                </NavLink>
                                <div v-if="user?.role === 'admin'" class="relative inline-flex">
                                    <NavLink :href="route('dashboard')" :active="route().current().startsWith('dashboard')">
                                        Dashboard
                                    </NavLink>
                                    <div v-if="unreadMessages" class="absolute flex items-center justify-center rounded-full bg-red-500 text-white w-6 h-6 text-xs font-semibold left-0 top-2">
                                        {{ unreadMessages }}
                                    </div>
                                    <div v-if="pendingApproval" class="absolute flex items-center justify-center rounded-full bg-blue-500 text-white w-6 h-6 text-xs font-semibold left-5 top-2">
                                        {{ pendingApproval }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ms-6">

                            <!-- The notifications Link  -->
                            <Link class="text-gray-500 relative pr-2 py-2" :href="route('notifications.index')">

                                <svg width="25px" height="25px" viewBox="0 0 128 128" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--noto" preserveAspectRatio="xMidYMid meet" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M53.32 18.8c0-7.09 5.77-12.86 12.86-12.86s12.86 5.77 12.86 12.86s-5.77 12.86-12.86 12.86S53.32 25.9 53.32 18.8zm7.48 0c0 2.97 2.41 5.38 5.38 5.38c2.97 0 5.38-2.41 5.38-5.38c0-2.97-2.41-5.38-5.38-5.38c-2.97 0-5.38 2.42-5.38 5.38z" fill="#e2a610"></path><path d="M77.24 12.28s.57 2.27-2.06 3.51c-2.63 1.23-4.37.32-4.37.32c.47.8.75 1.71.75 2.7c0 2.97-2.41 5.38-5.38 5.38c-2.97 0-5.38-2.41-5.38-5.38c0-.3.07-1.43.55-2.37c-4.46 2.12-7.85.31-7.85.31c-.11.67-.18 1.36-.18 2.06c0 7.09 5.77 12.86 12.86 12.86S79.04 25.9 79.04 18.8c0-2.38-.66-4.61-1.8-6.52z" fill="#9e740b"></path><path d="M10.46 97.8c6.77-6.65 10.99-8.89 12.71-18.53c1.72-9.64.34-29.95 7.92-43.25C38.01 23.84 50.71 18.8 63.1 18.8c.3 0 .6.02.9.02c.3-.01.6-.02.9-.02c12.39 0 25.09 5.04 32.01 17.21c7.57 13.31 6.2 33.62 7.92 43.25c1.72 9.64 5.94 11.88 12.71 18.53c2.92 2.87 6.45 7.44 6.46 10.38c.01 2.94-1.49 4.01-5.06 5.51c-10.1 4.25-23.6 8.37-54.94 8.37s-44.84-4.12-54.94-8.37c-3.57-1.5-5.07-2.56-5.06-5.51c.01-2.93 3.54-7.5 6.46-10.37z" fill="#ffca28"></path><path d="M113.7 108.38c0-4.43-22.25-8.02-49.7-8.02s-49.7 3.59-49.7 8.02s22.25 9.72 49.7 9.72s49.7-5.29 49.7-9.72z" fill="#4e342e"></path><path d="M93.84 44.79c.37 1.41.68 2.82.93 4.2c1.27 7.06 1.04 14.3 1.61 21.45c.77 9.57 2.47 14.61 6.34 19.11c.51.59-.01 1.5-.78 1.38c-5.17-.79-9.32-1.58-14.05-4.7c-7.06-4.65-8.8-13.4-8.85-21.26c-.08-11.7.14-23.03-.79-27.33c-1.29-5.99-2.49-9.18-4.45-12.09c-2.99-4.44 8.62 1.72 10.44 3.09c5.07 3.83 7.98 9.99 9.6 16.15z" fill="#e2a610"></path><path d="M30.89 60.32c-.12-7.58-.06-15.42 2.96-22.38c1.81-4.16 4.88-7.91 8.8-10.24c3.08-1.83 9.34-3.85 11.59.3c.45.83.63 1.8.66 2.75c.08 3.31-1.64 6.37-3.31 9.23c-4.94 8.48-6.91 17.75-9.52 27.15c-1.07 3.88-2.43 7.75-4.76 11.03c-1.6 2.25-10.51 10.25-8.47 3.02C30.8 74.19 31 67.6 30.89 60.32z" fill="#fff59d"></path><path d="M73.09 106.82c-.01-1.72-.94-2.71-3.08-3.45c-4.44-1.53-10-1.25-13.24.49c-3.4 1.82-1.04 11.91 7.23 11.91s9.1-7.64 9.09-8.95z" fill="#e2a610"></path><path d="M33.25 91.79c-8.78 1.54-15.14 4.87-17.89 7.57c-2.18 2.13-2.18 3.81 1.66 2.06c2.89-1.32 12.15-4 20.26-4.81c13.93-1.4 22.53-1.43 23.96-1.4c3.35.07 3.63-2.51-3.14-3.42c-6.77-.9-16.07-1.53-24.85 0z" fill="#fff59d"></path><path d="M60.46 113.82c1.16.8 2.7 1.19 4 .65c1.3-.54 2.14-2.19 1.5-3.44c-.25-.49-.68-.86-1.11-1.2c-1.19-.93-2.51-1.69-3.91-2.25c-.55-.22-1.13-.42-1.73-.38c-.59.03-1.21.34-1.44.89c-.99 2.25.99 4.57 2.69 5.73z" fill="#fff59d"></path></g></svg>
                                <div v-if="notificationCount"  class="absolute right-0 top-0 w-5 h-5 bg-red-700 dark:bg-red-400 text-white font-medium border border-white dark:border-gray-900 rounded-full text-xs text-center">
                                    {{notificationCount}}
                                </div>
                            </Link>
                            <!-- Settings Dropdown -->
                            <div class="ms-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500  bg-white  hover:text-gray-700  focus:outline-none transition ease-in-out duration-150"
                                            >
                                                {{ user?.name || 'Login / Register?' }}

                                                <div v-if="user?.google_avatar">
                                                    <!-- Display Google Avatar Image -->
                                                    <img :src="user.google_avatar" alt="User Avatar" class="ms-2 -me-0.5 rounded-full w-8 h-8" />
                                                </div>
                                                <div v-else>
                                                    <!-- Display Username SVG (or any default avatar) -->
                                                        <svg class="ms-2 -me-0.5 h-8 w-8" height="25px" width="25px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path style="fill:#FFFFFF;" d="M256,508C117.04,508,4,394.96,4,256S117.04,4,256,4s252,113.04,252,252S394.96,508,256,508z"></path> <path style="fill:#D6D6D6;" d="M256,8c136.752,0,248,111.248,248,248S392.752,504,256,504S8,392.752,8,256S119.248,8,256,8 M256,0 C114.608,0,0,114.608,0,256s114.608,256,256,256s256-114.608,256-256S397.392,0,256,0L256,0z"></path> <g> <ellipse style="fill:#0BA4E0;" cx="256" cy="175.648" rx="61.712" ry="60.48"></ellipse> <path style="fill:#0BA4E0;" d="M362.592,360.624c0-57.696-47.728-104.464-106.592-104.464s-106.592,46.768-106.592,104.464H362.592 z"></path> </g> </g></svg>
                                                </div>

                                                <svg
                                                    class="ms-2 -me-0.5 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>                                        
                                        <DropdownLink v-if="user?.name" :href="route('profile.edit')"> Profile </DropdownLink>
                                        <DropdownLink v-if="!user?.name" :href="route('login')" class="text-blue-500"> Login </DropdownLink>
                                        <DropdownLink v-if="!user?.name" :href="route('register')" class="text-blue-500"> Register </DropdownLink>

                                        <DropdownLink v-if="user?.name" :href="route('logout')" method="post" as="button">
                                            Log Out
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">

                            <!-- The notifications Link  -->
                            <Link class="text-gray-500 relative mr-5 py-2" :href="route('notifications.index')">

                                <svg width="25px" height="25px" viewBox="0 0 128 128" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--noto" preserveAspectRatio="xMidYMid meet" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M53.32 18.8c0-7.09 5.77-12.86 12.86-12.86s12.86 5.77 12.86 12.86s-5.77 12.86-12.86 12.86S53.32 25.9 53.32 18.8zm7.48 0c0 2.97 2.41 5.38 5.38 5.38c2.97 0 5.38-2.41 5.38-5.38c0-2.97-2.41-5.38-5.38-5.38c-2.97 0-5.38 2.42-5.38 5.38z" fill="#e2a610"></path><path d="M77.24 12.28s.57 2.27-2.06 3.51c-2.63 1.23-4.37.32-4.37.32c.47.8.75 1.71.75 2.7c0 2.97-2.41 5.38-5.38 5.38c-2.97 0-5.38-2.41-5.38-5.38c0-.3.07-1.43.55-2.37c-4.46 2.12-7.85.31-7.85.31c-.11.67-.18 1.36-.18 2.06c0 7.09 5.77 12.86 12.86 12.86S79.04 25.9 79.04 18.8c0-2.38-.66-4.61-1.8-6.52z" fill="#9e740b"></path><path d="M10.46 97.8c6.77-6.65 10.99-8.89 12.71-18.53c1.72-9.64.34-29.95 7.92-43.25C38.01 23.84 50.71 18.8 63.1 18.8c.3 0 .6.02.9.02c.3-.01.6-.02.9-.02c12.39 0 25.09 5.04 32.01 17.21c7.57 13.31 6.2 33.62 7.92 43.25c1.72 9.64 5.94 11.88 12.71 18.53c2.92 2.87 6.45 7.44 6.46 10.38c.01 2.94-1.49 4.01-5.06 5.51c-10.1 4.25-23.6 8.37-54.94 8.37s-44.84-4.12-54.94-8.37c-3.57-1.5-5.07-2.56-5.06-5.51c.01-2.93 3.54-7.5 6.46-10.37z" fill="#ffca28"></path><path d="M113.7 108.38c0-4.43-22.25-8.02-49.7-8.02s-49.7 3.59-49.7 8.02s22.25 9.72 49.7 9.72s49.7-5.29 49.7-9.72z" fill="#4e342e"></path><path d="M93.84 44.79c.37 1.41.68 2.82.93 4.2c1.27 7.06 1.04 14.3 1.61 21.45c.77 9.57 2.47 14.61 6.34 19.11c.51.59-.01 1.5-.78 1.38c-5.17-.79-9.32-1.58-14.05-4.7c-7.06-4.65-8.8-13.4-8.85-21.26c-.08-11.7.14-23.03-.79-27.33c-1.29-5.99-2.49-9.18-4.45-12.09c-2.99-4.44 8.62 1.72 10.44 3.09c5.07 3.83 7.98 9.99 9.6 16.15z" fill="#e2a610"></path><path d="M30.89 60.32c-.12-7.58-.06-15.42 2.96-22.38c1.81-4.16 4.88-7.91 8.8-10.24c3.08-1.83 9.34-3.85 11.59.3c.45.83.63 1.8.66 2.75c.08 3.31-1.64 6.37-3.31 9.23c-4.94 8.48-6.91 17.75-9.52 27.15c-1.07 3.88-2.43 7.75-4.76 11.03c-1.6 2.25-10.51 10.25-8.47 3.02C30.8 74.19 31 67.6 30.89 60.32z" fill="#fff59d"></path><path d="M73.09 106.82c-.01-1.72-.94-2.71-3.08-3.45c-4.44-1.53-10-1.25-13.24.49c-3.4 1.82-1.04 11.91 7.23 11.91s9.1-7.64 9.09-8.95z" fill="#e2a610"></path><path d="M33.25 91.79c-8.78 1.54-15.14 4.87-17.89 7.57c-2.18 2.13-2.18 3.81 1.66 2.06c2.89-1.32 12.15-4 20.26-4.81c13.93-1.4 22.53-1.43 23.96-1.4c3.35.07 3.63-2.51-3.14-3.42c-6.77-.9-16.07-1.53-24.85 0z" fill="#fff59d"></path><path d="M60.46 113.82c1.16.8 2.7 1.19 4 .65c1.3-.54 2.14-2.19 1.5-3.44c-.25-.49-.68-.86-1.11-1.2c-1.19-.93-2.51-1.69-3.91-2.25c-.55-.22-1.13-.42-1.73-.38c-.59.03-1.21.34-1.44.89c-.99 2.25.99 4.57 2.69 5.73z" fill="#fff59d"></path></g></svg>
                                <div v-if="notificationCount"  class="absolute right-0 top-0 w-5 h-5 bg-red-700 dark:bg-red-400 text-white font-medium border border-white dark:border-gray-900 rounded-full text-xs text-center">
                                    {{ notificationCount }}
                                </div>
                            </Link>
                            <button
                                @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400  hover:text-gray-500  hover:bg-gray-100  focus:outline-none focus:bg-gray-100  focus:text-gray-500  transition duration-150 ease-in-out"
                            >
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex': !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex': showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu For Mobile -->
                <div
                    :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
                    class="sm:hidden"
                >
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('home')" :active="route().current('home')">
                            Home
                        </ResponsiveNavLink>

                        <ResponsiveNavLink :href="route('payments')" :active="route().current('payments')">
                            Payments
                        </ResponsiveNavLink>

                        <ResponsiveNavLink :href="route('events.index')" :active="route().current().startsWith('events')">
                            Events
                        </ResponsiveNavLink>

                        <ResponsiveNavLink :href="route('call-for-speakers.create')" :active="route().current('call-for-speakers.create')">
                            Call For Speakers
                        </ResponsiveNavLink>

                        <ResponsiveNavLink :href="route('faqs')" :active="route().current('faqs')">
                            FAQs
                        </ResponsiveNavLink>

                        <div v-if="user?.role === 'admin'" class="relative inline-flex w-full">
                            <ResponsiveNavLink :href="route('dashboard')" :active="route().current().startsWith('dashboard')">
                                Dashboard
                            </ResponsiveNavLink>
                            <div v-if="unreadMessages" class="absolute flex items-center justify-center rounded-full bg-red-500 text-white w-6 h-6 text-xs font-semibold left-0 top-0">
                                {{ unreadMessages }}
                            </div>
                            <div v-if="pendingApproval" class="absolute flex items-center justify-center rounded-full bg-blue-500 text-white w-6 h-6 text-xs font-semibold left-5 top-0">
                                {{ pendingApproval }}
                            </div>
                        </div>
                        
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200 "> 
                        <div class="px-4">
                            <div class="inline-flex font-medium text-base text-gray-800  items-center">
                                {{ user?.name || 'Login / Register?' }}

                                <div v-if="user?.google_avatar">
                                    <!-- Display Google Avatar Image -->
                                    <img :src="user.google_avatar" alt="User Avatar" class="rounded-full w-8 h-8 ms-2 -me-0.5" />
                                </div>
                                <div v-else>
                                    <!-- Display Username SVG (or any default avatar) -->
                                        <svg class="ms-2 -me-0.5 h-8 w-8" height="25px" width="25px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path style="fill:#FFFFFF;" d="M256,508C117.04,508,4,394.96,4,256S117.04,4,256,4s252,113.04,252,252S394.96,508,256,508z"></path> <path style="fill:#D6D6D6;" d="M256,8c136.752,0,248,111.248,248,248S392.752,504,256,504S8,392.752,8,256S119.248,8,256,8 M256,0 C114.608,0,0,114.608,0,256s114.608,256,256,256s256-114.608,256-256S397.392,0,256,0L256,0z"></path> <g> <ellipse style="fill:#0BA4E0;" cx="256" cy="175.648" rx="61.712" ry="60.48"></ellipse> <path style="fill:#0BA4E0;" d="M362.592,360.624c0-57.696-47.728-104.464-106.592-104.464s-106.592,46.768-106.592,104.464H362.592 z"></path> </g> </g></svg>
                                </div>  
                                                      </div>
                            <div v-if="user?.email" class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                        </div>

                        <div class="mt-3 space-y-1">                            
                            <ResponsiveNavLink v-if="user?.name" :href="route('profile.edit')"> Profile </ResponsiveNavLink>
                            <ResponsiveNavLink v-if="!user?.name" :href="route('login')"> Login </ResponsiveNavLink>
                            <ResponsiveNavLink v-if="!user?.name" :href="route('register')"> Register </ResponsiveNavLink>
                            <ResponsiveNavLink v-if="user?.name" :href="route('logout')" method="post" as="button">
                                Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white  shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>

            <!-- Page Footer -->
            <footer class="bg-blue-700 py-4">
                <div class="container mx-auto px-5">
                    <div class="flex flex-col sm:flex-row items-center justify-between">
                        <div class="mb-2 sm:mb-0">
                            <div class="text-white text-sm">
                            Copyright &copy; EUCOSSA 2025
                            </div>
                        </div>
                        <div class="space-x-3">
                            <Link :href="route('about')" class="text-gray-100 underline text-sm hover:text-gray-300" href="#!">About</Link>
                            <span class="text-white mx-1">&middot;</span>
                            <Link :href="route('terms-and-conditions')" class="text-gray-100 underline text-sm hover:text-gray-300" href="#!">Terms</Link>
                            <span class="text-white mx-1">&middot;</span>
                            <Link :href="route('faqs')" class="text-gray-100 underline text-sm hover:text-gray-300" href="#!">Contact</Link>
                        </div>
                    </div>
                </div>
            </footer>

        </div>
    </div>
</template>

<style>
@media (max-width: 768px) {
  .responsiveButton {
    top: 0px !important;
  }
}

.toastify {
  position: fixed;
  bottom: 1rem;
  right: 1rem;
  z-index: 1050;
  opacity: 0;
  transform: translateX(100%); /* Start off-screen to the right */
  transition: opacity 2s ease, transform 2s ease; /* Slower transition for opacity and transform */
  visibility: hidden; /* Ensures it’s hidden when not active */
}

.toastify.show {
  opacity: 1;
  transform: translateX(0); /* Slide in from the right */
  visibility: visible; /* Make it visible when shown */
}

.toastify.hide {
  opacity: 0;
  transform: translateX(100%); /* Slide out to the right */
  visibility: hidden; /* Hide it after sliding out */
}

.toastify.error-alert {
  margin: 0;
  list-style: none;
}

.btn-close {
  background: none;
  border: none;
  padding: 0;
  cursor: pointer;
}

.btn-close svg {
  width: 1.5em;
  height: 1.5em;
  vertical-align: middle;
}
</style>
