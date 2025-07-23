<script setup>
</script>

<template>

<div class="app-header-menu app-header-mobile-drawer align-items-stretch" 
    data-kt-drawer="true" data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}"
    data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="end"
    data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true"
    data-kt-swapper-mode="{default: 'append', lg: 'prepend'}"
    data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">

    <div class="menu menu-rounded menu-column menu-lg-row my-5 my-lg-0 align-items-stretch fw-semibold px-2 px-lg-0" id="kt_app_header_menu" data-kt-menu="true">

      <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion me-0 me-lg-2">
        <span class="menu-link">
          <span class="menu-icon"><i class="bi bi-patch-plus-fill fs-3"></i></span>
          <span class="menu-title">Yeni</span>
          <span class="menu-arrow d-lg-none"></span>
        </span>
        <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-lg-2 py-lg-4 w-lg-200px">
              
              <div class="menu-item" v-for="(ctype,c) in $page.props.contentTypes" :key="`nav-menu-${c}`">
                <Link class="menu-link" :href="route('contents.create',{contentType:ctype.id})">
                  <span class="menu-icon"><i class="bi bi-back"></i></span>
                  <span class="menu-title">{{ ctype.name }}</span>
                </Link>
              </div>

            </div>
        </div>

    </div>

  </div>

</template>