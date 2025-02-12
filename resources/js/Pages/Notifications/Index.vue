<template>
    <AuthenticatedLayout>
        <Head title="Notifications"/>

        <section v-if="notifications?.data.length" class="text-gray-700 min-h-[80vh]">
            <div v-for="notification in notifications.data" :key="notification.id" class="border-b border-gray-800 py-4">
                <div>

                    <div v-if="notification.type === 'App\\Notifications\\EventPaymentSuccess'" class="flex justify-between items-center space-x-4">
                        <div>
                            Payment of Ksh {{notification.data.amount}} has been registered. Your ticket number is {{ notification.data.receipt_number }}.
                        </div>

                        <div>
                            <Link v-if="!notification.read_at" 
                                class="btn-outline text-xs font-bold uppercase bg-indigo-600 text-white rounded-md px-1 py-1 sm:mr-2" 
                                :href="route('notifications.seen', {notification: notification.id} )"
                                as="button"
                                method="put"
                            >
                                Mark as Read
                            </Link>
                        </div>
                    </div>
                    <!-- <span v-if="notification.type === 'App\Notifications\EventPaymentSuccess'">
                        Offer {{ notification.data.amount }} for 
                        <Link :href="route('realtor.listing.show', {listing: notification.data.listing_id})" class="text-indigo-600">
                            Listing
                        </Link>
                        was made. 
                    </span> -->
                    
                </div>            
                <!-- <div>
                    <Link v-if="!notification.read_at" 
                        class="btn-outline text-xs font-medium uppercase" 
                        :href="route('notifications.seen', {notification: notification.id} )"
                        as="button"
                        method="put"
                    >
                        Mark as Read
                    </Link>
                </div> -->
            </div>
        </section>

        <div v-if="!notifications?.data.length" class="border-b border-gray-200 py-4">
            <div class="flex items-center justify-center min-h-[80vh]">
                <div class="py-8 px-4 shadow-2xl shadow-b border-black">
                    No notifications Yet
                </div>
            </div>
        </div>

        <section v-if="notifications?.data.length" class="w-full flex justify-center">
            <Pagination :links="notifications.links"/>
        </section>
    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, Link } from '@inertiajs/vue3';
    import Pagination from '@/Components/Pagination.vue';

    const props = defineProps({
        notifications: Object
    });

    console.log(props.notifications);



</script>