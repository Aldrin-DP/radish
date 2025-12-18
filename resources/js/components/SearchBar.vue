<template>
    <div class="relative w-80">
        <input
            v-model="searchQuery" 
            type="text"
            placeholder="Search recipes or ingredients"
            @input="$emit('search', searchQuery)"
            @keyup.enter="handleSearch"
            class="w-full px-4 pr-10 py-2 border rounded-full focus:outline-none focus:border-[#53af53] focus:ring-1 focus:ring-[#53af53]"
        />
        <Icon 
            icon="mingcute:search-line" 
            width="24" 
            height="24" 
            class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" 
        />
    </div>
</template>

<script>
    export default {
        data() {
            return {
                searchQuery: '',
            }
        },      
    }
</script>