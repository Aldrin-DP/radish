<template>
    <div v-if="isLoading" class="mt-3">

        <div class="flex flex-col gap-3 lg:flex-row lg:justify-between lg:items-center">

            <div class="h-6 w-40 bg-gray-200 rounded animate-pulse"></div>

            <div class="flex gap-3 overflow-x-auto my-4">
                <div v-for="i in 6" :key="i" class="h-6 w-16 bg-gray-200 rounded animate-pulse"></div>
            </div>

            <div class="h-10 w-full lg:w-64 bg-gray-200 rounded"></div>
        </div>

        <div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5">
            <div v-for="i in 10" :key="i" class="p-3 border rounded">
                <div class="h-64 bg-gray-200 rounded mb-3 animate-pulse"></div>
                <div class="h-4 bg-gray-200 rounded w-1/2 mb-2 animate-pulse"></div>
                <div class="h-4 bg-gray-200 rounded w-full animate-pulse"></div>
            </div>
        </div>

    </div>
    <div v-else>
        <div class="flex flex-col mt-3 lg:flex-row lg:justify-between lg:items-center ">
            <h2 class="text-lg font-semibold text-gray-600">All Recipes</h2>

            <ul class="flex gap-3 overflow-x-auto scroll-m-1 my-4">
                <li class="px-1 bg-gray-200">All</li>
                <li class="px-1 bg-gray-200"    >Breakfast</li>
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
