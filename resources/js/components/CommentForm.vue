<template>
    <span class="text-red-400"> {{ errors.message }} </span>
    <div class="border border-gray-300 p-3 bg-white opacity-70">
        <form @submit.prevent="addComment">
            <textarea 
                name="" 
                id="" 
                rows="3"
                v-model="message"
                class="w-full outline-none bg-white"
                :placeholder="isLoggedIn ? 'Comments containing harmful or inappropriate content may be removed.' : 'Log in to leave a comment'
            ">
            </textarea>
            <div class="flex justify-end mt-1">
                <button
                    class="border border-gray-300 px-3 py-1 rounded-full flex items-center gap-2 transition-colors duration-200"
                    :class="
                        {
                            'cursor-not-allowed': !message,
                            'bg-slate-400': !message,
                            'opacity-50': !message,
                            'bg-green-500': message,
                            'text-white': message,
                            'hover:bg-green-600': message
                        }"
                >
                    {{ isSubmitting ? 'Submitting...' : 'Comment' }}
                    <Icon icon="mynaui:send" width="20px"></Icon>
                </button>
            </div>
        </form>
    </div>   
</template>

<script>
import { useToast } from 'vue-toastification';

    export default {
        props: {
            comments: {
                type: Array
            },
            isLoading: {
                type: Boolean,
                default: false,
            },
            isLoggedIn: {
                type: Boolean,
                default: false,
            },
            commentId: {
                type: Number,
                default: null
            }
        },
        data() {
            return {
                message: '',
                isSubmitting: false,
                errors: {},
            }
        }, 
        methods: {
            async addComment() {
                this.errors = {};

                if (!this.isLoggedIn){
                    this.toast.error('Log in first to comment.');
                    return;
                }

                if (!this.message || this.message.trim() === ''){
                    this.errors.message = 'Comment cannot be empty';
                    return;
                }

                if (Object.keys(this.errors).length === 0){
                    this.isSubmitting = true;
                    try {
                        const recipeId = this.$route.params.id;
                        const response = await axios.post(`/api/recipes/${recipeId}/comments`, { 
                            message: this.message,
                            parent_id: this.commentId
                        });
                        console.log(response.data);
                        this.$emit('comment-added', response.data.comment);
                        this.toast.success('Comment submitted');
                        this.errors = {};
                        this.message = '';
                    } catch (error) {
                        if (error.response?.data?.errors){
                            this.errors = error.response.data.errors;
                        } else {
                            this.toast.error('Comment failed. Try again.');
                        }
                    } finally {
                        this.isSubmitting = false;
                    }
                }
            }
        },
        created() {
            this.toast = useToast();
        }
    }
</script>

