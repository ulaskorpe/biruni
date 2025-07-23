<template>
    <Head head-key="title" title="Email güncelle" />

    <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container  container-fluid d-flex flex-stack ">
            
            <div  class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Email güncelle: {{ props.email.name }}
                </h1>
            </div>

            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <Link :href="route('email-contents.index')" class="btn fw-bold btn-sm btn-secondary d-flex align-items-center me-2">
                    <i class="bi bi-arrow-left fs-4"></i>
                    <span class="ms-1 lh-1">geri</span>
                </Link>
            </div>

        </div>
    </div>
	
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid h-100">
            <form @submit.prevent="update" class="h-100">
                <div class="card h-100">
                    <div class="card-body position-relative">
                        <div id="emailEditorDiv" class="h-100">
                            <EmailEditor ref="emailEditor" @load="editorLoaded" @ready="editorReady"/>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn fw-bold btn-success ms-auto" type="submit">Kaydet</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</template>

<script setup>

import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { EmailEditor } from 'vue-email-editor';

const props = defineProps({
    email: Object
});

const form = useForm({
    content: props.email.content,
    admin_json: props.email.admin_json
});

const emailEditor = ref(null);

const editorLoaded = () => {
    emailEditor.value.editor.loadDesign(JSON.parse(JSON.stringify(props.email.admin_json)));
}

const editorReady = () => {

    let emailEditorDiv = document.getElementById('emailEditorDiv');
    document.querySelector('iframe').style.minHeight = emailEditorDiv.offsetHeight + "px";

}

const saveDesign = async () => {
    await new Promise(resolve => {
        if (emailEditor.value && emailEditor.value.editor) {
            emailEditor.value.editor.saveDesign((design) => {
                form.admin_json = design;
                console.log('design');
                resolve();
            });
        }
    });
};

const exportHtml = async () => {
    await new Promise(resolve => {
        if (emailEditor.value && emailEditor.value.editor) {
            emailEditor.value.editor.exportHtml((data) => {
                form.content = data.html;
                console.log('html');
                resolve();
            });
        }
    });
};

const submitForm = async () => {
    await new Promise(resolve => {
        form.put(route('email-contents.update', props.email), {
            preserveScroll: true,
            onSuccess: (page) => {

            }
        });
    });
};

const update = async () => {
    await saveDesign();
    await exportHtml();
    await submitForm();
};

</script>