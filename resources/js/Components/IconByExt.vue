<script setup>
defineProps({
    ext:String,
    size:{
        type:String,
        default:"3"
    }
});
</script>

<template>
    <span>
        <i :class="`bi bi-filetype-${ext} fs-${size}`"></i>
    </span>
</template>
