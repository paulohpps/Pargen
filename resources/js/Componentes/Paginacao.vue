<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    links: Array,
})

</script>

<template>
    <nav v-if="links.length > 3">
        <ul class="pagination m-2">
            <li v-for="link in links" :key="link.label" class="page-item">
                <Link class="page-link" :href="link.url ?? ''" :class="{disable: !link.url, active: link.active}">
                    {{ link.label  }}
                </Link>
            </li>
        </ul>
    </nav>
</template>
