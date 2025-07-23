<template>
<div>
    <ConfirmPopup :group="`publish-popup-${props.model.id}`">
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
    <button type="button" @click="confirmDialog($event)" class="btn btn-icon btn-sm btn-light-success"><i class="bi bi-play fs-3"></i></button>
</div>
</template>
<script setup>

import { useForm } from "@inertiajs/vue3";
import { useConfirm } from "primevue/useconfirm";
import ConfirmPopup from "primevue/confirmpopup";

const props = defineProps({
    uri: String,
    model:Object,
    message:{
        type:String,
        default:'Seçtiğiniz kayıt yayından kaldırılacak.'
    },
    deleteDone:{
        type:Function,
        required:false,
        default:function(){}
    }
});

const form = useForm({});

const deleteRecord = () => {
    form.put(props.uri,{
        preserveScroll: true,
        onSuccess: () => {
            props.deleteDone(props.model);
        }
    });
}

const confirm = useConfirm();

const confirmDialog = (event) => {
    confirm.require({
        group: `publish-popup-${props.model.id}`,
        target: event.currentTarget,
        message: props.message,
        header: 'Confirmation',
        icon: 'bi bi-exclamation-triangle-fill',
        rejectLabel: 'Vazgeç',
        acceptLabel: 'Evet, yayından kaldır!',
        acceptClass: 'p-button-info p-button-sm',
        accept: () => {
            deleteRecord();
        },
        reject: () => {
            //
        }
    });
};


</script>