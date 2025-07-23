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

          <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
            <span class="menu-link">
              <span class="menu-icon"><i class="bi bi-buildings fs-2"></i></span>
              <span class="menu-title">Kurumsal</span>
              <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-accordion">
              <div class="menu-item p-0">
                <Link class="menu-link ps-10 py-2" :href="route('roles.index')" :only="['flash','roles']">
                  <span class="menu-title">Rol Yönetimi</span>
                </Link>
              </div>
              <div class="menu-item p-0">
                <Link class="menu-link ps-10 py-2" :href="route('users.index')" :only="['flash','users','filters']">
                  <span class="menu-title">Kullanıcı Yönetimi</span>
                </Link>
              </div>
              <div class="h-10px"></div>
            </div>
          </div>

          <div class="menu-item">
            <Link class="menu-link" :href="route('medias.index')" :only="['flash','medias']">
              <span class="menu-icon"><i class="bi bi-images fs-2"></i></span>
              <span class="menu-title">Medya Kütüphanesi</span>
            </Link>
          </div>


          <div class="menu-item pt-5">
            <div class="menu-content">
              <span class="menu-heading fw-bold text-uppercase fs-7">SİTE YÖNETİMİ</span>
            </div>
          </div>

          <div data-kt-menu-trigger="click" class="menu-item menu-accordion" v-for="(ctype,c) in $page.props.contentTypes" :key="c">
            <span class="menu-link">
              <span class="menu-icon"><i class="bi bi-back fs-2"></i></span>
              <span class="menu-title">{{ ctype.name }}</span>
              <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-accordion">
              <div class="menu-item p-0">
                <Link class="menu-link ps-10 py-2" :href="route('contents.create',{contentType:ctype.id,language:$page.props.current_language})">
                  <span class="menu-title">Yeni Ekle</span>
                </Link>
              </div>
              <div class="menu-item p-0">
                <Link class="menu-link ps-10 py-2" :href="route('contents.index',{contentType:ctype.id,language:$page.props.current_language})" :only="['flash','contents','content_type','queryParams','filters']">
                  <span class="menu-title">İçerik Listesi</span>
                </Link>
              </div>
              <div class="menu-item p-0" v-if="ctype.has_category">
                <Link class="menu-link ps-10 py-2" :href="route('content-categories.index',{contentType:ctype.id,language:$page.props.current_language})" :only="['flash','categories','content_type','queryParams','filters']">
                  <span class="menu-title">Kategoriler</span>
                </Link>
              </div>
              <div class="h-10px"></div>
            </div>
          </div>

          <div class="menu-item">
            <Link class="menu-link" :href="route('sliders.index')" :only="['flash','sliders']">
              <span class="menu-icon"><i class="bi bi-images fs-2"></i></span>
              <span class="menu-title">Slider Yönetimi</span>
            </Link>
          </div>

          <div class="menu-item">
            <Link class="menu-link" :href="route('menus.index',{language:$page.props.current_language})" :only="['flash','menus']">
              <span class="menu-icon"><i class="bi bi-menu-down fs-2"></i></span>
              <span class="menu-title">Menü Yönetimi</span>
            </Link>
          </div>

          <div class="menu-item">
            <Link class="menu-link" :href="route('forms.index')" :only="['flash','forms']">
              <span class="menu-icon"><i class="bi bi-textarea-resize fs-2"></i></span>
              <span class="menu-title">Form Yönetimi</span>
            </Link>
          </div>

          <div class="menu-item">
            <Link class="menu-link" :href="route('design-templates.index')" :only="['flash','templates']">
              <span class="menu-icon"><i class="bi bi-textarea-resize fs-2"></i></span>
              <span class="menu-title">İçerik Şablonları</span>
            </Link>
          </div>

          <div class="menu-item">
            <Link class="menu-link" :href="route('tags.index',{language:$page.props.current_language})" :only="['flash','tags']">
              <span class="menu-icon"><i class="bi bi-tags fs-2"></i></span>
              <span class="menu-title">Etiket Yönetimi</span>
            </Link>
          </div>

          <div class="menu-item pt-5">
            <div class="menu-content">
              <span class="menu-heading fw-bold text-uppercase fs-7">REKLAM YÖNETİMİ</span>
            </div>
          </div>

          <div class="menu-item">
            <Link class="menu-link" :href="route('commercial-ad-areas.index')" :only="['flash','commercial_ad_areas']">
              <span class="menu-icon"><i class="bi bi-textarea-resize fs-2"></i></span>
              <span class="menu-title">Reklam Grupları</span>
            </Link>
          </div>

          <div class="menu-item">
            <Link class="menu-link" :href="route('commercial-ads.index',{language:$page.props.current_language})" :only="['flash','commercial_ads','filters']">
              <span class="menu-icon"><i class="bi bi-tags fs-2"></i></span>
              <span class="menu-title">Reklamlar</span>
            </Link>
          </div>

          <div class="menu-item pt-5">
            <div class="menu-content">
              <span class="menu-heading fw-bold text-uppercase fs-7">GELİŞMİŞ</span>
            </div>
          </div>

          <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
            <span class="menu-link">
              <span class="menu-icon"><i class="bi bi-gear fs-2"></i></span>
              <span class="menu-title">Site Yönetimi</span>
              <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-accordion">
              <div class="menu-item p-0">
                <Link class="menu-link ps-10 py-2" :href="route('content-types.index',{language:$page.props.current_language})" :only="['flash','content_types']">
                  <span class="menu-title">İçerik Tipleri</span>
                </Link>
              </div>
              <div class="menu-item p-0">
                <Link class="menu-link ps-10 py-2" :href="route('content-attributes.index',{language:$page.props.current_language})" :only="['flash','content_attributes']">
                  <span class="menu-title">İçerik Tipi Seçenekleri</span>
                </Link>
              </div>
              <div class="menu-item p-0">
                <Link class="menu-link ps-10 py-2" :href="route('sidebars.index')" :only="['sidebars','flash']">
                  <span class="menu-title">Sidebar Yönetimi</span>
                </Link>
              </div>
              <div class="menu-item p-0">
                <Link class="menu-link ps-10 py-2" :href="route('layouts.index')" :only="['layouts','flash']">
                  <span class="menu-title">İçerik Layout Yönetimi</span>
                </Link>
              </div>
              <div class="menu-item p-0">
                <Link class="menu-link ps-10 py-2" :href="route('header-layouts.index')" :only="['headerLayouts','flash']">
                  <span class="menu-title">Header Layout Yönetimi</span>
                </Link>
              </div>
              <div class="menu-item p-0">
                <Link class="menu-link ps-10 py-2" :href="route('card-layouts.index')" :only="['cardLayouts','flash']">
                  <span class="menu-title">Widget Card Layout Yönetimi</span>
                </Link>
              </div>
              <div class="h-10px"></div>
            </div>
          </div>

          <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
            <span class="menu-link">
              <span class="menu-icon"><i class="bi bi-gear fs-2"></i></span>
              <span class="menu-title">Ayarlar</span>
              <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-accordion">
              <div class="menu-item p-0">
                <Link class="menu-link ps-10 py-2" :href="route('settings.index')" :only="['flash','settings']">
                  <span class="menu-title">Site Ayarları</span>
                </Link>
              </div>
              <div class="menu-item p-0">
                <Link class="menu-link ps-10 py-2" :href="route('email-contents.index')" :only="['flash','emails']">
                  <span class="menu-title">E-Posta Şablonları</span>
                </Link>
              </div>
              <div class="h-10px"></div>
            </div>
          </div>

          <div class="menu-item">
            <Link class="menu-link" :href="route('links.index')" :only="['flash', 'links']">
              <span class="menu-icon"><i class="bi bi-link fs-2"></i></span>
              <span class="menu-title">URL Yönetimi</span>
            </Link>
          </div>

          <div class="menu-item">
            <Link class="menu-link" :href="route('redirect-uris.index')" :only="['flash', 'redirect_uris']">
              <span class="menu-icon"><i class="bi bi-box-arrow-up-right fs-2"></i></span>
              <span class="menu-title">Yönlendirme Kuralları</span>
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