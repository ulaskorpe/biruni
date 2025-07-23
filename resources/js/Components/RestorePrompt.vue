<template>
    <ConfirmPopup :group="`restore-popup-${props.model.id}`">
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
    <Button icon="bi bi-arrow-clockwise text-info" severity="info" text rounded @click="confirmDialog($event)" class="ms-2" />
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
        default:'Seçtiğiniz kayıt geri alınacak.'
    },
    restoreDone:{
        type:Function,
        required:false,
        default:function(){}
    }
});

const form = useForm({});

const restoreRecord = () => {
    form.put(props.uri,{
        preserveScroll: true,
        onSuccess: () => {
            props.restoreDone(props.model);
        }
    });
}

const confirm = useConfirm();

const confirmDialog = (event) => {
    confirm.require({
        group: `restore-popup-${props.model.id}`,
        target: event.currentTarget,
        message: props.message,
        header: 'Confirmation',
        icon: 'bi bi-exclamation-triangle-fill',
        rejectLabel: 'Vazgeç',
        acceptLabel: 'Evet, Geri al',
        acceptClass: 'p-button-info p-button-sm',
        accept: () => {
            restoreRecord();
        },
        reject: () => {
            //
        }
    });
};


</script>