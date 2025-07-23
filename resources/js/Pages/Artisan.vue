<template>
    <Head head-key="title" title="Artisan" />

    <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container  container-xxl d-flex flex-stack ">
            
            <div  class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Artisan
                </h1>
            </div>


        </div>
    </div>
	
    <div id="kt_app_content" class="app-content  flex-column-fluid">
        <div id="kt_app_content_container" class="app-container  container-xxl">
            <form @submit.prevent="commandSubmit">
                <div class="card mb-5 mb-xl-10">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <label class="col-lg-4 form-label text-uppercase">Command</label>
                            <div class="col-lg-8">
                                <div class="d-flex flex-column mb-5">
                                    <InputText v-model="form.command" class="w-100"/>
                                </div>
                                <button type="submit" class="btn btn-dark btn-sm" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Execute</button>
                            </div>
                        </div>
                    </div>
                </div>

                <code v-html="$page.props.redirect_data"></code>

            </form>
        </div>
    </div>

</template>

<script setup>

import InputText from "primevue/inputtext";
import {useForm} from "@inertiajs/vue3";

const form = useForm({
    command:""
});

const commandSubmit = () => {
    form.post(route('artisan.command'),{
        only:['redirect_data'],
        onSuccess:() => form.reset()
    });
}

</script>