<script setup>
    import { ref, computed } from 'vue';
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
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100 ">
            <nav class="bg-white  border-b border-gray-100 ">
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
                                                {{ user?.name || 'Guest' }}

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
                                        <DropdownLink v-if="!user?.name" :href="route('login')"> Login </DropdownLink>
                                        <DropdownLink v-if="!user?.name" :href="route('register')"> Register </DropdownLink>

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
                                {{ user?.name || 'Guest' }}

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
                            <ResponsiveNavLink :href="route('profile.edit')"> Profile </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('logout')" method="post" as="button">
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
                            Copyright &copy; EUCOSSA 2024
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
