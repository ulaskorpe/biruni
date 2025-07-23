<template>
    <div id="iyzipay-checkout-form" class="responsive"></div>
    <div v-html="props.form_scripts"></div>
</template>

<script>
import GuestLayout from '../../Layouts/GuestLayout';
export default {
    layout:GuestLayout
}
</script>

<script setup>

    const props = defineProps({
        form_scripts:String
    });

</script>