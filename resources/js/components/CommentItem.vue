<template>
    <div class="mt-4 border-b pb-5">
        <p class="opacity-90 flex items-center gap-1">
            {{ comment.user.firstname }} {{ comment.user.lastname }} 
            <span 
                v-if="recipe?.user_id === comment?.user.id"
                class="text-green-500 text-xs font-semibold">
                Raddisher
            </span>
        </p> 
        <span class="text-sm text-slate-500">{{ formattedDate(comment.created_at) }}</span>
        <div class="pt-1">
            {{ comment.message }}
        </div>
        <div class="flex justify-between items-center mt-3">
            <div
                v-if="!comment.parent_id"
                @click="toggleReplies()" 
                class="px-3 py-1 border border-gray-300 text-gray-500 text-sm cursor-pointer">
                {{ (comment.replies?.length > 1) ? 'Replies' : 'Reply' }}
                 <span class="text-black opacity-60">
                    {{ comment.replies ? comment.replies.length : '0' }}
                </span>
            </div>
            <div class="flex gap-1">
                <button class="flex items-center gap-1 px-3 py-1 border border-gray-300">
                    <Icon icon="mdi:like" width="18" height="18" class="text-gray-500 flex"/>
                    <span class="opacity-60 text-sm">
                        0
                    </span>
                </button>
                <button class="flex items-center gap-1 px-3 py-1 border border-gray-300">
                    <Icon icon="mdi:dislike" width="18" height="18" class="text-gray-500"/>
                    <span class="opacity-60 text-sm">
                        0
                    </span>
                </button>
            </div>
        </div>
    </div>

    <div v-if="commentReplies">
        <!-- Replies -->
        <div v-if="comment.replies && comment.replies.length > 0" class="bg-[#eee]">
            <ul class="border-b">
                <li 
                    class="pt-3 relative pr-3"
                    v-for="reply in comment.replies" :key="reply.id"
                >
                    <Icon 
                        icon="radix-icons:corner-bottom-left" width="13" height="13" 
                        class="absolute left-3 top-6"
                    />
                    <div class="ms-8">
                        <CommentItem 
                            :comment="reply"
                            :recipe="recipe"
                        />
                    </div>
                </li>
            </ul>
        
        </div>
        <!-- Reply Form -->
        <div
            v-if="comment.replies" 
            class="py-6 border-b bg-[#eee]"
        >
            <div class="relative">            
                <Icon 
                    icon="radix-icons:corner-bottom-left" width="13" height="13" 
                    class="absolute left-3"
                />
                <div class="ms-8 mr-3 bg-white">
                    <CommentForm
                        @comment-added="$emit('comment-added', $event)"
                        :isLoggedIn="isLoggedIn"
                        :commentId="comment.id"
                    />    
                </div>
            </div>
        </div>

        <div
            @click="showLess()" 
            class="flex justify-center p-3 border-b-2 text-gray-500 font-bold cursor-pointer bg-[#eee]"
        >
            Show Less
        </div>
    </div>
    
    
</template>

<script>
import CommentForm from './CommentForm.vue';
    export default {
        name: 'CommentItem',
        emits: ['comment-added'],
        components: {
            CommentForm
        },
        props: {
            comment: {
                type: Object,
                required: true,
            },
            recipe: {
                type: Object,
                required: true,
            },
            isLoggedIn: {
                type: Boolean,
                default: false,
            }
        },
        data (){
            return {
                commentReplies: false,
            }
        },
        methods: {
            formattedDate(inputDate) {
                const date = new Date(inputDate);

                const formattedDate = date.toLocaleString('en-PH',{
                    month: 'short',
                    day: '2-digit',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: true
                });
                
                return formattedDate;
            },
           toggleReplies() {
                this.commentReplies = !this.commentReplies;
           },
           showLess() {
                this.commentReplies = false;
           }
        }
    }
</script>