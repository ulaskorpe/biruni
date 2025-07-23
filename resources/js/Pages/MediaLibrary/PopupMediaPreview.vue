<template>
    
    <div class="symbol symbol-100px bg-opacity-25 bg-dark border" v-tooltip.top="media.name">

        <img :src="media.preview_url" alt="" class="cursor-pointer rounded" :class="activeClass" v-if="media.mime_type.startsWith('image/') && media.preview_url"/>
        <img :src="media.original_url" alt="" class="cursor-pointer rounded" :class="activeClass" v-if="media.mime_type.startsWith('image/') && !media.preview_url"/>

        <div class="cursor-pointer symbol-label" :class="activeClass" v-if="!media.mime_type.startsWith('image/')">
            <IconByExt :ext="media.custom_properties.ext" :size="'2x'"/>
        </div>

    </div>

</template>

<script setup>

import IconByExt from "../../Components/IconByExt";


defineProps({
    media:Object,
    activeClass:{
        type:String,
        default:""
    }
});

</script>