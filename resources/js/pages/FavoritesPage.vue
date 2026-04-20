<template>

    <div v-if="isLoading" class="mt-3">
        <div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5">
            <div v-for="i in 10" :key="i" class="p-3 border rounded">
                <div class="h-64 bg-gray-200 rounded mb-3 animate-pulse"></div>
                <div class="h-4 bg-gray-200 rounded w-1/2 mb-2 animate-pulse"></div>
                <div class="h-4 bg-gray-200 rounded w-full  animate-pulse"></div>
            </div>
        </div>
    </div>

    <div
        v-else-if="favorites?.length > 0"
        class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5"
    >
        <div
            v-for="recipe in favorites"
            :key="recipe.id"
            class="cursor-pointer"
            @click="goToRecipe(recipe.id, recipe.slug)"
        >
            <RecipeCard
                :recipe="recipe"
            />
        </div>
    </div>

    <div v-else class="mt-5 text-gray-500">
        No favorite recipes yet. Start exploring recipes to add your first one.
    </div>
</template>

<script>
    import RecipeCard from '../components/RecipeCard.vue';

    export default {
        components: {
            RecipeCard
        },
        data() {
            return {
                favorites: [],
                isLoading: false,
                showModal: false,
            }
        },
        methods: {
            async fetchFavorites() {
                this.isLoading = true;
                try {
                    const response = await axios.get('/api/favorites');
                    console.log(response);
                    this.favorites = response.data.recipes;
                    console.log(response.data.recipes);
                    console.log(this.favorites);
                } catch (error) {
                    console.error('Error fetching favorite recipes', error);
                } finally {
                    this.isLoading = false;
                }
            },
            goToRecipe(recipeId, slug){
                this.$router.push(`/recipes/${recipeId}-${slug}`);
            }

        },
        mounted() {
            this.fetchFavorites();
        }
    }
</script>

