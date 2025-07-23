<template>
	
	<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
		<div class="app-page  flex-column flex-column-fluid " id="kt_app_page">
			
			<Header />

			<div class="app-wrapper  flex-column flex-row-fluid " id="kt_app_wrapper">

				<Sidebar />

				<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
					<div class="d-flex flex-column flex-column-fluid">

						<slot />

					</div>

					<Footer />

				</div>

			</div>
		</div>
	</div>

	<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
		<i class="ki-bi bi-arrow-up"></i>
	</div>

	<Toast />

</template>
<script setup>
	import { onMounted,onUpdated, onBeforeMount } from 'vue';
	import Footer from "../Shared/Footer";
	import Header from "../Shared/Header";
	import Sidebar from "../Shared/Sidebar";
	import Toast from 'primevue/toast';
	import { useToast } from "primevue/usetoast";

	const props = defineProps({
		flash:Object
	});

	const toast = useToast();

	onBeforeMount(() => {

	});

	onMounted(() => {
		KTMenu.init();
		//KTMenu.initHandlers();
		//KTAppSidebar.init();
		KTToggle.init();
		KTSticky.init();
		KTDrawer.init();
		KTScroll.init();
		KTScrolltop.init();
	});

	
	onUpdated(() => {
		if(props.flash){

			const flashTitle = {
				success:'Başarılı',
				error:'Hata',
				warning:'Uyarı',
				info:'Bilgi'
			};
			let flashType = props.flash.type ?? 'info';
			toast.add({ severity: flashType, summary: flashTitle[flashType], detail: props.flash.message, life: 10000 });

		}
	});
	

</script>