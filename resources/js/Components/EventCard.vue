<template>
    
    <div class="card bg-white shadow-md rounded-lg p-2 relative">
            <Link :href="route('events.show', event=event.id)">
        <img :src="event.image" alt="Event Image" class="w-full h-48 object-cover rounded-t-md mb-4" />
    
        <h2 class="text-xl font-semibold mb-2 max-h-[56px] overflow-y-auto">{{ truncatedTitle }}</h2>

            <p class="hidden sm:block text-sm text-gray-600 mb-4">
                {{ truncatedDescription }}
            </p>
    
            <div class="text-sm text-gray-500">
                <p><strong>Event Day:</strong> {{ event.event_day }}</p>
                <p><strong>Time:</strong> {{ event.start_time }} - {{ event.end_time }}</p>
                <p><strong>Speaker:</strong> {{ event.speaker }}</p>
            </div>

            <!-- Badge for past events -->
            <span v-if="isEventPassed" class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded absolute right-3 top-3">
                Event Passed
            </span>
            
            
            <!-- Badge for Hackathons -->
            <span v-if="event.category === 'hackathon'" class="bg-blue-500 text-white text-lg font-bold px-2 py-1 rounded absolute left-3 top-3">
                Hackathon
            </span>

            </Link>

            <div class="absolute bottom-2 right-1 flex justify-between space-x-2">
                <div class="text-center">
                    <p class="text-xs text-gray-500">{{ event.likes }}</p>
                    <!-- Like Button -->
                    <button :class="['like-button', { liked: isLiked }]" @click="handleLike">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>

                

                <div class="text-center">
                    <p class="text-xs text-gray-500">{{ event.dislikes }}</p>
                    <!-- Dislike Button -->
                    <button :class="['dislike-button', { disliked: isDisliked }]" @click="handleDislike">
                        <i class="fas fa-heart-broken"></i>
                    </button>
                </div>

            </div>
        </div>
    
  </template>

<script setup>
    import { computed, ref, watchEffect } from 'vue';
    import { router, Link } from '@inertiajs/vue3';

    const props = defineProps({
        event: Object, 
    });

    // Computed property to truncate the description
    const maxLength = 85;
    const truncatedDescription = computed(() => {
      return props.event.description.length > maxLength
        ? props.event.description.substring(0, maxLength) + '...'
        : props.event.description;
    });

    // Computed Property to truncate the Title:

    const maxLenghth = 35;
    const truncatedTitle = computed(() => {
        return props.event.title.length > maxLenghth 
        ? props.event.title.substring(0, maxLenghth) + '...'
        : props.event.title
    })

    // Computed Property to check if the event has passed
    const isEventPassed = computed(() => {
        const currentDate = new Date();
        const eventEndTime = new Date(props.event.event_day); // Assuming end_time is in a valid date format
       // Extract hours and minutes from the end_time string
        const [hours, minutes] = props.event.end_time.split(':').map(Number);
        
        // Set the hours and minutes for the event end time
        eventEndTime.setHours(hours, minutes, 0, 0); // Set event end time to HH:MM:00.000

        return currentDate > eventEndTime;
    });

    // Reactive states for like and dislike
    const isLiked = ref(false);
    const isDisliked = ref(false);

    // Watch for changes in user_reaction and update states accordingly
    watchEffect(() => {
        if (props.event.user_reaction === 'like') {
            isLiked.value = true;
            isDisliked.value = false;
        } else if (props.event.user_reaction === 'dislike') {
            isLiked.value = false;
            isDisliked.value = true;
        } else {
            // If user_reaction is null or neither 'like' nor 'dislike'
            isLiked.value = false;
            isDisliked.value = false;
        }
    });

    // Handle like reaction
    const handleLike = () => {
        if (!isLiked.value) {
            postReaction('like');  // Like the event
        } else {
            postReaction(null);  // Remove the like (set reaction to null)
        }
    };

    // Handle dislike reaction
    const handleDislike = () => {
        if (!isDisliked.value) {
            postReaction('dislike');  // Dislike the event
        } else {
            postReaction(null);  // Remove the dislike (set reaction to null)
        }
    };

    // Post reaction to the server using Inertia router
    const postReaction = (reaction) => {
        router.post(`/events/${props.event.id}/reactions`, 
            { reaction }, 
            {
                preserveScroll: true,  // Optional: keeps the page from reloading or scrolling
                onSuccess: () => {
                    // Update local states
                    isLiked.value = (reaction === 'like');
                    isDisliked.value = (reaction === 'dislike');
                },
                onError: (errors) => {
                    console.error('Error posting reaction:', errors);
                }
            }
        );
    };

</script>
  
  <style scoped>
    .card {
        border-radius: 0.5rem;
        background-color: #ffffff;
    }

    .like-button,
    .dislike-button {
    background: none;
    border: none;
    color: #1e293b;
    cursor: pointer;
    font-size: 16px;
    }

    .like-button.liked {
    color: rgb(28, 236, 5);
    }

    .dislike-button.disliked {
    color: red;
    }
  </style>
  