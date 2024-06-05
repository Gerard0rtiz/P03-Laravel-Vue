<template>
    <div class="container" style="padding-top: 150px;">
        <div class="row justify-content-center my-5">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm" style="background-color: #ede8db;">
                    <div class="card-body">
                        <form @submit.prevent="submitLogin">
                            <div class="">
                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">{{ $t('email') }}</label>
                                    <input v-model="loginForm.email" id="email" type="email" class="form-control" required autofocus autocomplete="username" style="background-color: #f0efec;">
                                    <!-- Validation Errors -->
                                    <div class="text-danger mt-1">
                                        <div v-for="message in validationErrors?.email">
                                            {{ message }}
                                        </div>
                                    </div>
                                </div>
                                <!-- Password -->
                                <div class="mb-4">
                                    <label for="password" class="form-label">
                                        {{ $t('password') }}
                                    </label>
                                    <input v-model="loginForm.password" id="password" type="password" class="form-control" required autocomplete="current-password" style="background-color: #f0efec;">
                                    <!-- Validation Errors -->
                                    <div class="text-danger-600 mt-1">
                                        <div v-for="message in validationErrors?.password">
                                            {{ message }}
                                        </div>
                                    </div>
                                </div>
                                <!-- Remember me -->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" v-model="loginForm.remember" id="flexCheckIndeterminate">
                                    <label class="form-check-label" for="flexCheckIndeterminate">
                                        {{ $t('remember_me') }}
                                    </label>
                                </div>

                                <!-- Buttons -->
                                <div class="flex items-center justify-end mt-4">
                                    <button class="btn login-btn" :class="{ 'opacity-25': processing }" :disabled="processing">
                                        {{ $t('login') }}
                                    </button>
                                </div>
                            </div>
                            <router-link :to="{name: 'auth.forgot-password'}">{{ $t('forgot_password')}}</router-link>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>

import useAuth from '@/composables/auth'
import { onMounted } from 'vue';

const { loginForm, validationErrors, processing, submitLogin } = useAuth();

onMounted(()=>{
    window.scrollTo(0, 0);
});
</script>

<style>

body{
    background-color: #f5f5f5 !important;
}

.login-btn{
    background-color: #053b28;
    color: #f1f1f1;
    margin-bottom: 15px;
}

.login-btn:hover{
    background-color: #04744d;
    color: #f1f1f1;
}

</style>