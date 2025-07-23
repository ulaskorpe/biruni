<template>
    
    <div>
        <button type="button" :class="props.buttonClass" @click="dialogVisible = true" v-html="props.buttonText"></button>

        <Dialog v-model:visible="dialogVisible" modal @show="getListTemplates();getCardLayouts()" header="Yeni İçerik Tipi Ekle" :style="{ width: '50vw' }" :breakpoints="{ '960px': '75vw', '641px': '95vw' }">
            <form @submit.prevent="create">

                <div class="row align-items-center">
                    <div class="col-md-6 fw-bold text-uppercase">
                        <div class="d-flex align-items-center">
                            <span class="fw-semibold">İsim</span>
                            <div class="d-flex align-items-center ms-2">
                                <img :src="`/dmn/media/flags/${props.language}.svg`" class="me-2" style="width: 14px" />
                                <span class="text-uppercase">{{ props.language }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <InputText v-model="form.name" class="w-100" />
                    </div>
                </div>

                <Divider />

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

                <div class="separator my-10"></div>
                <button type="submit" class="btn btn-primary" :class="{ 'opacity-25': form.processing || !form.isDirty }" :disabled="form.processing || !form.isDirty">Kaydet</button>
                <FormErrors :form="form"/>

            </form>
        </Dialog>
    </div>

</template>

<script setup>

import {ref} from "vue";
import { useForm } from "@inertiajs/vue3";
import Dialog from "primevue/dialog";
import InputText from 'primevue/inputtext';
import InputSwitch from 'primevue/inputswitch';
import Divider from "primevue/divider";
import Dropdown from "primevue/dropdown";

const props = defineProps({
    layouts:Object,
    language:{
        type:String,
        default:'tr'
    },
    fromContentType:{
        type:Object,
        default:null
    },
    buttonClass:{
        type:String,
        default:'btn fw-bold btn-sm btn-success d-flex align-items-center'
    },
    buttonText:{
        type:String,
        default:'<i class="bi bi-person-plus fs-4"></i><span class="ms-1 lh-1">YENİ</span>'
    },
});

const dialogVisible = ref(false);

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

const form = useForm({
    name:props.fromContentType ? props.fromContentType.name+' - '+props.language : "",
    language:props.language,
    has_category:props.fromContentType ? props.fromContentType.has_category : false,
    has_url:props.fromContentType ? props.fromContentType.has_url : false,
    is_published:false,
    use_taxonomy_link:props.fromContentType ? props.fromContentType.use_taxonomy_link : false,
    layout_id:props.fromContentType ? props.fromContentType.layout_id : null,
    content_category_list_template_id:props.fromContentType ? props.fromContentType.content_category_list_template_id : null,
    content_category_default_list_type:props.fromContentType ? props.fromContentType.content_category_default_list_type : "contents",
    card_layout_id:props.fromContentType ? props.fromContentType.card_layout_id : null,
    uuid:props.fromContentType ? props.fromContentType.uuid : "",
    additional:{
        adminOptions:props.fromContentType && props.fromContentType.additional && props.fromContentType.additional.adminOptions ? props.fromContentType.additional.adminOptions : {
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
    content_mode:props.fromContentType && props.fromContentType.content_mode ? props.fromContentType.content_mode : "content",
    depending_content_type_id:props.fromContentType && props.fromContentType.depending_content_type_id ? props.fromContentType.depending_content_type_id : null,
    offcanvas:props.fromContentType && props.fromContentType.offcanvas ? props.fromContentType.offcanvas : false,
});

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

const create = () => {
    form.post(route('content-types.store'),{
        onSuccess: () => {
            form.reset();
            dialogVisible.value = false;
        },
    });
}

</script>