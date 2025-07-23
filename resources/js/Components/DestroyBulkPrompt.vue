<template>
    <ConfirmPopup group="bulk-destroy">
        <template #message="slotProps">

            <div class="d-flex align-items-center p-3">
                <i class="bi bi-exclamation-triangle-fill fs-2hx text-danger me-4"></i>
                <div class="d-flex flex-column">
                    <h4 class="mb-1 text-danger">Emin misiniz?</h4>
                    <span>{{ slotProps.message.message }}</span>
                </div>
            </div>

        </template>
    </ConfirmPopup>
    <button class="btn btn-light-danger btn-icon btn-sm ms-2" type="button" @click="confirmDialog($event)"><i class="bi bi-trash fs-3 p-0"></i></button>
</template>
<script setup>

import { useForm } from "@inertiajs/vue3";
import { useConfirm } from "primevue/useconfirm";
import ConfirmPopup from "primevue/confirmpopup";

const props = defineProps({
    uri: String,
    items:Array,
    message:{
        type:String,
        default:'Seçtiğiniz kayıtlar tamamen silinecek. Bu işlem geri alınamaz.'
    },
    deleteDone:{
        type:Function,
        required:false,
        default:function(){}
    }
});

const form = useForm({
    items:[]
});

const deleteRecords = () => {
    form.transform((data) => ({
        ...data,
        items:props.items.map((row) => row.id)
    })).delete(props.uri,{
        preserveScroll: true,
        onSuccess: () => {
            props.deleteDone();
        }
    });
}

const confirm = useConfirm();

const confirmDialog = (event) => {
    confirm.require({
        group: 'bulk-destroy',
        target: event.currentTarget,
        message: props.message,
        header: 'Confirmation',
        icon: 'bi bi-exclamation-triangle-fill',
        rejectLabel: 'Vazgeç',
        acceptLabel: 'Evet, Sil',
        acceptClass: 'p-button-danger p-button-sm',
        accept: () => {
            deleteRecords();
        },
        reject: () => {
            //
        }
    });
};


</script>