<template>
    
    <div>
        
        <TabView>

            <TabPanel header="Builder Elements">
                <div class="row g-3 row-cols-2 row-cols-lg-4 row-cols-xl-6">
                    
                    <div class="col">
                        <button class="btn btn-flex flex-column btn-light p-4 w-100" @click="elemSelected('html')">
                            <i class="bi bi-code-slash fs-3"></i>
                            <span class="lh-1 mt-2 fw-bol fs-6">HTML</span>
                        </button>
                    </div>

                    <div class="col">
                        <button class="btn btn-flex flex-column btn-light p-4 w-100" @click="elemSelected('title')">
                            <i class="bi bi-type-h2 fs-3"></i>
                            <span class="lh-1 mt-2 fw-bol fs-6">TITLE</span>
                        </button>
                    </div>

                    <div class="col">
                        <button class="btn btn-flex flex-column btn-light p-4 w-100" @click="elemSelected('title_typewrite')">
                            <i class="bi bi-type-h2 fs-3"></i>
                            <span class="lh-1 mt-2 fw-bol fs-6">TITLE TYPEWRITE</span>
                        </button>
                    </div>

                    <div class="col">
                        <button class="btn btn-flex flex-column btn-light p-4 w-100" @click="elemSelected('richtext')">
                            <i class="bi bi-card-text fs-3"></i>
                            <span class="lh-1 mt-2 fw-bol fs-6">RICH TEXT</span>
                        </button>
                    </div>

                    <div class="col">
                        <button class="btn btn-flex flex-column btn-light p-4 w-100" @click="elemSelected('button')">
                            <i class="bi bi-link-45deg fs-3"></i>
                            <span class="lh-1 mt-2 fw-bol fs-6">BUTTON</span>
                        </button>
                    </div>

                    <div class="col">
                        <button class="btn btn-flex flex-column btn-light p-4 w-100" @click="elemSelected('image')">
                            <i class="bi bi-image fs-3"></i>
                            <span class="lh-1 mt-2 fw-bol fs-6">IMAGE</span>
                        </button>
                    </div>

                    <div class="col">
                        <button class="btn btn-flex flex-column btn-light p-4 w-100" @click="elemSelected('gallery')">
                            <i class="bi bi-images fs-3"></i>
                            <span class="lh-1 mt-2 fw-bol fs-6">GALLERY</span>
                        </button>
                    </div>

                    <div class="col">
                        <button class="btn btn-flex flex-column btn-light p-4 w-100" @click="elemSelected('image_card')">
                            <i class="bi bi-card-heading fs-3"></i>
                            <span class="lh-1 mt-2 fw-bol fs-6">IMAGE CARD</span>
                        </button>
                    </div>

                    <div class="col">
                        <button class="btn btn-flex flex-column btn-light p-4 w-100" @click="elemSelected('card_gallery')">
                            <i class="bi bi-grid-fill fs-3"></i>
                            <span class="lh-1 mt-2 fw-bol fs-6">IMAGE CARD GALLERY</span>
                        </button>
                    </div>

                    <div class="col">
                        <button class="btn btn-flex flex-column btn-light p-4 w-100" @click="elemSelected('timeline_swiper')">
                            <i class="bi bi-calendar-range fs-3"></i>
                            <span class="lh-1 mt-2 fw-bol fs-6">TIMELINE GALLERY</span>
                        </button>
                    </div>

                    <div class="col">
                        <button class="btn btn-flex flex-column btn-light p-4 w-100" @click="elemSelected('paragraph')">
                            <i class="bi bi-paragraph fs-3"></i>
                            <span class="lh-1 mt-2 fw-bol fs-6">PARAGRAPH</span>
                        </button>
                    </div>

                    <div class="col">
                        <button class="btn btn-flex flex-column btn-light p-4 w-100" @click="elemSelected('accordeon')">
                            <i class="bi bi-list fs-3"></i>
                            <span class="lh-1 mt-2 fw-bol fs-6">ACCORDEON</span>
                        </button>
                    </div>

                    <div class="col">
                        <button class="btn btn-flex flex-column btn-light p-4 w-100" @click="elemSelected('tab')">
                            <i class="bi bi-segmented-nav fs-3"></i>
                            <span class="lh-1 mt-2 fw-bol fs-6">TAB</span>
                        </button>
                    </div>

                    <div class="col">
                        <button class="btn btn-flex flex-column btn-light p-4 w-100" @click="elemSelected('iconcard')">
                            <i class="bi bi-postcard-heart fs-3"></i>
                            <span class="lh-1 mt-2 fw-bol fs-6">ICON CARD</span>
                        </button>
                    </div>

                    <div class="col">
                        <button class="btn btn-flex flex-column btn-light p-4 w-100" @click="elemSelected('blockquote')">
                            <i class="bi bi-quote fs-3"></i>
                            <span class="lh-1 mt-2 fw-bol fs-6">BLOCKQUOTE</span>
                        </button>
                    </div>

                    <div class="col">
                        <button class="btn btn-flex flex-column btn-light p-4 w-100" @click="elemSelected('video')">
                            <i class="bi bi-play fs-3"></i>
                            <span class="lh-1 mt-2 fw-bol fs-6">VIDEO</span>
                        </button>
                    </div>

                    <div class="col">
                        <button class="btn btn-flex flex-column btn-light p-4 w-100" @click="elemSelected('icon_list')">
                            <i class="bi bi-list-stars fs-3"></i>
                            <span class="lh-1 mt-2 fw-bol fs-6">ICON LIST</span>
                        </button>
                    </div>

                    <div class="col">
                        <button class="btn btn-flex flex-column btn-light p-4 w-100" @click="elemSelected('modal_window')">
                            <i class="bi bi-window fs-3"></i>
                            <span class="lh-1 mt-2 fw-bol fs-6">MODAL</span>
                        </button>
                    </div>

                    <div class="col">
                        <button class="btn btn-flex flex-column btn-light p-4 w-100" @click="elemSelected('modal_button')">
                            <i class="bi bi-menu-button-fill fs-3"></i>
                            <span class="lh-1 mt-2 fw-bol fs-6">MODAL OPENER</span>
                        </button>
                    </div>

                    <div class="col">
                        <button class="btn btn-flex flex-column btn-light p-4 w-100" @click="elemSelected('offcanvas_window')">
                            <i class="bi bi-layout-sidebar-inset-reverse fs-3"></i>
                            <span class="lh-1 mt-2 fw-bol fs-6">OFFCANVAS</span>
                        </button>
                    </div>

                    <div class="col">
                        <button class="btn btn-flex flex-column btn-light p-4 w-100" @click="elemSelected('offcanvas_button')">
                            <i class="bi bi-menu-button-wide-fill fs-3"></i>
                            <span class="lh-1 mt-2 fw-bol fs-6">OFFCANVAS OPENER</span>
                        </button>
                    </div>

                    <div class="col">
                        <button class="btn btn-flex flex-column btn-light p-4 w-100" @click="elemSelected('nested_columns')">
                            <i class="bi bi-grid-1x2 fs-3"></i>
                            <span class="lh-1 mt-2 fw-bol fs-6">NESTED COLUMNS</span>
                        </button>
                    </div>
                </div>
            </TabPanel>

            <TabPanel header="Layout Elements" v-if="props.layoutMode">
                <div class="row g-3 g-xl-5 row-cols-2 row-cols-lg-4 row-cols-xl-6">
                
                    <div class="col">
                        <button class="btn btn-flex flex-column btn-light p-4 w-100" @click="elemSelected('layout_title')">
                            <i class="bi bi-type fs-3"></i>
                            <span class="lh-1 mt-2 fw-bol fs-6">SAYFA BAŞLIĞI</span>
                        </button>
                    </div>

                    <div class="col">
                        <button class="btn btn-flex flex-column btn-light p-4 w-100" @click="elemSelected('layout_subtitle')">
                            <i class="bi bi-textarea-t fs-3"></i>
                            <span class="lh-1 mt-2 fw-bol fs-6">SAYFA ALT BAŞLIĞI</span>
                        </button>
                    </div>

                    <div class="col">
                        <button class="btn btn-flex flex-column btn-light p-4 w-100" @click="elemSelected('layout_depending_title')">
                            <i class="bi bi-text-indent-right fs-3"></i>
                            <span class="lh-1 mt-2 fw-bol fs-6">BAĞLI OLDUĞU İÇERİK BAŞLIĞI</span>
                        </button>
                    </div>

                    <div class="col">
                        <button class="btn btn-flex flex-column btn-light p-4 w-100" @click="elemSelected('layout_depending_contents')">
                            <i class="bi bi-text-indent-left fs-3"></i>
                            <span class="lh-1 mt-2 fw-bol fs-6">SAHİP OLDUĞU İÇERİK LİSTESİ</span>
                        </button>
                    </div>

                    <div class="col">
                        <button class="btn btn-flex flex-column btn-light p-4 w-100" @click="elemSelected('layout_mainimage')">
                            <i class="bi bi-image fs-3"></i>
                            <span class="lh-1 mt-2 fw-bol fs-6">SAYFA ANA GÖRSEL</span>
                        </button>
                    </div>

                    <div class="col">
                        <button class="btn btn-flex flex-column btn-light p-4 w-100" @click="elemSelected('layout_gallery_images')">
                            <i class="bi bi-images fs-3"></i>
                            <span class="lh-1 mt-2 fw-bol fs-6">SAYFA GALERİSİ</span>
                        </button>
                    </div>

                    <div class="col">
                        <button class="btn btn-flex flex-column btn-light p-4 w-100" @click="elemSelected('layout_icon')">
                            <i class="bi bi-bootstrap fs-3"></i>
                            <span class="lh-1 mt-2 fw-bol fs-6">SAYFA İKONU</span>
                        </button>
                    </div>


                    <div class="col">
                        <button class="btn btn-flex flex-column btn-light p-4 w-100" @click="elemSelected('layout_summary')">
                            <i class="bi bi-card-text fs-3"></i>
                            <span class="lh-1 mt-2 fw-bol fs-6">SAYFA ÖZETİ</span>
                        </button>
                    </div>

                    <div class="col">
                        <button class="btn btn-flex flex-column btn-light p-4 w-100" @click="elemSelected('layout_content_attributes')">
                            <i class="bi bi-view-list fs-3"></i>
                            <span class="lh-1 mt-2 fw-bol fs-6">EK SEÇENEKLER</span>
                        </button>
                    </div>

                    <div class="col">
                        <button class="btn btn-flex flex-column btn-light p-4 w-100" @click="elemSelected('layout_description')">
                            <i class="bi bi-images fs-3"></i>
                            <span class="lh-1 mt-2 fw-bol fs-6">SAYFA AÇIKLAMASI</span>
                        </button>
                    </div>

                    <div class="col">
                        <button class="btn btn-flex flex-column btn-light p-4 w-100" @click="elemSelected('layout_content')">
                            <i class="bi bi-columns fs-3"></i>
                            <span class="lh-1 mt-2 fw-bol fs-6">SAYFA İÇERİĞİ</span>
                        </button>
                    </div>

                    <div class="col">
                        <button class="btn btn-flex flex-column btn-light p-4 w-100" @click="elemSelected('layout_read_more_button')">
                            <i class="bi bi-link fs-3"></i>
                            <span class="lh-1 mt-2 fw-bol fs-6">DETAY BUTON</span>
                        </button>
                    </div>

                    <div class="col">
                        <button class="btn btn-flex flex-column btn-light p-4 w-100" @click="elemSelected('layout_meta_data')">
                            <i class="bi bi-tags fs-3"></i>
                            <span class="lh-1 mt-2 fw-bol fs-6">META BİLGİLERİ</span>
                        </button>
                    </div>

                </div>
            </TabPanel>

            <TabPanel header="Widgets">
                <div class="row g-3 g-xl-5 row-cols-2 row-cols-lg-4 row-cols-xl-6">
            
                    <div class="col">
                        <button class="btn btn-flex flex-column btn-light p-4 w-100" @click="elemSelected('slider')">
                            <i class="bi bi-sliders fs-3"></i>
                            <span class="lh-1 mt-2 fw-bol fs-6">SLIDER</span>
                        </button>
                    </div>

                    <div class="col">
                        <button class="btn btn-flex flex-column btn-light p-4 w-100" @click="elemSelected('menu')">
                            <i class="bi bi-list fs-3"></i>
                            <span class="lh-1 mt-2 fw-bol fs-6">MENU</span>
                        </button>
                    </div>

                    <div class="col">
                        <button class="btn btn-flex flex-column btn-light p-4 w-100" @click="elemSelected('form')">
                            <i class="bi bi-ui-checks-grid fs-3"></i>
                            <span class="lh-1 mt-2 fw-bol fs-6">FORM</span>
                        </button>
                    </div>

                    <div class="col">
                        <button class="btn btn-flex flex-column btn-light p-4 w-100" @click="elemSelected('content_categories')">
                            <i class="bi bi-bookmarks fs-3"></i>
                            <span class="lh-1 mt-2 fw-bol fs-6">İÇERİK KATEGORİLERİ</span>
                        </button>
                    </div>

                    <div class="col">
                        <button class="btn btn-flex flex-column btn-light p-4 w-100" @click="elemSelected('contents')">
                            <i class="bi bi-card-list fs-3"></i>
                            <span class="lh-1 mt-2 fw-bol fs-6">İÇERİK LİSTESİ</span>
                        </button>
                    </div>

                    <div class="col">
                        <button class="btn btn-flex flex-column btn-light p-4 w-100" @click="elemSelected('design_template')">
                            <i class="bi bi-heart fs-3"></i>
                            <span class="lh-1 mt-2 fw-bol fs-6">HAZIR ŞABLON</span>
                        </button>
                    </div>

                    <div class="col">
                        <button class="btn btn-flex flex-column btn-light p-4 w-100" @click="elemSelected('commercial_ads')">
                            <i class="bi bi-cash fs-3"></i>
                            <span class="lh-1 mt-2 fw-bol fs-6">REKLAM LİSTESİ</span>
                        </button>
                    </div>

                    <div class="col">
                        <button class="btn btn-flex flex-column btn-light p-4 w-100" @click="elemSelected('newsletter_form')">
                            <i class="bi bi-newspaper fs-3"></i>
                            <span class="lh-1 mt-2 fw-bol fs-6">E-BÜLTEN FORMU</span>
                        </button>
                    </div>

                    <div class="col">
                        <button class="btn btn-flex flex-column btn-light p-4 w-100" @click="elemSelected('social_accounts')">
                            <i class="bi bi-share fs-3"></i>
                            <span class="lh-1 mt-2 fw-bol fs-6">SOSYAL MEDYA HESAPLARI</span>
                        </button>
                    </div>

                    <div class="col">
                        <button class="btn btn-flex flex-column btn-light p-4 w-100" @click="elemSelected('swiper_navigation')">
                            <i class="bi bi-arrow-left-right fs-3"></i>
                            <span class="lh-1 mt-2 fw-bol fs-6">SWIPER NAVIGATON</span>
                        </button>
                    </div>

                </div>
            </TabPanel>

        </TabView>

    </div>

</template>

<script setup>

import TabView from 'primevue/tabview';
import TabPanel from 'primevue/tabpanel';

const props = defineProps({
    onSelect:Function,
    layoutMode:{
        type:Boolean,
        default:false
    },
    productLayoutMode:{
        type:Boolean,
        default:false
    }
});

const elemSelected = (type) => {
    props.onSelect(type);
}

</script>