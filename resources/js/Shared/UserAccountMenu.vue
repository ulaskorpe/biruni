<script setup></script>

<template>
<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold pt-4 fs-6 w-275px" data-kt-menu="true">
    <!--begin::Menu item-->
    <div class="menu-item px-3">
        <div class="menu-content d-flex align-items-center px-3">
            <!--begin::Avatar-->
            <div class="symbol symbol-50px me-5">
                <img class="rounded" :src="`${$page.props.auth.user.avatar_preview_url}`" alt="" v-if="$page.props.auth.user.avatar_preview_url"/>
                <div class="symbol-label" v-else><i class="bi bi-person fs-1"></i></div>
            </div>
            <!--end::Avatar-->
            <!--begin::Username-->
            <div class="d-flex flex-column">
                <div class="fw-bold d-flex align-items-center fs-5">
                    {{ $page.props.auth.user.name }}
                </div>
                <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">
                    {{ $page.props.auth.user.email }}
                </a>
            </div>
            <!--end::Username-->
        </div>
    </div>
    <!--end::Menu item-->
    <!--begin::Menu separator-->
    <div class="separator my-2"></div>
    <!--end::Menu separator-->
    <!--begin::Menu item-->
    <div class="menu-item px-5 my-1">
        <Link :href="route('my.index')" class="menu-link px-5">
            Profilim
        </Link>
    </div>
    <div class="menu-item p-5 bg-light">
        <div class="d-flex justify-content-end">
            <Link :href="route('logout')" class="btn btn-sm btn-secondary" method="post" as="button">Çıkış</Link>
        </div>
    </div>
    <!--end::Menu item-->
</div>
</template>