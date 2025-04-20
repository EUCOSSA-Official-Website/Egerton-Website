<template>
  <section class="bg-white pt-8 pb-5 mt-5" id="sec-1115">
    <h2 class="text-center font-sans font-semibold text-4xl">Our Members</h2>
    <p class="text-center text-lg py-4 max-w-2xl mx-auto">
      Egerton Computer Science Students Always Strive to Seek Solutions and Spearhead Innovations.
    </p>

    <div class="relative max-w-4xl mx-auto overflow-hidden min-h-[300px]">
      <div
        ref="carousel"
        class="flex space-x-4 overflow-x-auto scrollbar-hide snap-x snap-mandatory p-4 transition-all duration-900 min-h-[300px]"
      >
        <!-- Invisible padding at the start -->
        <div class="flex-shrink-0" :style="{ width: '40px' }"></div>

        <div
          v-for="(image, index) in hImages"
          :key="index"
          class="relative flex-shrink-0 snap-center rounded-lg overflow-hidden shadow-lg transition-all duration-500"
          :class="{ 'w-80 h-60 scale-110': index === currentIndex, 'w-64 h-48 opacity-70': index !== currentIndex }"
          @mouseenter="hoveredIndex = index"
          @mouseleave="hoveredIndex = null"
        >
          <!-- Image -->
          <img class="w-full h-full object-cover rounded-lg" :src="image.image" alt="Member" />

          <!-- Floating Description -->
          <transition name="fade">
            <div
              v-if="index === currentIndex"
              class="absolute bottom-0 left-1/3 transform -translate-x-1/2 bg-black bg-opacity-50 text-white text-sm px-4 py-2 rounded-lg shadow-lg whitespace-normal"
            >
              {{ image.description }}
            </div>
          </transition>
        </div>


        <!-- Invisible padding at the end -->
        <div class="flex-shrink-0" :style="{ width: '40px' }"></div>
      </div>

      <!-- Navigation Buttons -->
      <button
        class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-gray-800 text-white p-2 rounded-full shadow-md hover:bg-gray-700"
        @click="prevImage"
      >
        &#10094;
      </button>
      <button
        class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-gray-800 text-white p-2 rounded-full shadow-md hover:bg-gray-700"
        @click="nextImage"
      >
        &#10095;
      </button>

      <!-- Dot Indicators -->
      <div class="flex justify-center mt-6 space-x-2">
        <button
          v-for="(image, index) in hImages"
          :key="'dot-' + index"
          @click="goToImage(index)"
          class="w-3 h-3 rounded-full"
          :class="{ 'bg-blue-500': index === currentIndex, 'bg-gray-300 hover:bg-gray-500': index !== currentIndex }"
        ></button>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, watch, nextTick } from 'vue';

// setting up constants
const hoveredIndex = ref(null);

const props = defineProps({
  hImages: Array,
});

// Handle reactivity properly
const currentIndex = ref(0);
const carousel = ref(null);
let carouselInterval;

// Start auto-slide
const startCarousel = () => {
  stopCarousel(); // <— ADD THIS LINE
  if (props.hImages.length > 1) {
    carouselInterval = setInterval(() => {
      nextImage();
    }, 6000);
  }
};

// Stop auto-slide
const stopCarousel = () => {
  clearInterval(carouselInterval);
};

// Move to next image
const nextImage = () => {
  if (props.hImages.length > 0) {
    currentIndex.value = (currentIndex.value + 1) % props.hImages.length;
  }
};

// Move to previous image
const prevImage = () => {
  if (props.hImages.length > 0) {
    currentIndex.value = (currentIndex.value - 1 + props.hImages.length) % props.hImages.length;
  }
};

// Move to specific image
const goToImage = (index) => {
  currentIndex.value = index;
};

// Ensure selected image is centered
const scrollToCurrent = () => {
  if (carousel.value && props.hImages.length > 0) {
    nextTick(() => {
      const children = carousel.value.children;
      if (children[currentIndex.value + 1]) {
        const parentWidth = carousel.value.clientWidth;
        const childWidth = children[currentIndex.value + 1].clientWidth;
        const scrollLeft = children[currentIndex.value + 1].offsetLeft - (parentWidth - childWidth) / 2;
        carousel.value.scrollTo({ left: scrollLeft, behavior: 'smooth' });
      }
    });
  }
};


// Watch for index change and center image
watch(currentIndex, () => {
  scrollToCurrent();
});

// Ensure images exist before starting carousel
watch(
  () => props.hImages,
  (newImages) => {
    if (newImages.length > 0) {
      currentIndex.value = 0;
      startCarousel();
    } else {
      stopCarousel();
    }
  },
  { immediate: true }
);

// Center first image on load
onMounted(() => {
  if (props.hImages.length > 0) {
    setTimeout(() => {
      scrollToCurrent();
    }, 300);
    startCarousel();
  }
});

onBeforeUnmount(stopCarousel);
</script>

<style>
.scrollbar-hide::-webkit-scrollbar {
  display: none;
}
.scrollbar-hide {
  -ms-overflow-style: none;
  scrollbar-width: none;
}

.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s ease, transform 0.3s ease;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
  transform: translateY(10px);
}
</style>
