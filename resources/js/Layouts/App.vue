<template>
    <Sidebar />

    <div id="main">
        <header class="mb-3">
            <a
                href="#"
                class="burger-btn d-block d-xl-none"
                @click.prevent="openSidebar"
            >
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>

        <slot />

        <Footer />
    </div>
</template>

<script>
import { Head } from "@inertiajs/vue3";
import Footer from "../Components/Footer.vue";
import Sidebar from "../Components/Sidebar.vue";

export default {
    name: "LayoutApp",

    components: {
        Head,
        Sidebar,
        Footer,
    },

    setup(props) {
        const openSidebar = () => {
            if (
                !document.getElementById("sidebar").classList.contains("active")
            ) {
                document.getElementById("sidebar").classList.add("active");
            }
        };

        return {
            openSidebar,
        };
    },
};
</script>

<style>
/* Scrollbar minimalis */
::-webkit-scrollbar {
    width: 0.3rem;
}
::-webkit-scrollbar-track {
    background: #f1f1f1;
}
::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 50rem;
}

/* Handle Library in Dark Mode */
body.theme-dark ul.vue-simple-context-menu {
    padding-left: 0;
}

.swal2-actions button.swal2-styled {
    margin-left: 0.25rem;
    margin-right: 0.25rem;
}

body.theme-dark .vue-simple-context-menu {
    background-color: #1e1e2d;
    color: #fff;
    box-shadow: 0 3px 6px 0 rgba(35, 35, 35, 0.4);
}

body.theme-dark .vue-simple-context-menu__item {
    color: #ffffff;
}

.vue-simple-context-menu__item:hover {
    background-color: #435ebe;
    color: #fff;
}
</style>
