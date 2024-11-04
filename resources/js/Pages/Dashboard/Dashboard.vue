<template>
    <AuthenticatedLayout>

        <Head title="Admin" />

        <section>

            <header class="text-center py-5 bg-blue-700 text-white">
                <Link :href="route('dashboard')"><h1 class="font-bold text-4xl">Dashboard</h1></Link>
                <p class="text-2xl font-normal mb-0">
                    All Admin Functions Are Here!
                </p>
            </header>

            <div class="grid grid-cols-12 min-h-[60vh] py-5">                

                <div class="overflow-x-auto col-span-12 lg:col-span-8 ml-2 order-2 lg:order-1">
                    <slot>
                        <div style="background-image: url('/assets/img/admin_dashboard.png'); background-size: cover; background-position: center; height: 350px; width: 800px;">
                        </div>
                    </slot>
                </div>

                <div class="ml-2 lg:ml-0 mt-4 lg:mt-0 col-span-12 lg:col-span-3 lg:col-start-10 bg-slate-300 lg:min-h-[50vh] max-h-fit lg:sticky lg:top-20 order-1 lg:order-2">

                    <Link 
                        :href="route('analytics')"
                        :class="{ 'active-class': route().current('analytics'), 'inactive-class': !route().current('analytics') }" >
                        Analytics
                    </Link>

                    <Link :href="route('speakers')" :class="{ 'active-class': route().current('speakers'), 'inactive-class': !route().current('speakers') }">
                        Speakers
                    </Link>

                    <Link :href="route('events.create')" :class="{ 'active-class': route().current('events.create'), 'inactive-class': !route().current('events.create') }">
                        Post An Event
                    </Link>

                    <Link :href="route('finances')" :class="{ 'active-class': route().current('finances'), 'inactive-class': !route().current('finances') }">
                        Club Finances
                    </Link>

                    <Link :href="route('attendees')" :class="{ 'active-class': route().current('attendees'), 'inactive-class': !route().current('attendees') }">
                        Event Attendees
                    </Link>
                </div>

            </div>
            
        </section>         
    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Link, Head } from '@inertiajs/vue3';
</script>
