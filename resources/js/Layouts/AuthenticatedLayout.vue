<script setup>
    import { ref, computed, watch } from 'vue';
    import ApplicationLogo from '@/Components/ApplicationLogo.vue';
    import Dropdown from '@/Components/Dropdown.vue';
    import DropdownLink from '@/Components/DropdownLink.vue';
    import NavLink from '@/Components/NavLink.vue';
    import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
    import { Link, usePage } from '@inertiajs/vue3';

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

    // Consoling the User Component
    // console.log(user.value);

    // PASSING THE TOAST MESSAGES
    const alerts = ref([]);

    // Add and remove toasts
    function addToast(message, type = 'info') {
        const id = Date.now();
        alerts.value.push({ id, message, type });

        // Remove toast after 8 seconds
        setTimeout(() => {
            removeToast(id);
        }, 8000);
    }

    function removeToast(id) {
        alerts.value = alerts.value.filter(toast => toast.id !== id);
    }

    // A ref to hold the flash message
    const flashMessage = ref(null);

    // Watch for changes to the flash message in Inertia's props
    watch(
        () => page.props.flash.success, // Observe the raw message from Inertia
        (newMessage) => {
            // Only update if there is a new message
            if (newMessage && newMessage !== flashMessage.value) {
                flashMessage.value = newMessage; // Set new message
                addToast(newMessage, 'success'); // Display the toast
            }
        },
        { immediate: true }
    );

</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100 ">

            <!-- THE TOAST MESSAGE -->
            <div class="border-black">
                <div v-for="toast in alerts" :key="toast.id" class="toastify show bg-blue-500 text-white font-bold border border-slate-200 border-l-8 border-l-blue-500 py-8 text-sm px-3 relative shadow-2xl">
                    <p>{{ toast.message }}</p>
                    <button class="btn-close absolute top-1 left-1" @click="removeToast(toast.id)" >
                        <svg height="40px" width="40px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 506.4 506.4" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <circle style="fill:#f31212;" cx="253.2" cy="253.2" r="249.2"></circle> <path style="fill:#F4EFEF;" d="M281.6,253.2l90.8-90.8c4.4-4.4,4.4-12,0-16.4l-11.2-11.2c-4.4-4.4-12-4.4-16.4,0L254,225.6 l-90.8-90.8c-4.4-4.4-12-4.4-16.4,0L135.6,146c-4.4,4.4-4.4,12,0,16.4l90.8,90.8L135.6,344c-4.4,4.4-4.4,12,0,16.4l11.2,11.6 c4.4,4.4,12,4.4,16.4,0l90.8-90.8l90.8,90.8c4.4,4.4,12,4.4,16.4,0l11.2-11.6c4.4-4.4,4.4-12,0-16.4L281.6,253.2z"></path> <path d="M253.2,506.4C113.6,506.4,0,392.8,0,253.2S113.6,0,253.2,0s253.2,113.6,253.2,253.2S392.8,506.4,253.2,506.4z M253.2,8 C118,8,8,118,8,253.2s110,245.2,245.2,245.2s245.2-110,245.2-245.2S388.4,8,253.2,8z"></path> <path d="M352.8,379.6c-4,0-8-1.6-11.2-4.4l-88-88l-88,88c-2.8,2.8-6.8,4.4-11.2,4.4c-4,0-8-1.6-11.2-4.4L132,364 c-2.8-2.8-4.4-6.8-4.4-11.2c0-4,1.6-8,4.4-11.2l88-88l-88-88c-2.8-2.8-4.4-6.8-4.4-11.2c0-4,1.6-8,4.4-11.2l11.2-11.2 c6-6,16.4-6,22,0l88,88l88-88c2.8-2.8,6.8-4.4,11.2-4.4l0,0c4,0,8,1.6,11.2,4.4l11.2,11.2c6,6,6,16,0,22l-88,88l88,88 c2.8,2.8,4.4,6.8,4.4,11.2c0,4-1.6,8-4.4,11.2l-11.2,11.2C360.8,378,357.2,379.6,352.8,379.6L352.8,379.6z M253.6,277.2 c1.2,0,2,0.4,2.8,1.2l90.8,90.8c1.6,1.6,3.2,2.4,5.6,2.4l0,0c2,0,4-0.8,5.6-2.4l11.6-11.6c1.6-1.6,2.4-3.2,2.4-5.6 c0-2-0.8-4-2.4-5.6l-90.8-90.8c-0.8-0.8-1.2-1.6-1.2-2.8s0.4-2,1.2-2.8l90.8-90.8c2.8-2.8,2.8-8,0-10.8l-11.2-11.2 c-1.6-1.6-3.2-2.4-5.6-2.4l0,0c-2,0-4,0.8-5.6,2.4L256.8,228c-1.6,1.6-4,1.6-5.6,0l-90.8-90.8c-2.8-2.8-8-2.8-10.8,0L138,148.4 c-1.6,1.6-2.4,3.2-2.4,5.6s0.8,4,2.4,5.6l90.8,90.8c1.6,1.6,1.6,4,0,5.6L138,346.8c-1.6,1.6-2.4,3.2-2.4,5.6c0,2,0.8,4,2.4,5.6 l11.6,11.6c2.8,2.8,8,2.8,10.8,0l90.8-90.8C251.6,277.6,252.4,277.2,253.6,277.2z"></path> </g></svg>
                    </button>
                </div>
            </div>

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
                     <a href="#register">
                        <img src="/assets/img/register.png" alt="Site Logo" href="#register" class="h-10">
                    </a>
                </div>
            </div>


            <nav class="bg-white  border-b border-gray-100 sticky top-0 z-10">
                <!-- Primary Navigation Menu -->
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

                <!-- Responsive Navigation Menu -->
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

                        <div class="relative inline-flex w-full">
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
