<template>

    <div class="card" :class="{'mb-5 mb-xl-10':props.confirmGroup == 'page'}">
        <div class="card-header px-5 min-h-50px">
            <h3 class="card-title fs-4 fw-bold">İÇERİK ALANI</h3>
        </div>
        <div class="card-body bg-primary" :class="{'p-5':props.useSections, 'p-0':!props.useSections}">

            <draggable v-model="form.content" group="section" @start="dragStarted" @end="dragEnded" handle=".drag-section" item-key="id" ghost-class="ghost">
                <template #item="{ element: section, index }">
                    <div class="card content-section border-0 card-flush" :class="{'mb-5':props.useSections}">
                        <div class="card-header min-h-60px px-5" v-if="props.useSections">
                            <div class="card-title">
                                <i class="bi bi-arrows-move me-3 fs-3 drag-section"></i>
                                <h3 class="mb-0">
                                    {{ section.settings.name }}
                                </h3>
                            </div>
                            <div class="card-toolbar gap-2">
                                <button type="button" class="btn btn-sm btn-icon btn-light" @click="toogleCollapse($event)"><i class="bi bi-chevron-down"></i></button>
                                <button type="button" class="btn btn-sm btn-icon btn-light" @click="cloneSection(index)" v-tooltip.top="'Çoğalt'"><i class="bi bi-copy"></i></button>
                                <button type="button" class="btn btn-sm btn-icon btn-light" @click="openSectionSettings(section)" v-tooltip.top="'Ayarlar'"><i class="bi bi-gear"></i></button>
                                <button type="button" class="btn btn-sm btn-icon btn-light-primary" @click="saveAsTemplate(section, route('saved-sections.store'))" v-tooltip.top="'Kaydet'"><i class="bi bi-floppy"></i></button>
                                <button type="button" class="btn btn-sm btn-icon btn-light-danger" @click="removeSection(index)" v-tooltip.top="'Kaldır'"><i class="bi bi-trash"></i></button>
                            </div>
                        </div>
                        <div class="card-body p-0 content-section-body">
                            <draggable v-model="section.containers" group="container" @start="dragStarted" @end="dragEnded" handle=".drag-container" item-key="id" ghost-class="ghost">
                                <template #item="{ element: container, index: c }">
                                    <div class="card section-container border-0 card-flush shadow-none rounded-0">
                                        <div class="card-header min-h-50px px-5 bg-opacity-75 bg-dark rounded-0" v-if="props.useContainers">
                                            <div class="card-title">
                                                <i class="bi bi-arrows-move text-white me-3 fs-4 drag-container"></i>
                                                <h4 class="mb-0 text-white">{{ container.settings.name ?? 'Container' }}</h4>
                                            </div>
                                            <div class="card-toolbar gap-2">
                                                <button type="button" class="btn btn-sm btn-icon btn-light" @click="cloneContainer(index,c)" v-tooltip.top="'Çoğalt'"><i class="bi bi-copy"></i></button>
                                                <button type="button" class="btn btn-sm btn-icon btn-light" @click="openContainerSettings(container)" v-tooltip.top="'Ayarlar'"><i class="bi bi-gear"></i></button>
                                                <button type="button" class="btn btn-sm btn-icon btn-light" @click="saveAsTemplate(container, route('saved-containers.store'))" v-tooltip.top="'Kaydet'"><i class="bi bi-floppy"></i></button>
                                                <button type="button" class="btn btn-sm btn-icon btn-light" @click="removeContainer(index,c)" v-tooltip.top="'Kaldır'"><i class="bi bi-trash"></i></button>
                                            </div>
                                        </div>

                                        <div class="card-body bg-opacity-25 bg-dark p-4 section-container-body">
                                            <draggable v-model="container.rows" group="row" @start="dragStarted" @end="dragEnded" handle=".drag-row" item-key="id" ghost-class="ghost">
                                                <template #item="{ element: row, index: r }">
                                                    <div class="card container-row shadow-none mb-5">
                                                        <div class="card-header min-h-30px px-5 overflow-hidden bg-opacity-10 bg-dark" v-if="props.useRows">
                                                            <div class="card-title">
                                                                <i class="bi bi-arrows-move me-3 fs-4 drag-row"></i>
                                                                <h5 class="mb-0">{{ row.settings.name ?? 'Row' }}</h5>
                                                            </div>
                                                            <div class="card-toolbar">
                                                                <div class="btn-group">
                                                                    <button type="button" class="btn btn-sm btn-icon btn-light" @click="cloneRow(index,c,r)" v-tooltip.top="'Çoğalt'"><i class="bi bi-copy"></i></button>
                                                                    <button type="button" class="btn btn-sm btn-icon btn-light" @click="openRowSettings(row)" v-tooltip.top="'Ayarlar'"><i class="bi bi-gear"></i></button>
                                                                    <button type="button" class="btn btn-sm btn-icon btn-light" @click="saveAsTemplate(row, route('saved-rows.store'))" v-tooltip.top="'Kaydet'"><i class="bi bi-floppy"></i></button>
                                                                    <button type="button" class="btn btn-sm btn-icon btn-light" @click="removeRow(index,c,r)" v-tooltip.top="'Kaldır'"><i class="bi bi-trash"></i></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-body container-row-body p-5">
                                                            <draggable v-model="row.columns" group="column" @start="dragStarted" @end="dragEnded" handle=".drag-column" item-key="id" ghost-class="ghost" class="row" :class="`${row.settings.alignContents} ${row.settings.justifyContents} ${row.settings.gutter.sm} ${row.settings.gutter.md} ${row.settings.gutter.lg} ${row.settings.gutter.xl}`">
                                                                <template #item="{ element: column, index: co }">
                                                                    <div :class="`${column.settings.size.sm} ${column.settings.size.md} ${column.settings.size.lg} ${column.settings.size.xl}`">
                                                                        <div class="card shadow-none bg-opacity-25 bg-primary">
                                                                            <div class="card-header min-h-30px px-5 overflow-hidden" v-if="props.useColumns">
                                                                                <div class="card-title">
                                                                                    <i class="bi bi-arrows-move me-3 fs-4 drag-column"></i>
                                                                                    <h5 class="mb-0">{{ column.settings.name ?? 'Column' }}</h5>
                                                                                </div>
                                                                                <div class="card-toolbar">
                                                                                    <div class="btn-group">
                                                                                        <button type="button" class="btn btn-sm btn-icon btn-light-primary" @click="cloneColumn(index,c,r,co)" v-tooltip.top="'Çoğalt'"><i class="bi bi-copy"></i></button>
                                                                                        <button type="button" class="btn btn-sm btn-icon btn-light-primary" @click="openColumnSettings(column)" v-tooltip.top="'Ayarlar'"><i class="bi bi-gear"></i></button>
                                                                                        <button type="button" class="btn btn-sm btn-icon btn-light-primary" @click="saveAsTemplate(column, route('saved-columns.store'))" v-tooltip.top="'Kaydet'"><i class="bi bi-floppy"></i></button>
                                                                                        <button type="button" class="btn btn-sm btn-icon btn-light-primary" @click="removeColumn(index,c,r,co)" v-tooltip.top="'Kaldır'"><i class="bi bi-trash"></i></button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="card-body p-4 bg-light-primary column-elements" :class="`${column.settings.flexDirection.sm} ${column.settings.flexDirection.md} ${column.settings.flexDirection.lg} ${column.settings.flexDirection.xl}`">
                                                                                <draggable v-model="column.elements" group="element" @start="dragStarted" @end="dragEnded" handle=".drag-elem" item-key="id" :class="{ 'pt-3': !props.useColumns }" ghost-class="ghost">
                                                                                    <template #item="{ element: elem, index: e }">
                                                                                        <div class="card overlay overflow-hidden m-4 shadow-none border-dark">
                                                                                            <div class="card-body p-4">
                                                                                                <div class="overlay-wrapper"
                                                                                                    v-html="elem.data.prevHtml">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="overlay-layer bg-dark bg-opacity-25">
                                                                                                <Button icon="bi bi-pencil" severity="help" size="small" rounded @click="editElement(elem)" />
                                                                                                <Button icon="bi bi-arrows-move" severity="secondary" size="small" rounded class="ms-2 drag-elem" />
                                                                                                <Button icon="bi bi-copy" severity="warning" size="small" rounded class="ms-2" @click="cloneElement(index,c,r,co,e)" />
                                                                                                <Button icon="bi bi-trash" severity="danger" size="small" rounded class="ms-2" @click="removeElement(index,c,r,co,e)" />
                                                                                                <Button
                                                                                                    icon="bi bi-floppy text-white"
                                                                                                    severity="secondary"
                                                                                                    size="small" rounded
                                                                                                    class="ms-2"
                                                                                                    v-tooltip.top="'Kaydet'"
                                                                                                    @click="saveAsTemplate(elem, route('saved-elements.store'))" />
                                                                                            </div>
                                                                                        </div>
                                                                                    </template>
                                                                                </draggable>

                                                                                <div class="hstack mt-5 pt-5 border-top justify-content-center">
                                                                                    <button type="button" class="btn btn-sm btn-outline btn-outline-dark" @click="openElementSelectDialog(column)">Element Ekle</button>
                                                                                    <button type="button" class="btn btn-sm btn-outline btn-light ms-2 btn-icon" v-tooltip.top="'Kaydedilenlerden Ekle'" @click="addSavedTemplate('element', index, c, r, co)"><i class="bi bi-folder-plus fs-3"></i></button>
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </template>
                                                            </draggable>

                                                            <div class="hstack mt-5 justify-content-end" v-if="props.useColumns">
                                                                <button type="button" class="btn btn-sm btn-outline btn-outline-dark" @click="addColumn(row)">Column Ekle</button>
                                                                <button type="button" class="btn btn-sm btn-outline btn-light ms-2 btn-icon" v-tooltip.top="'Kaydedilenlerden Ekle'" @click="addSavedTemplate('column', index, c, r)"><i class="bi bi-folder-plus fs-3"></i></button>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </template>
                                            </draggable>

                                            <div class="hstack mt-7" v-if="props.useRows">
                                                <button type="button" class="btn btn-sm btn-outline btn-light" @click="addRow(container)">Row Ekle</button>
                                                <button type="button" class="btn btn-sm btn-outline btn-light ms-2 btn-icon" v-tooltip.top="'Kaydedilenlerden Ekle'" @click="addSavedTemplate('row', index,c)"><i class="bi bi-folder-plus fs-3"></i></button>
                                            </div>
                                        </div>

                                    </div>
                                </template>
                            </draggable>

                            <div class="d-flex justify-content-end p-5" v-if="props.useContainers">
                                <button type="button" class="btn btn-outline btn-outline-dark" @click="addContainer(section)">Container Ekle</button>
                                <button type="button" class="btn btn-outline btn-light ms-2 btn-icon" v-tooltip.top="'Kaydedilenlerden Ekle'" @click="addSavedTemplate('container', index)"><i class="bi bi-folder-plus fs-3"></i></button>
                            </div>
                        </div>
                    </div>
                </template>
            </draggable>

            <div class="hstack gap-3" v-if="props.useSections">
                <button type="button" class="btn btn-light btn-lg" @click="addSection(form)">Section Ekle</button>
                <button type="button" class="btn btn-outline btn-outline-light btn-lg btn-icon" v-tooltip.top="'Kaydedilenlerden Ekle'" @click="addSavedTemplate('section')"><i class="bi bi-folder-plus fs-2"></i></button>
            </div>

        </div>
    </div>

    <div>
        <Dialog v-model:visible="dialogSectionSettingsVisible" modal maximizable header="SECTION SETTINGS" @hide="hideSectionSettings">
            <SectionSettings :section="selectedSection" :hide-settings="hideSectionSettings" />
        </Dialog>

        <Dialog v-model:visible="dialogContainerSettingsVisible" modal maximizable header="CONTAINER SETTINGS"
            :style="{ width: '75vw' }" :breakpoints="{ '768px': '95vw' }" @hide="hideContainerSettings">
            <ContainerSettings :container="selectedContainer" :hide-settings="hideContainerSettings" />
        </Dialog>

        <Dialog v-model:visible="dialogRowSettingsVisible" modal maximizable header="ROW SETTINGS"
            :style="{ width: '75vw' }" :breakpoints="{ '768px': '95vw' }" @hide="hideRowSettings">
            <RowSettings :row="selectedRow" :hide-settings="hideRowSettings" />
        </Dialog>

        <Dialog v-model:visible="dialogColumSettingsVisible" modal maximizable header="COLUMN SETTINGS"
            :style="{ width: '75vw' }" :breakpoints="{ '768px': '95vw' }" @hide="hideColumnSettings">
            <ColumnSettings :column="selectedColumn" :hide-settings="hideColumnSettings" :layout-mode="props.layoutMode" />
        </Dialog>

        <Dialog v-model:visible="elemDialogVisible" modal maximizable header="ELEMENTS" :style="{ width: '75vw' }"
            :breakpoints="{ '768px': '95vw' }">
            <ElementSelect :on-select="elementSelected" :layout-mode="props.layoutMode"
                :product-layout-mode="props.productLayoutMode" />
        </Dialog>

        <Dialog v-if="selectedElementType" v-model:visible="elemSelectedDialogVisible" modal maximizable @hide="
            selectedElementType = null;
        selectedElement = null;
        " header="ELEMENT EKLE" :style="{ width: '75vw' }" :breakpoints="{ '768px': '95vw' }">
            <ElementSelected :on-done="addOrUpdateElement" :elem-type="selectedElementType" :elem="selectedElement" />
        </Dialog>


        <Dialog v-model:visible="savedDialogVisible" modal @hide="savedSelected" header="KAYITLI ŞABLON EKLE"
            :style="{ width: '75vw' }" :breakpoints="{ '768px': '95vw' }">
            <SavedTemplates v-if="savedSelectedType" :on-select="savedSelected" :form="form"
                :template-type="savedSelectedType" :section-index="savedSelectedSectionIndex"
                :container-index="savedSelectedContainerIndex" :row-index="savedSelectedRowIndex"
                :column-index="savedSelectedColumnIndex" />
        </Dialog>

        <Dialog v-model:visible="saveAsTemplateVisible" modal header="TEMPLATE ADI" :style="{ width: '300px' }">

            <div class="mb-3">
                <InputText class="w-100" v-model="templateNameForSave" />
            </div>
            <button type="button" class="btn btn-primary btn-sm w-100" @click="saveTemplate">Kaydet</button>

        </Dialog>


    </div>

    <ConfirmDialog :group="props.confirmGroup"></ConfirmDialog>
