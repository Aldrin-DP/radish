<template>
    <div v-if="isInitialLoading" class="mt-3">

        <div class="flex flex-col gap-3 lg:flex-row lg:justify-between lg:items-center">

            <div class="h-6 w-40 bg-gray-200 rounded animate-pulse"></div>

            <div class="flex gap-3 overflow-x-auto my-4">
                <div v-for="(i, index) in 2" :key="index" class="h-6 w-32 bg-gray-200 rounded animate-pulse"></div>
            </div>

            <div class="h-10 w-full lg:w-64 bg-gray-200 rounded"></div>
        </div>

        <div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5">
            <div v-for="(i, index) in 10" :key="index" class="p-3 border rounded">
                <div class="h-64 bg-gray-200 rounded mb-3 animate-pulse"></div>
                <div class="h-4 bg-gray-200 rounded w-1/2 mb-2 animate-pulse"></div>
                <div class="h-4 bg-gray-200 rounded w-full animate-pulse"></div>
            </div>
        </div>

    </div>
    <div v-else>
        <div class="flex flex-col mt-3 lg:flex-row lg:justify-between lg:items-center ">
            <h2 class="text-lg font-semibold text-gray-600 mb-2">All Recipes</h2>

            <Filter
                :selectedCategory="selectedCategory"
                :selectedDifficulty="selectedDifficulty"
                @filter-changed="handleFilterChanged"
                class="mb-2"
            />

            <SearchBar
                @search="handleSearch"
            />
        </div>
        <div v-if="isSearching" class="mt-5 text-gray-500 text-md font-semibold" >Searching...</div>
        <div v-else-if="recipes.length < 1" class="text-md mt-4 text-gray-500 font-semibold">
            We couldn’t find any recipes matching your search.
        </div>
        <div v-else class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5">
            <div
                v-for="recipe in recipes"
                :key="recipe.id"
                class="cursor-pointer"
                @click="goToRecipe(recipe.id, recipe.slug)"
            >
                <RecipeCard
                    :recipe="recipe"
                />
            </div>
        </div>
        <div class="mt-8 mb-3 flex justify-center">
            <button
                v-if="page < lastPage"
                @click="loadMoreRecipe"
                class="uppercase font-bold text-gray-700 tracking-wider"
            >
                See more recipe
            </button>
            <div v-if="isLoadingMore" class="text-gray-700 font-semibold">
                Loading...
            </div>
        </div>
    </div>
</template>

<script>
    import RecipeCard from '../components/RecipeCard.vue';
    import Filter from '../components/Filter.vue';
    import SearchBar from '../components/SearchBar.vue';

    export default {
        components: {
            RecipeCard,
            Filter,
            SearchBar
        },
        data() {
            return {
                allRecipes: [],
                recipes: [],
                isLoadMore: false,
                searchQuery: '',
                isInitialLoading: false,
                isLoadingMore: false,
                isSearching: false,
                page: 1,
                lastPage: 1,
                selectedCategory: '',
                selectedDifficulty: ''
            }
        },
        methods: {
            async fetchRecipes() {
                if (this.isLoadMore){
                    this.isLoadingMore = true;
                } else {
                    this.isInitialLoading = true;
                }

                try {
                    const response = await axios.get(`/api/recipes?page=${this.page}`);
                    this.allRecipes = [...this.allRecipes, ...response.data.recipes.data];
                    this.recipes = this.allRecipes;
                    this.lastPage = response.data.recipes.last_page;
                } catch (error) {
                    console.error('Error fetching recipes', error);
                } finally {
                    this.isInitialLoading = false;
                    this.isLoadingMore = false;
                    this.isLoadMore = false;
                }
            },
            async loadMoreRecipe() {

                if (this.page >= this.lastPage) return;

                this.isLoadMore = true;

                this.page++;
                await this.fetchRecipes();
            },
            goToRecipe(recipeId, slug){
                this.$router.push(`/recipes/${recipeId}-${slug}`);
            },
            async handleSearch(query) {
                this.searchQuery = query;
                this.isSearching = true;

                this.$router.push({
                    path: '/',
                    query: {
                        search: query,
                        category: this.selectedCategory,
                        difficulty: this.selectedDifficulty
                    }
                });

                try {
                    const response = await axios.get(`/api/recipes`, {
                        params: {
                            search: query,
                            category: this.selectedCategory,
                            difficulty: this.selectedDifficulty
                        }
                    });
                    this.recipes = response.data.recipes.data;
                } catch (error) {
                    console.error('Error fetching recipes', error);
                } finally {
                    this.isSearching = false;
                }

            },
            handleFilterChanged(filters) {
                this.selectedCategory = filters.category;
                this.selectedDifficulty = filters.difficulty;

                this.$router.push({
                    path: '/',
                    query: {
                        search: this.searchQuery,
                        category: filters.category,
                        difficulty: filters.difficulty
                    }
                });

                this.filterRecipes();
            },
            async filterRecipes() {
                try {
                    const response = await axios.get(`/api/recipes`, {
                        params: {
                            category: this.selectedCategory,
                            difficulty: this.selectedDifficulty,
                            search: this.searchQuery
                        }
                    });
                    this.recipes = response.data.recipes.data;
                    this.lastPage = response.data.recipes.last_page;
                    this.page = 1;
                } catch (error) {
                    console.error('Filter Failed', error);
                }

            }
        },
        computed: {

        },
        mounted() {

            this.selectedCategory = this.$route.query.category || '';
            this.selectedDifficulty = this.$route.query.difficulty || '';
            this.searchQuery = this.$route.query.search || '';

            this.fetchRecipes().then( () => {
                if (this.searchQuery || this.selectedCategory || this.selectedDifficulty) {
                    this.filterRecipes();
                }
            })

            window.addEventListener('home-clicked', () => {
                this.recipes = this.allRecipes;

                this.searchQuery = '';
                this.selectedCategory = '';
                this.selectedDifficulty = '';
            })
        },
    }

</script>
