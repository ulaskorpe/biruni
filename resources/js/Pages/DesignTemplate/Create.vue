<template>
    <Head head-key="title" title="Şablon Ekle" />

    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            
            <div  class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Yeni Şablon
                </h1>
            </div>

            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <Link :href="route('design-templates.index')" class="btn fw-bold btn-sm btn-secondary d-flex align-items-center">
                    <i class="bi bi-arrow-left fs-4"></i>
                    <span class="ms-1 lh-1">Geri</span>
                </Link>
            </div>

        </div>
    </div>
	
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            
            <FormErrors :form="form"/>

            <form @submit.prevent="create">

                <div class="card mb-4 mb-xl-10">
                    <div class="card-body">

                        <h5 class="card-title text-muted">Genel Bilgiler</h5>
                        <Divider class="mb-10"/>

                        <div class="row align-items-center mt-5">
                            <label class="col-md-3 fw-bold text-uppercase">İsim</label>
                            <div class="col-md-9">
                                <InputText class="w-100" v-model="form.name" :class="{'p-invalid':form.errors.name}"/>
                            </div>
                        </div>

                        <div class="row align-items-center mt-5">
                            <label class="col-md-3 fw-bold text-uppercase">Kolonları Kullan</label>
                            <div class="col-md-9">
                                <InputSwitch v-model="form.use_columns"/>
                            </div>
                        </div>

                        <div class="row align-items-center mt-5">
                            <label class="col-md-3 fw-bold text-uppercase">Satırları Kullan</label>
                            <div class="col-md-9">
                                <InputSwitch v-model="form.use_rows"/>
                            </div>
                        </div>

                        <div class="row align-items-center mt-5">
                            <label class="col-md-3 fw-bold text-uppercase">Kapsayıcıları Kullan</label>
                            <div class="col-md-9">
                                <InputSwitch v-model="form.use_containers"/>
                            </div>
                        </div>
                        
                    </div>
                </div>

                <ContentArea :form="form" :use-sections="false" :use-columns="form.use_columns" :use-rows="form.use_rows" :use-containers="form.use_containers"/>

                <button type="submit" class="btn btn-primary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Kaydet</button>

            </form>
        </div>
    </div>

    
</template>

<script setup>

import {ref} from "vue";
import { useForm } from "@inertiajs/vue3";
import Divider from "primevue/divider";
import InputText from "primevue/inputtext";
import Button from "primevue/button";
import InputSwitch from 'primevue/inputswitch';

import ContentArea from '../Content/DesignElements/ContentArea';

const props = defineProps({
    sortables:{
        type:Array,
        default:[]
    }
});

const editor = ref(null);

const form = useForm({
    name:"",
    content:[],
    use_columns:false,
    use_rows:false,
    use_containers:false
});

const create = () => {
    form.post(route('design-templates.store'),{
        onSuccess: () => {
            
        },
    });
}


</script>