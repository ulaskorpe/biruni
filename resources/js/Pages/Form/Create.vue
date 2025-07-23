<template>
    <Head head-key="title" title="Form Ekle" />

    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            
            <div  class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Yeni Form Ekle
                </h1>
            </div>

            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <Link :href="route('forms.index')" class="btn fw-bold btn-sm btn-secondary d-flex align-items-center">
                    <i class="bi bi-arrow-left fs-4"></i>
                    <span class="ms-1 lh-1">Geri</span>
                </Link>
            </div>

        </div>
    </div>
	
    <div id="kt_app_content" class="app-content  flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            
            <form @submit.prevent="create">

                <div class="card mb-4 mb-xl-10">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <label class="col-md-3 fw-bold text-uppercase">Form Adı</label>
                            <div class="col-md-9">
                                <InputText type="text" v-model="form.name" class="w-100" :class="{'p-invalid':form.errors.name}"/>
                            </div>
                        </div>
                        <Divider />
                        <div class="row align-items-center">
                            <label class="col-md-3 fw-bold text-uppercase">Popup</label>
                            <div class="col-md-9">
                                <InputSwitch v-model="form.is_modal"/>
                            </div>
                        </div>
                        <div v-if="form.is_modal">
                            <Divider />
                            <div class="row align-items-center">
                                <label class="col-md-3 fw-bold text-uppercase">Popup Buton Yazısı</label>
                                <div class="col-md-9">
                                    <InputText type="text" v-model="form.modal_button_text" class="w-100"/>
                                </div>
                            </div>
                        </div>
                        <Divider />
                        <div class="row align-items-center">
                            <label class="col-md-3 fw-bold text-uppercase">E-Posta Gönderen Adı</label>
                            <div class="col-md-9">
                                <InputText type="text" v-model="form.sender_name" class="w-100" :class="{'p-invalid':form.errors.sender_name}"/>
                            </div>
                        </div>
                        <Divider />
                        <div class="row align-items-center">
                            <label class="col-md-3 fw-bold text-uppercase">Alıcı E-Posta</label>
                            <div class="col-md-9">
                                <InputText type="text" v-model="form.to_email" class="w-100" :class="{'p-invalid':form.errors.to_email}"/>
                            </div>
                        </div>
                        <Divider />
                        <div class="row align-items-center">
                            <label class="col-md-3 fw-bold text-uppercase">CC E-Posta</label>
                            <div class="col-md-9">
                                <InputText type="text" v-model="form.cc_email" class="w-100" :class="{'p-invalid':form.errors.cc_email}"/>
                            </div>
                        </div>
                        <Divider />
                        <div class="row align-items-center">
                            <label class="col-md-3 fw-bold text-uppercase">BCC E-Posta</label>
                            <div class="col-md-9">
                                <InputText type="text" v-model="form.bcc_email" class="w-100" :class="{'p-invalid':form.errors.bcc_email}"/>
                            </div>
                        </div>
                        <Divider />
                        <div class="row align-items-center">
                            <label class="col-md-3 fw-bold text-uppercase">E-Posta Konu</label>
                            <div class="col-md-9">
                                <InputText type="text" v-model="form.subject" class="w-100" :class="{'p-invalid':form.errors.subject}"/>
                            </div>
                        </div>
                        <Divider />
                        <div class="row align-items-center">
                            <label class="col-md-3 fw-bold text-uppercase">Buton Yazısı</label>
                            <div class="col-md-9">
                                <InputText type="text" v-model="form.button_text" class="w-100" :class="{'p-invalid':form.errors.button_text}"/>
                            </div>
                        </div>
                        <Divider />
                        <div class="row align-items-center">
                            <label class="col-md-3 fw-bold text-uppercase">Başarılı Mesaj Tipi</label>
                            <div class="col-md-9">
                                <div class="hstack gap-5">
                                    <div class="flex align-items-center">
                                        <RadioButton v-model="form.success_type" inputId="form-success-type-1" name="success_type" value="message" />
                                        <label for="form-success-type-1" class="ms-2">Mesaj</label>
                                    </div>
                                    <div class="flex align-items-center">
                                        <RadioButton v-model="form.success_type" inputId="form-success-type-2" name="success_type" value="redirect" />
                                        <label for="form-success-type-2" class="ms-2">Sayfa Yönlendirme</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="form.success_type == 'message'">
                            <Divider />
                            <div class="row align-items-center">
                                <label class="col-md-3 fw-bold text-uppercase">Başarılı Mesajı</label>
                                <div class="col-md-9">
                                    <Textarea autoResize rows="1" cols="30" class="w-100 mb-0" v-model="form.success_message" />
                                </div>
                            </div>
                        </div>
                        <div v-if="form.success_type == 'redirect'">
                            <Divider />
                            <div class="row align-items-center">
                                <label class="col-md-3 fw-bold text-uppercase">Yönlendirilecek URL</label>
                                <div class="col-md-9">
                                    <InputText type="text" v-model="form.success_uri" class="w-100" :class="{'p-invalid':form.errors.button_text}"/>
                                </div>
                            </div>
                        </div>

                        <Divider />
                        <div class="row align-items-center">
                            <label class="col-md-3 fw-bold text-uppercase">Adım Sayısı</label>
                            <div class="col-md-9">
                                <Dropdown v-model="form.step_count" class="w-100" :options="[1,2,3,4,5,6,7,8,9,10]"/>
                            </div>
                        </div>

                        <div v-if="form.step_count === 1">
                            <Divider />
                            <div class="row align-items-center">
                                <label class="col-md-3 fw-bold text-uppercase">Kolon Sayısı</label>
                                <div class="col-md-9">
                                    <Dropdown v-model="form.column_count" class="w-100" :options="[1,2]"/>
                                </div>
                            </div>
                        </div>

                        <Divider />
                        
                        <div class="row align-items-center">
                            <label class="col-md-3 fw-bold text-uppercase">Gönderim Sonrası Script</label>
                            <div class="col-md-9">
                                <AceEditor
                                    v-model:codeContent="form.success_script" 
                                    v-model:editor="editor"
                                    :options="{'showPrintMargin': false}"
                                    theme="chrome"
                                    lang="html"
                                    width="100%" 
                                    height="200px" 
                                />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4 mb-xl-10">
                    <div class="card-body">
                        <h5 class="card-title text-muted">Form İçeriği</h5>
                        <Divider class="mb-10"/>

                        <draggable 
                            v-model="form.json_data" 
                            group="formItem" animation="200" 
                            tag="div" 
                            class="row g-4" 
                            @start="dragging = true" 
                            @end="dragging = false" 
                            :item-key="`label-${Math.floor(Math.random() * 10000000)}`"
                        >
                            <template #item="{element:item,index}">
                                <div :class="item.size">
                                    <Panel toggleable collapsed :header="item.itemLabel">
                                        <template #icons>
                                            <button @click="form.json_data.splice(index,1)" type="button" class="p-panel-header-icon p-link me-2">
                                                <span class="bi bi-trash"></span>
                                            </button>
                                        </template>
                                        <div v-if="form.step_count > 1">
                                            <div class="row align-items-center">
                                                <label class="col-lg-6 fw-bold">Bulunduğu Adım</label>
                                                <div class="col-lg-6">
                                                    <Dropdown v-model="item.itemStep" class="w-100" :options="[...Array(form.step_count).keys()].map(i => i + 1)"/>
                                                </div>
                                            </div>
                                            <Divider />
                                        </div>
                                        <div v-if="form.step_count === 1">
                                            <div class="row align-items-center">
                                                <label class="col-lg-6 fw-bold">Bulunduğu Kolon</label>
                                                <div class="col-lg-6">
                                                    <Dropdown v-model="item.itemColumn" class="w-100" :options="[1,2]"/>
                                                </div>
                                            </div>
                                            <Divider />
                                        </div>
                                        <div class="row align-items-center">
                                            <label class="col-lg-6 fw-bold">Label</label>
                                            <div class="col-lg-6">
                                                <InputText v-model="item.itemLabel" class="w-100" @input="makeInputName(index,true)"/>
                                            </div>
                                        </div>
                                        <Divider />
                                        <div class="row align-items-center">
                                            <label class="col-lg-6 fw-bold">Input Name</label>
                                            <div class="col-lg-6">
                                                <InputText v-model="item.itemInputName" class="w-100" @input="makeInputName(index)"/>
                                            </div>
                                        </div>
                                        <Divider />
                                        <div class="row align-items-center">
                                            <label class="col-lg-6 fw-bold">Tip</label>
                                            <div class="col-lg-6">
                                                <Dropdown v-model="item.type" :options="inputTypes" class="w-100"/>
                                            </div>
                                        </div>

                                        <div v-if="['select','radio','checkbox','multiselect'].includes(item.type)">
                                            <Divider/>
                                            <div class="row align-items-center">
                                                <label class="col-lg-6 fw-bold">Değerler</label>
                                                <div class="col-lg-6">
                                                    <draggable 
                                                        v-model="item.options" 
                                                        group="inputOption" animation="200" 
                                                        class="d-flex flex-column mb-4" 
                                                        @start="dragging = true" 
                                                        @end="dragging = false" 
                                                        :item-key="`option-${Math.floor(Math.random() * 10000000)}`"
                                                    >
                                                        <template #item="{element,index}">
                                                            <div class="p-inputgroup d-flex mb-2" :key="element">
                                                                <span class="p-inputgroup-addon">
                                                                    <i class="bi bi-arrow-down-up"></i>
                                                                </span>
                                                                <InputText v-model="item.options[index]" type="text"/>
                                                                <span class="p-inputgroup-addon cursor-pointer" @click="item.options.splice(index,1)">
                                                                    <i class="bi bi-trash"></i>
                                                                </span>
                                                            </div>
                                                        </template>
                                                    </draggable>
                                                    <button type="button" class="btn btn-secondary btn-sm btn-icon" @click="item.options.push('')">
                                                        <i class="bi bi-plus fs-3"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div v-if="['radioWithIcon','checkboxWithIcon'].includes(item.type)">
                                            <Divider/>
                                            <div class="row align-items-center">
                                                <label class="col-lg-6 fw-bold">Değerler</label>
                                                <div class="col-lg-6">
                                                    <draggable 
                                                        v-model="item.optionsWithIcon" 
                                                        group="inputOption" animation="200" 
                                                        class="d-flex flex-column mb-4" 
                                                        @start="dragging = true" 
                                                        @end="dragging = false" 
                                                        :item-key="`option-${Math.floor(Math.random() * 10000000)}`"
                                                    >
                                                        <template #item="{element,index}">
                                                            <div class="d-flex gap-2 bg-light border p-2 rounded mb-2" :key="element">
                                                                <div class="d-flex flex-column gap-1 flex-grow-1">
                                                                    <div class="p-inputgroup d-flex mb-1">
                                                                        <span class="p-inputgroup-addon w-75px">IconHtml</span>
                                                                        <Textarea autoResize rows="1" cols="30" class="mb-0" v-model="item.optionsWithIcon[index].icon" />
                                                                    </div>
                                                                    <div class="p-inputgroup d-flex mb-1">
                                                                        <span class="p-inputgroup-addon w-75px">Text</span>
                                                                        <InputText v-model="item.optionsWithIcon[index].text" type="text"/>
                                                                    </div>
                                                                    <div class="p-inputgroup d-flex mb-1">
                                                                        <span class="p-inputgroup-addon w-75px">Value</span>
                                                                        <InputText v-model="item.optionsWithIcon[index].value" type="text"/>
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <span class="btn btn-icon btn-light-danger cursor-pointer" @click="item.optionsWithIcon.splice(index,1)">
                                                                        <i class="bi bi-trash"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </template>
                                                    </draggable>
                                                    <button type="button" class="btn btn-secondary btn-sm btn-icon" @click="item.optionsWithIcon.push({icon:null,text:null,value:null})">
                                                        <i class="bi bi-plus fs-3"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div v-if="['range'].includes(item.type)">
                                            <Divider/>
                                            <div class="row align-items-center">
                                                <label class="col-lg-6 fw-bold">Kurallar</label>
                                                <div class="col-lg-6">
                                                    <div class="d-flex flex-column gap-2 bg-light border p-3 rounded">
                                                        <div class="p-inputgroup d-flex mb-1">
                                                            <span class="p-inputgroup-addon w-75px">MIN</span>
                                                            <InputNumber v-model="item.rangeOptions.min" :useGrouping="false"/>
                                                        </div>
                                                        <div class="p-inputgroup d-flex mb-1">
                                                            <span class="p-inputgroup-addon w-75px">MAX</span>
                                                            <InputNumber v-model="item.rangeOptions.max" :useGrouping="false"/>
                                                        </div>
                                                        <div class="p-inputgroup d-flex mb-1">
                                                            <span class="p-inputgroup-addon w-75px">DEFAULT</span>
                                                            <InputNumber v-model="item.rangeOptions.default" :useGrouping="false"/>
                                                        </div>
                                                        <div class="p-inputgroup d-flex mb-1">
                                                            <span class="p-inputgroup-addon w-75px">STEP</span>
                                                            <InputNumber v-model="item.rangeOptions.step" :useGrouping="false"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div v-if="['contentList'].includes(item.type)">
                                            <Divider/>
                                            <div class="row align-items-center">
                                                <label class="col-lg-6 fw-bold">İçerik Tipleri</label>
                                                <div class="col-lg-6">
                                                    <div class="d-flex flex-column gap-2 bg-light border p-3 rounded">
                                                        <MultiSelect v-model="item.rangeOptions.contentTypes" :options="$page.props.contentTypes" optionLabel="name" optionValue="id" placeholder="Lütfen seçiniz" :maxSelectedLabels="5" class="w-100"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <Divider />
                                        <div class="row align-items-center">
                                            <label class="col-lg-6 fw-bold">Zorunlu</label>
                                            <div class="col-lg-6">
                                                <InputSwitch v-model="item.required"/>
                                            </div>
                                        </div>
                                        <Divider />
                                        <div class="row align-items-center">
                                            <label class="col-lg-6 fw-bold">Label as placeholder</label>
                                            <div class="col-lg-6">
                                                <InputSwitch v-model="item.placeholder"/>
                                            </div>
                                        </div>
                                        <Divider />
                                        <div class="row align-items-center">
                                            <label class="col-lg-6 fw-bold">Size</label>
                                            <div class="col-lg-6">
                                                <div class="hstack gap-3 flex-wrap">
                                                    <div class="flex align-items-center">
                                                        <RadioButton v-model="item.size" :inputId="`${index}-input-size-1`" name="size" value="col-12" />
                                                        <label :for="`${index}-input-size-1`" class="ms-2">1/1</label>
                                                    </div>
                                                    <div class="flex align-items-center">
                                                        <RadioButton v-model="item.size" :inputId="`${index}-input-size-1-2`" name="size" value="col-md-6" />
                                                        <label :for="`${index}-input-size-1-2`" class="ms-2">1/2</label>
                                                    </div>
                                                    <div class="flex align-items-center">
                                                        <RadioButton v-model="item.size" :inputId="`${index}-input-size-1-3`" name="size" value="col-md-4" />
                                                        <label :for="`${index}-input-size-1-3`" class="ms-2">1/3</label>
                                                    </div>
                                                    <div class="flex align-items-center">
                                                        <RadioButton v-model="item.size" :inputId="`${index}-input-size-2-3`" name="size" value="col-md-8" />
                                                        <label :for="`${index}-input-size-2-3`" class="ms-2">2/3</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </Panel>
                                </div>
                            </template>
                        </draggable>

                        <Divider />
                        <Button label="Input ekle" severity="secondary" size="small" @click="addInputToForm" />

                        <Divider />

                        <div class="row g-4">
                            <div class="col-md-4">
                                <div class="hstack gap-2 align-items-center">
                                    <InputSwitch v-model="form.kvkk_check"/>
                                    <label>KVKK Checkbox</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="hstack gap-2 align-items-center">
                                    <InputSwitch v-model="form.membership_check"/>
                                    <label>Üyelik Sözleşmesi Checkbox</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="hstack gap-2 align-items-center">
                                    <InputSwitch v-model="form.privacy_check"/>
                                    <label>Gizlilik ve Güvenlik Checkbox</label>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary" :class="{ 'opacity-25': form.processing || !form.isDirty }" :disabled="form.processing || !form.isDirty">Kaydet</button>
                    </div>
                </div>

            </form>

        </div>
    </div>

