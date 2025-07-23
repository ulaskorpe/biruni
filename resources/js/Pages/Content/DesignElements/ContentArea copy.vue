<template>
    <div class="card mb-5 mb-xl-10">
        <div class="card-header">
            <h3 class="card-title">İÇERİK ALANI</h3>
        </div>
        <div class="card-body p-0">
            <draggable v-model="form.content" group="section" @start="drag = true" @end="drag = false"
                handle=".drag-section" item-key="id">
                <template #item="{ element: section, index }">
                    <div class="content-section min-h-200px bg-gray-200 mb-5">
                        <div class="d-flex flex-row align-items-center justify-content-between bg-primary ps-5" v-if="props.useSections">
                            <div class="d-flex flex-row align-items-center">
                                <i class="bi bi-arrows-move text-white me-3 fs-3 drag-section"></i>
                                <h4 class="mb-0 fs-6 text-white">
                                    {{ section.settings.name }}
                                </h4>
                            </div>
                            <div class="d-flex flex-row">
                                <Button icon="bi bi-gear text-white" text severity="info" size="large" class="rounded-0"
                                    @click="openSectionSettings(section)" />
                                <Button icon="bi bi-copy text-white" text severity="info" size="large" class="rounded-0"
                                    @click="cloneSection(index)" />
                                <Button icon="bi bi-trash text-white" text severity="info" size="large" class="rounded-0"
                                    @click="removeSection(index)" />
                                <Button icon="bi bi-floppy text-white" text severity="info" size="large" class="rounded-0"
                                    v-tooltip.top="'Kaydet'" @click="saveAsTemplate(section,route('saved-sections.store'))"/>
                            </div>
                        </div>
                        <div class="content-section-body">
                            <draggable v-model="section.containers" group="container" @start="drag = true"
                                @end="drag = false" handle=".drag-container" item-key="id">
                                <template #item="{ element: container, index: c }">
                                    <div class="section-container min-h-200px bg-opacity-25 bg-dark">
                                        <div v-if="props.useContainers" 
                                            class="d-flex flex-row align-items-center justify-content-between bg-dark ps-5">
                                            <div class="d-flex flex-row align-items-center">
                                                <i class="bi bi-arrows-move text-white me-3 fs-4 drag-container"></i>
                                                <h4 class="mb-0 fs-7 text-white">{{ container.settings.name ?? 'Container'}}</h4>
                                            </div>
                                            <div class="d-flex flex-row">
                                                <Button icon="bi bi-gear text-white" text severity="secondary"
                                                    class="rounded-0" @click="openContainerSettings(container)" />
                                                <Button icon="bi bi-copy text-white" text severity="secondary"
                                                    class="rounded-0" @click="cloneContainer(index, c)" />
                                                <Button icon="bi bi-trash text-white" text severity="secondary"
                                                    class="rounded-0" @click="removeContainer(index, c)" />
                                                <Button icon="bi bi-floppy text-white" text severity="secondary"
                                                    v-tooltip.top="'Kaydet'" @click="saveAsTemplate(container,route('saved-containers.store'))"/>
                                            </div>
                                        </div>
                                        <div class="section-container-body">
                                            <draggable v-model="container.rows" group="row" @start="drag = true"
                                                @end="drag = false" handle=".drag-row" item-key="id">
                                                <template #item="{ element: row, index: r }">
                                                    <div class="container-row bg-gray-300">
                                                        <div v-if="props.useRows" 
                                                            class="d-flex flex-row align-items-center justify-content-between bg-opacity-50 bg-dark ps-5">
                                                            <div class="d-flex flex-row align-items-center">
                                                                <i
                                                                    class="bi bi-arrows-move text-white me-3 fs-4 drag-row"></i>
                                                                <h4 class="mb-0 fs-7 text-white">{{ row.settings.name ?? 'Row'}}</h4>
                                                            </div>
                                                            <div class="d-flex flex-row">
                                                                <Button icon="bi bi-gear" severity="secondary" size="small"
                                                                    class="rounded-0" @click="openRowSettings(row)" />
                                                                <Button icon="bi bi-copy" severity="secondary" size="small"
                                                                    class="rounded-0" @click="cloneRow(index, c, r)" />
                                                                <Button icon="bi bi-trash" severity="secondary" size="small"
                                                                    class="rounded-0" @click="removeRow(index, c, r)" />
                                                                <Button icon="bi bi-floppy text-white" severity="secondary" size="small"
                                                                    v-tooltip.top="'Kaydet'" @click="saveAsTemplate(row,route('saved-rows.store'))"/>
                                                            </div>
                                                        </div>
                                                        <div class="container-row-body p-5">
                                                            <draggable v-model="row.columns" group="column"
                                                                @start="drag = true" @end="drag = false"
                                                                handle=".drag-column" item-key="id" class="row"
                                                                :class="`${row.settings.alignContents} ${row.settings.justifyContents} ${row.settings.gutter.sm} ${row.settings.gutter.md} ${row.settings.gutter.lg} ${row.settings.gutter.xl}`">
                                                                <template #item="{ element: column, index: co }">
                                                                    <div 
                                                                        :class="`${column.settings.size.sm} ${column.settings.size.md} ${column.settings.size.lg} ${column.settings.size.xl}`">
                                                                        <div class="bg-white">
                                                                            <div v-if="props.useColumns" 
                                                                                class="d-flex flex-row align-items-center justify-content-between bg-light border-bottom ps-5 py-0">
                                                                                <div
                                                                                    class="d-flex flex-row align-items-center">
                                                                                    <i
                                                                                        class="bi bi-arrows-move me-3 fs-5 drag-column"></i>
                                                                                    <h5 class="mb-0 fs-8 text-dark">
                                                                                        Column
                                                                                    </h5>
                                                                                </div>
                                                                                <div class="d-flex flex-row">
                                                                                    <Button icon="bi bi-gear"
                                                                                        severity="secondary" size="small"
                                                                                        class="rounded-0"
                                                                                        @click="openColumnSettings(column)" />
                                                                                    <Button icon="bi bi-copy"
                                                                                        severity="secondary" size="small"
                                                                                        class="rounded-0" @click="
                                                                                            cloneColumn(index, c, r, co)
                                                                                            " />
                                                                                    <Button icon="bi bi-trash"
                                                                                        severity="secondary" size="small"
                                                                                        class="rounded-0" @click="
                                                                                            removeColumn(index, c, r, co)
                                                                                            " />
                                                                                    <Button icon="bi bi-floppy text-white" severity="secondary" size="small" class="rounded-0"
                                                                                        v-tooltip.top="'Kaydet'" @click="saveAsTemplate(column,route('saved-columns.store'))"/>
                                                                                </div>
                                                                            </div>
                                                                            <div class="column-elements bg-light"
                                                                                :class="`${column.settings.flexDirection.sm} ${column.settings.flexDirection.md} ${column.settings.flexDirection.lg} ${column.settings.flexDirection.xl}`">
                                                                                <draggable v-model="column.elements"
                                                                                    group="element" @start="drag = true"
                                                                                    @end="drag = false" handle=".drag-elem"
                                                                                    item-key="id" :class="{'pt-3':!props.useColumns}">
                                                                                    <template
                                                                                        #item="{ element: elem, index: e }">
                                                                                        <div
                                                                                            class="card overlay overflow-hidden m-4 shadow-none border-dark">
                                                                                            <div class="card-body p-4">
                                                                                                <div class="overlay-wrapper"
                                                                                                    v-html="elem.data.prevHtml">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div
                                                                                                class="overlay-layer bg-dark bg-opacity-25">
                                                                                                <Button icon="bi bi-pencil"
                                                                                                    severity="help"
                                                                                                    size="small" rounded
                                                                                                    @click="editElement(elem)" />
                                                                                                <Button
                                                                                                    icon="bi bi-arrows-move"
                                                                                                    severity="secondary"
                                                                                                    size="small" rounded
                                                                                                    class="ms-2 drag-elem" />
                                                                                                <Button icon="bi bi-copy"
                                                                                                    severity="warning"
                                                                                                    size="small" rounded
                                                                                                    class="ms-2" @click="
                                                                                                        cloneElement(
                                                                                                            index,
                                                                                                            c,
                                                                                                            r,
                                                                                                            co,
                                                                                                            e
                                                                                                        )
                                                                                                        " />
                                                                                                <Button icon="bi bi-trash"
                                                                                                    severity="danger"
                                                                                                    size="small" rounded
                                                                                                    class="ms-2" @click="
                                                                                                        removeElement(
                                                                                                            index,
                                                                                                            c,
                                                                                                            r,
                                                                                                            co,
                                                                                                            e
                                                                                                        )
                                                                                                        " />
                                                                                                <Button icon="bi bi-floppy text-white" severity="secondary" size="small" rounded class="ms-2"
                                                                                                    v-tooltip.top="'Kaydet'" @click="saveAsTemplate(elem,route('saved-elements.store'))"/>
                                                                                            </div>
                                                                                        </div>
                                                                                    </template>
                                                                                </draggable>

                                                                                <div class="p-5 bg-white border-top hstack gap-3">
                                                                                    <Button label="Element Ekle" severity="success" size="small" @click="openElementSelectDialog(column)" />
                                                                                    <Button label="Kayıtlı Element Ekle" severity="secondary" size="small" @click="addSavedTemplate('element',index,c,r,co)" />
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </template>
                                                            </draggable>

                                                            <div class="hstack gap-3 px-5" v-if="props.useColumns">
                                                                <Button label="Column Ekle" severity="secondary" size="small" @click="addColumn(row)"/>
                                                                <Button label="Kayıtlı Column Ekle" severity="secondary" size="small" @click="addSavedTemplate('column',index,c,r)"/>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </template>
                                            </draggable>

                                            <div class="hstack gap-3 p-5" v-if="props.useRows">
                                                <Button label="Row Ekle" severity="secondary" size="small" @click="addRow(container)"/>
                                                <Button label="Kayıtlı Row Ekle" severity="secondary" size="small" @click="addSavedTemplate('row',index,c)"/>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </draggable>

                            <div class="hstack gap-3 p-5" v-if="props.useContainers">
                                <Button label="Container Ekle" severity="primary" @click="addContainer(section)"/>
                                <Button label="Kayıtlı Container Ekle" severity="secondary" @click="addSavedTemplate('container',index)"/>
                            </div>

                        </div>
                    </div>
                </template>
            </draggable>
        </div>
        <div class="card-footer">
            <button type="button" class="btn btn-primary" @click="addSection(form)">
                Boş Section Ekle
            </button>
            <button type="button" class="btn btn-dark ms-2" @click="addSavedTemplate('section')">
                Kayıtlı Section Ekle
            </button>
        </div>
    </div>

    <div>
        <Dialog v-model:visible="dialogSectionSettingsVisible" modal maximizable header="SECTION SETTINGS"
            :style="{ width: '75vw' }" :breakpoints="{ '768px': '95vw' }" @hide="hideSectionSettings">
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
            <ColumnSettings :column="selectedColumn" :hide-settings="hideColumnSettings" :layout-mode="props.layoutMode"/>
        </Dialog>

        <Dialog v-model:visible="elemDialogVisible" modal maximizable header="ELEMENTS" :style="{ width: '75vw' }"
            :breakpoints="{ '768px': '95vw' }">
            <ElementSelect :on-select="elementSelected" :layout-mode="props.layoutMode" :product-layout-mode="props.productLayoutMode"/>
        </Dialog>

        <Dialog v-if="selectedElementType" v-model:visible="elemSelectedDialogVisible" modal maximizable @hide="
            selectedElementType = null;
        selectedElement = null;
        " header="ELEMENT EKLE" :style="{ width: '75vw' }" :breakpoints="{ '768px': '95vw' }">
            <ElementSelected :on-done="addOrUpdateElement" :elem-type="selectedElementType" :elem="selectedElement" />
        </Dialog>


        <Dialog v-model:visible="savedDialogVisible" modal @hide="savedSelected" header="KAYITLI ŞABLON EKLE" :style="{ width: '75vw' }" :breakpoints="{ '768px': '95vw' }">
            <SavedTemplates v-if="savedSelectedType" :on-select="savedSelected" :form="form" :template-type="savedSelectedType" :section-index="savedSelectedSectionIndex" :container-index="savedSelectedContainerIndex" :row-index="savedSelectedRowIndex" :column-index="savedSelectedColumnIndex"/>
        </Dialog>

        <Dialog v-model:visible="saveAsTemplateVisible" modal header="TEMPLATE ADI" :style="{ width: '300px' }">

            <div class="mb-3">
                <InputText class="w-100" v-model="templateNameForSave"/>
            </div>
            <button type="button" class="btn btn-primary btn-sm w-100" @click="saveTemplate">Kaydet</button>

        </Dialog>


    </div>

    <ConfirmDialog></ConfirmDialog>
