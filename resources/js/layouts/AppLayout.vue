<template>
    <div>
        <Navbar 
            :user="user"
            :isLoggedIn="isLoggedIn"
            @userLoggedOut="handleUserLogout"
        />

        <main class="px-5">
            <router-view v-slot="{ Component }">
                <component :is="Component" :isLoggedIn="isLoggedIn" />
            </router-view>
        </main>

        <footer>

        </footer>
    </div>
</template>

<script>

import Navbar from '../components/Navbar.vue';

export default {
    components: { Navbar },
    data() {
        return {
            user: {},
            isLoggedIn: false,
        }
    }, 
    methods: {
        async fetchCurrentUser() {
            
            try {
                const response = await axios.get('/api/user');
                this.user = response.data.user;
                this.isLoggedIn = true;
            } catch (error) {
                this.user = null;
                this.isLoggedIn = false;
            }
        },
        handleUserLogout() {
            this.user = null;
            this.isLoggedIn = false;
        }
    },
    mounted() {
        this.fetchCurrentUser();
    }
};

</script>
