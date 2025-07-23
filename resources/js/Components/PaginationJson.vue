<template>
    <div>
        <div class="d-flex justify-content-center">
            <ul class="pagination pagination-outline">
                <template v-for="(link, p) in links" :key="p">
                    <li class="page-item previous disabled" v-if="link.url === null">
                        <span class="page-link" v-if="p == 0"><i class="bi bi-chevron-double-left fs-3"></i></span>
                        <span class="page-link" v-else-if="p == links.length - 1"><i class="bi bi-chevron-double-right fs-3"></i></span>
                    </li>
                    <li class="page-item" :class="{ 'active': link.active }" v-else>
                        <a href="#" @click="onClick(link.url)" class="page-link" v-if="p == 0"><i class="bi bi-chevron-double-left fs-3"></i></a>
                        <a href="#" @click="onClick(link.url)" class="page-link" v-else-if="p == links.length - 1"><i class="bi bi-chevron-double-right fs-3"></i></a>
                        <a href="#" @click="onClick(link.url)" class="page-link" v-else>{{ link.label }}</a>
                    </li>
                </template>
            </ul>
        </div>
    </div>
</template>
<script setup>

    defineProps({
        links: Array,
        onClick:{
            type:Function,
            required:true
        }
    });
    
</script>