<script setup>

    import { ref,onBeforeMount } from 'vue';
    import Editor from '@tinymce/tinymce-vue';
    import PopupMediaLibrary from "../Pages/MediaLibrary/PopupMediaLibrary";

    const props = defineProps({
        modelValue:[String,Object,Number],
        fullMode:{
            type:Boolean,
            default:false
        }
    });

    const emit = defineEmits(['update:modelValue']);
    const handleChange = (editor) => {
        emit('update:modelValue',editor.level.content)
    }

    const randId = Math.floor(Math.random() * 100000);
    const linkList = ref([]);

    const fetchLinkList = () => linkList.value;

    const tinyOptionsFullMode = ref({
        //menubar: false,
        content_css: '/css/app.css',
        relative_urls: false,
        plugins: [
            'advlist','autolink', 'code', 'emoticons',
            'lists','link','image','charmap','preview','anchor','searchreplace','visualblocks',
            'fullscreen','media','table','help','wordcount', 'powerpaste', 'tableofcontents',
        ],
        toolbar:'undo redo | styles | bold italic forecolor backcolor | \
            link emoticons image| \
            alignleft aligncenter alignright alignjustify | \
            numlist bullist outdent indent | removeformat | code table tableofcontents fullscreen',
        style_formats: [
            { title: 'Headings', items: [
                { title: 'Heading 2', format: 'h2' },
                { title: 'Heading 3', format: 'h3' },
                { title: 'Heading 4', format: 'h4' },
                { title: 'Heading 5', format: 'h5' },
                { title: 'Heading 6', format: 'h6' }
            ]},
            { title: 'Inline', items: [
                { title: 'Bold', format: 'bold' },
                { title: 'Italic', format: 'italic' },
                { title: 'Underline', format: 'underline' },
                { title: 'Strikethrough', format: 'strikethrough' },
                { title: 'Superscript', format: 'superscript' },
                { title: 'Subscript', format: 'subscript' },
                { title: 'Code', format: 'code' }
            ]},
            { title: 'Blocks', items: [
                { title: 'Paragraph', format: 'p' },
                { title: 'Blockquote', format: 'blockquote' },
                { title: 'Div', format: 'div' },
                { title: 'Pre', format: 'pre' }
            ]},
            { title: 'Align', items: [
                { title: 'Left', format: 'alignleft' },
                { title: 'Center', format: 'aligncenter' },
                { title: 'Right', format: 'alignright' },
                { title: 'Justify', format: 'alignjustify' }
            ]}
        ],
        powerpaste_allow_local_images: false,
        powerpaste_word_import: 'prompt',
        powerpaste_html_import: 'prompt',
        link_rel_list: [
            { title: 'None', value: '' },
            { title: 'No Opener', value: 'noreferrer' },
            { title: 'No Referrer', value: 'noreferrer' },
            { title: 'No Follow', value: 'nofollow' },
            { title: 'No Referrer & Follow', value: 'noreferrer nofollow' },
        ],
        link_list: (success) => {
            const links = fetchLinkList();
            success(links);
        },
        license_key:"gpl",
        skin:"tinymce-5"
    });

    const tinyOptions = ref({
        menubar: false,
        content_css:["/css/app.css"],
        relative_urls: false,
        plugins: ['emoticons','lists','link','image','charmap','preview','anchor','searchreplace','visualblocks','wordcount', 'powerpaste'
        ],
        toolbar:'undo redo | blocks | bold italic forecolor backcolor | link emoticons | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | removeformat',
        block_formats: 'Paragraph=p; Header 2=h2; Header 3=h3; Header 4=h4; Header 5=h5; Header 6=h6; Div=div',
        powerpaste_allow_local_images: false,
        powerpaste_word_import: 'prompt',
        powerpaste_html_import: 'prompt',
        link_rel_list: [
            { title: 'None', value: '' },
            { title: 'No Opener', value: 'noreferrer' },
            { title: 'No Referrer', value: 'noreferrer' },
            { title: 'No Follow', value: 'nofollow' },
            { title: 'No Referrer & Follow', value: 'noreferrer nofollow' },
        ],
        license_key:"gpl",
        height : 150,
        skin:"tinymce-5"
    });

    const insertMedia = (media) => {
        const editor = tinymce.get('tinymce-'+randId);
        editor.insertContent(`<img src="${media.original_url}" alt="${media.name}" width="${media.custom_properties.width}" height="${media.custom_properties.height}" class="img-fluid"/>`);
    }

    onBeforeMount(() => {
        fetch(route('fetch.links'),{
        headers: {
            'Accept': 'application/json',
        }
        }).then(function (response) {
            return response.json();
        }).then((json) => {

            const sortedData = Object.values(json).sort((a, b) => {
                const titleA = a.title;
                const titleB = b.title;
                if (titleA < titleB) return -1;
                if (titleA > titleB) return 1;
                return 0;
            });

            linkList.value = sortedData;
        });
    });

</script>

<template>
    <div class="vstack gap-3">
        <div v-if="props.fullMode">
            <PopupMediaLibrary :on-select="insertMedia" :button-text="'Kütüphane\'den Görsel Ekle'" :mime-type="'image/'" :key="randId"/>
        </div>
        <div>
            <Editor 
                :id="`tinymce-${randId}`"
                @change="handleChange" 
                api-key="no-api-key" 
                tinymce-script-src="/js/tinymce/tinymce.min.js" 
                :initial-value=modelValue 
                model-events="change" 
                :init="props.fullMode ? tinyOptionsFullMode : tinyOptions"
            />
        </div>
    </div>
</template>
