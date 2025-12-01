<template>
    <nav x-data="{ open: false }">
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
                    <Bars3Icon x-show="!open" class="w-6 h-6 cursor-pointer" />
                    <XMarkIcon x-show="open" class="w-6 h-6 cursor-pointer" />
                </div>

                <div class="hidden md:block">
                        <router-link
                            to="/login"
                            class="border border-gray-300 px-3 py-1 rounded-full hover:bg-[#5FB15F] hover:text-white hover:border-[#5FB15F] transition-colors duration-300"
                        >
                            Log in
                        </router-link>
                        <form action="" method="POST">
                            
                            <button 
                                type="submit"
                                class="border border-gray-300 px-3 py-1 rounded-full hover:bg-[#E94E63] hover:text-white hover:border-[#E94E63] transition-colors duration-300"
                            >
                                Log out
                            </button>
                        </form>
                   
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
                    <p></p>
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
                    <li class="hover:text-white transition-all duration-300">
                        <a  class="px-4 py-1 flex"
                            href="">
                            Home
                        </a>                
                    </li>
                   
                        <li class="  hover:text-white transition-all duration-300">
                            <a 
                                class="px-4 py-1 flex"
                                href="">
                                My Recipes 
                                
                            </a>
                        </li>
                    
                    <li class="  hover:text-white transition-all duration-300">
                        <a 
                            class="px-4 py-1 flex"
                            href="">
                            Favorites
                        </a>
                    </li>                
                    <li class="px-4 py-1 hover:bg-[#7dc97d] md:hidden">
                        
                            <a href="" 
                            class="md:border border-gray-300 md:px-3 md:py-1 md:rounded-full">
                                Log in
                            </a>    
                       
                            <form action="" method="POST">
                                @csrf
                                <button type="submit" class="">
                                    Log out
                                </button>
                            </form>
                        
                    </li>
                </ul>
            </div>
        </div>
    </nav>

</template>

<script>
import { Bars3Icon, XMarkIcon } from '@heroicons/vue/24/outline';

export default {
    components: { Bars3Icon, XMarkIcon }
}
</script>