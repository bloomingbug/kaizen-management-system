import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import VueSimpleContextMenu from "vue-simple-context-menu";
import Vue3Toastify from "vue3-toastify";

import "vue-simple-context-menu/dist/vue-simple-context-menu.css";
import "vue3-toastify/dist/index.css";
import "./bootstrap";

createInertiaApp({
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .mixin({
                methods: {
                    hasAnyPermission: function (permissions) {
                        let allPermissions = this.$page.props.auth.permissions;

                        let hasPermission = false;
                        permissions.forEach(function (item) {
                            if (allPermissions[item]) hasPermission = true;
                        });

                        return hasPermission;
                    },
                },
            })
            .component("vue-simple-context-menu", VueSimpleContextMenu)
            .use(Vue3Toastify)
            .use(plugin)
            .mount(el);
    },
});
