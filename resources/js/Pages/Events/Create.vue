<template>
    <AuthenticatedLayout>

        <div class="max-w-lg mx-auto p-4 bg-white shadow-md rounded sm:my-5">
            <h2 class="text-2xl font-bold mb-4">Create Event</h2>

            <form @submit.prevent="submitForm">
            <!-- Event Title -->
            <div class="mb-4">
                <label for="title" class="block font-medium text-gray-700">Event Title</label>
                <input type="text" id="title" v-model="form.title"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Enter event title"
                    required
                />
            </div>

            <!-- Event Description -->
            <div class="mb-4">
                <label for="description" class="block font-medium text-gray-700">Description</label>
                <textarea id="description" v-model="form.description"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="Enter event description"
                required
                ></textarea>
            </div>

            <!-- Event Image -->
            <div class="mb-4">
            <label for="image" class="block font-medium text-gray-700">Upload Image</label>
            <input
                type="file"
                id="image"
                @change="handleImageUpload"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                required
            />
            </div>

            <!-- Event Day (Calendar) -->
            <div class="mb-4">
                <label for="event_day" class="block font-medium text-gray-700">Event Day</label>
                <input
                type="date"
                id="event_day"
                v-model="form.event_day"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                required
                />
            </div>

            <!-- Start Time -->
            <div class="mb-4">
                <label for="start-time" class="block font-medium text-gray-700">Start Time</label>
                <input
                type="time"
                id="start-time"
                class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg p-2"
                min="09:00"
                max="19:00"
                v-model="form.start_time"
                required
                />
            </div>

            <!-- End Time -->
            <div class="mb-4">
                <label for="end-time" class="block font-medium text-gray-700">End Time</label>
                <input
                type="time"
                id="end-time"
                class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg p-2"
                min="09:00"
                max="19:00"
                v-model="form.end_time"
                required
                />
            </div>

            <!-- Speaker -->
            <div class="mb-4">
                <label for="speaker" class="block font-medium text-gray-700">Speaker</label>
                <input
                type="text"
                id="speaker"
                v-model="form.speaker"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="Enter speaker's name"
                required
                />
            </div>

            <!-- Reminder Checkbox -->
            <div class="mb-4">
                <label class="block font-medium text-gray-700">
                <input
                    type="checkbox"
                    v-model="form.reminder"
                    class="mr-2 leading-tight"
                />
                Set Reminder
                </label>
            </div>

            <!-- Submit Button -->
            <button
                type="submit"
                class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md shadow hover:bg-indigo-700 focus:outline-none"
            >
                Create Event
            </button>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { useForm } from '@inertiajs/vue3';
    

    // Initializing the form using `useForm`
    const form = useForm({
        title: '',
        description: '',
        image: null, // Placeholder for image file
        event_day: '',
        start_time: '14:00', // Default start time
        end_time: '16:00',   // Default end time
        speaker: '',
        reminder: false,
    });

    // Method to handle image upload
    const handleImageUpload = (event) => {
        form.image = event.target.files[0]; // Store the uploaded image file in the form object
    };

    const submitForm = () => {
      // You can access startTime.value and endTime.value
      console.log('Start Time:', startTime.value);
      console.log('End Time:', endTime.value);
      // Further processing like form submission
    };

</script>