</template>

<style>
.ghost {
    min-height:100px;
    background:#000
}
</style>

<script setup>
import { ref, onMounted } from "vue";
import { usePage } from "@inertiajs/vue3";
import { useConfirm } from "primevue/useconfirm";
import ConfirmDialog from "primevue/confirmdialog";
import Button from "primevue/button";
import Dialog from "primevue/dialog";
import InputText from "primevue/inputtext";

import draggable from "vuedraggable";

import {
    addSection,
    addContainer,
    addRow,
    addColumn,
} from "./design-elements-sections.js";

import SectionSettings from "./SectionSettings";
import ContainerSettings from "./ContainerSettings";
import RowSettings from "./RowSettings";
import ColumnSettings from "./ColumnSettings";

import ElementSelect from "./ElementSelect";
import ElementSelected from "./ElementSelected";

import SavedTemplates from "./SavedTemplates";

const props = defineProps({
    form: Object,
    useSections: {
        type: Boolean,
        default: true
    },
    useContainers: {
        type: Boolean,
        default: true
    },
    useRows: {
        type: Boolean,
        default: true
    },
    useColumns: {
        type: Boolean,
        default: true
    },
    addSection: {
        type: Boolean,
        default: true
    },
    layoutMode: {
        type: Boolean,
        default: false
    },
    productLayoutMode: {
        type: Boolean,
        default: false
    },
    confirmGroup:{
        type:String,
        default:"page"
    }
});

