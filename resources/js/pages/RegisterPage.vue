<template>
    <div class="p-5 w-full lg:w-8/12">
        <div class=" flex border">
            <div class="w-3/6 p-3 flex items-center justify-center">
                <img src="/public/images/logo.png" alt="" width="100px">
                <div>
                    <p>Radish.</p>
                    <p>Your recipe, your dish.</p>
                </div>
            </div>
            <div class="w-3/6 p-3">
                <h2 class="">Create an account</h2>
                <form @submit.prevent="handleRegister()">
                    <div class="p-3">
                        <div class="mb-1">
                            <label for="" class="text-sm" >First name</label>
                            <input 
                                type="text" 
                                v-model="form.firstname"
                                class="border w-full px-3 py-1 rounded text-sm"
                                placeholder="First name"
                            >
                            <div
                                v-if="errors.firstname" 
                                class="text-red-500 text-sm mb-1"
                            >
                                {{ errors.firstname[0] }}
                            </div>
                        </div>
                        
                        <div class="mb-2">
                            <label for="" class="text-sm">Last name</label>
                            <input 
                                type="text" 
                                v-model="form.lastname"
                                class="border w-full px-3 py-1 rounded text-sm"
                                placeholder="Last name"
                            >
                            <div 
                                v-if="errors.lastname" 
                                class="text-red-500 text-sm mb-1"
                            >
                                {{ errors.lastname[0] }}
                            </div>
                        </div>

                        <div class="mb-2">
                            <label for="" class="text-sm">Email Address</label>
                            <input 
                                type="email" 
                                v-model="form.email"
                                class="border w-full px-3 py-1 rounded text-sm"
                                placeholder="Email address"
                            >
                            <div 
                                v-if="errors.email && errors.email.length" 
                                class="text-red-500 text-sm mb-1"
                            >
                                {{ errors.email[0] }}
                            </div>
                        </div>

                        <div class="mb-2">
                            <label for="" class="text-sm">Password</label>
                            <input 
                                type="password" 
                                v-model="form.password"
                                class="border w-full px-3 py-1 rounded text-sm"
                                placeholder="Password"
                            >
                            <div 
                                v-if="errors.password" 
                                class="text-red-500 text-sm mb-1"
                            >
                                {{ errors.password[0] }}
                            </div>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-sm">
                                Have an account?
                                <a href="" class="text-blue-500">
                                    Log in here
                                </a> 
                            </span>
                            <button class="border border-gray-300 px-7 py-1 rounded-full hover:bg-[#5FB15F] hover:text-white">
                                Register
                            </button>
                        </div>
                    </div>
                </form>
                
      

            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

    export default {
        data() {
            return {
                form: {
                    firstname: '',
                    lastname: '',
                    email: '',
                    password: '',
                }, 
                isLoading: false,
                errors: {}
            }
        },
        methods: {
            async handleRegister() {
                this.errors = {};

                const requiredFields = ['firstname', 'lastname', 'email', 'password'];

                requiredFields.forEach(field => {
                    if (!this.form[field]){
                        const fieldName = field.charAt(0).toUpperCase() + field.slice(1);
                        this.errors[field] = `${fieldName} is required`
                    }
                });

                if (Object.keys(this.errors).length === 0){
                    this.isLoading = true;

                    try {
                        const response = await axios.post(`/api/register`, this.form);
                        this.form = {};
                    } catch (error) {
                        this.errors = error.response.data.errors;
                    } finally {
                        this.isLoading = false;
                    }
                }
            }
        }
    }
</script>