<template>
    <ConfirmPopup group="bulk-restore">
        <template #message="slotProps">

            <div class="d-flex align-items-center p-3">
                <i class="bi bi-exclamation-triangle-fill fs-2hx text-info me-4"></i>
                <div class="d-flex flex-column">
                    <h4 class="mb-1 text-info">Emin misiniz?</h4>
                    <span>{{ slotProps.message.message }}</span>
                </div>
            </div>

        </template>
    </ConfirmPopup>
    <button class="btn btn-light-info btn-icon btn-sm ms-2" type="button" @click="confirmDialog($event)"><i class="bi bi-arrow-clockwise fs-3 p-0"></i></button>
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
        default:'Seçtiğiniz kayıtlar geri alınacak.'
    },
    restoreDone:{
        type:Function,
        required:false,
        default:function(){}
    }
});

const form = useForm({
    items:[]
});

const restoreRecords = () => {
    form.transform((data) => ({
        ...data,
        items:props.items.map((row) => row.id)
    })).put(props.uri,{
        preserveScroll: true,
        onSuccess: () => {
            props.restoreDone();
        }
    });
}

const confirm = useConfirm();

const confirmDialog = (event) => {
    confirm.require({
        group: 'bulk-restore',
        target: event.currentTarget,
        message: props.message,
        header: 'Confirmation',
        icon: 'bi bi-exclamation-triangle-fill',
        rejectLabel: 'Vazgeç',
        acceptLabel: 'Evet, Geri al',
        acceptClass: 'p-button-info p-button-sm',
        accept: () => {
            restoreRecords();
        },
        reject: () => {
            //
        }
    });
};


</script>