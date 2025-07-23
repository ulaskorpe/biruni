<template>
    
    <div>
        <Dialog v-model:visible="dialogVisible" modal @hide="props.onUpdateDone" header="Rol Güncelle" :style="{ width: '50vw' }" :breakpoints="{ '960px': '75vw', '641px': '95vw' }">
            <form @submit.prevent="update">

                <div class="row align-items-center">
                    <label class="col-md-6 form-label">İSİM</label>
                    <div class="col-md-6">
                        <InputText v-model="form.view_name" class="w-100" :class="{'p-invalid':form.errors.view_name}"/>
                    </div>
                </div>

                <Divider />

                <div class="row align-items-center mb-10">
                    <label class="col-md-6 form-label">AÇIKLAMA</label>
                    <div class="col-md-6">
                        <Textarea autoResize rows="1" cols="30" class="w-100" v-model="form.description" />
                    </div>
                </div>
                
                <h4 class="text-muted">Header Scripts</h4>
                <Divider class="mb-10"/>
                <div v-for="(group,g) in permissionGroups" :key="`permission-group-${g}`">

                    <div class="row align-items-center">
                        <label class="col-md-6 form-label">{{ group.name }}</label>
                        <div class="col-md-6">
                            <div class="hstack gap-4 flex-wrap">
                                <div class="flex align-items-center" v-for="(permission,p) in group.permissions" :key="`permission-${g}-${p}`">
                                    <Checkbox v-model="form.permission" :inputId="`permission-id-${g}-${p}`" name="permission" :value="permission.id" />
                                    <label :for="`permission-id-${g}-${p}`" class="ms-2">{{ permission.view_name }}</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <Divider />

                </div>

                <div class="mt-5">
                    <button type="submit" class="btn btn-primary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Kaydet</button>
                    <button type="button" class="btn btn-light ms-5" @click="cancel()">Vazgeç</button>
                </div>

            </form>
        </Dialog>
    </div>

</template>

<script setup>

import {ref,onMounted} from "vue";
import { useForm } from "@inertiajs/vue3";
import Dialog from "primevue/dialog";
import InputText from 'primevue/inputtext';
import Checkbox from 'primevue/checkbox';
import Textarea from 'primevue/textarea';
import Divider from "primevue/divider";

const props = defineProps({
    selectedRole:Object,
    onUpdateDone:{
        type:Function,
        required:true
    }
});

const dialogVisible = ref(true);
let permissionGroups = ref([]);

const form = useForm({
    view_name:props.selectedRole.view_name,
    description:props.selectedRole.description,
    permission:props.selectedRole.permissions.map((row) => row.id)
});

const cancel = () => {
    dialogVisible.value = false;
    props.onUpdateDone();
};

const update = () => {
    form.put(route('roles.update',props.selectedRole),{
        onSuccess: () => {
            form.reset();
            props.onUpdateDone();
        },
    });
}

const getPermissionGroups = () => {

    fetch(route('permission-groups.index'),{
        headers: {
            'Accept':'application/json',
        }
    }).then(function(response){
        return response.json();
    }).then((json) =>{
        permissionGroups.value = json;
    }) ;

}

onMounted(() => {
    getPermissionGroups();
});

</script>