<template>
    <Head head-key="title" title="Kategori Güncelle" />

    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            
            <div  class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Güncelle: {{ props.content_category.name }}
                </h1>
            </div>

            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <Link :href="route('content-categories.index',{contentType:props.content_type.id,language:$page.props.current_language})" class="btn fw-bold btn-sm btn-secondary d-flex align-items-center">
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

                <div class="row g-4 g-lg-6 g-xl-10">
                    <div class="col-lg-9">

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
                                    <label class="col-md-3 fw-bold text-uppercase">Üst Kategori</label>
                                    <div class="col-md-9">
                                        <Dropdown v-model="form.parent_id" :options="props.categories" filter showClear optionValue="id" optionLabel="depth_name" placeholder="Root" class="w-100" />
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="card mb-4 mb-xl-10">
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

                        <div class="card mb-4 mb-xl-10">
                            <div class="card-body">

                                <h5 class="card-title text-muted">Özet Bilgi</h5>
                                <Divider class="mb-10"/>

                                <TextEditor v-model="form.summary" />

                            </div>
                        </div>

                        <ContentArea :form="form"/>

                        <div class="card mb-4 mb-xl-10">
                            <div class="card-body">

                                <h5 class="card-title text-muted">Sayfa Özellikleri</h5>
                                <Divider class="mb-10"/>

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
                        </div>

                        <div class="card mb-4 mb-xl-10">
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

                        <div class="card mb-4 mb-xl-10">
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

                        <div class="card mb-4 mb-xl-10">
                            <div class="card-body">

                                <div>
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

                                <div>
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

                                <div>
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

                                <div>
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

                        <button type="submit" class="btn btn-primary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Kaydet</button>
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
import InputSwitch from "primevue/inputswitch";
import Dropdown from "primevue/dropdown";
import Textarea from "primevue/textarea";
import Button from "primevue/button";
import PopupMediaLibrary from "../MediaLibrary/PopupMediaLibrary";

import TextEditor from "../../Components/TextEditor";

import AceEditor from "ace-editor-vue3";
import "brace/mode/html";
import "brace/theme/chrome";

import ContentArea from '../Content/DesignElements/ContentArea';

const props = defineProps({
    content_type:Object,
    categories:Array,
    content_category:Object,
    layouts:Object,
});

const editor = ref(null);

const form = useForm({
    language:props.content_category.language,
    name:props.content_category.name,
    summary:props.content_category.summary,
    additional:{
        footerScripts:props.content_category && props.content_category.additional && props.content_category.additional.footerScripts ? props.copy_content.content_category.footerScripts : ``,
        headerScripts:props.content_category && props.content_category.additional && props.content_category.additional.headerScripts ? props.content_category.additional.headerScripts : ``,
        hideHeader:props.content_category.additional && props.content_category.additional.hideHeader ? props.content_category.additional.hideHeader : false,
        hideFromWidgets:props.content_category && props.content_category.additional && props.content_category.additional.hideFromWidgets ? props.content_category.additional.hideFromWidgets : false,
        customTitle:props.content_category && props.content_category.additional && props.content_category.additional.customTitle ? props.content_category.additional.customTitle : false,
        customTitleText:props.content_category && props.content_category.additional && props.content_category.additional.customTitleText ? props.content_category.additional.customTitleText : null,
        subTitle:props.content_category && props.content_category.additional && props.content_category.additional.subTitle ? props.content_category.additional.subTitle : null,
    },
    media_objects:{
        mainImage:props.content_category.media_objects.mainImage ?? "",
        headerImage:props.content_category.media_objects.headerImage ?? "",
        mainVideo:props.content_category.media_objects.mainVideo ?? "",
        galleryImages:props.content_category.media_objects.galleryImages ?? "",
    },
    seo:{
        title:props.content_category.seo ? props.content_category.seo.title : "",
        description:props.content_category.seo ? props.content_category.seo.description : ""
    },
    layout_id:props.content_category.layout_id,
    header_layout_id:props.content_category.header_layout_id,
    content:props.content_category.content ?? [],
    is_published:props.content_category.is_published,
    parent_id:props.content_category.parent_id,
    slug:props.content_category.slug,
    content_type_id:props.content_type.id
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

const update = () => {
    form.put(route('content-categories.update',[props.content_category,{language:props.content_category.language}]),{
        onSuccess: () => {
            
        },
    });
}


</script>