</template>

<script setup>

import {ref} from "vue";
import { useForm } from "@inertiajs/vue3";
import Divider from "primevue/divider";
import InputText from "primevue/inputtext";
import InputNumber from "primevue/inputnumber";
import InputSwitch from "primevue/inputswitch";
import MultiSelect from "primevue/multiselect";
import Dropdown from 'primevue/dropdown';
import Button from "primevue/button";
import RadioButton from 'primevue/radiobutton';
import Panel from "primevue/panel";
import Textarea from "primevue/textarea";
import draggable from 'vuedraggable';
import AceEditor from "ace-editor-vue3";
import "brace/mode/html";
import "brace/theme/chrome";

import {slugify} from "../Content/DesignElements/design-elements-data.js";

const props = defineProps({
    email_contents:Object
});

const editor = ref(null);

const dragging = ref(false);
let inputTypes = [
    'text',
    'number',
    'email',
    'textarea',
    'password',
    'select',
    'multiselect',
    'radio',
    'checkbox',
    'intTelInput',
    'stateSelect',
    'citySelect',
    'range',
    'radioWithIcon',
    'checkboxWithIcon',
    'contentList'
];


let inputForAdding = ref({
    itemStep:1,
    itemColumn:1,
    itemLabel:"Input Label",
    itemInputName:"",
    type:"",
    required:false,
    placeholder:false,
    size:"col-lg-12",
    options:[],
    optionsWithIcon:[],
    rangeOptions:{
        min:0,
        max:100,
        step:1,
        default:25
    },
    contentTypes:[]
});

const form = useForm({
    name:"",
    json_data:[],
    sender_name:"",
    to_email:"",
    subject:"",
    button_text:"Gönder",
    success_type:"message",
    success_message:"",
    success_uri:"",
    success_script:"",
    is_modal:false,
    modal_button_text:"",
    cc_email:"",
    bcc_email:"",
    email_content_id:null,
    kvkk_check:false,
    privacy_check:false,
    membership_check:false,
    step_count:1,
    column_count:1
});

const create = () => {
    form.post(route('forms.store'),{
        only:['forms','flash','errors'],
        onSuccess: () => {
            
        },
    });
}


const addInputToForm = async () => {

    form.json_data.push(JSON.parse(JSON.stringify(inputForAdding.value)));

}

const makeInputName = (index,fromLabel = false) => {

    let changedLabel = form.json_data[index].itemInputName;

    if( fromLabel ){
        changedLabel = form.json_data[index].itemLabel;
    }
    form.json_data[index].itemInputName = slugify(changedLabel,"");

}

</script>