<script setup>
import Menu from "./Menu"
import Navbar from "./Navbar"
</script>

<template>

<!--begin::Header-->
<div id="kt_app_header" class="app-header" data-kt-sticky="true" data-kt-sticky-activate="{default: true, lg: true}" data-kt-sticky-name="app-header-minimize" data-kt-sticky-offset="{default: '200px', lg: '0'}" data-kt-sticky-animation="false"  >
<!--begin::Header container-->
	<div class="app-container  container-fluid d-flex align-items-stretch justify-content-between " id="kt_app_header_container">
		<!--begin::Sidebar mobile toggle-->
		<div class="d-flex align-items-center d-lg-none ms-n3 me-1 me-md-2" title="Show sidebar menu">
			<div class="btn btn-icon btn-active-color-primary w-35px h-35px" id="kt_app_sidebar_mobile_toggle">
				<i class="bi bi-list p-0 fs-2 fs-md-1"></i>
			</div>
		</div>
		<!--end::Sidebar mobile toggle-->
		<!--begin::Mobile logo-->
		<div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
			<Link href="/admin" class="d-lg-none">
                <img alt="Logo" :src="$page.props.settings.logo.mobile.original_url" class="h-30px" v-if="$page.props.settings.logo && $page.props.settings.logo.mobile && $page.props.settings.logo.mobile.original_url"/>
            </Link>
		</div>
		<!--end::Mobile logo-->
		<!--begin::Header wrapper-->
		<div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1" id="kt_app_header_wrapper">
            <Menu />
            <Navbar />
		</div>
		<!--end::Header wrapper-->
	</div>
		<!--end::Header container-->
</div>
<!--end::Header-->

</template>