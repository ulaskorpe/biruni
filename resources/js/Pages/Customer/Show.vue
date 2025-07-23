<template>
    <Head head-key="title" title="Üye Detayı" />

    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            
            <div  class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ props.customer.name }}
                </h1>
            </div>

            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <Link :href="route('customers.index')" class="btn fw-bold btn-sm btn-secondary d-flex align-items-center">
                    <i class="bi bi-arrow-left fs-4"></i>
                    <span class="ms-1 lh-1">Geri</span>
                </Link>
            </div>

        </div>
    </div>
	
    <div id="kt_app_content" class="app-content  flex-column-fluid">

        <div id="kt_app_content_container" class="app-container container-xxl">
            
            <div class="card mb-5 mb-xl-10">
                <div class="card-body">

                    <h5 class="card-title text-muted">Üye Bilgileri</h5>
                    <Divider class="mb-5"/>

                    <div class="d-flex gap-7 align-items-center">

                        <div class="symbol symbol-circle symbol-100px">
                            <img :src="customer.avatar_preview_url" alt="" v-if="props.customer.avatar_preview_url">
                            <div class="symbol-label fs-2 fw-semibold bg-danger text-inverse-danger" v-else>{{ props.customer.name.charAt(0) }}</div>
                        </div>
                        
                        <div class="d-flex flex-column gap-2">

                            <h3 class="mb-0">{{ props.customer.name }}</h3>
                            <div class="d-flex align-items-center gap-2">
                                <i class="ki-duotone ki-sms fs-2"><span class="path1"></span><span class="path2"></span></i>
                                <a href="#" class="text-muted text-hover-primary">{{ props.customer.email }}</a>
                            </div>
                            
                            <div class="d-flex align-items-center gap-2">
                                <i class="ki-duotone ki-phone fs-2"><span class="path1"></span><span class="path2"></span></i>
                                <a href="#" class="text-muted text-hover-primary">{{ props.customer.phone }}</a>
                            </div>
                            
                        </div>

                    </div>

                </div>
            </div>

        </div>

    </div>

</template>

<script setup>

import Avatar from 'primevue/avatar';
import Divider from "primevue/divider";

const props = defineProps({
    customer:Object,
});


</script>