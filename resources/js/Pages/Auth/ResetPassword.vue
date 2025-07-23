<template>
    <Head>
        <title head-key="title">Reset Password!</title>
        <meta type="description" content="Please login to use app" head-key="description">
    </Head>

	<div class="d-flex align-items-center justify-content-center flex-root" id="kt_app_root">
		<div class="p-10 d-flex flex-column w-md-500px">

			<h1 class="text-dark mb-5 text-center">Yeni Şifre Oluştur</h1>
			
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
						<InputText v-model="form.email" type="email" class="w-100" autocomplete="email" placeholder="E-posta"/>
					</InputGroup>
				</div>

                <div class="mb-7">
					<InputGroup>
						<InputGroupAddon>
							<i class="bi bi-key"></i>
						</InputGroupAddon>
						<Password v-model="form.password" class="w-100" autocomplete="new-password" placeholder="Yeni şifreniz"/>
					</InputGroup>
				</div>

                <div class="mb-7">
					<InputGroup>
						<InputGroupAddon>
							<i class="bi bi-key"></i>
						</InputGroupAddon>
						<Password v-model="form.password_confirmation" class="w-100" :feedback="false" autocomplete="new-password" placeholder="Şifreniz tekrar"/>
					</InputGroup>
				</div>
				
				<button class="btn btn-primary w-100" type="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
					Gönder
				</button>

				<FormErrors :form="form" />

				<div v-if="props.flash?.type == 'error'" class="my-5 alert alert-danger">
					{{ props.flash.message }}
				</div>
				<div v-if="props.flash?.type == 'success'" class="my-5 alert alert-success">
					{{ props.flash.message }}
				</div>

				<Divider class="my-10"/>

				<Link :href="route('login')" class="btn btn-light w-100">Üye Girişi</Link>

				</form>
			</div>

			<div class="text-center mt-4">
				<a href="/" class="btn px-0"><i class="bi bi-arrow-left"></i> Siteye dön</a>
			</div>

		</div>
	</div>

</template>

<script>
import GuestLayout from '../../Layouts/GuestLayout';
export default {
    layout:GuestLayout
}
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
import FormErrors from '../../Components/FormErrors';
import InputGroup from 'primevue/inputgroup';
import Password from 'primevue/password';
import InputGroupAddon from 'primevue/inputgroupaddon';
import Divider from 'primevue/divider';

const props = defineProps({
    email: String,
    token: String,
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>