<template>
    <div 
        v-if="isLoading"
        class="p-3 animate-pulse text-lg"
    >
        Loading recipe details...
    </div>

    <div
        v-else-if="recipe" 
        class="mt-3"
    >   
        <div class="w-full pe-10">
            <div class="flex gap-3 items-center">
                <h2 class=" text-xl font-semibold">{{ recipe.recipe_name }}</h2>
                <div class="flex items-center">
                    <Icon icon="mdi-light:heart" width="16" height="16" />    
                    <span class="text-gray-600"></span>
                </div>
            </div>    
            <div class="sm:flex gap-5">
                <div class="w-full mt-1 flex-1">
                    <img 
                        :src="imagePath + recipe.image" 
                        :alt="recipe.recipe_name"
                        class="h-full w-full object-cover rounded-lg"
                    >
                </div>
                <div class="sm:mt-1 flex-1">
                    <div
                        v-if="recipe.description" 
                        class="mt-2 sm:mt-0 text-justify"
                    >
                        {{ recipe.description }}
                    </div>
                    <div class="flex gap-5 items-center mt-2">
                        <div>
                            <p :class="{
                                    'bg-orange-400': recipe.difficulty == 'easy',
                                    'bg-orange-600': recipe.difficulty == 'medium',
                                    'bg-orange-800': recipe.difficulty == 'hard',
                                }"
                                class="px-4 bg-orange-400 rounded-full text-gray-100 capitalize">
                                {{ recipe.difficulty }}
                            </p>
                        </div>
                         <div class="flex items-center gap-1">
                            <Icon icon="bx:dish" width="18" height="18" />
                            <p class="">{{ recipe.category }}</p>
                        </div>
                        <div class="flex items-center gap-1">
                            <Icon icon="tdesign:time"></Icon>
                            <p>{{ recipe.prep_time }} mins.</p>
                        </div>  
                    </div>
                    
                    <div class="mt-7 flex gap-3">
                        <div
                            @click="toggleReaction('love')" 
                            class="border px-2 py-1 bg-slate-200 rounded cursor-pointer"
                            :class="checkReaction('love') ? 'border-green-500' : ''"
                        >
                            <button class="flex gap-2 items-center ">
                                <Icon icon="fluent-emoji-flat:red-heart" width="26" height="26" />
                                <span class="">
                                    {{ recipe.love_reactions_count }}
                                </span>
                            </button>
                        </div>
                        <div 
                            @click="toggleReaction('fire')" 
                            class="border px-2 py-1 bg-slate-200 rounded cursor-pointer">
                            <button class="flex gap-2 items-center ">
                                <Icon icon="noto:fire" width="26" height="26" />
                                <span class="">
                                    {{ recipe.fire_reactions_count }}
                                </span>
                            </button>
                        </div>
                        <div 
                            @click="toggleReaction('laugh')" 
                            class="border px-2 py-1 bg-slate-200 rounded cursor-pointer">
                            <button class="flex gap-2 items-center ">
                                <Icon icon="noto:rolling-on-the-floor-laughing" width="26" height="26" />
                                <span class="">
                                    {{ recipe.laugh_reactions_count }}
                                </span>
                            </button>
                        </div>
                        <div 
                            @click="toggleReaction('dislike')" 
                            class="border px-2 py-1 bg-slate-200 rounded cursor-pointer">
                            <button class="flex gap-2 items-center ">
                                <Icon icon="fluent-emoji-flat:thumbs-down" width="26" height="26" />
                                <span class="">
                                    {{ recipe.dislike_reactions_count }}
                                </span>
                            </button>
                        </div>
                        <!-- <div 
                            @click="manageReaction('heart')"
                            class="border px-2 py-1 bg-slate-200 rounded cursor-pointer"
                            :class="checkReaction('heart') ? 'border-green-500' : '' " 
                        >
                            <button class="flex gap-2 items-center ">
                                <Icon icon="fluent-emoji-flat:red-heart" width="26" height="26" />
                                {{ recipe.hearts_count }}
                            </button>
                        </div>
                        <div 
                            @click="manageReaction('fire')"
                            class="border px-2 py-1 bg-slate-200 rounded cursor-pointer"
                            :class="checkReaction('fire') ? 'border-green-500' : '' "
                        >
                            <button class="flex gap-2 items-center ">
                                <Icon icon="noto:fire" width="26" height="26" />
                                {{ recipe.fires_count }}
                            </button>
                        </div>
                        <div 
                            @click="manageReaction('dislike')"
                            class="border px-2 py-1 bg-slate-200 rounded cursor-pointer"
                            :class="checkReaction('dislike') ? 'border-green-500' : '' "
                        >
                            <button class="flex gap-2 items-center ">
                                <Icon icon="fluent-emoji-flat:thumbs-down" width="26" height="26" />
                                {{ recipe.dislikes_count }}
                            </button>
                        </div> -->
                    </div>

                    <!-- Large screen -->
                    <div class="mt-10">
                        <button class="bg-green-600 px-5 py-2 text-lg rounded-full text-slate-200 font-semibold flex gap-2">
                            Add to Favorites
                            <Icon icon="uis:favorite" width="24" height="24" />
                        </button>
                    </div>
                     <!-- <div class="flex gap-2 lg:flex-wrap mt-2">
                        <base-button
                            variant="primary"
                            class="lg:flex hidden items-center gap-1 mt-5"
                            @click="toggleFavorite"
                        >
                            {{ isFavorited ? 'Remove from Favorites' : 'Add from Favorites' }}
                            <Icon icon="clarity:favorite-line" width="18"></Icon> 
                        </base-button>
                        <base-button
                            v-if="user.data.id == recipe.user_id"
                            variant="secondary" 
                            class="lg:flex hidden items-center gap-1 mt-5 bg-blue-400 hover:bg-blue-500"   
                        >
                            
                            <Icon icon="material-symbols:edit-outline" width="18"></Icon> 
                        </base-button>
                        <base-button
                            v-if="user.data.id === recipe.user_id"
                            variant="danger"    
                            class="lg:flex hidden items-center gap-1 mt-5"
                            @click="deleteRecipe"
                        >
                        
                            <Icon icon="material-symbols:delete-outline" width="18"></Icon> 
                        </base-button>
                     </div> -->
                </div>
            </div>
            <div class="">
                <div class="mt-2">
                    <label for="" class="text-gray-500 font-semibold">Ingredients:</label>      
                    <p class="whitespace-pre-line">
                        {{ recipe.ingredients }}
                    </p>
                </div>
                <div class="mt-2">
                    <label for="" class="text-gray-500 font-semibold">Instructions:</label>      
                    <p class="whitespace-pre-line">
                        {{ recipe.steps }}
                    </p>
                </div>
            </div>
            <!-- <div class="flex gap-2 mb-3 lg:hidden">
                <base-button
                    v-if="user.data.id == recipe.user_id"
                    variant="primary"
                    class="flex items-center gap-1 mt-5"
                    @click.prevent="toggleFavorite"
                >
                    {{ isFavorited ? 'Remove from Favorites' : 'Add from Favorites' }}
                    
                    <Icon icon="clarity:favorite-line" width="18"></Icon> 
                </base-button>
                <base-button
                    v-if="user.data.id == recipe.user_id"
                    variant="secondary" 
                    class="flex items-center gap-1 mt-5 bg-blue-400 text-white hover:bg-blue-500"   
                >
                    Edit
                    <Icon icon="material-symbols:edit-outline" width="18"></Icon> 
                </base-button>
                <base-button
                    variant="danger"    
                    class="flex items-center gap-1 mt-5"
                >
                    Delete
                    <Icon icon="material-symbols:delete-outline" width="18"></Icon> 
                </base-button>
            </div> -->
        </div>
    </div>
</template>

<script>
import { useToast } from 'vue-toastification';
    export default {
        props: {
            recipe: {
                type: Object
            },
            isLoading: {
                type: Boolean
            }
        },
        watch: {
            recipe(newVal) {
                // console.log('Recipe', newVal);
            }
        },
        data() {
            return {
                imagePath: '/storage/'
            }
        }, 
        methods: {
            async toggleReaction(reactionType) {
                try {
                    const recipeId = this.$route.params.id;
                    const response = await axios.post(`/api/recipes/${recipeId}/reactions`, {
                        reaction_type: reactionType
                    });
                    this.toast.success('Reaction saved.');
                } catch (error){
                    console.error('Reaction failed', error);
                    this.toast.error('Something went wrong. Please try again.');
                }
            }
        },
        created() {
            this.toast = useToast();
        }
    }
</script>