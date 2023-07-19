<script setup>
const props = defineProps({
    error: String,
})
</script>

<template>
    <div v-if="error">
        <p class="erro text-danger">
            {{ error }}
        </p>
    </div>
</template>
