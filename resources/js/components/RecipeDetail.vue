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
                <h2 class=" text-2xl font-semibold">{{ recipe.recipe_name }}</h2>
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
                            @click="$emit('reaction-clicked', 'love')" 
                            class="border px-2 py-1 bg-slate-200 rounded cursor-pointer"
                            :class="{
                                'text-green-500': userReaction?.reaction_type === 'love',
                                'border-green-500': userReaction?.reaction_type === 'love'
                            }"
                        >
                            <button class="flex gap-2 items-center ">
                                <Icon icon="fluent-emoji-flat:red-heart" width="26" height="26" />
                                <span class="">
                                    {{ recipe.love_reactions_count }}
                                </span>
                            </button>
                        </div>
                        <div 
                            @click="$emit('reaction-clicked', 'fire')" 
                            class="border px-2 py-1 bg-slate-200 rounded cursor-pointer text-gre"
                            :class="{
                                'text-green-500': userReaction?.reaction_type === 'fire',
                                'border-green-500': userReaction?.reaction_type === 'fire'
                            }"
                        >
                            <button class="flex gap-2 items-center ">
                                <Icon icon="noto:fire" width="26" height="26" />
                                <span class="">
                                    {{ recipe.fire_reactions_count }}
                                </span>
                            </button>
                        </div>
                        <div 
                            @click="$emit('reaction-clicked', 'laugh')" 
                            class="border px-2 py-1 bg-slate-200 rounded cursor-pointer"
                            :class="{
                                'text-green-500': userReaction?.reaction_type === 'laugh',
                                'border-green-500': userReaction?.reaction_type === 'laugh'
                            }"
                        >
                            <button class="flex gap-2 items-center ">
                                <Icon icon="noto:rolling-on-the-floor-laughing" width="26" height="26" />
                                <span class="">
                                    {{ recipe.laugh_reactions_count }}
                                </span>
                            </button>
                        </div>
                        <div 
                            @click="$emit('reaction-clicked', 'dislike')" 
                            class="border px-2 py-1 bg-slate-200 rounded cursor-pointer"
                            :class="{
                                'text-green-500': userReaction?.reaction_type === 'dislike',
                                'border-green-500': userReaction?.reaction_type === 'dislike'
                            }"
                        >
                            <button class="flex gap-2 items-center ">
                                <Icon icon="fluent-emoji-flat:thumbs-down" width="26" height="26" />
                                <span class="">
                                    {{ recipe.dislike_reactions_count }}
                                </span>
                            </button>
                        </div>
                    </div>

                    <!-- Large screen -->
                    <div class="mt-10">
                        <button class="bg-green-600 px-5 py-2 text-lg rounded-full text-slate-200 font-semibold flex gap-2">
                            Add to Favorites
                            <Icon icon="uis:favorite" width="24" height="24" />
                        </button>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="mt-2">
                    <label for="" class="text-gray-500 font-semibold text-lg">Ingredients:</label>      
                    <p class="whitespace-pre-line">
                        {{ recipe.ingredients }}
                    </p>
                </div>
                <div class="mt-2">
                    <label for="" class="text-gray-500 font-semibold text-lg">Instructions:</label>      
                    <p class="whitespace-pre-line">
                        {{ recipe.steps }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            recipe: {
                type: Object,
                required: true
            },
            isLoading: {
                type: Boolean,
                default: false
            },
            user: {
                type: Object,
                required: true,
            }
        },
        watch: {
            reactionCount(newVal) {
                console.log('Count', newVal);
            }
        },
        data() {
            return {
                imagePath: '/storage/'
            }
        },
        computed: {
            userReaction() {
                if (!this.user?.reactions) return null;
                
                return this.user.reactions.find(reaction => 
                    reaction.recipe_id === Number(this.$route.params.id)
                );
            }
        }
    }
</script>