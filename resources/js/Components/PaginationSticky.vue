<template>
    <div class="">
        <div class="d-flex justify-content-center">
            <ul class="pagination pagination-outline">
                <template v-for="(link, p) in props.links" :key="p">
                    <li class="page-item previous disabled" v-if="link.url === null">
                        <span class="page-link" v-if="p == 0"><i class="bi bi-chevron-double-left fs-3"></i></span>
                        <span class="page-link" v-else-if="p == links.length - 1"><i class="bi bi-chevron-double-right fs-3"></i></span>
                    </li>
                    <li class="page-item" :class="{ 'active': link.active }" v-else>
                        <Link :href="link.url" class="page-link" v-if="p == 0" :only="props.only"><i class="bi bi-chevron-double-left fs-3"></i></Link>
                        <Link :href="link.url" class="page-link" v-else-if="p == links.length - 1" :only="props.only"><i class="bi bi-chevron-double-right fs-3"></i></Link>
                        <Link :href="link.url" class="page-link" v-else :only="props.only">{{ link.label }}</Link>
                    </li>
                </template>
            </ul>
        </div>
    </div>
</template>
<script setup>

    const props = defineProps({
        links: Array,
        only:{
            type:Array,
            default:[]
        }
    });
    
</script>