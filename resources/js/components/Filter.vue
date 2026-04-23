<template>
    <div>
        <div>
            <button
                v-for="category in categories"
                :key="category"
                class="px-4 py-1 rounded-full border bg-gray-50 cursor-pointer text-sm mr-1"
            >
                {{ category }}
            </button>
        </div>

        <select name="" id="">
            <option value="">Select Category:</option>
        </select>
    </div>
</template>

<script>

export default {
    data() {
        return {
            categories: ['All', 'Breakfast', 'Lunch', 'Dinner', 'Snacks', 'Beverages']
        }

    },
    methods: {

    }
}

</script>
