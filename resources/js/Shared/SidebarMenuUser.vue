<script setup>

</script>

<template>
  <!--begin::sidebar menu-->
  <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
    <!--begin::Menu wrapper-->
    <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper">
      <!--begin::Scroll wrapper-->
      <div
        id="kt_app_sidebar_menu_scroll"
        class="scroll-y my-5 mx-3"
        data-kt-scroll="true"
        data-kt-scroll-activate="true"
        data-kt-scroll-height="auto"
        data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
        data-kt-scroll-wrappers="#kt_app_sidebar_menu"
        data-kt-scroll-offset="5px"
        data-kt-scroll-save-state="true"
      >
        <!--begin::Menu-->
        <div
          class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6"
          id="#kt_app_sidebar_menu"
          data-kt-menu="true"
          data-kt-menu-expand="false"
        >

          <div class="menu-item">
            <Link class="menu-link" href="/admin">
              <span class="menu-icon"><i class="bi bi-speedometer2 fs-2"></i></span>
              <span class="menu-title">Dashboard</span>
            </Link>
          </div>


        </div>
        <!--end::Menu-->
      </div>
      <!--end::Scroll wrapper-->
    </div>
    <!--end::Menu wrapper-->
  </div>
  <!--end::sidebar menu-->
</template>