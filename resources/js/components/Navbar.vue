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
                <a href="">
                    <h3 class="text-4xl font-sheppards text-[#E94E63]">
                        Ra<span class="text-[#5FB15F]">dish.</span>
                    </h3>
                </a>
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
                        v-if="isLoggedIn"
                        type="submit"
                        class="border mb-2 border-gray-300 px-3 py-1 rounded-full hover:bg-[#E94E63] hover:text-white hover:border-[#E94E63] transition-colors duration-300"
                    >
                        Log out
                    </button>
                </div>
            </div>
        </div>

        <div class="md:flex justify-between flex-row-reverse bg-white bg-opacity-50">
            
            <div class="px-3 py-2 bg-white bg-opacity-50 flex justify-between items-center">
                <div class="flex gap-2 items-center">
                    <img 
                        class="rounded-full"
                        src="/public/images/placeholder.jpg" 
                        alt="Profile photo"
                        width="40px"
                    >
                    <p v-if="isLoggedIn">
                        {{ user.firstname }} {{ user.lastname }}
                    </p>
                </div>
                <div class="flex gap-1 items-center md:hidden">
                    <p>Recipes: 4</p>
                </div>
            </div>    
           

            <div 
                class="p-3 flex-grow md:block" 
                :class="{ 'hidden': !open, 'block': open }"
            >
                <ul class="cursor-pointer border md:flex md:border-none">
                    <li class="nav-link" active-class="active">
                        <router-link 
                            to="/" 
                            active-class="active"
                            class="px-4 py-1 flex hover:bg-[#399739] hover:text-white transition-all duration-300 nav-link">
                            Home
                        </router-link>                
                    </li>
                                
                    <li 
                        v-if="isLoggedIn"
                        class="hover:text-white transition-all duration-300 nav-link"
                        active-class="active"
                    >
                        <router-link 
                            to="/my-recipes" 
                            active-class="active"
                            class="px-4 py-1 flex hover:bg-[#399739] hover:text-white transition-all duration-300 nav-link">
                            My Recipes
                        </router-link>  
                    </li>
                    
                    <li 
                        v-if="isLoggedIn"
                        class="hover:text-white transition-all duration-300"
                    >
                        <a 
                            class="px-4 py-1 flex"
                            href="">
                            Favorites
                        </a>
                    </li>                
                    <li class="px-4 py-1 hover:bg-[#7dc97d] md:hidden">
                        
                        <router-link 
                            to="/login"
                            v-if="!isLoggedIn"
                            class="md:border border-gray-300 md:px-3 md:py-1 md:rounded-full"
                        >
                            Log in
                        </router-link> 
                    
                        <button 
                            v-if="isLoggedIn"
                            @click.prevent="handleLogout" type="submit" class="">
                                Log out
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
            open: false
        }
    },
    methods: {
        async handleLogout() {
            try {
                const response = await axios.post('/api/logout');
                // remove token
                localStorage.removeItem('auth_token');
                this.$emit('userLoggedOut');
                this.$router.push('/login');
                
            } catch (error){
                console.error('Logout error', error);
                this.toast.error('Error logging out. Please try again');
            }  
        }
    },
    created() {
        this.toast = useToast();
    }
}
</script>