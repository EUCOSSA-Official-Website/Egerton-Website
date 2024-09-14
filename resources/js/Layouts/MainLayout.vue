<template>
    <div>
        <!-- Dummy Header -->
        <header class="flex items-center justify-center">
            <img src="/assets/img/EUCOSSA_LOGO.png" alt="Logo" class="h-12 w-auto">
            <nav class="flex space-x-4 font-bold text-2xl">
                <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
                </ul>
            </nav>
        </header>

        <!-- Main Content -->
        <main>
            <!-- Slot where the page content will be injected -->
            <slot></slot>
        </main>

        <!-- Dummy Footer -->
        <footer>
            <p>&copy; 2024 My Website</p>
        </footer>
    </div>
</template>
  
<script setup>

</script>
  
<style scoped>
    /* Add basic styles for the layout */
    header {
    background-color: #FFC3E7;
    color: black;
    padding: 10px;
    text-align: center;
    }

    nav ul {
    list-style: none;
    padding: 0;
    }

    nav ul li {
    display: inline;
    margin: 0 10px;
    }

    footer {
    background-color: #FFC3E7;
    color: black;
    text-align: center;
    padding: 10px;
    }
</style>
  