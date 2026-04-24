<template>
    <div>
        <!-- <div>
            <button
                v-for="category in categories"
                :key="category"
                class="px-4 py-1 rounded-full border bg-gray-50 cursor-pointer text-sm mr-1"
            >
                {{ category }}
            </button>
        </div> -->
        <select
            @change="$emit('filter-changed', { category: $event.target.value, difficulty: selectedDifficulty })"
            :value="selectedCategory"
            class="px-2 py-1 border rounded bg-gray-50 mr-3"
        >
            <option value="">Meal Type</option>
            <option value="breakfast">Breakfast</option>
            <option value="lunch">Lunch</option>
            <option value="dinner">Dinner</option>
            <option value="Snacks">Snacks</option>
            <option value="Beverages">Beverages</option>
        </select>

        <select
            @change="$emit('filter-changed', { category: selectedCategory, difficulty: $event.target.value })"
            :value="selectedDifficulty"
            class="px-2 py-1 border rounded bg-gray-50"
        >
            <option value="">Meal Difficulty</option>
            <option value="easy">Easy</option>
            <option value="medium">Medium</option>
            <option value="Hard">Hard</option>
        </select>
    </div>
</template>

<script>

export default {
    props: {
        selectedCategory: {
            type: String,
            default: '',
        },
        selectedDifficulty: {
            type: String,
            default: '',
        }
    },
    data() {
        return {

        }

    },
    methods: {

    }
}

</script>
