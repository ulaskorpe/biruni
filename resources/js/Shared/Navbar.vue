<template>
    
    <div class="app-navbar flex-shrink-0">

        <div class="app-navbar-item ms-3 ms-md-4" id="kt_header_user_menu_toggle">
            <div class="cursor-pointer symbol symbol-35px"
                data-kt-menu-trigger="{default: 'hover', lg: 'hover'}"
                data-kt-menu-attach="parent"
                data-kt-menu-placement="bottom-end">
                <img class="" :src="`${$page.props.auth.user.avatar_preview_url}`" alt="" v-if="$page.props.auth.user.avatar_preview_url"/>
                <div class="symbol-label bg-dark" v-else><i class="bi bi-person fs-1 text-white"></i></div>
            </div>
            <UserAccountMenu />
        </div>

        <div class="app-navbar-item d-lg-none ms-3 me-n3" title="Show header menu">
            <div class="btn btn-flex btn-icon w-30px h-30px" id="kt_app_header_menu_toggle">
                <i class="bi bi-list fs-1 p-0"></i>
            </div>
        </div>

    </div>

</template>

<script setup>
import UserAccountMenu from "./UserAccountMenu";
</script>