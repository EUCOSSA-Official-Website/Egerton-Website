<template>
    <div>
        <!-- Dummy Header -->
        <header>
            <nav>
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
    background-color: #333;
    color: white;
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

    main {
    padding: 20px;
    }

    footer {
    background-color: #333;
    color: white;
    text-align: center;
    padding: 10px;
    margin-top: 20px;
    }
</style>
  