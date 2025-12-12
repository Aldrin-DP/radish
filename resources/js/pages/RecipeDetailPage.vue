<template>
    <div class="flex">
        <div class="lg:w-8/12">
            <RecipeDetail 
                :recipe="recipe"
                :isLoading="isLoading"
                :user="user"
                @reaction-clicked="toggleReaction"
            />
        </div>
        <div class="lg:w-4/12">
            <CommentSection 
                :comments="comments"
                :isLoading="isLoading"
                :isLoggedIn="isLoggedIn"
                :recipe="recipe"
                @comment-added="handleCommentAdded"
            />
        </div>
    </div>
</template>

<script>
import RecipeDetail from '../components/RecipeDetail.vue';
import CommentSection from '../components/CommentSection.vue';
import { useToast } from 'vue-toastification';

export default {
        components: {
            RecipeDetail,
            CommentSection
        },
        props: {
            isLoggedIn: {
                type: Boolean,
                default: false
            },
            user: {
                type: Object,
                required: true,
            }
        },
        data() {
            return {
                isLoading: false,
                recipe: {},
                comments: [],
            }
        }, 
        methods: {
            async fetchRecipe() {
                this.isLoading = true;
                const recipeId = this.$route.params.id;
                try {
                    const response = await axios.get(`/api/recipes/${recipeId}`);
                    this.recipe = response.data.recipe;
                    this.comments = response.data.recipe.comments;
                } catch (error) {
                    console.error('Error fetching recipe detail', error);
                } finally {
                    this.isLoading = false;
                }
            },
            handleCommentAdded(newComment) {
                if (newComment.parent_id){

                    const parentComment = this.comments.find(c => c.id === newComment.parent_id);

                    if (parentComment){
                        if (!parentComment.replies){
                            parentComment.replies = [];
                        }
                        parentComment.replies.push(newComment);
                    }
                   
                } else {
                    this.comments.unshift(newComment);
                }
            },
            async toggleReaction(reactionType) {

                if (!this.isLoggedIn){
                    this.toast.error('Please login to react');
                    return;
                }

                try {
                    const recipeId = this.$route.params.id;
                    const response = await axios.post(`/api/recipes/${recipeId}/reactions`, {
                        reaction_type: reactionType
                    });
                    this.toast.success('Reaction saved!');
                    this.recipe.love_reactions_count = response.data.counts.love;
                    this.recipe.fire_reactions_count = response.data.counts.fire;
                    this.recipe.laugh_reactions_count = response.data.counts.laugh;
                    this.recipe.dislike_reactions_count = response.data.counts.dislike;

                     this.$emit('user-reaction-changed');

                    const existingReactionIndex = this.user.reactions.findIndex(
                        r => r.recipe_id === Number(this.$route.params.id)
                    );

                    if (response.data.removed) {
                        // user removed reaction
                        if (existingReactionIndex !== -1) {
                            this.user.reactions.splice(existingReactionIndex, 1);
                        }
                    } else {
                        // User added/changed reaction
                        if (existingReactionIndex !== -1) {
                            this.user.reactions[existingReactionIndex].reaction_type = reactionType;
                        } else {
                            this.user.reactions.push({
                                recipe_id: Number(this.$route.params.id),
                                reaction_type: reactionType,
                                user_id: this.user_id
                            });
                        }
                    }

                } catch (error){
                    console.error('Reaction failed', error);
                    this.toast.error('Failed to save reaction');
                }
            }
        },
        mounted() {
            this.fetchRecipe();
        },
        created() {
            this.toast = useToast();
        },
    }
</script>