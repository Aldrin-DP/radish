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
        <div class="w-full lg:pe-10">
            <h2 class=" text-2xl font-semibold">{{ recipe.recipe_name }}</h2>
            <div class="">
                <div class="aspect-[2/2] mt-1 lg:w-full text-center">
                    <img
                        :src="recipe.image?.startsWith('http') ? recipe.image : imagePath + recipe.image"
                        :alt="recipe.recipe_name"
                        class="h-full w-full object-cover rounded-lg"
                    >
                </div>
                <div class="sm:mt-1 lg:w-full">
                    <div class="flex gap-1 sm:gap-5 items-center justify-center m-5">
                        <div>
                            <p :class="{
                                'bg-green-100 text-green-700': recipe.difficulty == 'easy',
                                'bg-yellow-100 text-yellow-700': recipe.difficulty == 'medium',
                                'bg-red-100 text-red-700': recipe.difficulty == 'hard',
                                }"
                                class="px-4  rounded-full text-gray-100 capitalize font-semibold">
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
                    <div
                        v-if="recipe.description"
                        class="mt-5 sm:mt-0 text-justify"
                    >
                        {{ recipe.description }}
                    </div>

                    <div>
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

                    <div class="mt-7 flex gap-3 justify-center">
                        <div
                            @click="$emit('reaction-clicked', 'love')"
                            class="border px-2 py-1 bg-slate-200 rounded cursor-pointer"
                            :class="{
                                'text-green-500': userReaction === 'love',
                                'border-green-500': userReaction === 'love',
                                'opacity-50': isReacting
                            }"
                            :style="{pointerEvents: isReacting ? 'none' : 'auto'}"
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
                                'text-green-500': userReaction === 'fire',
                                'border-green-500': userReaction === 'fire',
                                'opacity-50': isReacting
                            }"
                            :style="{pointerEvents: isReacting ? 'none' : 'auto'}"
                        >
                            <button class="flex gap-2 items-center ">
                                <Icon icon="noto:face-savoring-food" width="26" height="26" />
                                <span class="">
                                    {{ recipe.fire_reactions_count }}
                                </span>
                            </button>
                        </div>
                        <div
                            @click="$emit('reaction-clicked', 'laugh')"
                            class="border px-2 py-1 bg-slate-200 rounded cursor-pointer"
                            :class="{
                                'text-green-500': userReaction === 'laugh',
                                'border-green-500': userReaction === 'laugh',
                                'opacity-50': isReacting
                            }"
                            :style="{pointerEvents: isReacting ? 'none' : 'auto'}"
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
                                'text-green-500': userReaction === 'dislike',
                                'border-green-500': userReaction === 'dislike',
                                'opacity-50': isReacting
                            }"
                            :style="{pointerEvents: isReacting ? 'none' : 'auto'}"
                        >
                            <button class="flex gap-2 items-center ">
                                <Icon icon="fluent-emoji-flat:thumbs-down" width="26" height="26" />
                                <span class="">
                                    {{ recipe.dislike_reactions_count }}
                                </span>
                            </button>
                        </div>
                    </div>

                    <div class="mt-5 flex gap-1 justify-center">
                        <button
                            @click="$emit('favorite-clicked', recipe.id)"
                            class=" bg-green-600 px-2 py-2 rounded-full text-slate-200 font-semibold flex gap-1 items-center justify-center"
                            :class="{'bg-red-400' : isFavorited}"
                        >
                            <span v-if="isFavorited">Removed from Favorites</span>
                            <span v-else>Add to Favorites</span>
                            <Icon icon="uis:favorite" width="24" height="24" />
                        </button>
                        <div
                            v-if="isRaddisher"
                            class="flex gap-1"
                        >
                            <button
                                @click="$emit('edit-clicked', recipe)"
                                class="flex gap-2 px-2 py-2 border rounded-full bg-sky-500 text-slate-200"
                            >
                                <Icon icon="mingcute:edit-line" width="24" height="24" />
                            </button>
                            <button
                                @click="$emit('delete-clicked', recipe.id)"
                                class="flex gap-2 px-2 py-2 border rounded-full bg-red-500 text-slate-200"
                            >
                                <Icon icon="akar-icons:cross" width="24" height="24" />
                            </button>
                        </div>

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
            },
            isFavorited: {
                type: Boolean,
                default: false
            },
            isLoading: {
                type: Boolean,
                default: false
            },
            user: {
                type: Object,
                required: true,
            },
            userReaction: {
                type: String,
                default: null
            },
            isReacting: {
                type: Boolean,
                default: false
            }
        },
        watch: {
            reactionCount(newVal) {
                console.log('Count', newVal);
            }
        },
        data() {
            return {
                imagePath: '/storage/',
            }
        },
        computed: {
            isRaddisher() {
                return Number(this.recipe?.user_id) === Number(this.user?.id);
            }
        }
    }
</script>
