<template>
  <section class="bg-white pt-8 pb-5 mt-5" id="sec-1115">
    <h2 class="text-center font-sans font-semibold text-4xl">Our Members</h2>
    <p class="text-center text-lg py-4 max-w-2xl mx-auto">
      Egerton Computer Science Students Always Strive to Seek Solutions and Spearhead Innovations.
    </p>
    
    <div class="relative max-w-4xl mx-auto overflow-hidden min-h-[300px]">
      <div ref="carousel" class="flex space-x-4 overflow-x-auto scrollbar-hide snap-x snap-mandatory p-4 transition-all duration-900 min-h-[300px]">
        
        <!-- Invisible padding at the start -->
        <div class="flex-shrink-0" :style="{ width: '40px' }"></div>

        <div v-for="(image, index) in images" :key="index" 
             class="flex-shrink-0 snap-center rounded-lg overflow-hidden shadow-lg transition-all duration-500"
             :class="{ 'w-80 h-60 scale-110': index === currentIndex, 'w-64 h-48 opacity-70': index !== currentIndex }">
          <img class="w-full h-full object-cover rounded-lg" :src="image" alt="Member">
        </div>

        <!-- Invisible padding at the end -->
        <div class="flex-shrink-0" :style="{ width: '40px' }"></div>

      </div>

      <!-- Navigation Buttons -->
      <button class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-gray-800 text-white p-2 rounded-full shadow-md hover:bg-gray-700" @click="prevImage">
        &#10094;
      </button>
      <button class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-gray-800 text-white p-2 rounded-full shadow-md hover:bg-gray-700" @click="nextImage">
        &#10095;
      </button>

      <!-- Dot Indicators -->
      <div class="flex justify-center mt-6 space-x-2">
        <button v-for="(image, index) in images" :key="'dot-' + index" @click="goToImage(index)"
                class="w-3 h-3 rounded-full"
                :class="{ 'bg-blue-500': index === currentIndex, 'bg-gray-300 hover:bg-gray-500': index !== currentIndex }">
        </button>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, watch, nextTick } from 'vue';

const images = ref([
  '/assets/SliderImages/photo-1577897113051-1a0395bfc3e2.jpeg',
  '/assets/SliderImages/photo-1577897113051-1a0395bfc3e2.jpeg',
  '/assets/SliderImages/photo-1577897113051-1a0395bfc3e2.jpeg',
  '/assets/SliderImages/photo-1577897113051-1a0395bfc3e2.jpeg',
  '/assets/SliderImages/photo-1577897113051-1a0395bfc3e2.jpeg',
  '/assets/SliderImages/photo-1577897113051-1a0395bfc3e2.jpeg',
]);

const currentIndex = ref(0);
const carousel = ref(null);
let carouselInterval;

const startCarousel = () => {
  carouselInterval = setInterval(() => {
    nextImage();
  }, 4000);
};

const stopCarousel = () => {
  clearInterval(carouselInterval);
};

// Move to the next image
const nextImage = () => {
  currentIndex.value = (currentIndex.value + 1) % images.value.length;
};

// Move to the previous image
const prevImage = () => {
  currentIndex.value = (currentIndex.value - 1 + images.value.length) % images.value.length;
};

// Move to a specific image when clicking a dot
const goToImage = (index) => {
  currentIndex.value = index;
};

// Ensure the selected image is **centered**, considering padding
const scrollToCurrent = () => {
  if (carousel.value) {
    nextTick(() => {
      const children = carousel.value.children;
      if (children[currentIndex.value + 1]) { // +1 to account for first padding div
        const parentWidth = carousel.value.clientWidth;
        const childWidth = children[currentIndex.value + 1].clientWidth;
        const scrollLeft =
          children[currentIndex.value + 1].offsetLeft - (parentWidth - childWidth) / 2;
        carousel.value.scrollTo({ left: scrollLeft, behavior: 'smooth' });
      }
    });
  }
};

// Watch for index changes and center the image
watch(currentIndex, () => {
  scrollToCurrent();
});

// Center the first image on load
onMounted(() => {
  setTimeout(() => {
    scrollToCurrent();
  }, 300);
  startCarousel();
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
</style>