const form = ref(props.form);

const confirm = useConfirm();
const elemDialogVisible = ref(false);
const elemSelectedDialogVisible = ref(false);

//sections
const dialogSectionSettingsVisible = ref(false);
const selectedSection = ref(null);

//containers
const dialogContainerSettingsVisible = ref(false);
const selectedContainer = ref(null);

//Rows
const dialogRowSettingsVisible = ref(false);
const selectedRow = ref(null);

//Columns
const dialogColumSettingsVisible = ref(false);
const selectedColumn = ref(null);

//Elements
const selectedElement = ref(null);
const selectedElementType = ref(null);

const openElementSelectDialog = (column) => {
    elemDialogVisible.value = true;
    selectedColumn.value = column;
};

const elementSelected = (type) => {
    selectedElementType.value = type;
    elemDialogVisible.value = false;
    elemSelectedDialogVisible.value = true;
};

const editElement = (element) => {
    selectedElementType.value = element.type;
    selectedElement.value = element;
    elemSelectedDialogVisible.value = true;
};

const addOrUpdateElement = (element) => {
    //update real time yapiyor. update yoksa push edicez
    if (!selectedElement.value) {
        selectedColumn.value.elements.push(element);
    }

    elemSelectedDialogVisible.value = false;
    selectedElementType.value = null;
    selectedElement.value = null;
};

