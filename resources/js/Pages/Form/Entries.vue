<template>
    <Head head-key="title" :title="`${props.form.name} Kayıtlar`" />

    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            
            <div  class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ props.form.name }} kayıtlar
                </h1>
            </div>

            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <Link :href="route('forms.index')" class="btn fw-bold btn-sm btn-secondary d-flex align-items-center">
                    <i class="bi bi-arrow-left fs-4"></i>
                    <span class="ms-1 lh-1">Geri</span>
                </Link>
            </div>

        </div>
    </div>
	
    <div id="kt_app_content" class="app-content  flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            
            <div class="card">
                <div class="card-header px-4">
                    <Filter :filters="props.filters" :uri="route('forms.show',props.form.id)" :has-export="true"/>
                </div>
                <div class="card-body p-0">

                    <DataTable :value="props.entries.data" stripedRows dataKey="id" tableStyle="min-width: 50rem">
                        <template #empty> Seçilen kriterlere uygun kayıt bulunamadı. </template>
                        <Column field="id" header="ID" headerStyle="width: 4rem"></Column>
                        <Column field="ip_address" header="IP"></Column>
                        <Column header="Tarih">
                            <template #body="{ data }">
                                <span>{{ formatDateToMask(data.created_at, true) }}</span>
                            </template>
                        </Column>
                        <Column v-for="(head,h) in props.form.json_data" :key="h">
                            <template #header>
                                {{ head.itemLabel }}
                            </template>
                            <template #body="{ data }">
                                {{ getHeadValue(data.json_data,head.itemInputName) }}
                            </template>
                        </Column>
                    </DataTable>

                </div>
                <div class="card-footer">
                    <Pagination :links="props.entries.links" :only="['entries','flash']"/>
                </div>
            </div>

        </div>

    </div>

</template>

<script setup>
import Pagination from "../../Components/Pagination";
import DataTable from "primevue/datatable";
import Column from 'primevue/column';
import Filter from "../../Components/Filter";

const props = defineProps({
    form:Object,
    entries:Object,
    filters:Object,
    queryParams:{
        type:Object,
        default:null
    }
});

const getHeadValue = (json_data,itemInputName) => {

    if( !Array.isArray(json_data) ){
        return "#NA#";
    }

    const op_value = json_data.find((x) => x.name === itemInputName);
    if( op_value ){
        return op_value.value;
    }
    return "NA";
}

const formatDateToMask = (date, withHour = false) => {
    var originalDate = new Date(date);
    var day = originalDate.getDate().toLocaleString().padStart(2, '0');
    var month = (originalDate.getMonth() + 1).toString().padStart(2, '0'); // Ay 0-11 arasında olduğu için +1 ekliyoruz.
    var year = originalDate.getFullYear();
    var hour = String(originalDate.getHours()).padStart(2, '0');
    var min = String(originalDate.getMinutes()).padStart(2, '0');
    var sec = String(originalDate.getSeconds()).padStart(2, '0');

    if( withHour ){
        return day + '.' + month + '.' + year + ' ' + hour + ':' + min + ':' + sec;
    }
    return day + '.' + month + '.' + year;
}

</script>