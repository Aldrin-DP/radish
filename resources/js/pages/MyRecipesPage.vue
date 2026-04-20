<template>
    <div class="flex justify-between items-center">
        <button
            @click="openModal"
            class="border border-gray-300 px-4 py-2 rounded-full mt-3 flex items-center gap-2 hover:bg-[#53af53] hover:text-slate-200 transition-colors duration-300 focus:bg-[#53af53] focus:text-slate-200"
        >
            Add Recipe <Icon icon="carbon:add-filled" width="24" height="24" />
        </button>
        <div class="flex justify-end mt-3">
            <SearchBar
                @search="handleSearch"
            />
        </div>
        <RecipeFormModal
            v-if="showModal"
            @closeModal="closeModal"
            @recipe-added="handleRecipeAdded"
        />
    </div>

    <div v-if="isLoading" class="mt-3">
        <div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5">
            <div v-for="i in 10" :key="i" class="p-3 border rounded">
                <div class="h-64 bg-gray-200 rounded mb-3 animate-pulse"></div>
                <div class="h-4 bg-gray-200 rounded w-1/2 mb-2 animate-pulse"></div>
                <div class="h-4 bg-gray-200 rounded w-full animate-pulse"></div>
            </div>
        </div>
    </div>

    <div
        v-else-if="myRecipes.length > 0"
        class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5"

    >
        <div
            v-for="recipe in myRecipes"
            :key="recipe.id"
            class="cursor-pointer"
            @click="goToRecipe(recipe.id, recipe.slug)"
        >
            <RecipeCard
                :recipe="recipe"
            />
        </div>
    </div>
    <div v-else>
        No recipes found..
    </div>
</template>

<script>
    import RecipeCard from '../components/RecipeCard.vue';
    import RecipeFormModal from '../components/RecipeFormModal.vue';
    import SearchBar from '../components/SearchBar.vue';

    export default {
        components: {
            RecipeCard,
            RecipeFormModal,
            SearchBar
        },
        data() {
            return {
                myRecipes: [],
                isLoading: false,
                showModal: false,
            }
        },
        methods: {
            async fetchMyRecipes() {
                this.isLoading = true;
                try {
                    const response = await axios.get('/api/my-recipes');
                    this.myRecipes = response.data.myRecipes;
                } catch (error) {
                    console.error('Error fetching recipes', error);
                } finally {
                    this.isLoading = false;
                }
            },
            openModal() {
                this.showModal = true;
            },
            closeModal() {
                this.showModal = false;
            },
            handleRecipeAdded(data) {
                this.myRecipes.push(data.recipe);
            },
            goToRecipe(recipeId, slug){
                this.$router.push(`/recipes/${recipeId}-${slug}`);
            }
        },
        mounted() {
            this.fetchMyRecipes();
        }
    }
</script>

