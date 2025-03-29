<template>
    <AuthenticatedLayout>

        <Head title="Admin" />

        <section>

            <header class="text-center py-5 bg-blue-700 text-white relative">
                <Link :href="route('dashboard')"><h1 class="font-bold text-4xl">Dashboard</h1></Link>
                <p class="text-2xl font-normal mb-0">
                    All Admin Functions Are Here!
                </p>

                <Link :href="route('dashboard.clear.cache')"
                    class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-white text-blue-600 font-bold text-xs px-2 py-1 rounded shadow hover:bg-gray-100 transition flex items-center gap-2">
                    <i class="fas fa-sync-alt"></i> Clear Cache
                </Link>


            </header>

            <div class="grid grid-cols-12 min-h-[60vh] py-5">                

                <div class="overflow-x-auto col-span-12 lg:col-span-8 ml-2 order-2 lg:order-1">
                    <slot>
                        <div style="background-image: url('/assets/img/admin_dashboard.png'); background-size: cover; background-position: center; height: 350px; width: 800px;">
                        </div>
                    </slot>
                </div>

                <div class="ml-2 lg:ml-0 mt-4 lg:mt-0 col-span-12 lg:col-span-3 lg:col-start-10 bg-slate-300 lg:min-h-[50vh] max-h-fit lg:sticky lg:top-20 order-1 lg:order-2">

                    <div class="relative">
                        <Link 
                            :href="route('dashboard.analytics')"
                            :class="{ 'active-class': route().current('dashboard.analytics'), 'inactive-class': !route().current('dashboard.analytics') }" >
                            Analytics
                        </Link>
                        <div v-if="unreadMessages" class="absolute flex items-center justify-center rounded-full bg-red-500 text-white w-6 h-6 text-xs font-semibold left-2 top-1">
                            {{ unreadMessages }}
                        </div>
                    </div>

                    <div class="relative">
                        <Link 
                            :href="route('dashboard.speakers')"
                            :class="{ 'active-class': route().current('dashboard.speakers'), 'inactive-class': !route().current('dashboard.speakers') }" >
                            Speakers
                        </Link>
                        <div v-if="pendingApproval" class="absolute flex items-center justify-center rounded-full bg-blue-500 text-white w-6 h-6 text-xs font-semibold left-2 top-1">
                            {{ pendingApproval }}
                        </div>
                    </div>

                    <Link :href="route('dashboard.events.create')" :class="{ 'active-class': route().current('dashboard.events.create'), 'inactive-class': !route().current('dashboard.events.create') }">
                        Post An Event
                    </Link>

                    <Link :href="route('dashboard.finances')" :class="{ 'active-class': route().current('dashboard.finances'), 'inactive-class': !route().current('dashboard.finances') }">
                        Club Finances
                    </Link>

                    <Link :href="route('dashboard.attendees')" :class="{ 'active-class': route().current('dashboard.attendees'), 'inactive-class': !route().current('dashboard.attendees') }">
                        Event Attendees
                    </Link>
                </div>

            </div>
            
        </section>         
    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Link, Head, usePage } from '@inertiajs/vue3';
    import { computed } from 'vue';

    const page = usePage()
    
    // Passing the unread messages count to the view!
    const unreadMessages = computed(
        () => Math.min(page.props.messages.unreadMessages, 99)
    )

    // Passing the Un Approved Speakers Count
    const pendingApproval = computed(
        () => Math.min(page.props.messages.pendingSpeakerApproval, 99)
    )
    
</script>
