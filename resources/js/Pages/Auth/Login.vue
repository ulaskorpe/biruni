<template>
  <Head>
    <title head-key="title">Login!</title>
    <meta
      type="description"
      content="Please login to use app"
      head-key="description"
    />
  </Head>

  <div class="d-flex align-items-center justify-content-center flex-root" id="kt_app_root">
    <div class="p-10 d-flex flex-column w-md-500px">

      <h1 class="text-dark mb-5 text-center">Üye Girişi</h1>

      <div class="bg-body p-10 rounded-4 w-100">
        <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" @submit.prevent="submit">
          <div class="text-center">
            <div class="text-gray-500 fw-semibold fs-6" v-if="$page.props.settings.logo.main">
              <img :src="$page.props.settings.logo.main.original_url" class="img-fluid mw-200px" v-if="$page.props.settings.logo.main.original_url">
            </div>
          </div>
          <Divider class="my-10"/>
          <div class="mb-7">
            <InputGroup>
                <InputGroupAddon>
                    <i class="bi bi-envelope"></i>
                </InputGroupAddon>
                <InputText v-model="form.email" type="email" class="w-100" placeholder="E-posta"/>
            </InputGroup>
          </div>
          <div class="mb-3">
            <InputGroup>
                <InputGroupAddon>
                    <i class="bi bi-key"></i>
                </InputGroupAddon>
                <Password v-model="form.password" :feedback="false" class="w-100" placeholder="Şifre"/>
            </InputGroup>
          </div>
          <div class="d-flex justify-content-end fs-base fw-semibold mb-8">
            <Link v-if="canResetPassword" :href="route('password.request')" class="link-primary">Şifremi Unuttum</Link>
          </div>
          
          <button class="btn btn-primary w-100" type="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Giriş Yap</button>

          <FormErrors :form="form" />

          <div v-if="props.flash?.type == 'error'" class="my-5 alert alert-danger">
            {{ props.flash.message }}
          </div>
          <div v-if="props.flash?.type == 'success'" class="my-5 alert alert-success">
            {{ props.flash.message }}
          </div>

          <Divider class="my-10"/>

          <Link :href="route('register')" class="btn btn-light w-100">Üyelik Başvurusu</Link>

        </form>
      </div>

      <div class="text-center mt-4">
				<a href="/" class="btn px-0"><i class="bi bi-arrow-left"></i> Siteye dön</a>
			</div>

    </div>
  </div>
</template>

<script>
import GuestLayout from "../../Layouts/GuestLayout";
export default {
  layout: GuestLayout,
};
</script>

<style>
body {
  background-image: url("/dmn/media/auth/bg10.jpeg");
}

[data-bs-theme="dark"] body {
  background-image: url("/dmn/media/auth/bg10-dark.jpeg");
}
</style>

<script setup>
import { useForm, Link } from "@inertiajs/vue3";
import InputText from 'primevue/inputtext';
import Password from 'primevue/password';
import FormErrors from '../../Components/FormErrors';
import InputGroup from 'primevue/inputgroup';
import InputGroupAddon from 'primevue/inputgroupaddon';
import Divider from 'primevue/divider';

const props = defineProps({
  canResetPassword: Boolean,
  status: String,
  redirect:String,
  flash:Object
});

const form = useForm({
  email: "",
  password: "",
});

const submit = () => {
  form.post(route("login",{redirect:props.redirect}), {
    onFinish: () => form.reset("password"),
  });
};
</script>