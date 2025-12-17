<template>
    <div class="flex justify-between items-center">
        <div>
            <p>{{ recipe?.user?.firstname || 'You' }} {{ recipe?.user?.lastname || ''}}</p>
            <div class="flex items-center gap-1">
                <Icon icon="fontisto:comments" width="20" height="13" />
                <span v-if="recipe.comments_count == 0">0</span>
                <span v-else>{{ recipe.comments_count }}</span>
            </div>
        </div>
        <div class="text-center">
            <div>
                <p :class="{
                        'bg-orange-400': recipe.difficulty == 'easy',
                        'bg-orange-600': recipe.difficulty == 'medium',
                        'bg-orange-800': recipe.difficulty == 'hard',
                    }"
                    class="px-2 py-[2px] bg-orange-400 text-sm rounded-full text-gray-100 capitalize">
                    {{ recipe.difficulty }}
                </p>
            </div>
            <div class="flex items-center gap-1">
                <Icon icon="bx:dish" width="14" height="14" />
                <p class="">{{ recipe.category }}</p>
            </div>
        </div>
    </div>

    <div>
        <div class="border p-1 rounded-lg bg-gray-200 relative hover:bg-gray-300">
            <p v-if="recipe.likes_count > 0"
                class="absolute rounded-full right-2 top-2 bg-green-400 px-1 text-xs text-green-800 font-bold">TOP</p>
            <div class="aspect-[2/2]">
                <img 
                    :src="imagePath + recipe.image" 
                    alt="" 
                    class="w-full h-full object-cover rounded-lg hover:scale-105 transition-all duration-300">
            </div>
        </div>
        <h4 class="text-center text-gray-800 font-semibold">{{ recipe.recipe_name }}</h4>                
    </div>
</template>

<script>
    export default {
        props: {
            recipe: {
                type: Object,
                required: true
            }
        },
        data() {
            return {
                imagePath: '/storage/',
            }
        }
    }
</script>