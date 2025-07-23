<script setup>

    import { onBeforeMount } from 'vue';
    import InputText from 'primevue/inputtext';

    const props = defineProps({
        modelValue:Object,
    });

    const emit = defineEmits(['update:modelValue']);

</script>

<template>
    <InputText v-model="props.modelValue" class="w-100" />
</template>
