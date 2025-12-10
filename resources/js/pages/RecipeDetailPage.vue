<template>
    <div class="flex">
        <div class="lg:w-8/12">
            <RecipeDetail 
                :recipe="recipe"
                :isLoading="isLoading"
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

export default {
        components: {
            RecipeDetail,
            CommentSection
        },
        props: {
            isLoggedIn: {
                type: Boolean
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
                this.comments.unshift(newComment);
            }
        },
        mounted() {
            this.fetchRecipe();
        }
    }
</script>