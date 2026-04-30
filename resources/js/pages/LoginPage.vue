<template>
    <div class="py-5 md:p-5 w-full lg:w-8/12 m-auto">
        <div class="flex flex-col lg:flex-row border shadow-sm">
            <div class="w-full lg:w-3/6 p-3 flex items-center justify-center relative">
                <img src="/public/images/logo.png" alt="" width="100px">
                <div class="after:content-[''] after:absolute after:right-0 after:top-0 after:w-full after:h-1 after:bg-[#E94E63]">
                    <p>Your recipe, your dish.</p>
                </div>
            </div>

            <div class="w-full lg:w-3/6 p-3 relative">
                <div class="after:content-[''] after:absolute after:right-0 after:top-0 after:w-full after:h-1 after:bg-[#5FB15F]">
                    <h2 class="text-xl font-semibold mb-3">Sign in</h2>
                    <form @submit.prevent="handleLogin">
                        <div class="p-3">
                            <div class="mb-2">
                                <label for="" class="text">Email Address</label>
                                <input
                                    type="text"
                                    v-model="form.email"
                                    class="border w-full px-3 py-1 rounded text"
                                    placeholder="Email address"
                                >
                                <div
                                    v-if="errors.email"
                                    class="text-red-500 mb-1"
                                >
                                    {{ Array.isArray(errors.email) ? errors.email[0] : errors.email }}
                                </div>
                            </div>

                            <div class="mb-2">
                                <label for="" class="">Password</label>
                                <input
                                    type="password"
                                    v-model="form.password"
                                    class="border w-full px-3 py-1 rounded "
                                    placeholder="Password"
                                >
                                <div
                                    v-if="errors.password"
                                    class="text-red-500  mb-1"
                                >
                                    {{ Array.isArray(errors.password) ? errors.password[0] : errors.password }}
                                </div>
                            </div>

                            <div class="mt-5">
                                <button
                                    :disabled="isLoading"
                                    :class="{ 'opacity-50': isLoading }"
                                    class="border w- border-gray-300 px-7 mb-3 py-1 rounded-full hover:bg-[#5FB15F] hover:text-white"
                                >
                                    {{ isLoading ? 'Signing in...' : 'Sign in' }}
                                </button>
                                <span class="block">
                                    No account yet?
                                    <router-link
                                        to="/register"
                                        class="text-blue-500">
                                        Register here
                                    </router-link>
                                </span>

                            </div>
                        </div>
                    </form>
                </div>
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

                        this.$emit('user-reaction-changed');

                        this.resetForm();

                        this.$router.push('/');


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
