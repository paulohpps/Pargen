<script setup>
import { Link, usePage } from '@inertiajs/vue3';

</script>
<template>
    <nav class="navbar navbar-layout fixed-top">
        <div class="container-fluid ">
            <i class="fa-solid fa-flask fa-2xl"></i>
            <img src="../../img/logo.jpg" width="130" height="45" alt="Logo" />
            <div class="dropdown">
                <label class="dropdown-toggle cursor-pointer" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <label class="me-2 user-select-none">{{ usePage().props.auth.user.username }}</label>
                    <i class="fa-solid fa-user fa-xl"
                        :class="usePage().props.auth.user.tipo_usuario === 0 ? 'fa-user' : 'fa-user-tie'"></i>
                </label>
                <ul class="dropdown-menu dropdown-menu-end dropdown-user">
                    <li>
                        <Link href="/dashboard/conta" class="dropdown-item">Atualizar senha</Link>
                    </li>
                    <li>
                        <Link class="dropdown-item" href="/logout">Sair</Link>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>
