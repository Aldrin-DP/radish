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
    <div v-if="isLoading">
        Loading my recipes...
    </div>  
    <div    
        v-else-if="myRecipes.length > 0"
        class="mt-5 grid grid-cols-2 gap-3 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-5"
    >       
        <div 
            v-for="recipe in myRecipes" 
            :key="recipe.id" 
            class="cursor-pointer"
            @click="goToRecipe(recipe.id)"
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
            goToRecipe(recipeId){
                this.$router.push(`/recipes/${recipeId}`);
            }
        },
        mounted() {
            this.fetchMyRecipes();
        }
    }
</script>