const removeElement = (
    sectionIndex,
    containerIndex,
    rowIndex,
    columnIndex,
    elemIndex
) => {
    confirm.require({
        group:props.confirmGroup,
        message: "Seçilen alan silinecek! Bu işlem geri alınamaz!",
        header: "Emin misiniz?",
        icon: "bi bi-exclamation-triangle-fill",
        rejectLabel: "Vazgeç",
        acceptLabel: "Evet, Sil",
        acceptClass: "p-button-danger p-button-sm",
        accept: () => {
            form.value.content[sectionIndex].containers[containerIndex].rows[
                rowIndex
            ].columns[columnIndex].elements.splice(elemIndex, 1);
        },
        reject: () => {
            //
        },
    });
};

const cloneElement = (
    sectionIndex,
    containerIndex,
    rowIndex,
    columnIndex,
    elemIndex
) => {
    let cloneElem = JSON.parse(
        JSON.stringify(
            form.value.content[sectionIndex].containers[containerIndex].rows[rowIndex]
                .columns[columnIndex].elements[elemIndex]
        )
    );

    cloneElem.id = "elem_" + Date.now();

    if( cloneElem.data.htmlId ){
        cloneElem.data.htmlId = "html_" + Date.now();
    }

    form.value.content[sectionIndex].containers[containerIndex].rows[rowIndex].columns[
        columnIndex
    ].elements.splice(elemIndex + 1, 0, cloneElem);
};


