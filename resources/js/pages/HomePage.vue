<template>
    <div v-if="isLoading" class="text-center mt-3 animate-pulse">
        Loading recipes...
    </div>
    <div v-else>
        <div class="flex flex-col mt-3 lg:flex-row lg:justify-between lg:items-center ">
            <h2 class="text-lg font-semibold text-gray-600">All Recipes</h2>

            <ul class="flex gap-3 overflow-x-auto scroll-m-1 my-4">
                <li class="px-1 bg-gray-200">All</li>
                <li class="px-1 bg-gray-200">Breakfast</li>
                <li>Lunch</li>
                <li>Dinner</li>
                <li>Snacks</li>
                <li>Beverages</li>
                <li>Easy</li>
                <li>Medium</li>
                <li>Hard</li>
            </ul>

            <SearchBar
                @search="handleSearch"
            />
        </div>
        <div v-if="filteredRecipes.length < 1" class="font-semibold mt-2 text-lg">
            We couldn’t find any recipes matching your search.
        </div>
        <div  class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5">
            <div
                v-for="recipe in filteredRecipes"
                :key="recipe.id"
                class="cursor-pointer"
                @click="goToRecipe(recipe.id)"
            >
                <RecipeCard
                    :recipe="recipe"
                />
            </div>
        </div>
    </div>
</template>

<script>
    import RecipeCard from '../components/RecipeCard.vue';
    import SearchBar from '../components/SearchBar.vue';

    export default {
        components: {
            RecipeCard,
            SearchBar
        },
        data() {
            return {
                recipes: [],
                isLoading: false,
                searchQuery: '',
            }
        },
        methods: {
            async fetchRecipes() {
                this.isLoading = true;
                try {
                    const response = await axios.get('/api/recipes');
                    console.log(response.data);
                    this.recipes = response.data.recipes.data;
                } catch (error) {
                    console.error('Error fetching recipes', error);
                } finally {
                    this.isLoading = false;
                }
            },
            goToRecipe(recipeId){
                this.$router.push(`/recipes/${recipeId}`);
            },
            handleSearch(query) {
                this.searchQuery = query;
            }
        },
        computed: {
            filteredRecipes(){
                if (!this.searchQuery) return this.recipes;

                return this.recipes.filter(recipe =>
                    recipe.recipe_name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                    recipe.ingredients.toLowerCase().includes(this.searchQuery.toLowerCase())
                );
            }
        },
        mounted() {
            this.fetchRecipes();
        }
    }

</script>
