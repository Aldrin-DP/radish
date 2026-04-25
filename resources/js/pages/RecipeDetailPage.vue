<template>
    <div v-if="error" class="mt-5 text-gray-500">
        No recipe found.
    </div>
    <div v-else class="flex flex-col lg:flex-row">
        <div class="lg:w-7/12">
            <RecipeDetail
                :recipe="recipe"
                :isFavorited="isFavorited"
                :isLoading="isLoading"
                :user="user"
                :userReaction="userReaction"
                :isReacting="isReacting"
                @reaction-clicked="toggleReaction"
                @edit-clicked="openEditModal"
                @delete-clicked="handleDelete"
                @favorite-clicked="toggleFavorite"
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
                type: Object
            }
        },
        data() {
            return {
                isLoading: false,
                recipe: {},
                comments: [],
                isFavorited: null,
                error: false,
                isReacting: false,
                selectedRecipe: null,
                showEditModal: false,
                userReaction: '',
                existingReaction: null,
            }
        },
        methods: {
            async fetchRecipe(id, slug) {
                this.isLoading = true;
                this.error = false;

                try {
                    const response = await axios.get(`/api/recipes/${id}-${slug}`);
                    console.log(response);

                    this.isFavorited = response.data.isFavorited;
                    this.recipe = response.data.recipe;
                    this.comments = response.data.recipe.comments;

                    const existing = this.user?.reactions.find(r => r.recipe_id === this.recipe.id);
                    this.userReaction = existing ? existing.reaction_type : null;

                } catch (error) {
                    console.error('Error fetching recipe detail', error);
                    this.recipe = null;
                    this.isFavorited = false;
                    this.error = true;
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
                    this.toast.error('Log in to react');
                    return;
                }
                if (this.isReacting) return;
                this.isReacting = true;

                let selectedReaction = null;
                const existing = this.user.reactions.find((r) => r.recipe_id === this.recipe.id);

                if (existing) {
                    selectedReaction = existing.reaction_type;
                    if (selectedReaction === reactionType) {
                        this.recipe[selectedReaction + '_reactions_count']--;
                        selectedReaction = null;
                    } else {
                        this.recipe[selectedReaction + '_reactions_count']--;
                        this.recipe[reactionType + '_reactions_count']++;
                        selectedReaction = reactionType;
                    }
                } else {
                    this.recipe[reactionType + '_reactions_count']++;
                    selectedReaction = reactionType;
                }
                this.userReaction = selectedReaction;

                try {
                    const recipeId = this.$route.params.id;
                    const response = await axios.post(`/api/recipes/${recipeId}/reactions`, {
                        reaction_type: reactionType
                    });

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
                } finally {
                    this.isReacting = false;
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
            },
            async toggleFavorite(recipeId) {

                if (!this.isLoggedIn) {
                    this.toast.error('Login to save your favorite recipes!');
                    return;
                }

                try {
                   const response = await axios.post(`/api/favorites/${recipeId}`, {withCredentials: true});
                    console.log(response);
                   this.isFavorited = response.data.isFavorited;

                   console.log('Favorited');
                } catch (error) {
                    console.error('Error adding favorites: ', error);
                }
            }
        },
        mounted() {

            const id = this.$route.params.id;
            const slug = this.$route.params.slug;

            this.fetchRecipe(id, slug);
        },
        created() {
            this.toast = useToast();
        },
    }
</script>
