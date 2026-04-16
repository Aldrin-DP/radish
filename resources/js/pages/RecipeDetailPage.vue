<template>
    <div class="flex flex-col lg:flex-row">
        <div class="lg:w-7/12">
            <RecipeDetail
                :recipe="recipe"
                :isLoading="isLoading"
                :user="user"
                @reaction-clicked="toggleReaction"
                @edit-clicked="openEditModal"
                @delete-clicked="handleDelete"
            />
        </div>
        <div class="lg:w-5/12">
            <CommentSection
                :comments="comments"
                :isLoading="isLoading"
                :isLoggedIn="isLoggedIn"
                :recipe="recipe"
                @comment-added="handleCommentAdded"
            />
        </div>
    </div>
    <RecipeFormModal
        v-if="showEditModal"
        :recipe="selectedRecipe"
        @recipe-updated="handleRecipeUpdated"
        @closeModal="showEditModal = false"
    >

    </RecipeFormModal>
</template>

<script>
import RecipeFormModal from '../components/RecipeFormModal.vue';
import RecipeDetail from '../components/RecipeDetail.vue';
import CommentSection from '../components/CommentSection.vue';
import { useToast } from 'vue-toastification';

export default {
        components: {
            RecipeDetail,
            CommentSection,
            RecipeFormModal
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
                selectedRecipe: null,
                showEditModal: false,
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
                        // User added or changed reaction
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
            },
            handleRecipeUpdated(updatedRecipe) {
                this.recipe = updatedRecipe.recipe ?? updatedRecipe;
            },
            openEditModal(recipe) {
                this.selectedRecipe = recipe;
                this.showEditModal = true;
            },
            async handleDelete(recipeId) {

                if (!confirm('Are you sure you want to delete this recipe?')) {
                    return;
                }

                try {
                    const response = await axios.delete(`/api/recipes/${recipeId}`, { withCredentials: true });

                    this.toast.success('Recipe deleted successfully!');

                    setTimeout(() => {
                        this.$router.push(`/my-recipes`);
                    }, 1000)


                } catch (error){
                    console.error('Error deleting recipe:', error);
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
