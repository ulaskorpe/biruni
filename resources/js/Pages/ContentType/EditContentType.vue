<template>
    
    <div>
        <Button icon="bi bi-pencil text-primary" text rounded severity="info" @click="visible = true"/>

        <Dialog @hide="hide" v-model:visible="visible" modal header="İçerik Tipi Güncelle" :style="{ width: '50vw' }" :breakpoints="{ '960px': '75vw', '641px': '95vw' }">
            <form @submit.prevent="update" class="d-flex flex-column h-100">

                <div class="row align-items-center">
                    <div class="col-md-6 fw-bold text-uppercase">
                        <div class="d-flex align-items-center">
                            <span class="fw-semibold">İsim</span>
                            <div class="d-flex align-items-center ms-2">
                                <img :src="`/dmn/media/flags/${props.contentType.language}.svg`" class="me-2" style="width: 14px" />
                                <span class="text-uppercase">{{ props.contentType.language }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <InputText v-model="form.name" class="w-100" />
                    </div>
                </div>

                <Divider />

                <div class="row align-items-center">
                    <label class="col-md-6 fw-bold text-uppercase">Slug</label>
                    <div class="col-md-6">
                        <InputText v-model="form.slug" class="w-100" />
                    </div>
                </div>

                <Divider />

                <div v-if="form.use_taxonomy_link">
                    <div class="row align-items-center">
                        <label class="col-md-6 form-label">TAXONOMY</label>
                        <div class="col-md-6">
                            <InputText v-model="form.taxonomy" class="w-100" />
                        </div>
                    </div>

                    <Divider />
                </div>

                <div class="row align-items-center">
                    <label class="col-md-6 fw-bold text-uppercase">Kategori kullanımı</label>
                    <div class="col-md-6">
                        <InputSwitch v-model="form.has_category" />
                    </div>
                </div>

                <Divider />

                <div class="row align-items-center">
                    <label class="col-md-6 fw-bold text-uppercase">URL kullanımı</label>
                    <div class="col-md-6">
                        <InputSwitch v-model="form.has_url" @change="linkOrOffcanvasUpdate('has_url')"/>
                    </div>
                </div>

                <Divider />

                <div class="row align-items-center">
                    <label class="col-md-6 fw-bold text-uppercase">URL Taxonomy Kullan</label>
                    <div class="col-md-6">
                        <InputSwitch v-model="form.use_taxonomy_link"/>
                    </div>
                </div>

                <Divider />

                <div class="row align-items-center">
                    <label class="col-md-6 fw-bold text-uppercase">İçeriği Popup Aç</label>
                    <div class="col-md-6">
                        <InputSwitch v-model="form.offcanvas" @change="linkOrOffcanvasUpdate('offcanvas')"/>
                    </div>
                </div>

                <Divider />

                <div class="row align-items-center">
                    <label class="col-md-6 fw-bold text-uppercase">Yayınla</label>
                    <div class="col-md-6">
                        <InputSwitch v-model="form.is_published"/>
                    </div>
                </div>

                <div v-if="form.has_category">
                    <Divider />

                    <div class="row align-items-center">
                        <label class="col-md-6 form-label">KATEGORİ ŞABLONU</label>
                        <div class="col-md-6">
                            <Dropdown v-model="form.content_category_list_template_id" showClear :options="listingTemplates" optionValue="id" optionLabel="name" placeholder="Default" class="w-100" />
                        </div>
                    </div>

                    <div v-if="!form.content_category_list_template_id">
                        <Divider/>
                        <div class="row align-items-center">
                            <label class="col-md-6 fw-bold text-uppercase">KATEGORİ VARSAYILAN LİSTELEME TİPİ</label>
                            <div class="col-md-6">
                                <Dropdown v-model="form.content_category_default_list_type" :options="['empty','contents','sub-categories','sub-categories-with-contents']" placeholder="Seçiniz" class="w-100" />
                            </div>
                        </div>
                    </div>
                </div>

                <Divider />

                <div class="row align-items-center">
                    <label class="col-md-6 fw-bold text-uppercase">İÇERİK ŞABLONU</label>
                    <div class="col-md-6">
                        <Dropdown v-model="form.layout_id" :options="props.layouts" showClear optionValue="id" optionLabel="name" placeholder="Default" class="w-100"/>
                    </div>
                </div>

                <Divider />

                <div class="row align-items-center">
                    <label class="col-md-6 form-label">İÇERİK KUTU ŞABLONU</label>
                    <div class="col-md-6">
                        <Dropdown v-model="form.card_layout_id" showClear :options="cardLayouts" optionValue="id" optionLabel="name" placeholder="Default" class="w-100" />
                    </div>
                </div>

                <Divider />

                <div class="row align-items-center">
                    <label class="col-md-6 fw-bold text-uppercase">BAĞLI OLDUĞU İÇERİK TİPİ</label>
                    <div class="col-md-6">
                        <Dropdown v-model="form.depending_content_type_id" :options="$page.props.contentTypes" showClear optionValue="id" optionLabel="name" placeholder="None" class="w-100"/>
                    </div>
                </div>

                <Divider />

                <div class="row align-items-center">
                    <label class="col-md-6 form-label">İÇERİK OLUŞTURMA SEÇENEKLERİ</label>
                    <div class="col-md-6">
                        
                        <div class="vstack gap-2">

                            <div class="hstack align-items-center">
                                <InputSwitch v-model="form.additional.adminOptions.tags" />
                                <span class="fw-bold ms-2">Etiketler</span>
                            </div>

                            <div class="hstack align-items-center">
                                <InputSwitch v-model="form.additional.adminOptions.summary" />
                                <span class="fw-bold ms-2">Özet Alanı</span>
                            </div>

                            <div class="hstack align-items-center">
                                <InputSwitch v-model="form.additional.adminOptions.description" />
                                <span class="fw-bold ms-2">Detaylı Açıklama Alanı</span>
                            </div>

                            <div class="hstack align-items-center">
                                <InputSwitch v-model="form.additional.adminOptions.designElements" />
                                <span class="fw-bold ms-2">Tasarım Modülü</span>
                            </div>

                            <div class="hstack align-items-center">
                                <InputSwitch v-model="form.additional.adminOptions.mainImage" />
                                <span class="fw-bold ms-2">Ana Görsel</span>
                            </div>

                            <div class="hstack align-items-center">
                                <InputSwitch v-model="form.additional.adminOptions.headerImage" />
                                <span class="fw-bold ms-2">Başlık Alanı Görsel</span>
                            </div>

                            <div class="hstack align-items-center">
                                <InputSwitch v-model="form.additional.adminOptions.mainVideo" />
                                <span class="fw-bold ms-2">Ana Video</span>
                            </div>

                            <div class="hstack align-items-center">
                                <InputSwitch v-model="form.additional.adminOptions.gallery" />
                                <span class="fw-bold ms-2">Galeri</span>
                            </div>

                            <div class="hstack align-items-center">
                                <InputSwitch v-model="form.additional.adminOptions.slider" />
                                <span class="fw-bold ms-2">Slider Seçimi</span>
                            </div>

                            <div class="hstack align-items-center">
                                <InputSwitch v-model="form.additional.adminOptions.headerLayout" />
                                <span class="fw-bold ms-2">Başlık Alanı Şablon Seçimi</span>
                            </div>

                            <div class="hstack align-items-center">
                                <InputSwitch v-model="form.additional.adminOptions.icon" />
                                <span class="fw-bold ms-2">İçerik İkonu</span>
                            </div>

                        </div>

                    </div>
                </div>

                <Divider />

                <div class="row align-items-center">
                    <label class="col-md-6 form-label">ANA İÇERİK YÖNTEMİ</label>
                    <div class="col-md-6">
                        <Dropdown v-model="form.content_mode" showClear :options="contentModes" optionValue="value" optionLabel="label" class="w-100" />
                    </div>
                </div>

                <div class="separator my-7"></div>

                <div class="">
                    <button type="submit" class="btn btn-primary" :class="{ 'opacity-25': form.processing || !form.isDirty }" :disabled="form.processing || !form.isDirty">Kaydet</button>
                    <button type="button" class="btn btn-light ms-5" @click="cancel()">Vazgeç</button>
                </div>
                <FormErrors :form="form"/>
            </form>
        </Dialog>
    </div>

</template>

<script setup>

import {ref,onMounted} from "vue";
import { useForm } from "@inertiajs/vue3";
import Dialog from "primevue/dialog";
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import InputSwitch from 'primevue/inputswitch';
import Divider from "primevue/divider";
import Dropdown from "primevue/dropdown";

const props = defineProps({
    contentType:Object,
    layouts:Object,
    onHide:{
        type:Function,
        default:() => {}
    }
});

const visible = ref(true);

const contentModes = [
    {
        label:"Tasarım Modülü",
        value:"content"
    },
    {
        label:"Detaylı Açıklama Alanı",
        value:"description"
    }
];

const listingTemplates = ref([]);
const cardLayouts = ref([]);

const getListTemplates = () => {

    fetch(route('content-category-list-templates.index'),{
        headers: {
            'Accept': 'application/json',
        }
    }).then(function (response) {
        return response.json();
    }).then((json) => {
        listingTemplates.value = json;
    });

}

const getCardLayouts = () => {

    fetch(route('card-layouts.index'),{
        headers: {
            'Accept': 'application/json',
        }
    }).then(function (response) {
        return response.json();
    }).then((json) => {
        cardLayouts.value = json;
    });

}

const linkOrOffcanvasUpdate = (field) => {

    if( field == 'has_url' && form.has_url && form.offcanvas){
        form.offcanvas = false;
    }

    if( field == 'offcanvas' && form.has_url && form.offcanvas){
        form.has_url = false;
        form.use_taxonomy_link = false;
    }

}

const form = useForm({
    name:props.contentType.name,
    slug:props.contentType.slug,
    has_category:props.contentType.has_category,
    has_url:props.contentType.has_url,
    is_published:props.contentType.is_published,
    taxonomy:props.contentType.use_taxonomy_link && props.contentType.taxonomy ? props.contentType.taxonomy.name : "",
    use_taxonomy_link:props.contentType.use_taxonomy_link,
    layout_id:props.contentType.layout_id,
    content_category_list_template_id:props.contentType.content_category_list_template_id,
    content_category_default_list_type:props.contentType.content_category_default_list_type,
    card_layout_id:props.contentType.card_layout_id,
    additional:{
        adminOptions:props.contentType.additional && props.contentType.additional.adminOptions ? props.contentType.additional.adminOptions : {
            tags:true,
            summary:true,
            description:false,
            designElements:true,
            mainImage:true,
            headerImage:true,
            mainVideo:true,
            gallery:true,
            slider:true,
            headerLayout:true,
            icon:""
        }
    },
    content_mode:props.contentType.content_mode ?? "content",
    depending_content_type_id:props.contentType.depending_content_type_id,
    offcanvas:props.contentType.offcanvas,
});

const cancel = () => {
    visible.value = false;
    form.reset();
};

const update = () => {
    form.put(route('content-types.update',[props.contentType,{language:props.contentType.language}]),{
        preserveScroll: true,
        onSuccess: (page) => {
            visible.value = false;
        }
    });
}

const hide = () => {
    visible.value = false;
    props.onHide();
}

onMounted(() => {
    getListTemplates();
    getCardLayouts();
});

</script>