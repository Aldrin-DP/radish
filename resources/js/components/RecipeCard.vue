<template>

    <div class="p-3 rounded-lg bg-gray-200 shadow-md">

        <div class=" bg-gray-300 rounded">
            <!-- <div class=""> -->
                    <!-- <p v-if="recipe.likes_count > 0"
                        class="absolute rounded-full right-2 top-2 bg-green-400 px-1 text-xs text-green-800 font-bold">TOP</p> -->
                <div class="aspect-[2/2]">
                    <img
                        :src="recipe.image.startsWith('http') ? recipe.image : imagePath + recipe.image"
                        alt=""
                        class="w-full h-full object-cover rounded transition-all duration-300">
                </div>
            <!-- </div> -->
            <!--  -->
        </div>

        <div class="flex flex-col">
            <h4 class="text-center text-gray-800 font-semibold h-14 mt-3 mb-5 text-lg truncate">{{ recipe.recipe_name }}</h4>

            <div>

                <p  v-if="recipe.user"
                    class="mb-2 text-gray-700">
                    {{ recipe?.user?.firstname || 'You' }} {{ recipe?.user?.lastname || ''}}
                </p>

                <div class="text-center flex justify-between text-gray-600">
                    <div class="flex items-center gap-1">
                        <Icon icon="fontisto:comments" width="20" height="13" />
                        <span v-if="recipe.comments_count == 0">0</span>
                        <span v-else>{{ recipe.comments_count }}</span>
                    </div>

                    <div class="flex items-center gap-1">
                        <Icon icon="bx:dish" width="14" height="14" />
                        <p class="text-[15px]">{{ recipe.category }}</p>
                    </div>
                    <div>
                        <p :class="{
                                'bg-green-100 text-green-700': recipe.difficulty == 'easy',
                                'bg-yellow-100 text-yellow-700': recipe.difficulty == 'medium',
                                'bg-red-100 text-red-700': recipe.difficulty == 'hard',
                            }"
                            class="px-2 py-[1px] font-medium text-sm rounded-full capitalize">
                            {{ recipe.difficulty }}
                        </p>
                    </div>
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
            }
        },
        data() {
            return {
                imagePath: '/storage/',
            }
        }
    }
</script>
