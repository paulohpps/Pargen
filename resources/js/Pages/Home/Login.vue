<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import Loginlayout from '../../Layouts/Loginlayout.vue';
import FormError from '../../Componentes/Forms/FormError.vue';

const form = useForm({
    username: '',
    password: '',
});

function submit() {
    form.post("/login");
}
</script>
<template>
    <Loginlayout/>
    <div class="login-container">
        <div class="login-grid">
            <form @submit.prevent="submit" class="form">
                <div class="login-body shadow">
                    <h3 class="login-title">Login</h3>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" v-model="form.username" name="username" id="username" placeholder="name@example.com">
                        <label for="username">Username</label>
                        <FormError :message="form.errors.username" />
                    </div>
                    <div class="form-floating">
                        <input type="password" class="form-control mb-3" v-model="form.password" name="senha" id="senha" placeholder="Password">
                        <label for="senha">Senha</label>
                        <FormError :message="form.errors.password" />
                    </div>
                    <input class="btn btn-primary" type="submit" value="Login">
                </div>
            </form>
        </div>
    </div>
</template>


