<template>
    <div class="p-5 w-full lg:w-8/12 ">
        <div class=" flex border ">
            <div class="w-3/6 p-3 flex items-center justify-center">
                <img src="/public/images/logo.png" alt="" width="100px">
                <div>
                    <p>Radish.</p>
                    <p>Your recipe, your dish.</p>
                </div>
                
            </div>

            <div class="w-3/6 p-3">
                <h2 class="">Sign in</h2>
                <form @submit.prevent="handleLogin">
                    <div class="p-3">
                        <div class="mb-2">
                            <label for="" class="text-sm">Email Address</label>
                            <input 
                                type="text"
                                v-model="form.email"
                                class="border w-full px-3 py-1 rounded text-sm"
                                placeholder="Email address"
                            >
                            <div 
                                v-if="errors.email" 
                                class="text-red-500 text-sm mb-1"
                            >   
                                {{ Array.isArray(errors.email) ? errors.email[0] : errors.email }}
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
                                {{ Array.isArray(errors.password) ? errors.password[0] : errors.password }}
                            </div>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-sm">
                                No account yet?
                                <router-link 
                                    to="/register"
                                    class="text-blue-500">
                                    Register here
                                </router-link>
                                <a href="" >
                                    
                                </a> 
                            </span>
                            <button class="border border-gray-300 px-7 py-1 rounded-full hover:bg-[#5FB15F] hover:text-white">
                                Sign in
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</template>

<script>
import { useToast } from 'vue-toastification';
import axios from 'axios';
    export default {
        data() {
            return {
                form: {
                    email: '',
                    password: '',
                },
                isLoading: false,
                errors: {}
            }
        },
        methods: {
            async handleLogin() {
                this.errors = {};

                if (!this.form.email){
                    this.errors.email = 'Email is required.'
                }
                if (!this.form.password){
                    this.errors.password = 'Password is required.'
                }
                if (Object.keys(this.errors).length === 0){
                    this.isLoading = true;
                    try {
                        const response = await axios.post(`/api/login`, this.form);
                        // store token
                        localStorage.setItem('auth_token', response.data.token);

                        this.toast.success('Login successful!');
                        this.resetForm();

                        setTimeout(() => {
                            this.$router.push('/').then(() => {
                                window.location.reload();
                            });
                        }, 1200);
                    } catch (error) {
                        if (error.response?.data?.errors){
                            this.errors = error.response.data.errors;
                        } else if (error.response?.data?.message) {
                            this.errors.email = "Invalid credentials."
                        } else {
                            this.toast.error("Login failed. Please try again.");
                        }
                    } finally {
                        this.isLoading = false;
                    } 
                } 
            },
            resetForm() {
                this.form = {
                    'email': '',
                    'password': ''
                }
            }
        },
        created() {
            this.toast = useToast();
        }
    }
</script>