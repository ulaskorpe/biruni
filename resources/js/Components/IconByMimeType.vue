<script setup>
defineProps({
    mimeType:String,
    size:{
        type:String,
        default:'fs-3'
    }
});
</script>

<template>
    <span>
        <i class="bi bi-filetype-pdf" v-if="mimeType == 'application/pdf'" :class="size"></i>
        <i class="bi bi-filetype-xml" v-if="mimeType == 'text/xml'" :class="size"></i>
        <i class="bi bi-play-circle" v-if="mimeType.startsWith('video')" :class="size"></i>
    </span>
</template>
