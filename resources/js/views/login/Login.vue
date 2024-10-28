<template>
    <!-- <div class="card p-fluid">
         <div class="p-fluid formgrid grid">
            <div class="field col-12 md:col-6">

            </div>

            <div class="field col-12 md:col-6">
                <div class="container">
                    <div class="row justify-content-center my-5">
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <form @submit.prevent="submitLogin">
                                        <div class="">

                                            <div class="mb-3">
                                                <label for="email" class="form-label">{{ $t('email') }}</label>
                                                <input v-model="loginForm.email" id="email" type="email"
                                                    class="form-control" required autofocus autocomplete="username">

                                                <div class="text-danger mt-1">
                                                    <div v-for="message in validationErrors?.email">
                                                        {{ message }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <label for="password" class="form-label">
                                                    {{ $t('password') }}
                                                </label>
                                                <input v-model="loginForm.password" id="password" type="password"
                                                    class="form-control" required autocomplete="current-password">

                                                <div class="text-danger-600 mt-1">
                                                    <div v-for="message in validationErrors?.password">
                                                        {{ message }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember"
                                                    v-model="loginForm.remember" id="flexCheckIndeterminate">
                                                <label class="form-check-label" for="flexCheckIndeterminate">
                                                    {{ $t('remember_me') }}
                                                </label>
                                            </div>


                                            <div class="flex items-center justify-end mt-4">
                                                <button class="btn btn-primary" :class="{ 'opacity-25': processing }"
                                                    :disabled="processing">
                                                    {{ $t('login') }}
                                                </button>
                                            </div>
                                        </div>
                                        <router-link :to="{ name: 'auth.forgot-password' }">{{
                                            $t('forgot_password') }}</router-link>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->


    <div id="main-wrapper" class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <div class="card border-0">
                    <div class="card-body p-0">
                        <div class="row no-gutters">
                            <div class="col-lg-6">
                                <div class="p-5">


                                    <div class="p-5 account-block2 "></div>
                                    <div class="mb-5">
                                        <h3 class="h4 font-weight-bold text-theme">{{ $t('login') }}</h3>
                                    </div>

                                    <h6 class="h5 mb-0">{{ $t('welcome_starter_title') }}</h6>
                                    <p class="text-muted mt-2 mb-5">Introdueix el teu email i adreça electrònica per
                                        accedir al panell d'administració.</p>

                                    <form @submit.prevent="submitLogin">

                                        <!-- Email -->
                                        <div class="form-group">
                                            <label for="email" class="form-label">{{ $t('email') }}</label>
                                            <input v-model="loginForm.email" id="email" type="email"
                                                class="form-control" required autofocus autocomplete="username">
                                            <!-- Validation Errors -->
                                            <div class="text-danger mt-1">
                                                <div v-for="message in validationErrors?.email">
                                                    {{ message }}
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Password -->
                                        <div class="form-group mb-5">
                                            <label for="password" class="form-label">
                                                {{ $t('password') }}
                                            </label>
                                            <input v-model="loginForm.password" id="password" type="password"
                                                class="form-control" required autocomplete="current-password">
                                            <!-- Validation Errors -->
                                            <div class="text-danger-600 mt-1">
                                                <div v-for="message in validationErrors?.password">
                                                    {{ message }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-end mt-4">
                                            <input class="form-check-input" type="checkbox" name="remember"
                                                v-model="loginForm.remember" id="flexCheckIndeterminate">
                                            <label class="form-check-label" for="flexCheckIndeterminate">
                                                {{ $t('remember_me') }}
                                            </label>
                                        </div>
                                        <!-- Buttons -->
                                        <div class="flex items-center justify-end mt-4">
                                            <button class="btn btn-primary" :class="{ 'opacity-25': processing }"
                                                :disabled="processing">
                                                {{ $t('login') }}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- imatge beneit -->
                            <div class="col-lg-6 d-none d-lg-inline-block">
                                <div class="account-block rounded-right"></div>
                            </div>
                        </div>
                    </div>
                    <!-- end card-body -->
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->
        </div>
        <!-- Row -->
    </div>

</template>

<script setup>

import useAuth from '@/composables/auth'

const { loginForm, validationErrors, processing, submitLogin } = useAuth();

</script>

<style>
body {
    background: #f6f9fc;
}

.account-block {
    padding: 0;
    background-image: url('/images/sanmartin.png');
    background-repeat: no-repeat;
    background-size: cover;
    height: 100%;
    position: relative;
}

.account-block2 {
    padding: 0;
    background-image: url('/images/images.png');
    background-repeat: no-repeat;
    background-size: contain;
    background-position: center;
    height: 100%;
    position: relative;
    min-height: 120px;
}


.account-block .overlay {
    -webkit-box-flex: 1;
    -ms-flex: 1;
    flex: 1;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: rgba(0, 0, 0, 0.4);
}

.account-block .account-testimonial {
    text-align: center;
    color: #fff;
    position: absolute;
    margin: 0 auto;
    padding: 0 1.75rem;
    bottom: 3rem;
    left: 0;
    right: 0;
}

.text-theme {
    color: #5369f8 !important;
}

.btn-theme {
    background-color: #5369f8;
    border-color: #5369f8;
    color: #fff;
}
</style>
