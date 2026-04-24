<template>
    <div class="app-wrapper">
        <Navbar
            :user="user"
            :isLoggedIn="isLoggedIn"
            @userLoggedOut="handleUserLogout"
        />

        <main class="main-content px-5">
            <router-view v-slot="{ Component }"
                @user-reaction-changed="fetchCurrentUser"
            >
                <component :is="Component" :isLoggedIn="isLoggedIn" :user="user" />
            </router-view>
        </main>

        <Footer>

        </Footer>
    </div>
</template>

<script>

import Navbar from '../components/Navbar.vue';
import Footer from '../components/Footer.vue';

export default {
    components: { Navbar, Footer },
    data() {
        return {
            user: {},
            isLoggedIn: false,
        }
    },
    methods: {
        async fetchCurrentUser() {

            try {
                const response = await axios.get('/api/me');
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
