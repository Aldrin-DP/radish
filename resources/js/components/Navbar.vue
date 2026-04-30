<template>
    <nav>
        <div class="flex justify-between items-center p-3 pb-1 border-b">
            <div class="flex items-center">
                <img
                    class="hidden"
                    src="/public/images/logo.png"
                    alt="Radish. logo"
                    width="60px"
                >
                <router-link
                    to="/"
                    @click="goHome"
                    class="cursor-pointer"
                >
                    <h3 class="text-4xl font-sheppards text-[#E94E63]">
                        Ra<span class="text-[#5FB15F]">dish.</span>
                    </h3>
                </router-link>
            </div>

            <div>
                <div class="md:hidden" @click="open = !open">
                    <Bars3Icon v-show="!open" class="w-6 h-6 cursor-pointer" />
                    <XMarkIcon v-show="open" class="w-6 h-6 cursor-pointer" />
                </div>

                <div class="hidden md:block">
                    <router-link
                        to="/login"
                        v-if="!isLoggedIn"
                        class="border border-gray-300 px-3 py-1 rounded-full hover:bg-[#5FB15F] hover:text-white hover:border-[#5FB15F] transition-colors duration-300"
                    >
                        Log in
                    </router-link>

                    <button
                        @click.prevent="handleLogout"
                        :disabled="isLoading"
                        :class="{ 'opacity-50': isLoading }"
                        v-if="isLoggedIn"
                        type="submit"
                        class="border mb-2 border-gray-300 px-3 py-1 rounded-full hover:bg-[#E94E63] hover:text-white hover:border-[#E94E63] transition-colors duration-300"
                    >
                        {{  isLoading ? 'Logging out...' : 'Log out'  }}
                    </button>
                </div>
            </div>
        </div>

        <div class="md:flex justify-between flex-row-reverse bg-white bg-opacity-50">

            <div
                v-if="isLoggedIn"
                class="px-3 py-2 bg-white bg-opacity-50 flex justify-between items-center">
                <div class="flex gap-2 items-center">
                    <img
                        class="rounded-full"
                        src="/public/images/placeholder.jpg"
                        alt="Profile photo"
                        width="40px"
                    >
                    <p>
                        {{ user.firstname }} {{ user.lastname }}
                    </p>
                </div>
                <!-- <div class="flex gap-1 items-center md:hidden">
                    <p>Recipes: 4</p>
                </div> -->
            </div>


            <div
                class="p-3 flex-grow md:block"
                :class="{ 'hidden': !open, 'block': open }"
            >
                <ul class="cursor-pointer border md:flex md:border-none">
                    <li class="nav-link" active-class="active">
                        <router-link
                            to="/"
                            @click="goHome"
                            active-class="active"
                            class="px-4 py-2 flex hover:bg-[#53af53] hover:text-white transition-all duration-300 nav-link">
                            Home
                        </router-link>
                    </li>

                    <li
                        v-if="isLoggedIn"
                        class="nav-link"
                        active-class="active"
                    >
                        <router-link
                            to="/my-recipes"
                            active-class="active"
                            class="px-4 py-2 flex hover:bg-[#53af53] hover:text-white transition-all duration-300 nav-link">
                            My Recipes
                        </router-link>
                    </li>

                    <li
                        v-if="isLoggedIn"
                        class="nav-link"
                        active-class="active"
                    >
                        <router-link
                            to="/favorites"
                            active-class="active"
                            class="px-4 py-2 flex hover:bg-[#53af53] hover:text-white transition-all duration-300 nav-link">
                            Favorites
                        </router-link>
                    </li>
                    <li class="md:hidden">

                        <router-link
                            to="/login"
                            v-if="!isLoggedIn"
                            class="md:px-4 py-2 flex hover:bg-[#53af53] hover:text-white transition-all duration-300 nav-link md:border md:border-gray-300 md:py-1 md:rounded-full"
                        >
                            Log in
                        </router-link>

                        <button
                            v-if="isLoggedIn"
                            :disabled="isLoading"
                            :class="{ 'opacity-50': isLoading }"
                            @click.prevent="handleLogout" type="submit"
                            class="md:px-4 py-1 flex hover:bg-[#53af53] hover:text-white transition-all duration-300 nav-link"
                            >
                                {{  isLoading ? 'Logging out...' : 'Log out'  }}
                        </button>

                    </li>
                </ul>
            </div>
        </div>
    </nav>

</template>

<script>
import { Bars3Icon, XMarkIcon } from '@heroicons/vue/24/outline';
import { useToast } from 'vue-toastification';

export default {
    components: { Bars3Icon, XMarkIcon },
    props: [
        'user',
        'isLoggedIn'
    ],
    data() {
        return {
            open: false,
            isLoading: false
        }
    },
    methods: {
        async handleLogout() {
            this.isLoading = true;
            try {
                const response = await axios.post('/api/logout');
                // remove token
                localStorage.removeItem('auth_token');
                this.$emit('userLoggedOut');
                this.$router.push('/login');

            } catch (error){
                console.error('Logout error', error);
                this.toast.error('Error logging out. Please try again');
            } finally {
                this.isLoading = false;
            }
        },
        goHome() {
            window.dispatchEvent(new Event('home-clicked'));
        }
    },
    created() {
        this.toast = useToast();
    }
}
</script>
