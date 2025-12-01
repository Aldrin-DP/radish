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
                <form>
                <div class="p-3">
                    <div class="mb-2">
                        <label for="" class="text-sm">Email Address</label>
                        <input 
                            type="email" 
                            name="email"
                            class="border w-full px-3 py-1 rounded text-sm"
                            placeholder="Email address"
                        >
                    </div>

                    <div class="mb-2">
                        <label for="" class="text-sm">Password</label>
                        <input 
                            type="password" 
                            name="password"
                            class="border w-full px-3 py-1 rounded text-sm"
                            placeholder="Password"
                        >
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

</script>