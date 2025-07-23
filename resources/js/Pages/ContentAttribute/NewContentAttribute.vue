<template>
    
    <div>
        <button type="button" :class="props.buttonClass" @click="dialogVisible = true" v-html="props.buttonText"></button>

        <Dialog v-model:visible="dialogVisible" modal header="Yeni Seçenek Ekle" :style="{ width: '50vw' }" :breakpoints="{ '960px': '75vw', '641px': '95vw' }">
            <form @submit.prevent="create">

                <div class="d-flex flex-row flex-wrap align-items-center">
                    <img :src="form.icon_uri" v-if="form.icon_uri" class="img-thumbnail" style="max-width:50px"/>
                    <div class="d-flex flex-row align-items-center">
                        <PopupMediaLibrary v-if="!form.icon_uri" :on-select="setAttributeIcon" :form-model="form.icon_uri"  :button-text="'İkon Ekle'" :mime-type="'image/'" :key="Math.floor(Math.random() * 100000)"/>
                        <button type="button" class="btn btn-sm btn-light-danger btn-icon ms-2" v-if="form.icon_uri" @click="form.icon_uri = null">
                            <i class="bi bi-x fs-3"></i>
                        </button>
                    </div>
                </div>

                <Divider />

                <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex flex-column">
                            <div class="d-flex align-items-center mb-1">
                                <span class="fw-semibold">İsim</span>
                                <div class="d-flex align-items-center ms-2">
                                    <img :src="`/dmn/media/flags/${form.language}.svg`" class="me-2" style="width: 14px" />
                                    <span class="text-uppercase">{{ form.language }}</span>
                                </div>
                            </div>
                            <InputText v-model="form.name" class="w-100" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex flex-column">
                            <div class="d-flex align-items-center mb-1">
                                <span class="fw-semibold">Tür</span>
                                <div class="d-flex align-items-center ms-2">
                                    <img :src="`/dmn/media/flags/${form.language}.svg`" style="width: 14px" />
                                </div>
                            </div>
                            <Dropdown v-model="form.option_type" :options="$page.props.enums.option_types" optionLabel="label" optionValue="value" placeholder="Seçiniz" class="w-100" />
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-column" v-if="form.option_type == 'select' || form.option_type == 'multiselect' || form.option_type == 'radio'">
                    <Divider />

                    <div class="row align-items-center">
                        <label class="form-label col-6">Site görünümü</label>
                        <div class="col-6">
                            <Dropdown v-model="form.site_view" :options="$page.props.enums.option_site_views" optionLabel="label" optionValue="value" class="w-100" placeholder="Default"/>
                        </div>
                    </div>

                    <Divider />

                    <div>
                        <div class="d-flex align-items-center mb-1">
                            <span class="fw-semibold">Seçenekler</span>
                            <div class="d-flex align-items-center ms-2">
                                <img :src="`/dmn/media/flags/${form.language}.svg`" class="me-2" style="width: 14px" />
                                <span class="text-uppercase">{{ form.language }}</span>
                            </div>
                        </div>
                        <div v-for="(val,key) in form.values" :key="key">
                            <div class="border rounded bg-opacity-10 bg-dark p-2 d-flex flex-row mb-1">
                                <div class="flex-grow-1">
                                    <div class="row w-100">
                                        <div :class="{'col-md-12':form.site_view == '','col-md-8':form.site_view != ''}">
                                            <InputText v-model="val.name" class="w-100" placeholder="İsim" size="small"/>
                                        </div>
                                        <div class="col-md-4" v-if="form.site_view == 'color'">
                                            <div class="hstack gap-2 align-items-center h-100">
                                                <span>Renk</span>
                                                <ColorPicker v-model="val.color_value" />
                                            </div>
                                        </div>
                                        <div class="col-md-4" v-if="form.site_view == 'image'">
                                            <div class="d-flex flex-row flex-wrap align-items-center">
                                                <img :src="val.image_uri" v-if="val.image_uri" class="img-thumbnail" width="50"/>
                                                <div class="d-flex flex-row align-items-center">
                                                    <PopupMediaLibrary v-if="!val.image_uri" @click="optionValueIndex = key" :on-select="setOptionValueMedia" :form-model="val.image_uri"  :button-text="'Seç'" :mime-type="'image/'" :key="Math.floor(Math.random() * 100000)"/>
                                                    <button type="button" class="btn btn-sm btn-light-danger btn-icon ms-2" v-if="val.image_uri" @click="val.image_uri = null">
                                                        <i class="bi bi-x fs-3"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-icon text-danger ms-2" @click="form.values.splice(key,1)"><i class="bi bi-x-lg"></i></button>
                            </div>
                        </div>

                        <button type="button" class="btn btn-sm btn-dark px-2 py-1 mt-4" @click="addOptionValue">Seçenek Ekle</button>

                    </div>
                </div>

                <Divider />

                <div class="d-flex flex-column">
                    <label class="form-label">Kullanacak İçerik Tipleri</label>
                    <MultiSelect v-model="form.content_types" :options="props.contentTypes" optionLabel="name" optionValue="id" placeholder="Lütfen seçiniz" :maxSelectedLabels="5" class="w-100" />
                </div>

                <Divider />

                <div class="row g-5">
                    <div class="col-lg-4 d-flex flex-row">
                        <InputSwitch v-model="form.fe_visible" />
                        <label class="fw-bold ms-2">Müşteriler görebilir</label>
                    </div>
                    <div class="col-lg-4 d-flex flex-row">
                        <InputSwitch v-model="form.is_required" />
                        <label class="fw-bold ms-2">Zorunlu</label>
                    </div>
                </div>
                
                <Divider />

                <button type="submit" class="btn btn-primary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Kaydet</button>
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
import MultiSelect from "primevue/multiselect";
import Dropdown from "primevue/dropdown";
import Divider from "primevue/divider";
import ColorPicker from "primevue/colorpicker";
import PopupMediaLibrary from "../MediaLibrary/PopupMediaLibrary";

const props = defineProps({
    contentTypes:Object,
    language:{
        type:String,
        default:'tr'
    },
    fromAttribute:{
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
const optionValueIndex = ref(null);

const form = useForm({
    name:props.fromAttribute ? props.fromAttribute.name+' - '+props.language : "",
    language:props.language,
    option_type:props.fromAttribute ? props.fromAttribute.option_type : "",
    fe_visible:props.fromAttribute ? props.fromAttribute.fe_visible : false,
    is_required:props.fromAttribute ? props.fromAttribute.is_required : false,
    content_types:[],
    values:props.fromAttribute && props.fromAttribute.values ? props.fromAttribute.values.map((row) => ({
        id:row.id,
        name:row.name,
        color_value:row.color_value,
        image_uri:row.image_uri
    })) : [],
    uuid:props.fromAttribute ? props.fromAttribute.uuid : "",
    site_view:props.fromAttribute ? props.fromAttribute.site_view : "",
    icon_uri:props.fromAttribute ? props.fromAttribute.icon_uri : "",
});


const addOptionValue = () => {

    form.values.push({
        name:"",
        color_value:"000000",
        image_uri:"",
    });

}

const create = () => {
    form.post(route('content-attributes.store'),{
        onSuccess: () => {
            form.reset();
            dialogVisible.value = false;
        },
    });
}

const setOptionValueMedia = (media) => {
    form.values[optionValueIndex.value].image_uri = media.original_url;
}

const setAttributeIcon = (media) => {
    form.icon_uri = media.original_url;
}

</script>