//Section
const openSectionSettings = (section) => {
    selectedSection.value = section;
    dialogSectionSettingsVisible.value = true;
};

const hideSectionSettings = () => {
    selectedSection.value = null;
    dialogSectionSettingsVisible.value = false;
};

const removeSection = (sectionIndex) => {
    confirm.require({
        group:props.confirmGroup,
        message: "Seçilen alan silinecek!",
        header: "Emin misiniz?",
        icon: "bi bi-exclamation-triangle-fill",
        rejectLabel: "Vazgeç",
        acceptLabel: "Evet, Sil",
        acceptClass: "p-button-danger p-button-sm",
        accept: () => {
            form.value.content.splice(sectionIndex, 1);
        },
        reject: () => {
            //
        },
    });
};

const cloneSection = async (sectionIndex) => {
    let promise = new Promise(function (resolve, reject) {
        let cloneSectionElem = JSON.parse(
            JSON.stringify(form.value.content[sectionIndex])
        );
        cloneSectionElem.settings.id = "section_" + Date.now();
        cloneSectionElem.containers.forEach((container, c) => {
            container.settings.id = "container_" + Date.now() + "_" +c;
            container.rows.forEach((row, r) => {
                row.settings.id = "row_" + Date.now() + "_" + c + "_" + r;
                row.columns.forEach((column, co) => {
                    column.settings.id = "column_" + Date.now() + "_" + c + "_" + r + "_" + co;
                    column.elements.forEach((elem, e) => {
                        elem.id = "elem_" + Date.now() + "_" + c + "_" + r + "_" + co + "_" + e;
                        if( elem.data.htmlId ){
                            elem.data.htmlId = "html_" + Date.now() + "_" + c + "_" + r + "_" + co + "_" + e;
                        }
                    });
                });
            });
        });

        resolve(cloneSectionElem);
    });

    const isSectionReady = await promise;
    if (isSectionReady) {
        form.value.content.splice(sectionIndex + 1, 0, isSectionReady);
    }
};



