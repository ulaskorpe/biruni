<template>
    <Head head-key="title" :title="`${props.content_type.name}`" />

    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            
            <div  class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    <span class="d-flex align-items-center">Yeni {{ props.content_type.name }} Ekle <span class="badge badge-dark p-2 ms-2 text-uppercase">{{ $page.props.current_language }}</span></span>
                </h1>
            </div>

            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <Link :href="route('contents.index',{contentType:props.content_type.id,language:$page.props.current_language})" class="btn fw-bold btn-sm btn-secondary d-flex align-items-center">
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

                <div v-if="props.depending_contents">
                    <div class="row align-items-center mb-5">
                        <label class="col-md-6 fw-bold text-uppercase">Bağlı Olacağı İçerik</label>
                        <div class="col-md-6">
                            <Dropdown v-model="form.depending_content_id" :options="props.depending_contents" filter showClear optionValue="id" optionLabel="name" :virtualScrollerOptions="{ itemSize: 38 }" placeholder="Seçiniz" class="w-100" />
                        </div>
                    </div>
                </div>

                <div class="row g-4 g-lg-6 g-xl-10" v-if="!props.depending_contents || form.depending_content_id">
                    <div class="col-lg-9">

                        <div class="card mb-4 mb-xl-10">
                            <div class="card-body">

                                <h5 class="card-title text-muted">{{ props.content_type.name }} Genel Bilgiler</h5>
                                <Divider class="mb-10"/>

                                <div class="row align-items-center mt-5">
                                    <label class="col-md-3 fw-bold text-uppercase">İsim</label>
                                    <div class="col-md-9">
                                        <InputText class="w-100" v-model="form.name" :class="{'p-invalid':form.errors.name}"/>
                                    </div>
                                </div>

                                <div v-if="props.content_type.has_category">
                                    <div class="row align-items-center mt-5">
                                        <label class="col-md-3 fw-bold text-uppercase">kategori</label>
                                        <div class="col-md-9">
                                            <MultiSelect v-model="form.content_categories" :options="props.categories" optionLabel="depth_name" optionValue="id" placeholder="Lütfen seçiniz" :maxSelectedLabels="5" class="w-100" :class="{'p-invalid':form.errors.content_categories}"/>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mt-5" v-if="form.content_categories.length > 0">
                                        <label class="col-md-3 fw-bold text-uppercase">URL İÇİN KATEGORİ</label>
                                        <div class="col-md-9">
                                            <Dropdown v-model="form.category_for_uri" :options="props.categories.filter((x) => form.content_categories.includes(x.id))" optionLabel="depth_name" optionValue="id" placeholder="Lütfen seçiniz" class="w-100"/>
                                            <small>İçerik linki oluşturulurken, burada seçilecek kategori linkinin devamı şeklinde oluşturulur.</small>
                                        </div>
                                    </div>
                                </div>

                                <div v-if="!props.content_type.has_category">
                                    <div class="row align-items-center mt-5">
                                        <label class="col-md-3 fw-bold text-uppercase">Üst {{ props.content_type.name }}</label>
                                        <div class="col-md-9">
                                            <Dropdown v-model="form.parent_id" :options="contents" filter showClear optionValue="id" optionLabel="depth_name" placeholder="Root" class="w-100" />
                                        </div>
                                    </div>
                                </div>

                                <div v-if="props.content_attributes">
                                    <div class="row align-items-center mt-5" v-for="(attribute, index) in form.attributes" :key="`product-attribute-${index}`">
                                        <label class="col-md-3 fw-bold text-uppercase">{{ attribute.name }}</label>
                                        <div class="col-md-9">

                                            <InputMask mask="99:99" v-if="attribute.option_type == 'time'" v-model="attribute.value" :class="{'p-invalid':form.errors[`attributes.${index}.value`]}"/>

                                            <InputMask mask="99.99.9999" placeholder="GG.AA.YYYY" v-if="attribute.option_type == 'date'" v-model="attribute.value" :class="{'p-invalid':form.errors[`attributes.${index}.value`]}"/>

                                            <InputMask mask="99.99.9999 99:99" placeholder="GG.AA.YYYY HH:SS" v-if="attribute.option_type == 'datetime'" v-model="attribute.value" :class="{'p-invalid':form.errors[`attributes.${index}.value`]}"/>

                                            <Dropdown v-if="attribute.option_type == 'select'" v-model="attribute.value" :options="attribute.values" optionLabel="name" optionValue="name" placeholder="Lütfen seçiniz" :class="{'p-invalid':form.errors[`attributes.${index}.value`]}"/>

                                            <Dropdown v-if="attribute.option_type == 'reviewSites'" v-model="attribute.value" :options="$page.props.enums.review_sites" optionLabel="label" optionValue="value" placeholder="Lütfen seçiniz" :class="{'p-invalid':form.errors[`attributes.${index}.value`]}"/>

                                            <Dropdown v-if="attribute.option_type == 'starCount'" v-model="attribute.value" :options="[1,2,3,4,5]" placeholder="Lütfen seçiniz" :class="{'p-invalid':form.errors[`attributes.${index}.value`]}"/>
                                            
                                            <MultiSelect v-if="attribute.option_type == 'multiselect'" v-model="attribute.value" :options="attribute.values" optionLabel="name" optionValue="name" placeholder="Lütfen seçiniz" :class="{'p-invalid':form.errors[`attributes.${index}.value`]}"/>

                                            <div class="d-flex flex-row align-items-center" v-if="attribute.option_type == 'file'">
                                                <PopupMediaLibrary v-if="!attribute.value" :on-select="setAttributeMedia" :form-model="attribute" :button-text="'Seç'" :mime-type="'application/'" :key="Math.floor(Math.random() * 100000)"/>
                                                <div class="d-flex flex-" v-if="attribute.value">
                                                    <a target="_blank" :href="attribute.value" class="btn btn-sm btn-light-success">Göster</a>
                                                    <button type="button" class="btn btn-sm btn-light-danger btn-icon ms-2" @click="attribute.value = null">
                                                        <i class="bi bi-x fs-3"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="d-flex flex-row flex-wrap align-items-center" v-if="attribute.option_type == 'image'">
                                                <img :src="attribute.value" v-if="attribute.value" class="img-thumbnail" width="100"/>
                                                <div class="d-flex flex-row align-items-center">
                                                    <PopupMediaLibrary v-if="!attribute.value" :on-select="setAttributeMedia" :form-model="attribute" :button-text="'Seç'" :mime-type="'image/'" :key="Math.floor(Math.random() * 100000)"/>
                                                    <button type="button" class="btn btn-sm btn-light-danger btn-icon ms-2" v-if="attribute.value" @click="attribute.value = null">
                                                        <i class="bi bi-x fs-3"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <OptionType :option="attribute" v-model="attribute.value" v-else :error-class="form.errors[`attributes.${index}.value`] ? true : false"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="row align-items-center mt-5" v-if="!props.content_type.additional || (props.content_type.additional.adminOptions.tags)">
                                    <label class="col-md-3 fw-bold text-uppercase">etiketler</label>
                                    <div class="col-md-9">
                                        <div class="d-flex flex-row align-items-center">
                                            <div class="flex-grow-1 me-2">
                                                <MultiSelect v-model="form.tags" display="chip" filter :options="optionTags" optionLabel="name" optionValue="id" :virtualScrollerOptions="{ itemSize: 44 }" :maxSelectedLabels="3" placeholder="Lütfen seçiniz" class="w-100"/>
                                            </div>
                                            <NewTag :render-as="'fetch'" :on-done="addNewTagToSelected"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="row align-items-center mt-5" v-if="!props.content_type.additional || (props.content_type.additional.adminOptions.icon)">
                                    <label class="col-md-3 fw-bold text-uppercase">Icon</label>
                                    <div class="col-md-9">
                                        <Dropdown v-model="form.additional.icon" :options="bootstrapIcons" optionValue="icon" optionLabel="icon" :virtualScrollerOptions="{ itemSize: 30 }" showClear filter placeholder="Select icon" class="w-100">
                        
                                            <template #value="slotProps">
                                                <div class="d-flex flex-row align-items-center" v-if="slotProps.value">
                                                    <i :class="`bi bi-${slotProps.value}`"></i>
                                                    <span v-html="slotProps.value" class="ms-3"></span>
                                                </div>
                                                <span v-else>
                                                    {{ slotProps.placeholder }}
                                                </span>
                                            </template>
                                            <template #option="slotProps">
                                                <div class="d-flex flex-row align-items-center">
                                                    <i :class="`bi bi-${slotProps.option.icon} fs-1`"></i>
                                                    <span v-html="slotProps.option.icon" class="ms-3"></span>
                                                </div>
                                            </template>

                                        </Dropdown>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="card mb-4 mb-xl-10" v-if="props.content_type.has_url">
                            <div class="card-body">
                                <h5 class="card-title text-muted">SEO Bilgileri</h5>
                                <Divider class="mb-10"/>

                                <div class="row align-items-center">
                                    <label class="col-md-3 fw-bold text-uppercase">SEO Başlık</label>
                                    <div class="col-md-9">
                                        <InputText class="w-100" v-model="form.seo.title" :class="{'p-invalid':form.errors['seo.title']}"/>
                                    </div>
                                </div>

                                <div class="row align-items-center mt-5">
                                    <label class="col-md-3 fw-bold text-uppercase">SEO Açıklama</label>
                                    <div class="col-md-9">
                                        <Textarea autoResize rows="1" cols="30" class="w-100" v-model="form.seo.description" :class="{'p-invalid':form.errors['seo.description']}" />
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="card mb-4 mb-xl-10" v-if="!props.content_type.additional || (props.content_type.additional.adminOptions.summary)">
                            <div class="card-body">

                                <h5 class="card-title text-muted">Özet Bilgi</h5>
                                <Divider class="mb-10"/>

                                <TextEditor v-model="form.summary" :full-mode="false"/>

                            </div>
                        </div>

                        <div class="card mb-4 mb-xl-10" v-if="!props.content_type.additional || (props.content_type.additional.adminOptions.description)">
                            <div class="card-body">

                                <h5 class="card-title text-muted">Detaylı Açıklama</h5>
                                <Divider class="mb-10"/>

                                <TextEditor v-model="form.description" :full-mode="true"/>

                            </div>
                        </div>

                        <ContentArea 
                            :form="form" 
                            :use-sections="!props.content_type.offcanvas" 
                            :add-section="props.content_type.offcanvas && form.content.length == 0" 
                            :layout-mode="true" 
                            v-if="!props.content_type.additional || (props.content_type.additional.adminOptions.designElements)"
                        />

                        <div class="card mb-4 mb-xl-10" v-if="props.content_type.has_url">
                            <div class="card-body">

                                <h5 class="card-title text-muted">Sayfa Özellikleri</h5>
                                <Divider class="mb-10"/>

                                <div class="row align-items-center">
                                    <label class="col-md-6 fw-bold text-uppercase">SLIDER</label>
                                    <div class="col-md-6">
                                        <Dropdown v-model="form.slider_id" showClear :options="props.sliders" optionLabel="name" optionValue="id" placeholder="Lütfen seçiniz" class="w-100"/>
                                    </div>
                                </div>

                                <Divider />

                                <div class="row align-items-center">
                                    <label class="col-md-6 fw-bold text-uppercase">BAŞLIK ALANI GİZLE</label>
                                    <div class="col-md-6">
                                        <InputSwitch v-model="form.additional.hideHeader" />
                                    </div>
                                </div>

                                <Divider />

                                <div v-if="!form.additional.hideHeader">
                                    <div class="row align-items-center">
                                        <label class="col-md-6 fw-bold text-uppercase">BAŞLIK YAZISINI DEĞİŞTİR</label>
                                        <div class="col-md-6">
                                            <InputSwitch v-model="form.additional.customTitle" />
                                        </div>
                                    </div>
                                    <Divider />
                                    <div v-if="form.additional.customTitle">
                                        <div class="row align-items-center">
                                            <label class="col-md-6 fw-bold text-uppercase">ÖZEL BAŞLIK YAZISI</label>
                                            <div class="col-md-6">
                                                <InputText class="w-100" v-model="form.additional.customTitleText" />
                                            </div>
                                        </div>
                                        <Divider />
                                    </div>
                                    <div class="row align-items-center">
                                        <label class="col-md-6 fw-bold text-uppercase">ALT BAŞLIK</label>
                                        <div class="col-md-6">
                                            <InputText class="w-100" v-model="form.additional.subTitle" />
                                        </div>
                                    </div>
                                    <Divider />
                                </div>

                                <div class="row align-items-center">
                                    <label class="col-md-6 fw-bold text-uppercase">ŞABLON</label>
                                    <div class="col-md-6">
                                        <Dropdown v-model="form.layout_id" :options="props.layouts" showClear optionValue="id" optionLabel="name" placeholder="Default" class="w-100"/>
                                    </div>
                                </div>

                                <Divider />

                                <div class="row align-items-center">
                                    <label class="col-md-3 fw-bold text-uppercase">HEADER ŞABLON</label>
                                    <div class="col-md-9">
                                        <Dropdown v-model="form.header_layout_id" :options="props.headerLayouts" showClear optionValue="id" optionLabel="name" placeholder="Default" class="w-100"/>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="card mb-4 mb-xl-10" v-if="props.content_type.has_url">
                            <div class="card-body">

                                <h5 class="card-title text-muted">Header Scripts</h5>
                                <Divider class="mb-10"/>

                                <AceEditor
                                    v-model:codeContent="form.additional.headerScripts" 
                                    v-model:editor="editor"
                                    :options="{'showPrintMargin': false}"
                                    theme="chrome"
                                    lang="html"
                                    width="100%" 
                                    height="200px" 
                                />

                            </div>
                        </div>

                        <div class="card mb-4 mb-xl-10" v-if="props.content_type.has_url">
                            <div class="card-body">

                                <h5 class="card-title text-muted">Footer Scripts</h5>
                                <Divider class="mb-10"/>

                                <AceEditor
                                    v-model:codeContent="form.additional.footerScripts" 
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

                    <div class="col-lg-3">

                        <div class="sticky-top" style="top:70px;z-index:999">
                            <div class="card mb-4 mb-xl-10">
                                <div class="card-body">

                                    <div v-if="!props.content_type.additional || (props.content_type.additional.adminOptions.mainImage)">
                                        <h5 class="card-title text-muted">Öne Çıkan Görsel</h5>
                                        <Divider class="mb-5"/>
                                        <div class="mb-4 mb-xl-10">
                                            <div class="overlay overflow-hidden" v-if="form.media_objects.mainImage">
                                                <div class="overlay-wrapper">
                                                    <img :src="form.media_objects.mainImage.original_url" class="img-fluid" />
                                                </div>
                                                <div class="overlay-layer bg-dark bg-opacity-25">
                                                    <button type="button" class="btn btn-sm btn-light-danger btn-icon ms-2" v-if="form.media_objects.mainImage" @click="form.media_objects.mainImage = null">
                                                        <i class="bi bi-x fs-3"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <PopupMediaLibrary v-if="!form.media_objects.mainImage" :on-select="setMainImage" :button-text="'Seç'" :mime-type="'image/'" :key="Math.floor(Math.random() * 100000)"/>
                                        </div>
                                    </div>

                                    <div v-if="!props.content_type.additional || (props.content_type.additional.adminOptions.headerImage)">
                                        <h5 class="card-title text-muted">Başlık Alanı Görsel</h5>
                                        <Divider class="mb-5"/>
                                        <div class="mb-4 mb-xl-10">
                                            <div class="overlay overflow-hidden" v-if="form.media_objects.headerImage">
                                                <div class="overlay-wrapper">
                                                    <img :src="form.media_objects.headerImage.original_url" class="img-fluid" />
                                                </div>
                                                <div class="overlay-layer bg-dark bg-opacity-25">
                                                    <button type="button" class="btn btn-sm btn-light-danger btn-icon ms-2" v-if="form.media_objects.headerImage" @click="form.media_objects.headerImage = null">
                                                        <i class="bi bi-x fs-3"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <PopupMediaLibrary v-if="!form.media_objects.headerImage" :on-select="setHeaderImage" :button-text="'Seç'" :mime-type="'image/'" :key="Math.floor(Math.random() * 100000)"/>
                                        </div>
                                    </div>

                                    <div v-if="!props.content_type.additional || (props.content_type.additional.adminOptions.mainVideo)">
                                        <h5 class="card-title text-muted">Başlık Alanı Video</h5>
                                        <Divider class="mb-5"/>
                                        <div class="d-flex flex-column mb-4 mb-xl-10">
                                            <div class="bg-light p-3 mb-3" v-if="form.media_objects.mainVideo">
                                                <video controls class="w-100">
                                                    <source :src="form.media_objects.mainVideo.original_url" type="video/mp4">
                                                </video>
                                            </div>
                                            <div class="d-flex flex-row align-items-center">
                                                <PopupMediaLibrary :on-select="setMainVideo" :button-text="'Seç'" :mime-type="'video/'" :key="Math.floor(Math.random() * 100000)"/>
                                                <button type="button" class="btn btn-sm btn-light-danger ms-2" v-if="form.media_objects.mainVideo" @click="form.media_objects.mainVideo = null">Kaldır</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div v-if="!props.content_type.additional || (props.content_type.additional.adminOptions.gallery)">
                                        <h5 class="card-title text-muted">Galeri</h5>
                                        <Divider class="mb-5"/>
                                        <div v-if="form.media_objects.galleryImages">
                                            
                                            <div class="row g-3 row-cols-3 mb-5">
                                                <div class="col" v-for="(media,m) in form.media_objects.galleryImages" :key="m">
                                                    <div class="overlay overflow-hidden rounded">
                                                        <div class="overlay-wrapper">
                                                            <img :src="media.preview_url" class="img-fluid rounded cursor-pointer" />
                                                        </div>
                                                        <div class="overlay-layer bg-dark bg-opacity-25">
                                                            <button type="button" class="btn btn-light-danger btn-sm btn-icon" @click="removeFromGallery(m)"><i class="bi bi-x fs-3"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <PopupMediaLibrary :on-select="setGalleryImages" :multiple="true" :button-text="'Görselleri Seç'" :mime-type="'image/'" :key="Math.floor(Math.random() * 100000)"/>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="card mb-4 mb-xl-10">
                                <div class="card-body">
                                    <div>
                                        <h5 class="card-title text-muted">Yayın Tarihi</h5>
                                        <Divider class="mb-5"/>
                                        
                                        <Calendar v-model="form.start_date" :class="{'p-invalid':form.errors.start_date}"/>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-4 mb-xl-10 vstack gap-3">
                                <div class="d-flex flex-row align-items-center">
                                    <InputSwitch v-model="form.additional.hideFromWidgets" />
                                    <label class="ms-2 fw-bold text-uppercase">İÇERİK LİSTELERİNDE GİZLE</label>
                                </div>
                                <div class="d-flex flex-row align-items-center">
                                    <InputSwitch v-model="form.is_published" />
                                    <label class="ms-2 fw-bold text-uppercase">YAYINLA</label>
                                </div>
                            </div>

                            <div class="d-flex flex-column gap-2">
                                <button @click="preview" type="button" class="btn btn-success btn-sm" :class="{ 'opacity-25': form.processing || !form.isDirty }" :disabled="form.processing || !form.isDirty">Önizleme</button>
                                <button type="submit" class="btn btn-primary" :class="{ 'opacity-25': form.processing || !form.isDirty }" :disabled="form.processing || !form.isDirty">Kaydet</button>
                            </div>

                        </div>

                    </div>
                    
                </div>

            </form>
        </div>
    </div>

    <Dialog v-model:visible="previewVisible" modal header="Önizleme" class="p-dialog-fullscreen" v-if="previewContentId" @hide="previewContentId = null;form.dirtyFromPreview = true;">
        <div class="w-100 h-100 overflow-hidden">
            <iframe width="100%" height="100%" :src="route('content-previews.show',previewContentId)"></iframe>
        </div>
    </Dialog>
    
