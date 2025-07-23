<template>
    
<!--begin::Sidebar-->
<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">

    <!--begin::Logo-->
    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        <!--begin::Logo image-->
        <Link href="/admin">
            <img alt="Logo" :src="$page.props.settings.logo.main.original_url" class="h-25px app-sidebar-logo-default" v-if="$page.props.settings.logo && $page.props.settings.logo.mobile && $page.props.settings.logo.mobile.original_url"/>
        </Link>
        <!--end::Logo image-->
        <!--begin::Sidebar toggle-->
        <div
            id="kt_app_sidebar_toggle"
            class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary h-30px w-30px position-absolute top-50 start-100 translate-middle rotate active"
            data-kt-toggle="true"
            data-kt-toggle-state="active"
            data-kt-toggle-target="body"
            data-kt-toggle-name="app-sidebar-minimize"
            >
            <i class="bi bi-arrow-left fs-3 rotate-180"></i>
        </div>
        <!--end::Sidebar toggle-->
    </div>
    <!--end::Logo-->

    <SidebarMenu v-if="$page.props.auth.user.is_admin"/>
    <SidebarMenuUser v-if="!$page.props.auth.user.is_admin"/>
    
    <!--begin::Footer-->
    <div class="app-sidebar-footer flex-column-auto pt-2 pb-6 px-6" id="kt_app_sidebar_footer">
        
    </div>
    <!--end::Footer-->

    </div>
<!--end::Sidebar-->

</template>
<script setup>
import SidebarMenu from "./SidebarMenu";
import SidebarMenuUser from "./SidebarMenuUser";
</script>