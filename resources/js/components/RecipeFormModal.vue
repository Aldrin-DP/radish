<template>
    <div>
        <div class="fixed inset-0 flex justify-center items-center bg-black bg-opacity-50 p-3 z-50">
            <div class="bg-white p-6 rounded border-t-8 border-t-[#E94E63] w-full md:w-2/3 lg:w-5/12">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold">
                        <span v-if="step === 1">Tell Us About Your Recipe</span>
                        <span v-if="step === 2">List the Ingredients</span>
                        <span v-if="step === 3">Add the Cooking Steps</span>
                        <span v-if="step === 4">Upload a Photo of your Dish</span>
                        <span class="text-sm font-normal text-gray-500 ms-2">
                            {{step}} of 4
                        </span> 
                    </h2>
                    <button @click="$emit('closeModal')" class="text-gray-600 hover:text-gray-900 text-3xl">
                        &times;
                    </button>
                </div>

                <div>
                    <form @submit.prevent="nextSteps">

                        <div v-if="step === 1">
                            <div class="mb-2">
                                <label for="" class="text-sm" >What's your recipe called?</label>
                                <input 
                                    v-model="recipe.recipe_name"
                                    type="text" 
                                    class="border w-full px-3 py-1 rounded text-sm focus:outline-gray-300"
                                    placeholder="Macaroni Salad"
                                >
                                <span 
                                    v-if="errors['recipe_name']"
                                    class="text-sm text-red-400"
                                >
                                    {{ errors['recipe_name'] }}
                                </span>
                            </div>

                            <div class="mb-2">
                                <label for="" class="text-sm" >Describe your recipe <span class="text-xs text-gray-500">(Optional)</span></label>
                                <textarea 
                                    v-model="recipe.description" 
                                    class="border w-full px-3 py-1 rounded text-xs focus:outline-gray-300"
                                    placeholder="Macaroni salad is a creamy pasta dish with mayo and veggies."
                                >
                                </textarea>
                                <span 
                                    v-if="errors['description']"
                                    class="text-sm text-red-400"
                                >
                                    {{ errors['description'] }}
                                </span>
                            </div>

                            <div class="mb-2">
                                <label for="" class="text-sm" >Choose a category</label>
                                <select 
                                    v-model="recipe.category" 
                                    class="border w-full px-2 py-1 rounded text-sm focus:outline-gray-300"
                                >
                                    <option value="" disabled selected>Select category:</option>
                                    <option value="Breakfast">Breakfast</option>
                                    <option value="Lunch">Lunch</option>
                                    <option value="Dinner">Dinner</option>
                                    <option value="Snacks">Snack</option>
                                    <option value="Beverages">Beverages</option>
                                    <option value="Other">Other</option>
                                </select>
                                <span 
                                    v-if="errors['category']"
                                    class="text-sm text-red-400"
                                >
                                    {{ errors['category'] }}
                                </span>
                            </div>

                            <div class="mb-2">
                                <label for="" class="text-sm" >How easy is it to make?</label>
                                <select 
                                    v-model="recipe.difficulty" 
                                    class="border w-full px-2 py-1 rounded text-sm focus:outline-gray-300"
                                >
                                    <option value="" disabled selected>Select difficulty:</option>
                                    <option value="easy">Easy</option>
                                    <option value="medium">Medium</option>
                                    <option value="hard">Hard</option>
                                </select>
                                <span 
                                    v-if="errors['difficulty']"
                                    class="text-sm text-red-400"
                                >
                                    {{ errors['difficulty'] }}
                                </span>
                            </div>

                            <div class="mb-2">
                                <label for="" class="text-sm" >How long does it take? <span class="text-xs text-gray-500">(Include prep and cook time (e.g., 30 minutes)</span></label>
                                <input 
                                    v-model="recipe.prep_time"
                                    type="number" 
                                    class="border w-full px-3 py-1 rounded text-sm focus:outline-gray-300"
                                    placeholder="Eg. 60"
                                >
                                <span 
                                    v-if="errors['prep_time']"
                                    class="text-sm text-red-400"
                                >
                                    {{ errors['prep_time'] }}
                                </span>
                            </div>
                        </div>

                        <div v-if="step === 2">
                            <div>
                                <small class="opacity-70 block mb-1">Enter one ingredient per line.</small>
                                <textarea 
                                    v-model="recipe.ingredients"
                                    rows="6" 
                                    class="w-full p-2 focus:outline-gray-200 text-sm"
                                    placeholder="Eg. 
2 cups of flour
3 eggs
1/2 cup sugar
1 tsp vanilla extract
                                    "
                                >
                                </textarea>
                                <span 
                                    v-if="errors['ingredients']"
                                    class="text-sm text-red-400"
                                >
                                    {{ errors['ingredients'] }}
                                </span>
                            </div>
                            <div v-if="recipe.ingredients">
                                <label for="" class="text-gray-500 block text-sm">Preview</label>
                                <pre class="whitespace-pre-line font-poppins text-sm">
                                    {{ recipe.ingredients }}
                                </pre>
                            </div>
                        </div>

                        <div v-if="step === 3">
                            <div>
                                <small class="opacity-70 block mb-1">Number each step in your instructions.</small>
                                <textarea 
                                    v-model="recipe.steps"
                                    rows="6" 
                                    class="w-full p-2 focus:outline-gray-200 text-sm"
                                    placeholder="Eg. 
1. Combine beef and oyster sauce.
2. Heat 2 tablespoons cooking oil in a cooking pot.
                                    "
                                >
                                </textarea>
                                <span 
                                    v-if="errors['steps']"
                                    class="text-sm text-red-400"
                                >
                                    {{ errors['steps'] }}
                                </span>
                            </div>
                            <div v-if="recipe.steps">
                                <label for="" class="text-gray-500 block text-sm">Preview</label>
                                <pre class="whitespace-pre-line font-poppins text-sm">
                                    {{ recipe.steps }}
                                </pre>
                            </div>
                        </div>

                        <div v-show="step === 4">
                            <div>
                                <small class="block mb-2">Upload one clear photo of your dish.</small>
                                
                                <input 
                                    @change="onFileChange"
                                    type="file"
                                    accept="image/*"
                                    class="block w-full text-sm text-gray-700 border border-gray-300 rounded-lg cursor-pointer p-2"
                                >
                                <span 
                                    v-if="errors['image']"
                                    class="text-sm text-red-400"
                                >
                                    {{ errors['image'] }}
                                </span>
                                <div v-if="imageName" class="text-sm text-gray-600 mt-2">
                                    {{ imageName }}
                                </div>
                            </div>

                            <div v-show="previewUrl" class="mt-3">
                                <img 
                                    :src="previewUrl" 
                                    alt="Dish Photo"
                                    class="sm:max-w-96 object-cover rounded-lg m-auto"
                                >
                            </div>

                            <!-- <div class="mt-2">
                                <small class="block mb-2">Additional note:</small>
                                <textarea 
                                    v-model="recipe.additional_note"
                                    rows="3" 
                                    class="w-full p-2 focus:outline-gray-200 text-sm"
                                    placeholder="Enter additional note"
                                >
                                </textarea>
                            </div> -->
                        </div>

                        <div class="flex justify-between mt-4">
                            <button
                                v-if="step > 1"
                                @click.prevent="prevStep"
                                class="border text-sm px-3 py-1 rounded-full border-gray-300 hover:bg-black hover:opacity-60 hover:text-white hover:border-black transition-colors duration-300"
                            >
                                Previous Step
                            </button>
                            <button 
                                :disabled="loading"
                                :class="loading ? 'opacity-50 cursor-not-allowed' : 'bg-[#5FB15F] text-white'"
                                class="ml-auto border text-sm px-3 py-1 rounded-full bg-[#5FB15F] text-white border-[#5FB15F] hover:bg-green-600"
                            >   
                                <span v-if="loading">
                                    Submitting...
                                </span>
                                <span v-else-if="step === 4">
                                    Share Recipe
                                </span>    
                                <span v-else>Next Step</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { useToast } from 'vue-toastification';

    export default {
        emits: ['closeModal', 'recipe-added'],
        data () {
            return {
                step: 1,
                recipe: {
                    recipe_name: '',
                    description: '',
                    category: '',
                    difficulty: '',
                    prep_time: '',
                    ingredients: '',
                    steps: '',
                    additional_note: ''
                },
                errors: {},
                loading: false,
                previewUrl: null,
                image: null,
                imageName: null,
            }          
        },
        methods: {
            nextSteps() {

                const total_steps = 4;

                if (this.step < total_steps){
                    const isValid = this.validateStep();
                    if (isValid){
                        this.step++;
                    }
                } else {

                    const hasImage = this.validateStep();
                    
                    if (!hasImage){
                        return
                    }

                    this.loading = true;

                    const formData = new FormData();

                    formData.append('recipe_name', this.recipe.recipe_name);
                    formData.append('description', this.recipe.description);
                    formData.append('category', this.recipe.category);
                    formData.append('difficulty', this.recipe.difficulty);
                    formData.append('prep_time', this.recipe.prep_time);
                    formData.append('ingredients', this.recipe.ingredients);
                    formData.append('steps', this.recipe.steps);
                    formData.append('image', this.image);
                    formData.append('additional_note', this.recipe.additional_note);

                    axios.post('api/recipes', formData, { withCredentials: true })
                    .then(response => {
                        this.$emit('recipe-added', response.data);

                        this.resetForm();
                        this.toast.success('Recipe added successfully!');
                        this.$emit('closeModal');
                        this.step = 1;
                    })
                    .catch(error => {
                        console.log('Error:', error);
                        this.toast.error('Something went wrong. Please try again.');
                        if (error.response && error.response.data.errors){
                            this.errors = error.response.data.errors;
                        } 
                    })
                    .finally(() => {
                        this.loading = false;
                    })
                }             
            },  
            prevStep() {
                this.step--;
            },
            validateStep() {
                this.errors = {};
                if (this.step === 1){
                    if (!this.recipe.recipe_name){
                        this.errors.recipe_name = 'Recipe name is required.';
                    } else if (this.recipe.recipe_name.length < 3){
                        this.errors.recipe_name = 'Recipe name must be 3 or more characters.';
                    }
                    if (!this.recipe.category){
                        this.errors.category = 'Category is required.';
                    }
                    if (!this.recipe.difficulty){
                        this.errors.difficulty = 'Difficulty is required.';
                    }
                    if (!this.recipe.prep_time){
                        this.errors.prep_time = 'Cooking time is required.';
                    }
                }
                if (this.step === 2){
                    if (!this.recipe.ingredients || this.recipe.ingredients.trim().length == 0){
                        this.errors.ingredients = 'Ingredients field is required.';
                    }
                }
                if (this.step === 3){
                    if (!this.recipe.steps || this.recipe.steps.trim().length == 0){
                        this.errors.steps = 'Instructions field is required.';
                    }
                }
                if (this.step === 4){
                    if (!this.image){
                        this.errors.image = 'Image field is required.';
                    }
                }

                return Object.keys(this.errors).length === 0; 
            },
            onFileChange(event) {
                const file = event.target.files[0];

                if (!file) {
                    return
                }
                
                this.image = file;
                this.imageName = file.name;
                this.previewUrl = URL.createObjectURL(file);
                
            },
            resetForm() {
                this.recipe = {
                    recipe_name: '',
                    description: '',
                    category: '',
                    difficulty: '',
                    prep_time: '',
                    ingredients: '',
                    steps: '',
                    additional_note: ''
                }
                this.image = null;
                this.imageName = null;
                this.previewUrl = null;
            }

        },
        created() {
            this.toast = useToast();
        }
    }
</script>