</template>

<script setup>

import {ref,onBeforeMount} from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import Divider from "primevue/divider";
import InputText from "primevue/inputtext";
import InputSwitch from "primevue/inputswitch";
import MultiSelect from "primevue/multiselect";
import Textarea from "primevue/textarea";
import Dropdown from "primevue/dropdown";
import Calendar from "primevue/calendar";
import PopupMediaLibrary from "../MediaLibrary/PopupMediaLibrary";
import OptionType from "../../Components/OptionType";
import InputMask from "primevue/inputmask";
import Dialog from "primevue/dialog";

import TextEditor from "../../Components/TextEditor";

import AceEditor from "ace-editor-vue3";
import "brace/mode/html";
import "brace/theme/chrome";

import ContentArea from './DesignElements/ContentArea';

import NewTag from '../Tag/NewTag';

import {bootstrapIcons} from "./DesignElements/bootstrap-icons.js";

const props = defineProps({
    content_type:Object,
    depending_contents:{
        type:Object,
        default:null
    },
    contents:Object,
    categories:Array,
    sliders:Array,
    layouts:Object,
    headerLayouts:Object,
    content_attributes:Array,
    copy_content:Object,
    sortables:{
        type:Array,
        default:[]
    }
});

const editor = ref(null);
const optionTags = ref([]);

