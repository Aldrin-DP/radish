<template>
  <div>
    
    <Navbar />

    <main>
        <router-view />
    </main>

    <footer>

    </footer>
  </div>
</template>

<script>

import Navbar from '../components/Navbar.vue';

export default {
    components: { Navbar }
};

</script>
