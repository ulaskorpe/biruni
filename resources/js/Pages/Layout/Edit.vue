<template>
    <Head head-key="title" :title="props.layout.name" />

    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            
            <div  class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Güncelle: {{ props.layout.name }}
                </h1>
            </div>

            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <Link :href="route('layouts.index')" class="btn fw-bold btn-sm btn-secondary d-flex align-items-center">
                    <i class="bi bi-arrow-left fs-4"></i>
                    <span class="ms-1 lh-1">Geri</span>
                </Link>
            </div>

        </div>
    </div>
	
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            
            <FormErrors :form="form"/>

            <form @submit.prevent="update">

                <div class="card mb-4 mb-xl-10">
                    <div class="card-body">

                        <h5 class="card-title text-muted">Genel Bilgiler</h5>
                        <Divider class="mb-10"/>

                        <div class="row align-items-center">
                            <label class="col-md-3 fw-bold text-uppercase">İsim</label>
                            <div class="col-md-9">
                                <InputText class="w-100" v-model="form.name" :class="{'p-invalid':form.errors.name}"/>
                            </div>
                        </div>

                        <Divider />

                        <div class="row align-items-center">
                            <label class="col-md-3 fw-bold text-uppercase">Tam Ekran</label>
                            <div class="col-md-9">
                                <InputSwitch v-model="form.full_width"/>
                            </div>
                        </div>

                        <Divider />

                        <div class="row align-items-center">
                            <label class="col-md-3 fw-bold text-uppercase">Sol Blok</label>
                            <div class="col-md-9">
                                <div class="hstack align-items-center">
                                    <InputSwitch v-model="form.left_sidebar"/>
                                    <div v-if="form.left_sidebar">
                                        <div class="vr mx-3"></div>
                                        <Dropdown v-model="form.left_sidebar_id" :options="props.sidebars" optionLabel="name" optionValue="id" placeholder="Sidebar Seçiniz"/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <Divider />

                        <div class="row align-items-center">
                            <label class="col-md-3 fw-bold text-uppercase">Sağ Blok</label>
                            <div class="col-md-9">
                                <div class="hstack align-items-center">
                                    <InputSwitch v-model="form.right_sidebar"/>
                                    <div v-if="form.right_sidebar">
                                        <div class="vr mx-3"></div>
                                        <Dropdown v-model="form.right_sidebar_id" :options="props.sidebars" optionLabel="name" optionValue="id" placeholder="Sidebar Seçiniz"/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <Divider />

                        <div class="row align-items-center mt-5">
                            <label class="col-md-3 fw-bold text-uppercase">Class</label>
                            <div class="col-md-9">
                                <InputText class="w-100" v-model="form.json_data.classes"/>
                            </div>
                        </div>

                    </div>
                </div>

                <ContentArea :form="form" :layout-mode="true" />

                <button type="submit" class="btn btn-primary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Kaydet</button>

            </form>

        </div>
    </div>

    
</template>

<script setup>

import { useForm } from "@inertiajs/vue3";
import Divider from "primevue/divider";
import InputText from "primevue/inputtext";
import InputSwitch from "primevue/inputswitch";
import Dropdown from "primevue/dropdown";
import Button from "primevue/button";
import ContentArea from '../Content/DesignElements/ContentArea';

const props = defineProps({
    sidebars:Object,
    layout:Object,
});

const form = useForm({
    name:props.layout.name,
    full_width:props.layout.full_width,
    left_sidebar:props.layout.left_sidebar,
    right_sidebar:props.layout.right_sidebar,
    json_data:props.layout.json_data,
    left_sidebar_id:props.layout.left_sidebar_id,
    right_sidebar_id:props.layout.right_sidebar_id,
    content:props.layout.content ?? [],
    json_data:{
        classes:props.layout.json_data && props.layout.json_data.classes ? props.layout.json_data.classes : ""
    }
});

const update = () => {
    form.put(route('layouts.update',props.layout),{
        onSuccess: () => {
            
        },
    });
}


</script>