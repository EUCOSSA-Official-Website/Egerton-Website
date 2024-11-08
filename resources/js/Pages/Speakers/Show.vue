<template>
    <Head title="Speaker" />

    <AuthenticatedLayout>

        <header class="text-2xl lg:text-4xl my-4 text-center bg-blue-700 text-white py-5 font-bold">
            <Link :href="(route('dashboard'))" class="underline">Dashboard</Link> → <Link :href="route('dashboard.speakers')" class="underline">Speakers</Link>→ <Link class="underline">Speaker</Link>
        </header>

        <div class="min-h-[50vh] grid grid-cols-12 lg:mb-28">
            <div class="col-span-12 lg:col-span-8 bg-white rounded-lg shadow-lg grid grid-cols-8">
                <ol class="space-y-2 text-gray-700 text-lg col-span-8 px-6 pt-6 lg:col-span-3">
                    <li><strong>Name:</strong> {{ speaker.name }}</li>
                    <li><strong>Year Of Study:</strong> {{ speaker.year_of_study }}</li>
                    <li><strong>Other Year:</strong> {{ speaker.other_year ?? null }}</li>
                    <li><strong>Topic:</strong> {{ speaker.topic }}</li>                    
                    <li><strong>Stack:</strong> {{ speaker.stack }}</li>
                    <li><strong>Skill:</strong> {{ speaker.skill }}</li>
                    <li><strong>Phone:</strong> {{ speaker.phone }}</li>
                </ol>

                <ol class="space-y-2 text-gray-700 text-lg col-span-8 lg:col-span-4 px-6 py-2 lg:p-6">
                    <li><strong>Description:</strong> {{ speaker.description }}</li>
                    <li><strong>Email:</strong> {{ speaker.email }}</li>
                </ol>
            </div>


            <div class="col-span-12 lg:col-span-4 bg-blue-400 max-h-[50vh] flex flex-col py-5 lg:py-14">

                <div class="py-8 px-4 text-white">
                    <strong class="text-2xl">Applied At: </strong>{{formattedDate}}
                </div>

                <div class="flex justify-evenly pb-4 ">
                    <Link :href="route('call-for-speakers.update', {call_for_speaker: speaker.id})" as="button" method="put" :data="{ approval_status: 'approved' }"><PrimaryButton>Approve</PrimaryButton></Link>
                    <Link :href="route('call-for-speakers.update', {call_for_speaker: speaker.id})" as="button" method="put" :data="{ approval_status: 'disapproved' }"><SecondaryButton>Dissaprove</SecondaryButton></Link>
                    <Link :href="route('call-for-speakers.destroy', {call_for_speaker: speaker.id})" as="button" method="delete"><PrimaryButton class="bg-red-600 hover:bg-red-700">Delete</PrimaryButton></Link>
                </div>
            </div>
     
        </div>
    </AuthenticatedLayout>

</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, Link } from '@inertiajs/vue3';
    import { computed } from 'vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import SecondaryButton from '@/Components/SecondaryButton.vue';

    const props = defineProps({
        speaker: Object
    });

    const formattedDate = computed(() => {
      const date = new Date(props.speaker.created_at);
      return `${date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      })} at ${date.toLocaleTimeString('en-US', {
        hour: '2-digit',
        minute: '2-digit',
        hour12: true
      })}`;
    });
</script>
