<template>

    <div class="w-full mt-3">
        <div>
            <h4 class="font-semibold text-gray-500 mb-2">Raddisher</h4>
            <div class="flex gap-2 items-center">
                <!-- <img 
                    :src="fakeImage" 
                    alt="" 
                    width="50"
                    class="rounded-full border-2 border-gray-300"
                > -->
                <div v-if="isLoading" class="">
                    <div class="bg-gray-200 h-5 w-40 animate-pulse"></div>
                </div>
                <div v-else-if="recipe.user">
                    <p class="font-semibold text-lg opacity-70 cursor-pointer">
                        {{ recipe.user.firstname + ' ' + recipe.user.lastname }}
                        <span class="text-sm font-normal">- {{ recipe.user.recipes_count }} recipes</span>
                    </p>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <h2 class="font-semibold text-xl opacity-90">
                COMMENTS {{ comments ? comments.length : '' }}
                <span class="text-lg text-gray-500 font-normal opacity-100">
                    <!-- {{ comments.length }} -->
                </span>
            </h2>

            <CommentForm 
                :comments="comments"
                :isLoading="isLoading"
                :isLoggedIn="isLoggedIn"
                @comment-added="$emit('comment-added', $event)"
            />
        </div>

        <!-- Comment Filter -->
        <div class="flex gap-3 mt-3">
            <button class="border-b-4 border-green-500 px-3 py-1 font-semibold tracking-wider">TOP</button>
            <button 
                @click="sortComments"
                class="px-3 py-1 font-semibold tracking-wider text-gray-400"
            >
                NEWEST
            </button>
        </div>
        
        <div v-for="(comment, index) in comments" :key="comment.id">
            <CommentItem 
                v-if="!comment.parent_id"
                :comment="comment"
                :isLoggedIn="isLoggedIn"
            />
        </div>
        
    </div>
</template>

<script>
import CommentForm from './CommentForm.vue';
import CommentItem from './CommentItem.vue';

    export default {
        components: {
            CommentForm,
            CommentItem
        },
        props: {
            comments: {
                type: Array
            }, 
            isLoading: {
                type: Boolean
            },
            isLoggedIn: {
                type: Boolean
            },
            recipe: {
                type: Object
            }
        },
        watch: {
            comments(newVal) {
                console.log(newVal);
            }
        }

    }
</script>