<template>

    <InputText v-if="props.option.option_type == 'input'" class="w-100" :class="{'p-invalid':props.errorClass}" :value="modelValue" @input="setNewValue($event.target.value)"/>
    <InputText v-if="props.option.option_type == 'vimeo'" class="w-100" :class="{'p-invalid':props.errorClass}" :value="modelValue" @input="setNewValue($event.target.value)"/>
    <InputText v-if="props.option.option_type == 'youtube'" class="w-100" :class="{'p-invalid':props.errorClass}" :value="modelValue" @input="setNewValue($event.target.value)"/>
    <InputNumber v-if="props.option.option_type == 'number'" :useGrouping="false" :class="{'p-invalid':props.errorClass}" :value="modelValue" @input="setNewValue($event.target.value)" />

    <div v-if="props.option.option_type == 'textarea'">
        <Textarea autoResize rows="1" cols="30" class="w-100" :class="{'p-invalid':props.errorClass}" :value="modelValue" @input="setNewValue($event.target.value)" />
    </div>
    
</template>

<script setup>

    import { ref } from 'vue';
    import InputText from "primevue/inputtext";
    import InputNumber from "primevue/inputnumber";
    import Textarea from 'primevue/textarea';
    import Dropdown from "primevue/dropdown"

    const props = defineProps({
        option:Object,
        modelValue:[String,Object,Number],
        errorClass:{
            type:Boolean,
            default:false
        }
    });

    const emit = defineEmits(['update:modelValue']);
    const setNewValue = (value) => {
        emit('update:modelValue',value)
    }

</script>