</template>

<script setup>
import { ref, onMounted } from "vue";
import {usePage} from "@inertiajs/vue3";
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
    useSections:{
        type:Boolean,
        default:true
    },
    useContainers:{
        type:Boolean,
        default:true
    },
    useRows:{
        type:Boolean,
        default:true
    },
    useColumns:{
        type:Boolean,
        default:true
    },
    addSection:{
        type:Boolean,
        default:true
    },
    layoutMode:{
        type:Boolean,
        default:false
    },
    productLayoutMode:{
        type:Boolean,
        default:false
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
        cloneSectionElem.settings.id =
            "section-" + Math.floor(Math.random() * 100000);
        cloneSectionElem.containers.forEach((container) => {
            container.settings.id =
                "container-" + Math.floor(Math.random() * 10000000);
            container.rows.forEach((row) => {
                row.settings.id = "row-" + Math.floor(Math.random() * 10000000);
                row.columns.forEach((column) => {
                    column.settings.id = "column-" + Math.floor(Math.random() * 10000000);
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
        cloneContainerElem.settings.id =
            "container-" + Math.floor(Math.random() * 100000);
        cloneContainerElem.rows.forEach((row) => {
            row.settings.id = "row-" + Math.floor(Math.random() * 10000000);
            row.columns.forEach((column) => {
                column.settings.id = "column-" + Math.floor(Math.random() * 10000000);
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
        cloneRowElem.settings.id = "row-" + Math.floor(Math.random() * 10000000);
        cloneRowElem.columns.forEach((column) => {
            column.settings.id = "row-" + Math.floor(Math.random() * 10000000);
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
        cloneColumnElem.settings.id =
            "column-" + Math.floor(Math.random() * 10000000);

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

const addSavedTemplate = async (type,sectionIndex = null,containerIndex = null,rowIndex = null,columnIndex = null) => {

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

const saveAsTemplate = (template,route) => {

    saveAsTemplateVisible.value = true;
    templateItemForSave.value = template;
    templateRouteForSave.value = route;

}
const saveTemplate = () => {

    if(templateNameForSave.value == "") return;

    (async () => {
        const rawResponse = await fetch(templateRouteForSave.value, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': usePage().props.csrf_token
            },
            body: JSON.stringify({
                name:templateNameForSave.value,
                json_data:templateItemForSave.value,
            })
        });
        const response = await rawResponse.json();

        saveAsTemplateVisible.value = false;
        templateItemForSave.value = null;
        templateRouteForSave.value = "";
        templateNameForSave.value = "";
    })();

}


onMounted(() => {
    if( !props.useSections && props.addSection ){
        addSection(form.value);
    } 
});
</script>