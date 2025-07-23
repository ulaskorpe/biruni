<template>
    <Head head-key="title" title="Site Ayarları" />

    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            
            <div  class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Site Ayarları
                </h1>
            </div>

            <div class="d-flex align-items-center gap-2 gap-lg-3">

            </div>

        </div>
    </div>
	
    <div id="kt_app_content" class="app-content  flex-column-fluid">

        <div id="kt_app_content_container" class="app-container container-fluid">
            
            <form @submit.prevent="update">
                
                <div class="card mb-5 mb-xl-10">
                    <div class="card-body p-0">
                        <TabView :scrollable="true">
                    
                            <TabPanel header="Genel" key='genel'>
                                <div class="row align-items-center">
                                    <label class="col-lg-4 form-label text-uppercase">Site Adı</label>
                                    <div class="col-lg-8">
                                        <InputText v-model="form.site_name" class="w-100" />
                                    </div>
                                </div>

                                <Divider />

                                <div class="row align-items-center">
                                    <label class="col-lg-4 form-label text-uppercase">Email</label>
                                    <div class="col-lg-8">
                                        <InputText v-model="form.contact.email" class="w-100" type="email" />
                                    </div>
                                </div>

                                <Divider />

                                <div class="row align-items-center">
                                    <label class="col-lg-4 form-label text-uppercase">Telefon</label>
                                    <div class="col-lg-8">
                                        <InputText v-model="form.contact.phone" class="w-100" />
                                    </div>
                                </div>

                                <Divider />

                                <div class="row align-items-center">
                                    <label class="col-lg-4 form-label text-uppercase">Whatsapp</label>
                                    <div class="col-lg-8">
                                        <InputText v-model="form.contact.whatsapp" class="w-100" />
                                    </div>
                                </div>

                                <Divider />
                                
                                <div class="row align-items-center">
                                    <label class="col-lg-4 form-label text-uppercase">Adres</label>
                                    <div class="col-lg-8">
                                        <Textarea v-model="form.contact.address" autoResize rows="1" cols="30" class="w-100"/>
                                    </div>
                                </div>

                                <Divider />
                                
                                <div class="row align-items-center">
                                    <label class="col-lg-4 form-label text-uppercase">Site Ana Sayfası</label>
                                    <div class="col-lg-8">
                                        <Dropdown v-model="form.home_page" :options="props.content_types" optionValue="uuid" optionLabel="name" optionGroupLabel="name" optionGroupChildren="contents" class="w-100" placeholder="Lütfen Seçiniz"/>
                                    </div>
                                </div>

                                <Divider />
                                
                                <div class="row align-items-center">
                                    <label class="col-lg-4 form-label text-uppercase">KVKK Sayfası</label>
                                    <div class="col-lg-8">
                                        <Dropdown v-model="form.kvkk_page" showClear :options="props.content_types" optionValue="uuid" optionLabel="name" optionGroupLabel="name" optionGroupChildren="contents" class="w-100" placeholder="Lütfen Seçiniz"/>
                                    </div>
                                </div>

                                <Divider />
                                
                                <div class="row align-items-center">
                                    <label class="col-lg-4 form-label text-uppercase">Çerez Politikası Sayfası</label>
                                    <div class="col-lg-8">
                                        <Dropdown v-model="form.cookie_policy_page" showClear :options="props.content_types" optionValue="uuid" optionLabel="name" optionGroupLabel="name" optionGroupChildren="contents" class="w-100" placeholder="Lütfen Seçiniz"/>
                                    </div>
                                </div>

                                <Divider />

                                <div class="row align-items-center">
                                    <label class="col-lg-4 form-label text-uppercase">Gizlilik ve Güvenlik Sayfası</label>
                                    <div class="col-lg-8">
                                        <Dropdown v-model="form.privacy_page" showClear :options="props.content_types" optionValue="uuid" optionLabel="name" optionGroupLabel="name" optionGroupChildren="contents" class="w-100" placeholder="Lütfen Seçiniz"/>
                                    </div>
                                </div>

                                <Divider />

                                <div class="row align-items-center">
                                    <label class="col-lg-4 form-label text-uppercase">Üyelik Sözleşmesi Sayfası</label>
                                    <div class="col-lg-8">
                                        <Dropdown v-model="form.membership_page" showClear :options="props.content_types" optionValue="uuid" optionLabel="name" optionGroupLabel="name" optionGroupChildren="contents" class="w-100" placeholder="Lütfen Seçiniz"/>
                                    </div>
                                </div>
                            </TabPanel>

                            <TabPanel header="Logo" key='logo'>
                                <div class="row align-items-center">
                                    <label class="col-lg-4 form-label text-uppercase">Desktop</label>
                                    <div class="col-lg-8">
                                        <div class="d-flex flex-row align-items-end">
                                            <div class="bg-light p-3 me-3" v-if="form.logo.main">
                                                <img :src="form.logo.main.original_url"/>
                                            </div>
                                            <div class="d-flex flex-row align-items-center">
                                                <PopupMediaLibrary :on-select="setMainLogo" :button-text="'Seç'" :mime-type="'image/'" :key="Math.floor(Math.random() * 100000)"/>
                                                <button type="button" class="btn btn-sm btn-light-danger ms-2" v-if="form.logo.main" @click="form.logo.main = null">Kaldır</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <Divider />

                                <div class="row align-items-center">
                                    <label class="col-lg-4 form-label text-uppercase">Mobil</label>
                                    <div class="col-lg-8">
                                        <div class="d-flex flex-row align-items-end">
                                            <div class="bg-light p-3 me-3" v-if="form.logo.mobile">
                                                <img :src="form.logo.mobile.original_url"/>
                                            </div>
                                            <div class="d-flex flex-row align-items-center">
                                                <PopupMediaLibrary :on-select="setMobileLogo" :button-text="'Seç'" :mime-type="'image/'" :key="Math.floor(Math.random() * 100000)"/>
                                                <button type="button" class="btn btn-sm btn-light-danger ms-2" v-if="form.logo.mobile" @click="form.logo.mobile = null">Kaldır</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <Divider />

                                <div class="row align-items-center">
                                    <label class="col-lg-4 form-label text-uppercase">Favicon</label>
                                    <div class="col-lg-8">
                                        <div class="d-flex flex-row align-items-end">
                                            <div class="bg-light p-3 me-3" v-if="form.logo.favicon">
                                                <img :src="form.logo.favicon.original_url"/>
                                            </div>
                                            <div class="d-flex flex-row align-items-center">
                                                <PopupMediaLibrary :on-select="setFavicon" :button-text="'Seç'" :mime-type="'image/'" :key="Math.floor(Math.random() * 100000)"/>
                                                <button type="button" class="btn btn-sm btn-light-danger ms-2" v-if="form.logo.favicon" @click="form.logo.favicon = null">Kaldır</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </TabPanel>

                            <TabPanel header="Sosyal Medya" key='sosyal-medya'>
                                <div v-for="(social,s) in form.socials" :key="s">
                                    <div class="hstack gap-2">

                                        <div class="row align-items-center flex-grow-1">
                                            <div class="col-lg-4">
                                                <Dropdown v-model="social.key" :options="socialTypes" class="w-100" placeholder="Seçiniz" />
                                            </div>
                                            <div class="col-lg-8">
                                                <InputText v-model="social.value" class="w-100" />
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-light-danger btn-sm btn-icon" @click="removeSocial(s)"><i class="bi bi-trash"></i></button>

                                    </div>
                                    <Divider />
                                </div>
                                <button type="button" class="btn btn-sm btn-light-success" @click="addSocial">Ekle</button>
                            </TabPanel>

                            <TabPanel header="Header & Footer Extra" key='header-footer'>
                                <div class="row align-items-center">
                                    <label class="col-lg-4 form-label text-uppercase">Header Button #1</label>
                                    <div class="col-lg-8">
                                        <div class="vstack gap-5">

                                            <div v-for="(lang,ind) in $page.props.languages.active" :key="lang" class="vstack gap-2 border bg-light rounded p-3">

                                                <div class="row align-items-center">
                                                    <div class="col-lg-4 col-xl-3 d-flex align-items-center">
                                                        <span class="fw-semibold">Aktif?</span>
                                                        <div class="d-flex align-items-center ms-2">
                                                            <img :src="`/dmn/media/flags/${lang}.svg`" class="me-2" style="width: 14px" />
                                                            <span class="text-uppercase">{{ lang }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8 col-xl-">
                                                        <InputSwitch v-model="form.header_buttons[lang].button_1.active"/>
                                                    </div>
                                                </div>

                                                <div v-if="form.header_buttons[lang].button_1.active" class="vstack gap-2">
                                                    <div class="row align-items-center">
                                                        <div class="col-lg-4 col-xl-3 d-flex align-items-center">
                                                            <span class="fw-semibold">Button Text</span>
                                                            <div class="d-flex align-items-center ms-2">
                                                                <img :src="`/dmn/media/flags/${lang}.svg`" class="me-2" style="width: 14px" />
                                                                <span class="text-uppercase">{{ lang }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-8 col-xl-">
                                                            <InputText v-model="form.header_buttons[lang].button_1.button_text" class="w-100"/>
                                                        </div>
                                                    </div>

                                                    <div class="row align-items-center">
                                                        <div class="col-lg-4 col-xl-3 d-flex align-items-center">
                                                            <span class="fw-semibold">Button Link</span>
                                                            <div class="d-flex align-items-center ms-2">
                                                                <img :src="`/dmn/media/flags/${lang}.svg`" class="me-2" style="width: 14px" />
                                                                <span class="text-uppercase">{{ lang }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-8 col-xl-">
                                                            <InputText v-model="form.header_buttons[lang].button_1.button_link" class="w-100"/>
                                                        </div>
                                                    </div>

                                                    <div class="row align-items-center">
                                                        <div class="col-lg-4 col-xl-3 d-flex align-items-center">
                                                            <span class="fw-semibold">Yeni Pencere</span>
                                                            <div class="d-flex align-items-center ms-2">
                                                                <img :src="`/dmn/media/flags/${lang}.svg`" class="me-2" style="width: 14px" />
                                                                <span class="text-uppercase">{{ lang }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-8 col-xl-">
                                                            <InputSwitch v-model="form.header_buttons[lang].button_1.new_window"/>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <Divider />

                                <div class="row align-items-center">
                                    <label class="col-lg-4 form-label text-uppercase">Header Button #2</label>
                                    <div class="col-lg-8">
                                        <div class="vstack gap-5">

                                            <div v-for="(lang,ind) in $page.props.languages.active" :key="lang" class="vstack gap-2 border bg-light rounded p-3">

                                                <div class="row align-items-center">
                                                    <div class="col-lg-4 col-xl-3 d-flex align-items-center">
                                                        <span class="fw-semibold">Aktif?</span>
                                                        <div class="d-flex align-items-center ms-2">
                                                            <img :src="`/dmn/media/flags/${lang}.svg`" class="me-2" style="width: 14px" />
                                                            <span class="text-uppercase">{{ lang }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8 col-xl-">
                                                        <InputSwitch v-model="form.header_buttons[lang].button_2.active"/>
                                                    </div>
                                                </div>

                                                <div v-if="form.header_buttons[lang].button_2.active" class="vstack gap-2">
                                                    <div class="row align-items-center">
                                                        <div class="col-lg-4 col-xl-3 d-flex align-items-center">
                                                            <span class="fw-semibold">Button Text</span>
                                                            <div class="d-flex align-items-center ms-2">
                                                                <img :src="`/dmn/media/flags/${lang}.svg`" class="me-2" style="width: 14px" />
                                                                <span class="text-uppercase">{{ lang }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-8 col-xl-">
                                                            <InputText v-model="form.header_buttons[lang].button_2.button_text" class="w-100"/>
                                                        </div>
                                                    </div>

                                                    <div class="row align-items-center">
                                                        <div class="col-lg-4 col-xl-3 d-flex align-items-center">
                                                            <span class="fw-semibold">Button Link</span>
                                                            <div class="d-flex align-items-center ms-2">
                                                                <img :src="`/dmn/media/flags/${lang}.svg`" class="me-2" style="width: 14px" />
                                                                <span class="text-uppercase">{{ lang }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-8 col-xl-">
                                                            <InputText v-model="form.header_buttons[lang].button_2.button_link" class="w-100"/>
                                                        </div>
                                                    </div>

                                                    <div class="row align-items-center">
                                                        <div class="col-lg-4 col-xl-3 d-flex align-items-center">
                                                            <span class="fw-semibold">Yeni Pencere</span>
                                                            <div class="d-flex align-items-center ms-2">
                                                                <img :src="`/dmn/media/flags/${lang}.svg`" class="me-2" style="width: 14px" />
                                                                <span class="text-uppercase">{{ lang }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-8 col-xl-">
                                                            <InputSwitch v-model="form.header_buttons[lang].button_2.new_window"/>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <Divider />

                                <div class="row align-items-center">
                                    <label class="col-lg-4 form-label text-uppercase">Footer Slogan</label>
                                    <div class="col-lg-8">
                                        <div class="vstack gap-5">

                                            <div v-for="(lang,ind) in $page.props.languages.active" :key="lang" class="vstack gap-2 border bg-light rounded p-3">

                                                <div class="row align-items-center">
                                                    <div class="col-lg-4 col-xl-3 d-flex align-items-center">
                                                        <span class="fw-semibold">Slogan</span>
                                                        <div class="d-flex align-items-center ms-2">
                                                            <img :src="`/dmn/media/flags/${lang}.svg`" class="me-2" style="width: 14px" />
                                                            <span class="text-uppercase">{{ lang }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8 col-xl-">
                                                        <Textarea v-model="form.footer_slogan[lang]" autoResize rows="1" cols="30" class="w-100"/>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <Divider />

                                <div class="row align-items-center">
                                    <label class="col-lg-4 form-label text-uppercase">Footer Form</label>
                                    <div class="col-lg-8">
                                        <div class="vstack gap-5">

                                            <div v-for="(lang,ind) in $page.props.languages.active" :key="lang" class="vstack gap-2 border bg-light rounded p-3">

                                                <div class="row align-items-center">
                                                    <div class="col-lg-4 col-xl-3 d-flex align-items-center">
                                                        <span class="fw-semibold">Form</span>
                                                        <div class="d-flex align-items-center ms-2">
                                                            <img :src="`/dmn/media/flags/${lang}.svg`" class="me-2" style="width: 14px" />
                                                            <span class="text-uppercase">{{ lang }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8 col-xl-">
                                                        <Dropdown v-model="form.footer_form[lang]" showClear :options="props.forms" optionValue="id" optionLabel="name" class="w-100" placeholder="Lütfen Seçiniz"/>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </TabPanel>

                            <TabPanel header="Gelişmiş" key='gelismis'>
                                <div class="row align-items-center">
                                    <label class="col-lg-4 form-label text-uppercase">Header</label>
                                    <div class="col-lg-8">
                                        <AceEditor
                                            v-model:codeContent="form.scripts.header" 
                                            v-model:editor="editor"
                                            :options="{'showPrintMargin': false}"
                                            theme="chrome"
                                            lang="html"
                                            width="100%" 
                                            height="200px"
                                        />
                                    </div>
                                </div>

                                <Divider />

                                <div class="row align-items-center">
                                    <label class="col-lg-4 form-label text-uppercase">After Body</label>
                                    <div class="col-lg-8">
                                        <AceEditor
                                            v-model:codeContent="form.scripts.afterBody" 
                                            v-model:editor="editor"
                                            :options="{'showPrintMargin': false}"
                                            theme="chrome"
                                            lang="html"
                                            width="100%" 
                                            height="200px"
                                        />
                                    </div>
                                </div>

                                <Divider />

                                <div class="row align-items-center">
                                    <label class="col-lg-4 form-label text-uppercase">Footer</label>
                                    <div class="col-lg-8">
                                        <AceEditor
                                            v-model:codeContent="form.scripts.footer" 
                                            v-model:editor="editor"
                                            :options="{'showPrintMargin': false}"
                                            theme="chrome"
                                            lang="html"
                                            width="100%" 
                                            height="200px"
                                        />
                                    </div>
                                </div>
                            </TabPanel>

                            <TabPanel header="Footer Varsayılan" key='footer-layout'>
                                <div>
                                    <ContentArea :form="form" :layout-mode="false"/>
                                </div>
                            </TabPanel>

                        </TabView>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Güncelle</button>
                    </div>
                </div>
                
            </form>

        </div>

    </div>

</template>

<script setup>

import {ref, onBeforeMount} from "vue";
import {useForm, usePage} from "@inertiajs/vue3";
import InputText from "primevue/inputtext";
import Divider from "primevue/divider";
import InputSwitch from 'primevue/inputswitch';
import Dropdown from 'primevue/dropdown';
import Textarea from 'primevue/textarea';
import TabView from 'primevue/tabview';
import TabPanel from 'primevue/tabpanel';
import PopupMediaLibrary from "../MediaLibrary/PopupMediaLibrary";

import ContentArea from '../Content/DesignElements/ContentArea';

import AceEditor from "ace-editor-vue3";
import "brace/mode/html";
import "brace/theme/chrome";

const props = defineProps({
    settings:Object,
    content_types:Array,
    forms:Object
});

const editor = ref(null);

const socialTypes = ref(['instagram','facebook','twitter-x','whatsapp','telegram','youtube','tiktok','linkedin','spotify']);

const form = useForm({
    site_name:props.settings.site_name,
    logo:{
        main:props.settings.logo.main,
        mobile:props.settings.logo.mobile,
        favicon:props.settings.logo.favicon,
    },
    scripts:{
        header:props.settings.scripts.header ?? "",
        afterBody:props.settings.scripts.afterBody ?? "",
        footer:props.settings.scripts.footer ?? "",
    },
    home_page:props.settings.home_page,
    cookie_policy_page:props.settings.cookie_policy_page,
    privacy_page:props.settings.privacy_page,
    kvkk_page:props.settings.kvkk_page,
    membership_page:props.settings.membership_page,
    contact:props.settings.contact,
    socials:props.settings.socials,
    header_buttons: {},
    footer_slogan:{},
    footer_form:{},
    content:props.settings.footer_layout,
});

const update = () => {
    form.put(route('settings.update'),{
        onSuccess: () => {
            
        },
    });
}

const setMainLogo = (media) => {
    form.logo.main = media;
}
const setMobileLogo = (media) => {
    form.logo.mobile = media;
}
const setFavicon = (media) => {
    form.logo.favicon = media;
}

const addSocial = () => {
    form.socials.push({key:"",value:""});
}

const removeSocial = (index) => {

    form.socials.splice(index,1);

}


onBeforeMount(() => {

    usePage().props.languages.active.forEach(lang => {

        if( props.settings.header_buttons && props.settings.header_buttons[lang] ){
            form.header_buttons[lang] = props.settings.header_buttons[lang];
        } else {
            const buttons = {
                button_1: {
                    active:false,
                    button_text:"",
                    button_link:"",
                    new_window:false
                },
                button_2: {
                    active:false,
                    button_text:"",
                    button_link:"",
                    new_window:false
                }
            };
            form.header_buttons[lang] = buttons;
        }

        if( props.settings.footer_slogan && props.settings.footer_slogan[lang] ){
            form.footer_slogan[lang] = props.settings.footer_slogan[lang];
        } else {
            form.footer_slogan[lang] = "";
        }

        if( props.settings.footer_form && props.settings.footer_form[lang] ){
            form.footer_form[lang] = props.settings.footer_form[lang];
        } else {
            form.footer_form[lang] = null;
        }

    });

});

</script>