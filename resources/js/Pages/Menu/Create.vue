<template>
    <Head head-key="title" title="Menü Ekle" />

    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            
            <div  class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Yeni Menü
                </h1>
            </div>

            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <Link :href="route('menus.index',{language:curr_language})" class="btn fw-bold btn-sm btn-secondary d-flex align-items-center">
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
                            <div class="col-md-3">
                                <div class="d-flex align-items-center mb-1">
                                    <span class="fw-semibold">İsim</span>
                                    <div class="d-flex align-items-center ms-2">
                                        <img :src="`/dmn/media/flags/${curr_language}.svg`" class="me-2" style="width: 14px" />
                                        <span class="text-uppercase">{{ curr_language }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <InputText v-model="form.name" class="w-100" :class="{'p-invalid':form.errors.name}"/>
                            </div>
                        </div>
                        <Divider />
                        <div class="row align-items-center">
                            <label class="col-md-3 fw-bold text-uppercase">Lokasyon</label>
                            <div class="col-md-9">
                                <Dropdown v-model="form.location" class="w-100" showClear :options="$page.props.enums.menu_locations" placeholder="None"/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <div class="card mb-4 mb-xl-10">
                            <div class="card-body">
                                <h5 class="card-title text-muted">İçerik Ekle</h5>
                                <Divider class="mb-10"/>
                                <div class="mb-5" v-for="(group,g) in linkableContents" :key="group.model + g">
                                    <h6>{{ group.model }}</h6>
                                    <MultiSelect v-model="selectedLinkableContens[g]" :options="group.items" optionLabel="content.name" :virtualScrollerOptions="{ itemSize: 30 }" filter placeholder="Lütfen seçiniz" class="w-100"/>
                                </div>
                                <Divider/>
                                <Button label="Menüye Ekle" severity="secondary" @click="addSelectedToMenuTree" />
                            </div>
                        </div>
                        <div class="card mb-4 mb-xl-10">
                            <div class="card-body">
                                <h5 class="card-title text-muted">Özel Menü Ekle</h5>
                                <Divider class="mb-10"/>
                                <div class="mb-5">
                                    <label class="fw-bold">Menü Başlık</label>
                                    <InputText v-model="customLink.menu_title" class="w-100"/>
                                </div>
                                <Divider/>
                                <div class="mb-5">
                                    <label class="fw-bold">Link</label>
                                    <InputText v-model="customLink.item_link" class="w-100"/>
                                </div>
                                <Divider/>
                                <div class="row align-items-center mb-5">
                                    <label class="col-lg-6 fw-bold">Megamenu</label>
                                    <div class="col-lg-6">
                                        <InputSwitch v-model="customLink.megamenu"/>
                                    </div>
                                </div>
                                <Divider/>
                                <div class="mb-5">
                                    <label class="fw-bold">Badge</label>
                                    <InputText v-model="customLink.badge" class="w-100"/>
                                </div>
                                <Divider/>
                                <div class="row align-items-center mb-5">
                                    <label class="col-lg-6 fw-bold">Yeni Pencere</label>
                                    <div class="col-lg-6">
                                        <InputSwitch v-model="customLink.new_window"/>
                                    </div>
                                </div>
                                <Divider/>
                                <Button label="Menüye Ekle" severity="secondary" @click="addCutomLinkToMenu" />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">

                        <div class="card mb-4 mb-xl-10">
                            <div class="card-body">
                                <h5 class="card-title text-muted">Menü Ağacı</h5>
                                <Divider class="mb-10"/>

                                <div class="d-flex flex-column">
                                    <draggable 
                                        v-model="form.tree" 
                                        group="menuItem" ghostClass="ghost" animation="200" 
                                        tag="div" 
                                        class="item-container mb-5" 
                                        @start="dragging = true" 
                                        @end="dragging = false" 
                                        item-key="link"
                                    >
                                        <template #item="{element:menu_item,index:m}">
                                            <div>
                                                <Panel toggleable collapsed :header="menu_item.menu_title">
                                                    <template #icons>
                                                        <button @click="form.tree.splice(m,1)" type="button" class="p-panel-header-icon p-link me-2">
                                                            <span class="bi bi-trash"></span>
                                                        </button>
                                                    </template>
                                                    <div class="row align-items-center">
                                                        <label class="col-lg-6 fw-bold">Menü Başlık</label>
                                                        <div class="col-lg-6">
                                                            <InputText v-model="menu_item.menu_title" class="w-100"/>
                                                        </div>
                                                    </div>
                                                    <Divider />
                                                    <div class="row align-items-center">
                                                        <label class="col-lg-6 fw-bold">Megamenu</label>
                                                        <div class="col-lg-6">
                                                            <InputSwitch v-model="menu_item.megamenu"/>
                                                        </div>
                                                    </div>
                                                    <Divider />
                                                    <div class="row align-items-center">
                                                        <label class="col-lg-6 fw-bold">Badge</label>
                                                        <div class="col-lg-6">
                                                            <InputText v-model="menu_item.badge" class="w-100"/>
                                                        </div>
                                                    </div>
                                                    <Divider />
                                                    <div class="row align-items-center">
                                                        <label class="col-lg-6 fw-bold">Yeni Pencere</label>
                                                        <div class="col-lg-6">
                                                            <InputSwitch v-model="menu_item.new_window"/>
                                                        </div>
                                                    </div>
                                                    <Divider />
                                                    <div class="row align-items-center">
                                                        <label class="col-lg-6 fw-bold">Link</label>
                                                        <div class="col-lg-6">
                                                            <InputText v-model="menu_item.item_link" class="w-100" :disabled="menu_item.is_custom ? false : true" :key="`menu-item-link-${m}`"/>
                                                        </div>
                                                    </div>
                                                    <Divider />
                                                    <div class="row align-items-center">
                                                        <label class="col-lg-6 fw-bold">Description</label>
                                                        <div class="col-lg-6">
                                                            <InputText v-model="menu_item.item_desc" class="w-100"/>
                                                        </div>
                                                    </div>
                                                    <Divider />
                                                    <div class="row align-items-center">
                                                        <label class="col-lg-6 fw-bold">Image</label>
                                                        <div class="col-lg-6">
                                                            <div class="d-flex flex-row flex-wrap align-items-center">
                                                                <img :src="menu_item.image" v-if="menu_item.image" class="img-thumbnail" width="100"/>
                                                                <div class="d-flex flex-row align-items-center">
                                                                    <PopupMediaLibrary v-if="!menu_item.image" @click="selectedForImage = menu_item" :on-select="setMenuItemMedia" :button-text="'Seç'" :mime-type="'image/'" :key="Math.floor(Math.random() * 100000)"/>
                                                                    <button type="button" class="btn btn-sm btn-light-danger btn-icon ms-2" v-if="menu_item.image" @click="menu_item.image = null">
                                                                        <i class="bi bi-x fs-3"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </Panel>

                                                <draggable 
                                                    v-model="menu_item.child_nodes" 
                                                    group="menuItem" ghostClass="ghost" animation="200" 
                                                    tag="div" 
                                                    class="item-container my-5" style="padding-left:30px;"  
                                                    @start="dragging = true" 
                                                    @end="dragging = false" 
                                                    item-key="link"
                                                >
                                                    <template #item="{element:depth1,index:d1}">
                                                        <div class="mb-3">
                                                            <Panel toggleable collapsed :header="depth1.menu_title">
                                                                <template #icons>
                                                                    <button @click="menu_item.child_nodes.splice(d1,1)" type="button" class="p-panel-header-icon p-link me-2">
                                                                        <span class="bi bi-trash"></span>
                                                                    </button>
                                                                </template>
                                                                <div class="row align-items-center">
                                                                    <label class="col-lg-6 fw-bold">Menü Başlık</label>
                                                                    <div class="col-lg-6">
                                                                        <InputText v-model="depth1.menu_title" class="w-100"/>
                                                                    </div>
                                                                </div>
                                                                <Divider />
                                                                <div class="row align-items-center">
                                                                    <label class="col-lg-6 fw-bold">Badge</label>
                                                                    <div class="col-lg-6">
                                                                        <InputText v-model="depth1.badge" class="w-100"/>
                                                                    </div>
                                                                </div>
                                                                <Divider />
                                                                <div class="row align-items-center">
                                                                    <label class="col-lg-6 fw-bold">Yeni Pencere</label>
                                                                    <div class="col-lg-6">
                                                                        <InputSwitch v-model="depth1.new_window"/>
                                                                    </div>
                                                                </div>
                                                                <Divider />
                                                                <div class="row align-items-center">
                                                                    <label class="col-lg-6 fw-bold">Link</label>
                                                                    <div class="col-lg-6">
                                                                        <InputText v-model="depth1.item_link" class="w-100" :disabled="depth1.is_custom ? false : true"/>
                                                                    </div>
                                                                </div>
                                                                <Divider />
                                                                <div class="row align-items-center">
                                                                    <label class="col-lg-6 fw-bold">Description</label>
                                                                    <div class="col-lg-6">
                                                                        <InputText v-model="depth1.item_desc" class="w-100"/>
                                                                    </div>
                                                                </div>
                                                                <Divider />
                                                                <div class="row align-items-center">
                                                                    <label class="col-lg-6 fw-bold">Image</label>
                                                                    <div class="col-lg-6">
                                                                        <div class="d-flex flex-row flex-wrap align-items-center">
                                                                            <img :src="depth1.image" v-if="depth1.image" class="img-thumbnail" width="100"/>
                                                                            <div class="d-flex flex-row align-items-center">
                                                                                <PopupMediaLibrary v-if="!depth1.image" @click="selectedForImage = depth1" :on-select="setMenuItemMedia" :button-text="'Seç'" :mime-type="'image/'" :key="Math.floor(Math.random() * 100000)"/>
                                                                                <button type="button" class="btn btn-sm btn-light-danger btn-icon ms-2" v-if="depth1.image" @click="depth1.image = null">
                                                                                    <i class="bi bi-x fs-3"></i>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </Panel>

                                                            <draggable 
                                                                v-model="depth1.child_nodes" 
                                                                group="menuItem" ghostClass="ghost" animation="200" 
                                                                tag="div" 
                                                                class="item-container my-5" style="padding-left:30px;"  
                                                                @start="dragging = true" 
                                                                @end="dragging = false" 
                                                                item-key="link"
                                                            >
                                                                <template #item="{element:depth2,index:d2}">
                                                                    <div class="mb-3">
                                                                        <Panel toggleable collapsed :header="depth2.menu_title">
                                                                            <template #icons>
                                                                                <button @click="depth1.child_nodes.splice(d2,1)" type="button" class="p-panel-header-icon p-link me-2">
                                                                                    <span class="bi bi-trash"></span>
                                                                                </button>
                                                                            </template>
                                                                            <div class="row align-items-center">
                                                                                <label class="col-lg-6 fw-bold">Menü Başlık</label>
                                                                                <div class="col-lg-6">
                                                                                    <InputText v-model="depth2.menu_title" class="w-100"/>
                                                                                </div>
                                                                            </div>
                                                                            <Divider />
                                                                            <div class="row align-items-center">
                                                                                <label class="col-lg-6 fw-bold">Badge</label>
                                                                                <div class="col-lg-6">
                                                                                    <InputText v-model="depth2.badge" class="w-100"/>
                                                                                </div>
                                                                            </div>
                                                                            <Divider />
                                                                            <div class="row align-items-center">
                                                                                <label class="col-lg-6 fw-bold">Yeni Pencere</label>
                                                                                <div class="col-lg-6">
                                                                                    <InputSwitch v-model="depth2.new_window"/>
                                                                                </div>
                                                                            </div>
                                                                            <Divider />
                                                                            <div class="row align-items-center">
                                                                                <label class="col-lg-6 fw-bold">Link</label>
                                                                                <div class="col-lg-6">
                                                                                    <InputText v-model="depth2.item_link" class="w-100" :disabled="depth2.is_custom ? false : true"/>
                                                                                </div>
                                                                            </div>
                                                                            <Divider />
                                                                            <div class="row align-items-center">
                                                                                <label class="col-lg-6 fw-bold">Description</label>
                                                                                <div class="col-lg-6">
                                                                                    <InputText v-model="depth2.item_desc" class="w-100"/>
                                                                                </div>
                                                                            </div>
                                                                            <Divider />
                                                                            <div class="row align-items-center">
                                                                                <label class="col-lg-6 fw-bold">Image</label>
                                                                                <div class="col-lg-6">
                                                                                    <div class="d-flex flex-row flex-wrap align-items-center">
                                                                                        <img :src="depth2.image" v-if="depth2.image" class="img-thumbnail" width="100"/>
                                                                                        <div class="d-flex flex-row align-items-center">
                                                                                            <PopupMediaLibrary v-if="!depth2.image" @click="selectedForImage = depth2" :on-select="setMenuItemMedia" :button-text="'Seç'" :mime-type="'image/'" :key="Math.floor(Math.random() * 100000)"/>
                                                                                            <button type="button" class="btn btn-sm btn-light-danger btn-icon ms-2" v-if="depth2.image" @click="depth2.image = null">
                                                                                                <i class="bi bi-x fs-3"></i>
                                                                                            </button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </Panel>

                                                                        <draggable 
                                                                            v-model="depth2.child_nodes" 
                                                                            group="menuItem" ghostClass="ghost" animation="200" 
                                                                            tag="div" 
                                                                            class="item-container my-5" style="padding-left:30px;"  
                                                                            @start="dragging = true" 
                                                                            @end="dragging = false" 
                                                                            item-key="link"
                                                                        >
                                                                            <template #item="{element:depth3,index:d3}">
                                                                                <div class="mb-3">
                                                                                    <Panel toggleable collapsed :header="depth3.menu_title">
                                                                                        <template #icons>
                                                                                            <button @click="depth2.child_nodes.splice(d3,1)" type="button" class="p-panel-header-icon p-link me-2">
                                                                                                <span class="bi bi-trash"></span>
                                                                                            </button>
                                                                                        </template>
                                                                                        <div class="row align-items-center">
                                                                                            <label class="col-lg-6 fw-bold">Menü Başlık</label>
                                                                                            <div class="col-lg-6">
                                                                                                <InputText v-model="depth3.menu_title" class="w-100"/>
                                                                                            </div>
                                                                                        </div>
                                                                                        <Divider />
                                                                                        <div class="row align-items-center">
                                                                                            <label class="col-lg-6 fw-bold">Badge</label>
                                                                                            <div class="col-lg-6">
                                                                                                <InputText v-model="depth3.badge" class="w-100"/>
                                                                                            </div>
                                                                                        </div>
                                                                                        <Divider />
                                                                                        <div class="row align-items-center">
                                                                                            <label class="col-lg-6 fw-bold">Yeni Pencere</label>
                                                                                            <div class="col-lg-6">
                                                                                                <InputSwitch v-model="depth3.new_window"/>
                                                                                            </div>
                                                                                        </div>
                                                                                        <Divider />
                                                                                        <div class="row align-items-center">
                                                                                            <label class="col-lg-6 fw-bold">Link</label>
                                                                                            <div class="col-lg-6">
                                                                                                <InputText v-model="depth3.item_link" class="w-100" :disabled="depth3.is_custom ? false : true"/>
                                                                                            </div>
                                                                                        </div>
                                                                                    </Panel>

                                                                                    <draggable 
                                                                                        v-model="depth3.child_nodes" 
                                                                                        group="menuItem" ghostClass="ghost" animation="200" 
                                                                                        tag="div" 
                                                                                        class="item-container my-5" style="padding-left:30px;"  
                                                                                        @start="dragging = true" 
                                                                                        @end="dragging = false" 
                                                                                        item-key="link"
                                                                                    >
                                                                                        <template #item="{element:depth4,index:d4}">
                                                                                            <div class="mb-3">
                                                                                                <Panel toggleable collapsed :header="depth4.menu_title">
                                                                                                    <template #icons>
                                                                                                        <button @click="depth3.child_nodes.splice(d4,1)" type="button" class="p-panel-header-icon p-link me-2">
                                                                                                            <span class="bi bi-trash"></span>
                                                                                                        </button>
                                                                                                    </template>
                                                                                                    <div class="row align-items-center">
                                                                                                        <label class="col-lg-6 fw-bold">Menü Başlık</label>
                                                                                                        <div class="col-lg-6">
                                                                                                            <InputText v-model="depth4.menu_title" class="w-100"/>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <Divider />
                                                                                                    <div class="row align-items-center">
                                                                                                        <label class="col-lg-6 fw-bold">Badge</label>
                                                                                                        <div class="col-lg-6">
                                                                                                            <InputText v-model="depth4.badge" class="w-100"/>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <Divider />
                                                                                                    <div class="row align-items-center">
                                                                                                        <label class="col-lg-6 fw-bold">Yeni Pencere</label>
                                                                                                        <div class="col-lg-6">
                                                                                                            <InputSwitch v-model="depth4.new_window"/>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <Divider />
                                                                                                    <div class="row align-items-center">
                                                                                                        <label class="col-lg-6 fw-bold">Link</label>
                                                                                                        <div class="col-lg-6">
                                                                                                            <InputText v-model="depth4.item_link" class="w-100" :disabled="depth4.is_custom ? false : true"/>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </Panel>
                                                                                            </div>
                                                                                        </template>
                                                                                    </draggable>

                                                                                </div>
                                                                            </template>
                                                                        </draggable>

                                                                    </div>
                                                                </template>
                                                            </draggable>

                                                        </div>
                                                    </template>
                                                </draggable>

                                            </div>
                                        </template>
                                    </draggable>
                                </div>

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

import {ref,onMounted} from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import Divider from "primevue/divider";
import InputText from "primevue/inputtext";
import InputSwitch from "primevue/inputswitch";
import MultiSelect from "primevue/multiselect";
import Dropdown from "primevue/dropdown";
import Button from "primevue/button";
import Panel from "primevue/panel";
import draggable from 'vuedraggable';
import PopupMediaLibrary from "../MediaLibrary/PopupMediaLibrary";

const linkableContents = ref([]);
const selectedLinkableContens = ref([]);

const customLink = ref({
    original_title:"",
    menu_title:"",
    is_custom:true,
    content_id:null,
    item_link:"",
    new_window:false,
    child_nodes:[],
    megamenu:false,
    badge:"",
    image:null,
    item_desc:""
});

let curr_language = usePage().props.current_language;

const form = useForm({
    name:"",
    language:curr_language,
    location:"",
    tree:[]
});

const selectedForImage = ref(null);

const create = () => {
    form.post(route('menus.store'),{
        only:['menus','flash','errors'],
        onSuccess: () => {
            
        },
    });
}

const getLinkableContents = () => {

    fetch(route('menus.contents',{language:curr_language})).then(function (response) {
        return response.json();
    }).then((json) => {
        linkableContents.value = json;
    });

}

const addSelectedToMenuTree = async () => {

    let promise = new Promise(function(resolve, reject) {

        selectedLinkableContens.value.forEach(selectedArr => {
        
            if( selectedArr.length == 0 ) return;

            selectedArr.forEach(item => {
                form.tree.push({
                    original_title:item.content.name,
                    menu_title:item.content.name,
                    is_custom:false,
                    content_id:item.content.id,
                    item_link:item.final_uri,
                    new_window:false,
                    child_nodes:[],
                    megamenu:false,
                    badge:"",
                    image:null,
                    item_desc:""
                }); 
            });

        });

        resolve(true);
    });

    const addedToTree = await promise;

    if(addedToTree){

        selectedLinkableContens.value = [];

    }

}

const addCutomLinkToMenu = () => {

    if(customLink.value.menu_title == "" || customLink.value.item_link == ""){
        return;
    }

    form.tree.push(JSON.parse(JSON.stringify(customLink.value)));
    customLink.value = {
        original_title:"",
        menu_title:"",
        is_custom:true,
        content_id:null,
        item_link:"",
        new_window:false,
        child_nodes:[],
        megamenu:false,
        badge:"",
        image:null,
        item_desc:""
    };

}

const dragging = ref(false);

const setMenuItemMedia = (media) => {
    selectedForImage.value.image = media.original_url;
}

onMounted(() => {
    getLinkableContents()
});

</script>