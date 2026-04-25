<template>
    <div class="p-5 w-full lg:w-8/12 m-auto">
        <div class="flex flex-col lg:flex-row border shadow-sm">
            <div class="w-full lg:w-3/6 p-3 flex items-center justify-center relative">
                <img src="/public/images/logo.png" alt="" width="100px">
                <div class="after:content-[''] after:absolute after:right-0 after:top-0 after:w-full after:h-1 after:bg-[#E94E63]">
                    <p>Your recipe, your dish.</p>
                </div>
            </div>

            <div class="w-full lg:w-3/6 p-3 relative">
                <div class="after:content-[''] after:absolute after:right-0 after:top-0 after:w-full after:h-1 after:bg-[#5FB15F]">
                    <h2 class="text-xl font-semibold mb-3">Create an account</h2>
                    <form @submit.prevent="handleRegister">
                        <div class="p-3">
                            <div class="mb-1">
                                <label for="" class="" >First name</label>
                                <input
                                    type="text"
                                    v-model="form.firstname"
                                    class="border w-full px-3 py-1 rounded "
                                    placeholder="First name"
                                >
                                <div
                                    v-if="errors.firstname"
                                    class="text-red-500  mb-1"
                                >
                                    {{ Array.isArray(errors.firstname) ? errors.firstname[0] : errors.firstname }}
                                </div>
                            </div>

                            <div class="mb-2">
                                <label for="" class="">Last name</label>
                                <input
                                    type="text"
                                    v-model="form.lastname"
                                    class="border w-full px-3 py-1 rounded "
                                    placeholder="Last name"
                                >
                                <div
                                    v-if="errors.lastname"
                                    class="text-red-500  mb-1"
                                >
                                    {{ Array.isArray(errors.lastname) ? errors.lastname[0] : errors.lastname }}
                                </div>
                            </div>

                            <div class="mb-2">
                                <label for="" class="">Email Address</label>
                                <input
                                    type="email"
                                    v-model="form.email"
                                    class="border w-full px-3 py-1 rounded "
                                    placeholder="Email address"
                                >
                                <div
                                    v-if="errors.email && errors.email.length"
                                    class="text-red-500  mb-1"
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
                                    :class="isLoading ? 'disabled bg-gray-500 opacity-60' : ''"
                                    class="border w- border-gray-300 px-7 mb-3 py-1 rounded-full hover:bg-[#5FB15F] hover:text-white">
                                    {{ isLoading ? 'Processing...' : 'Register' }}
                                </button>
                                <span class="block">
                                    Have an account?
                                    <router-link
                                        to="/login"
                                        class="text-blue-500"
                                    >
                                        Sign in here
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
        created() {
            this.toast = useToast();
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
                        // store token
                        localStorage.setItem('auth_token', response.data.token);
                        this.resetForm();
                        this.toast.success('Registration successful');
                        setTimeout(() => {
                            this.$router.push('/login');
                        }, 1500);

                    } catch (error) {
                        if (error.response?.data?.errors){
                            this.errors = error.response.data.errors;
                        } else {
                            this.toast.error('Registration failed. Please try again.');
                        }
                    } finally {
                        this.isLoading = false;
                    }
                }
            },
            resetForm() {
                this.form = {
                    firstname: '',
                    lastname: '',
                    email: '',
                    password: ''
                }
            }
        }

    }
</script>
