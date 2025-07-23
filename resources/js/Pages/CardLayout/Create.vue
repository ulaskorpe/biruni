<template>
    <Head head-key="title" title="Card Layout Ekle" />

    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            
            <div  class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Yeni Card Layout
                </h1>
            </div>

            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <Link :href="route('card-layouts.index')" class="btn fw-bold btn-sm btn-secondary d-flex align-items-center">
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
                            <label class="col-lg-4 fw-bold text-uppercase">İsim</label>
                            <div class="col-lg-8">
                                <InputText class="w-100" v-model="form.name" :class="{'p-invalid':form.errors.name}"/>
                            </div>
                        </div>

                        <div v-if="!form.json_data.link_to_depending_content && !form.json_data.link_to_attribute">
                            <Divider />

                            <div class="row align-items-center">
                                <label class="col-lg-4 fw-bold text-uppercase">İÇERİK LİNKİ</label>
                                <div class="col-lg-8">
                                    <InputSwitch v-model="form.json_data.link_to_content"/>
                                </div>
                            </div>
                        </div>

                        <div v-if="!form.json_data.link_to_content && !form.json_data.link_to_attribute">
                            <Divider />

                            <div class="row align-items-center">
                                <label class="col-lg-4 fw-bold text-uppercase">BAĞLI OLDUĞU İÇERİK LİNKİ</label>
                                <div class="col-lg-8">
                                    <InputSwitch v-model="form.json_data.link_to_depending_content"/>
                                </div>
                            </div>
                        </div>

                        <div v-if="!form.json_data.link_to_depending_content && !form.json_data.link_to_content">
                            <Divider />

                            <div class="row align-items-center">
                                <label class="col-lg-4 fw-bold text-uppercase">SEÇENEK LİNKİ</label>
                                <div class="col-lg-8">
                                    <InputSwitch v-model="form.json_data.link_to_attribute"/>
                                </div>
                            </div>
                        </div>

                        <div v-if="form.json_data.link_to_attribute">
                            <Divider />

                            <div class="row align-items-center">
                                <label class="col-lg-4 fw-bold text-uppercase">KULLANILACAK SEÇENEK</label>
                                <div class="col-lg-8">
                                    <Dropdown v-model="form.json_data.linkAttribute" showClear :options="attributeList" optionLabel="name" class="w-100"/>
                                </div>
                            </div>

                            <Divider />

                            <div class="row align-items-center">
                                <label class="col-lg-4 fw-bold text-uppercase">SEÇENEK LİNKİ FANCYBOX</label>
                                <div class="col-lg-8">
                                    <InputSwitch v-model="form.json_data.linkAttributeFancyBox"/>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <ContentArea :form="form" :use-sections="false" :use-containers="false" :layout-mode="true"/>

                <button type="submit" class="btn btn-primary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Kaydet</button>

            </form>
        </div>
    </div>

    
</template>

<script setup>
import {onMounted,ref} from 'vue';
import { useForm } from "@inertiajs/vue3";
import Divider from "primevue/divider";
import InputText from "primevue/inputtext";
import InputSwitch from "primevue/inputswitch";
import Button from "primevue/button";
import Dropdown from "primevue/dropdown";

import ContentArea from '../Content/DesignElements/ContentArea';


const form = useForm({
    name:"",
    json_data:{
        link_to_content:false,
        link_to_depending_content:false,
        link_to_attribute:false,
        linkAttribute:null,
        linkAttributeFancyBox:false
    },
    content:[],
});

const create = () => {
    form.post(route('card-layouts.store'),{
        onSuccess: () => {
            
        },
    });
}

const attributeList = ref(null);

const getContentAttributes = () => {

    fetch(route('content-attributes.index'),{
    headers: {
        'Accept': 'application/json',
    }
    }).then(function (response) {
        return response.json();
    }).then((json) => {
        attributeList.value = json;
    });

}

onMounted(() => {
    getContentAttributes();
});

</script>