let curr_language = usePage().props.current_language;

const form = useForm({
    language:curr_language,
    name:props.copy_content ? props.copy_content.name+' - '+curr_language : "",
    summary:props.copy_content ? props.copy_content.summary : "",
    description:props.copy_content ? props.copy_content.description : "",
    additional:{
        footerScripts:props.copy_content && props.copy_content.additional.footerScripts ? props.copy_content.additional.footerScripts : ``,
        headerScripts:props.copy_content && props.copy_content.additional.headerScripts ? props.copy_content.additional.headerScripts : ``,
        hideHeader:props.copy_content ? props.copy_content.additional.hideHeader : false,
        customTitle:props.copy_content ? props.copy_content.additional.customTitle : false,
        customTitleText:props.copy_content ? props.copy_content.additional.customTitleText : null,
        subTitle:props.copy_content ? props.copy_content.additional.subTitle : null,
        hideFromWidgets:props.copy_content ? props.copy_content.additional.hideFromWidgets : false,
        icon:props.copy_content?.additional?.icon ?? ""
    },
    content_categories:[],
    attributes:props.content_attributes,
    media_objects:props.copy_content ? props.copy_content.media_objects : {
        mainImage:null,
        headerImage:null,
        mainVideo:null,
        galleryImages:[],
    },
    seo:{
        title:props.copy_content && props.copy_content.seo ? props.copy_content.seo.title : "",
        description:props.copy_content && props.copy_content.seo ? props.copy_content.seo.description : ""
    },
    content:props.copy_content ? props.copy_content.content : [],
    is_published:false,
    parent_id:null,
    slider_id:null,
    layout_id:props.copy_content ? props.copy_content.layout_id : props.content_type.layout_id,
    header_layout_id:props.copy_content ? props.copy_content.header_layout_id : null,
    tags:[],
    start_date:props.copy_content ? new Date(props.copy_content.start_date) : new Date(),
    uuid:props.copy_content && props.copy_content.language != curr_language ? props.copy_content.uuid : "",
    depending_content_id:props.copy_content ? props.copy_content.depending_content_id : null,
    category_for_uri:null,
    dirtyFromPreview:false
});

