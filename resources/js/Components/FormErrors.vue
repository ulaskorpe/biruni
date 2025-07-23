<script setup>
import { computed } from "vue";


const props = defineProps({
    form:Object
});

const error_count = computed(() => Object.keys(props.form.errors).length);;

</script>

<template>
    <div class="mt-10 alert alert-danger" v-if="error_count > 0">
        <ul class="list-unstyled mb-0">
            <li v-for="(error,e) in props.form.errors" :key="`form-error-${e}`">{{ error }}</li>
        </ul>
    </div>
</template>
