<template>
    <div v-if="isLoading" class="text-center mt-3 animate-pulse">
        Loading recipes...
    </div>
    <div v-else>       
        <div  class="mt-3 grid grid-cols-1 gap-3 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6">
            <div 
                v-for="recipe in recipes" 
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
    
    export default {
        components: {
            RecipeCard,
        },
        data() {
            return {
                recipes: [],
                isLoading: false,
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
            }
        },
        mounted() {
            this.fetchRecipes();
        }
    }

</script>