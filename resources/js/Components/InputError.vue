<script setup>
defineProps(['message']);
</script>

<template>
    <span v-show="message" class="d-block text-danger fs-7 mt-2">{{ message }}</span>
</template>