//Container
const openContainerSettings = (container) => {
    selectedContainer.value = container;
    dialogContainerSettingsVisible.value = true;
};

const hideContainerSettings = () => {
    selectedContainer.value = null;
    dialogContainerSettingsVisible.value = false;
};

const removeContainer = (sectionIndex, containerIndex) => {
    confirm.require({
        group:props.confirmGroup,
        message: "Seçilen alan silinecek! Bu işlem geri alınamaz!",
        header: "Emin misiniz?",
        icon: "bi bi-exclamation-triangle-fill",
        rejectLabel: "Vazgeç",
        acceptLabel: "Evet, Sil",
        acceptClass: "p-button-danger p-button-sm",
        accept: () => {
            form.value.content[sectionIndex].containers.splice(containerIndex, 1);
        },
        reject: () => {
            //
        },
    });
};

const cloneContainer = async (sectionIndex, containerIndex) => {
    let promise = new Promise(function (resolve, reject) {
        let cloneContainerElem = JSON.parse(
            JSON.stringify(form.value.content[sectionIndex].containers[containerIndex])
        );
        cloneContainerElem.settings.id = "container_" + Date.now();
        cloneContainerElem.rows.forEach((row, r) => {
            row.settings.id = "row_" + Date.now() + "_" + containerIndex + "_" + r;
            row.columns.forEach((column, co) => {
                column.settings.id = "column_" + Date.now() + "_" + containerIndex + "_" + r + "_" + co;
                column.elements.forEach((elem, e) => {
                    elem.id = "elem_" + Date.now() + "_" + containerIndex + "_" + r + "_" + co + "_" + e;
                    if( elem.data.htmlId ){
                        elem.data.htmlId = "html_" + Date.now() + "_" + containerIndex + "_" + r + "_" + co + "_" + e;
                    }
                });
            });
        });

        resolve(cloneContainerElem);
    });

    const isContainerReady = await promise;
    if (isContainerReady) {
        form.value.content[sectionIndex].containers.splice(
            containerIndex + 1,
            0,
            isContainerReady
        );
    }
};

//Rows
const openRowSettings = (row) => {
    selectedRow.value = row;
    dialogRowSettingsVisible.value = true;
};

const hideRowSettings = () => {
    selectedRow.value = null;
    dialogRowSettingsVisible.value = false;
};

const removeRow = (sectionIndex, containerIndex, rowIndex) => {
    confirm.require({
        group:props.confirmGroup,
        message: "Seçilen alan silinecek! Bu işlem geri alınamaz!",
        header: "Emin misiniz?",
        icon: "bi bi-exclamation-triangle-fill",
        rejectLabel: "Vazgeç",
        acceptLabel: "Evet, Sil",
        acceptClass: "p-button-danger p-button-sm",
        accept: () => {
            form.value.content[sectionIndex].containers[containerIndex].rows.splice(
                rowIndex,
                1
            );
        },
        reject: () => {
            //
        },
    });
};

const cloneRow = async (sectionIndex, containerIndex, rowIndex) => {
    let promise = new Promise(function (resolve, reject) {
        let cloneRowElem = JSON.parse(
            JSON.stringify(
                form.value.content[sectionIndex].containers[containerIndex].rows[rowIndex]
            )
        );
        cloneRowElem.settings.id = "row_" + Date.now();
        cloneRowElem.columns.forEach((column,co) => {
            column.settings.id = "column_" + Date.now() + "_" + co;
            column.elements.forEach((elem, e) => {
                elem.id = "elem_" + Date.now() + "_" + co + "_" + e;
                if( elem.data.htmlId ){
                    elem.data.htmlId = "html_" + Date.now() + "_" + co + "_" + e;
                }
            });
        });

        resolve(cloneRowElem);
    });

    const isRowReady = await promise;
    if (isRowReady) {
        form.value.content[sectionIndex].containers[containerIndex].rows.splice(
            rowIndex + 1,
            0,
            isRowReady
        );
    }
};

//Columns
const openColumnSettings = (column) => {
    selectedColumn.value = column;
    dialogColumSettingsVisible.value = true;
};

const hideColumnSettings = () => {
    selectedColumn.value = null;
    dialogColumSettingsVisible.value = false;
};

