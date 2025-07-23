<template>
    <slot />

</template>
<script setup>
	
	import { onBeforeMount,onUpdated } from 'vue';

	const props = defineProps({
		flash:Object
	});


	onBeforeMount(() => {
		document.querySelector("body").classList.remove('app-default');
		document.querySelector("body").classList.add('app-blank','bgi-size-cover','bgi-attachment-fixed','bgi-position-center');
	});

	onUpdated(() => {
		
	});

</script>
