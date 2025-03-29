<template>
    <Dashboard>
                
        <!-- Create Event Section -->
        <button
            @click="showEventForm = !showEventForm"
            class="w-full bg-blue-500 text-white text-left px-6 py-4 text-2xl tracking-wide font-bold hover:bg-blue-600 transition duration-200 rounded-t flex items-center gap-3"
        >
            <i :class="showEventForm ? 'fas fa-chevron-down' : 'fas fa-chevron-right'"></i>
            <span>Create Event</span>
        </button>
        <div v-show="showEventForm" class="p-4">
            <div class="max-w-lg mx-auto p-4 bg-white shadow-md rounded sm:my-5">
                <h2 class="text-2xl font-bold mb-4">Create Event</h2>

                <div class="mb-4">
                    <label for="category" class="form-label text-black">
                        Event Type <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-2 space-y-2 space-x-5">
                        <div class="inline">
                            <input type="radio" id="techfriday" value="eucossa_tech_friday" v-model="form.category" name="category" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="techfriday" class="ml-2 text-sm text-black">Tech Friday Event</label>
                        </div>
                        <div class="inline">
                            <input type="radio" id="hackathon" value="hackathon" v-model="form.category" name="category" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="hackathon" class="ml-2 text-sm text-black">Hackathon</label>
                        </div>
                    </div>
                </div>

                <form @submit.prevent="submitForm">
                <!-- Event Title -->
                <div class="mb-4">
                    <label for="title" class="block font-medium text-black">Event Title</label>
                    <input type="text" id="title" v-model="form.title" class="form-input" placeholder="Enter event title" />
                    <div v-if="form.errors.title" class="input-error"> {{ form.errors.title }} </div>
                </div>

                <!-- Event Description -->
                <div class="mb-4">
                    <label for="description" class="block font-medium text-black">Description</label>
                    <textarea id="description" v-model="form.description"
                    class="form-input"
                    placeholder="Enter event description"
                    required
                    ></textarea>
                    <div v-if="form.errors.description" class="input-error"> {{ form.errors.description }} </div>
                </div>

                <!-- Event Image -->
                <div class="mb-4">
                    <label for="image" class="block font-medium text-black">Upload Image</label>
                    <input type="file" id="image" @change="handleImageUpload"
                        class="form-input"
                        required
                    />
                    <div v-if="form.errors.image" class="input-error"> {{ form.errors.image }} </div>
                </div>

                <!-- Event Day (Calendar) -->
                <div class="mb-4">
                    <label for="event_day" class="block font-medium text-black">Event Day</label>
                    <input type="date" id="event_day" v-model="form.event_day" class="form-input"required/>
                    <div v-if="form.errors.event_day" class="input-error"> {{ form.errors.event_day }} </div>
                </div>

                <div class="grid grid-cols-2 space-x-4">
                    <!-- Start Time -->
                    <div class="mb-4 col-span-1">
                        <label for="start-time" class="block font-medium text-black">Start Time</label>
                        <input type="time" id="start-time"
                        class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg p-2"
                        min="06:00"
                        max="19:00"
                        v-model="form.start_time"
                        required
                        />
                    </div>
        
                    <!-- End Time -->
                    <div class="mb-4 col-span-1">
                        <label for="end-time" class="block font-medium text-black">End Time</label>
                        <input type="time" id="end-time"
                        class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg p-2"
                        min="06:00"
                        max="19:00"
                        v-model="form.end_time"
                        required
                        />
                    </div>
                </div>

                <!-- Speaker -->
                <div class="mb-4">
                    <label for="speaker" class="block font-medium text-black">Speaker</label>
                    <input type="text" id="speaker" v-model="form.speaker" class="form-input" placeholder="Enter speaker's name" required />
                    <div v-if="form.errors.speaker" class="input-error"> {{ form.errors.speaker }} </div>
                </div>

                <!-- Reminder Checkbox -->
                <div class="mb-4">
                    <label class="block font-medium text-black">
                    <input
                        type="checkbox"
                        v-model="eventPaid"
                        class="mr-2 leading-tight"
                    />
                    Paid Event?
                    </label>
                    <div v-if="eventPaid" class="mt-5">
                        <input type="number" id="amount" v-model="form.event_charge" class="form-input" placeholder="Enter Event Charges" />
                    </div>
                    <div v-if="form.errors.event_charge" class="input-error"> {{ form.errors.event_charge }} </div>
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
        </div>


        <!-- Hackathon Image Section -->
        <button
            @click="showHackathonForm = !showHackathonForm"
            class="w-full bg-blue-500 text-white text-left px-6 py-4 text-2xl tracking-wide font-bold hover:bg-blue-600 transition duration-200 rounded-t flex items-center gap-3 mt-4"
        >
            <i :class="showHackathonForm ? 'fas fa-chevron-down' : 'fas fa-chevron-right'"></i>
            <span>The Hackathon Image</span>
        </button>
        <div v-show="showHackathonForm" class="p-4">
            <div class="flex justify-center bg-white shadow-lg mx-auto max-w-md">
                <form @submit.prevent="submitHackerForm">
                    <span class="font-md text-2xl">Upload Hackathon Images Here!</span>

                    <div class="my-4">
                        <label for="hackathon-image" class="block mb-2">The Hackathon Image:</label>
                        <input id="hackathon-image" type="file" @change="handleHackathonImageUpload" required>
                        <div v-if="hackerForm.errors.image" class="input-error"> {{ hackerForm.errors.image }} </div>
                    </div>

                    <div class="mb-4">
                        <label for="hTitle" class="block">Title <span class="text-red-500">*</span></label>
                        <input type="text" id="hTitle" v-model="hackerForm.title" required class="form-input">
                        <div v-if="hackerForm.errors.title" class="input-error"> {{ hackerForm.errors.title }} </div>
                    </div>

                    <div class="mb-4">
                        <label for="hDescription" class="block">Description <span class="text-red-500">*</span></label>
                        <textarea id="hDescription" v-model="hackerForm.description" required class="form-input"></textarea>
                        <div v-if="hackerForm.errors.description" class="input-error"> {{ hackerForm.errors.description }} </div>
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md shadow hover:bg-indigo-700 focus:outline-none mb-4"
                    >
                        Post Image
                    </button>
                </form>
            </div>

            <div class="justify-center mx-auto mt-8 max-w-3xl bg-white px-2">
                <div class="text-center flex justify-start font-semibold text-xl my-4 pt-4">
                    Hackathon Images
                </div>
                <div class="grid grid-cols-3 gap-2">
                    <div 
                        v-for="(image, index) in props.images" 
                        :key="index" 
                        class="relative group"
                    >
                        <!-- Image -->
                        <img 
                            :src="image.image" 
                            alt="Hackathon Image" 
                            class="w-full h-auto rounded-md shadow-md transition-opacity duration-300 group-hover:opacity-70"
                            :class="{ 'opacity-50 grayscale': image.deleted_at }"
                        >

                        <!-- Delete/Restore Button -->
                        <Link 
                            v-if="!image.deleted_at"
                            :href="route('hackathon-winner.destroy', { hackathon_winner: image.id })"
                            method="delete"
                            as="button"
                            class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 text-white text-lg font-bold opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                        >
                            <i class="fas fa-trash-alt"></i>
                        </Link>

                        <Link 
                            v-else
                            :href="route('hackathon-winner.restore', { hackathon_winner: image.id })"
                            method="post"
                            as="button"
                            class="absolute inset-0 flex items-center justify-center bg-green-600 bg-opacity-50 text-white text-lg font-bold opacity-100 transition-opacity duration-300"
                        >
                            <i class="fas fa-recycle"></i>
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Creation Section -->
        <button
            @click="showFaqForm = !showFaqForm"
            class="w-full bg-blue-500 text-white text-left px-6 py-4 text-2xl tracking-wide font-bold hover:bg-blue-600 transition duration-200 rounded-t flex items-center gap-3 mt-4"
        >
            <i :class="showFaqForm ? 'fas fa-chevron-down' : 'fas fa-chevron-right'"></i>
            <span>Create FAQ</span>
        </button>
        <div v-show="showFaqForm" class="p-4">
            <div class="max-w-2xl mx-auto p-6 bg-white rounded-xl shadow">
                <h2 class="text-xl font-semibold mb-4">Create FAQ</h2>

                <form @submit.prevent="submitForm2" class="space-y-4">
                    <!-- Category -->
                    <div>
                        <label class="block text-sm font-medium mb-1" for="category">Category</label>
                        <select
                            v-model="form2.category"
                            id="category"
                            class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500"
                        >
                            <option value="" disabled>Select a category</option>
                            <option v-for="cat in categories" :key="cat" :value="cat">
                                {{ cat }}
                            </option>
                        </select>
                        <div v-if="form2.errors.category" class="text-red-500 text-sm mt-1">
                            {{ form2.errors.category }}
                        </div>
                    </div>

                    <!-- Question -->
                    <div>
                        <label class="block text-sm font-medium mb-1" for="question">Question</label>
                        <input
                            type="text"
                            id="question"
                            v-model="form2.question"
                            class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500"
                        />
                        <div v-if="form2.errors.question" class="text-red-500 text-sm mt-1">
                            {{ form2.errors.question }}
                        </div>
                    </div>

                    <!-- Answer -->
                    <div>
                        <label class="block text-sm font-medium mb-1" for="answer">Answer</label>
                        <textarea
                            id="answer"
                            v-model="form2.answer"
                            rows="4"
                            class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500"
                        ></textarea>
                        <div v-if="form2.errors.answer" class="text-red-500 text-sm mt-1">
                            {{ form2.errors.answer }}
                        </div>
                    </div>

                    <!-- Submit -->
                    <div>
                        <button
                            type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition"
                            :disabled="form2.processing"
                        >
                            {{ form2.processing ? 'Submitting...' : 'Submit FAQ' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>


    </Dashboard>
</template>

<script setup>
    import { useForm, Link } from '@inertiajs/vue3';
    import Dashboard from '@/Pages/Dashboard/Dashboard.vue';
    import { ref } from 'vue';

    const props = defineProps({
        'images': Array,
    });

    const eventPaid = ref(false);

    const showEventForm = ref(false);
    const showHackathonForm = ref(false);
    const showFaqForm = ref(false);
    

    // Initializing the form using `useForm`
    const form = useForm({
        category: 'eucossa_tech_friday',
        title: '',
        description: '',
        image: null, // Placeholder for image file
        event_day: '',
        start_time: '14:00', // Default start time
        end_time: '16:00',   // Default end time
        speaker: '',
        event_charge: null,
    });

    // Method to handle image upload
    const handleImageUpload = (event) => {
        form.image = event.target.files[0]; // Store the uploaded image file in the form object
    };

    const submitForm = () => {      
      form.post(route('events.store'));
    };

    
    const hackerForm = useForm({
        title: '',
        description: '',
        image: null,
    });

    // Method to handle image upload
    const handleHackathonImageUpload = (event) => {
        hackerForm.image = event.target.files[0]; // Store the uploaded image file in the form object
    };

    const submitHackerForm = () => {
        hackerForm.post(route('hackathon-winner.store'));
    }

    const form2 = useForm({
        category: '',
        question: '',
        answer: '',
    });

    const categories = [
        'Payment Issues',
        'Registration',
        'Club Constitution',
        'Other',
    ];

    const submitForm2 = () => {
        form2.post(route('dashboard.faqs.store'), {            
            preserveScroll: true,
        });
    };

</script>