const removeColumn = (sectionIndex, containerIndex, rowIndex, columnIndex) => {
    confirm.require({
        group:props.confirmGroup,
        message: "Seçilen alan silinecek! Bu işlem geri alınamaz!",
        header: "Emin misiniz?",
        icon: "bi bi-exclamation-triangle-fill",
        rejectLabel: "Vazgeç",
        acceptLabel: "Evet, Sil",
        acceptClass: "p-button-danger p-button-sm",
        accept: () => {
            form.value.content[sectionIndex].containers[containerIndex].rows[
                rowIndex
            ].columns.splice(columnIndex, 1);
        },
        reject: () => {
            //
        },
    });
};

const cloneColumn = async (
    sectionIndex,
    containerIndex,
    rowIndex,
    columnIndex
) => {
    let cloneColumnElem = JSON.parse(
        JSON.stringify(
            form.value.content[sectionIndex].containers[containerIndex].rows[rowIndex]
                .columns[columnIndex]
        )
    );

    let promise = new Promise(function (resolve, reject) {
        cloneColumnElem.settings.id = "column_" + Date.now();
        cloneColumnElem.elements.forEach((elem, e) => {
            elem.id = "elem_" + Date.now() + "_" + e;
            if( elem.data.htmlId ){
                elem.data.htmlId = "html_" + Date.now() + "_" + e;
            }
        });
        resolve(cloneColumnElem);
    });

    const isContainerReady = await promise;
    if (isContainerReady) {
        form.value.content[sectionIndex].containers[containerIndex].rows[
            rowIndex
        ].columns.splice(columnIndex + 1, 0, cloneColumnElem);
    }
};



//Saved konulari
const savedDialogVisible = ref(false);
const savedSelectedType = ref("");
const savedSelectedSectionIndex = ref(null);
const savedSelectedContainerIndex = ref(null);
const savedSelectedRowIndex = ref(null);
const savedSelectedColumnIndex = ref(null);

const addSavedTemplate = async (type, sectionIndex = null, containerIndex = null, rowIndex = null, columnIndex = null) => {

    let promise = new Promise(function (resolve, reject) {
        savedDialogVisible.value = true;
        resolve(savedDialogVisible);
    });

    const isDialogReady = await promise;
    if (isDialogReady) {
        savedSelectedType.value = type;
        savedSelectedSectionIndex.value = sectionIndex;
        savedSelectedContainerIndex.value = containerIndex;
        savedSelectedRowIndex.value = rowIndex;
        savedSelectedColumnIndex.value = columnIndex;
    }


}

const savedSelected = () => {

    savedSelectedType.value = null;
    savedSelectedSectionIndex.value = null;
    savedSelectedContainerIndex.value = null;
    savedSelectedRowIndex.value = null;
    savedSelectedColumnIndex.value = null;

    savedDialogVisible.value = false;

}


const templateItemForSave = ref(null);
const templateNameForSave = ref("");
const templateRouteForSave = ref("");
const saveAsTemplateVisible = ref(false);

const saveAsTemplate = (template, route) => {

    saveAsTemplateVisible.value = true;
    templateItemForSave.value = template;
    templateRouteForSave.value = route;

}
const saveTemplate = () => {

    if (templateNameForSave.value == "") return;

    (async () => {
        const rawResponse = await fetch(templateRouteForSave.value, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': usePage().props.csrf_token
            },
            body: JSON.stringify({
                name: templateNameForSave.value,
                json_data: templateItemForSave.value,
            })
        });
        const response = await rawResponse.json();

        saveAsTemplateVisible.value = false;
        templateItemForSave.value = null;
        templateRouteForSave.value = "";
        templateNameForSave.value = "";
    })();

}


const toogleCollapse = (event) => {
    const cardBody = event.target.closest('.card').querySelector('.card-body');
    if(!cardBody) return;
    cardBody.classList.toggle("d-none");
}

const dragStarted = () => {
    document.getElementById('kt_app_header').classList.add("d-none");    
}
const dragEnded = () => {
    document.getElementById('kt_app_header').classList.remove("d-none");    
}

onMounted(() => {

    if (!props.useSections && props.addSection) {
        addSection(form.value);
    }

});
</script>