const setMainImage = (media) => {
    form.media_objects.mainImage = media;
}

const setHeaderImage = (media) => {
    form.media_objects.headerImage = media;
}

const setMainVideo = (media) => {
    form.media_objects.mainVideo = media;
}

const setGalleryImages = (medias) => {
    form.media_objects.galleryImages = [...form.media_objects.galleryImages, ...medias];
}

const removeFromGallery = (index) => {
    form.media_objects.galleryImages.splice(index,1);
}


const setAttributeMedia = (media, attribute) => {
    let attr = form.attributes.find(x => x.id == attribute.id);
    attr.value = media.original_url;
}


const create = () => {
    form.post(route('contents.store', {contentType:props.content_type.id}),{
        onSuccess: () => {
            
        },
    });
}

const previewVisible = ref(false);
const previewContentId = ref(null);

const preview = () => {

    form.dirtyFromPreview = false;
    
    form.post(route('content-previews.store', {contentType:props.content_type.id}),{
        onSuccess: () => {
            previewContentId.value = usePage().props.redirect_data;
            previewVisible.value = true;
        },
    });
}

const getTags = () => {
    fetch(route('tags.index',{language:curr_language}),{
       headers: {
           'Accept': 'application/json',
       }
   }).then(function (response) {
       return response.json();
   }).then((json) => {
       optionTags.value = json;
   });
}

const addNewTagToSelected = (tag) => {
    getTags();
    form.tags.push(tag.id);
}

onBeforeMount(() => {
   getTags();   
});

</script>