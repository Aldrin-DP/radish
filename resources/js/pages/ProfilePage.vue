<template>
    <div class="p-5 flex flex-col">
        <div class="md:flex gap-5">
            <div class="w-40 h-40 mx-auto md:mx-0 rounded-full border-2 shrink-0 ">
                <img
                    class="rounded-full self-start w-full h-full object-cover"
                    src="/public/images/logo.png"
                    alt="Profile photo"
                >
            </div>
            <div>
                <p
                    v-if="profile"
                    class="font-semibold text-lg text-gray-800 mb-2"
                >
                    {{ `${profile.firstname} ${profile.lastname}` }}
                </p>
                <p> Hi! Cooking is my hobby. I love cooking and I experiment recipes almost everyday! Hope you like my recipes! </p>
            </div>

        </div>

        <div class="mt-5" v-if="profile && profile.recipes">
            <h2 class="text-lg font-semibold text-gray-600">
                {{`${profile.firstname}'s Recipes`}}
            </h2>
            <div
                class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5"
            >
                <div
                    v-for="recipe in profile.recipes"
                    :key="recipe.id"
                    class="cursor-pointer"
                    @click="$router.push(`/recipes/${recipe.id}-${recipe.slug}`)"
                >
                    <RecipeCard
                        :recipe="recipe"
                    />
                </div>
            </div>

        </div>
        <div v-else>
            Loading...
        </div>
    </div>
</template>

<script>

    import RecipeCard from '../components/RecipeCard.vue';

    export default {
        components: {
            RecipeCard
        },
        props: {
            user: {
                type: Object,
                default: null
            },
            isLoggedIn: {
                type: Boolean,
                default: false
            }
        },
        data () {
            return {
                profile: null,
            }
        },
        methods: {
            async fetchProfile(slug) {

                try {
                    const response = await axios.get(`/api/users/${slug}`);
                    console.log(response);
                    this.profile = response.data.user;
                    console.log(this.profile);
                    console.log('recipes', this.profile.recipes);
                    console.log('recipes length', this.profile.recipes.length);
                } catch(error) {
                    console.error(`Failed to fetch user's recipe.`, error);
                }

            }
        },
        watch: {
            profile(newVal) {
                console.log(newVal);
            }
        },
        mounted() {
            const slug = this.$route.params.slug;

            this.fetchProfile(slug);
        }
    }
</script>
