<template>
    <ConfirmPopup :group="`delete-popup-${props.model.id}`">
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
    <Button icon="bi bi-trash text-danger" severity="danger" text rounded @click="confirmDialog($event)" class="ms-2" />
</template>
<script setup>

import { useForm } from "@inertiajs/vue3";
import { useConfirm } from "primevue/useconfirm";
import ConfirmPopup from "primevue/confirmpopup";
import Button from 'primevue/button';

const props = defineProps({
    uri: String,
    model:Object,
    message:{
        type:String,
        default:'Seçtiğiniz kayıt çöp kutusuna taşınacak.'
    },
    deleteDone:{
        type:Function,
        required:false,
        default:function(){}
    }
});

const form = useForm({});

const deleteRecord = () => {
    form.delete(props.uri,{
        preserveScroll: true,
        onSuccess: () => {
            props.deleteDone(props.model);
        }
    });
}

const confirm = useConfirm();

const confirmDialog = (event) => {
    confirm.require({
        group: `delete-popup-${props.model.id}`,
        target: event.currentTarget,
        message: props.message,
        header: 'Confirmation',
        icon: 'bi bi-exclamation-triangle-fill',
        rejectLabel: 'Vazgeç',
        acceptLabel: 'Evet, Sil',
        acceptClass: 'p-button-danger p-button-sm',
        accept: () => {
            deleteRecord();
        },
        reject: () => {
            //
        }
    });
};


</script>