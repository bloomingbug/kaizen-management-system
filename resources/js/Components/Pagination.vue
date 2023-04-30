<template>
    <nav aria-label="Pagination" class="mt-4">
        <ul :class="`pagination pagination-primary justify-content-${align}`">
            <li
                v-for="(link, index) in links"
                :key="index"
                :class="[
                    'page-item',
                    link.url === null ? 'disabled' : '',
                    link.active ? 'active' : '',
                ]"
            >
                <Link
                    class="page-link"
                    :href="link.url === null ? '#' : link.url"
                    preserve-scroll
                >
                    <span v-html="link.label"></span>
                </Link>
            </li>
        </ul>
    </nav>
</template>

<script>
import { Link } from "@inertiajs/vue3";

export default {
    name: "Pagination",

    props: {
        links: Array,
        align: {
            type: String,
            default: "end",
        },
    },

    components: {
        Link,
    },
};
</script>
