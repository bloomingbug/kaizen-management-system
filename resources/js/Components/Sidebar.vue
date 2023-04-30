<template>
    <div id="sidebar" class="active">
        <div class="sidebar-wrapper active">
            <div class="sidebar-header position-relative">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="logo">
                        <Link href="/">Kaizen</Link>
                    </div>
                    <div
                        class="theme-toggle d-flex gap-2 align-items-center mt-2"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink"
                            aria-hidden="true"
                            role="img"
                            class="iconify iconify--system-uicons"
                            width="20"
                            height="20"
                            preserveAspectRatio="xMidYMid meet"
                            viewBox="0 0 21 21"
                        >
                            <g
                                fill="none"
                                fill-rule="evenodd"
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path
                                    d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2"
                                    opacity=".3"
                                ></path>
                                <g transform="translate(-210 -1)">
                                    <path
                                        d="M220.5 2.5v2m6.5.5l-1.5 1.5"
                                    ></path>
                                    <circle cx="220.5" cy="11.5" r="4"></circle>
                                    <path
                                        d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2"
                                    ></path>
                                </g>
                            </g>
                        </svg>
                        <div class="form-check form-switch fs-6">
                            <input
                                class="form-check-input me-0"
                                type="checkbox"
                                @input="handleTheme"
                                id="toggle-dark"
                                v-model="theme"
                            />
                            <label class="form-check-label"></label>
                        </div>
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink"
                            aria-hidden="true"
                            role="img"
                            class="iconify iconify--mdi"
                            width="20"
                            height="20"
                            preserveAspectRatio="xMidYMid meet"
                            viewBox="0 0 24 24"
                        >
                            <path
                                fill="currentColor"
                                d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z"
                            ></path>
                        </svg>
                    </div>
                    <div class="sidebar-toggler x">
                        <a
                            href="#"
                            class="sidebar-hide d-xl-none d-block"
                            @click.prevent="closeSidebar"
                            ><i class="bi bi-x bi-middle"></i
                        ></a>
                    </div>
                </div>
            </div>
            <div class="sidebar-menu">
                <ul class="menu">
                    <li class="sidebar-title">Menu</li>
                    <li
                        class="sidebar-item"
                        :class="{
                            active: $page.url.startsWith('/admin/dashboard'),
                        }"
                    >
                        <Link href="/admin/dashboard" class="sidebar-link">
                            <i class="bi bi-grid-fill"></i>
                            <span>Dashboard</span>
                        </Link>
                    </li>

                    <li class="sidebar-title">Data</li>
                    <li
                        class="sidebar-item"
                        :class="{
                            active: $page.url.startsWith('/admin/kaizens'),
                        }"
                    >
                        <Link href="/admin/kaizens" class="sidebar-link">
                            <i class="fas fa-lightbulb"></i>
                            <span>Kaizen</span>
                        </Link>
                    </li>

                    <li class="sidebar-title">Master</li>
                    <li
                        class="sidebar-item"
                        :class="{
                            active: $page.url.startsWith('/admin/permissions'),
                        }"
                    >
                        <Link href="/admin/permissions" class="sidebar-link">
                            <i class="fas fa-cog"></i>
                            <span>Permissions</span>
                        </Link>
                    </li>
                    <li
                        class="sidebar-item"
                        :class="{
                            active: $page.url.startsWith('/admin/roles'),
                        }"
                    >
                        <Link href="/admin/roles" class="sidebar-link">
                            <i class="fas fa-toolbox"></i>
                            <span>Roles</span>
                        </Link>
                    </li>
                    <li
                        class="sidebar-item"
                        :class="{
                            active: $page.url.startsWith('/admin/users'),
                        }"
                    >
                        <Link href="/admin/users" class="sidebar-link">
                            <i class="fas fa-user"></i>
                            <span>Users</span>
                        </Link>
                    </li>
                    <li
                        class="sidebar-item"
                        :class="{
                            active: $page.url.startsWith('/admin/departements'),
                        }"
                    >
                        <Link href="/admin/departements" class="sidebar-link">
                            <i class="fas fa-building"></i>
                            <span>Departements</span>
                        </Link>
                    </li>
                    <li
                        class="sidebar-item"
                        :class="{
                            active: $page.url.startsWith('/admin/categories'),
                        }"
                    >
                        <Link href="/admin/categories" class="sidebar-link">
                            <i class="fas fa-shapes"></i>
                            <span>Category</span>
                        </Link>
                    </li>

                    <li class="sidebar-title">Logging</li>
                    <li
                        class="sidebar-item"
                        :class="{
                            active: $page.url.startsWith('/admin/log'),
                        }"
                    >
                        <a
                            href="/admin/log"
                            target="_blank"
                            title="Log Viewer"
                            class="sidebar-link"
                        >
                            <i class="fab fa-slack"></i>
                            <span>Log Viewer</span>
                        </a>
                    </li>

                    <hr />

                    <li class="sidebar-item mt-4">
                        <Link
                            href="/logout"
                            method="post"
                            role="button"
                            class="sidebar-link link-logout btn w-100"
                            as="button"
                        >
                            <i class="fas fa-sign-out-alt text-white"></i>
                            <span>Logout</span>
                        </Link>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";
import { onMounted } from "vue";

export default {
    name: "SidebarComponent",

    components: {
        Link,
    },

    setup() {
        onMounted(() => {
            if (localStorage.getItem("dark")) {
                if (localStorage.getItem("dark") === "true") {
                    document.body.classList.add("theme-dark");
                } else {
                    document.body.classList.add("theme-light");
                }
            } else {
                if (
                    window.matchMedia &&
                    window.matchMedia("(prefers-color-scheme:dark)").matches
                ) {
                    document.body.classList.add("theme-dark");
                } else {
                    document.body.classList.add("theme-light");
                }
            }

            if (weight.value < 1200) {
                document.getElementById("sidebar").classList.remove("active");
            }

            window.addEventListener("resize", () => {
                weight.value = window.innerWidth;
                if (weight.value < 1200) {
                    document
                        .getElementById("sidebar")
                        .classList.remove("active");
                } else {
                    document.getElementById("sidebar").classList.add("active");
                }
            });
        });

        const weight = ref(window.innerWidth);

        const theme = ref(
            localStorage.getItem("dark") === "true"
                ? true
                : false ||
                  (window.matchMedia &&
                      window.matchMedia("(prefers-color-scheme:dark)").matches)
                ? true
                : false
        );

        const handleTheme = () => {
            if (theme.value) {
                localStorage.setItem("dark", false);
                document.body.classList.remove("theme-dark");
                document.body.classList.add("theme-light");
            } else {
                localStorage.setItem("dark", true);
                document.body.classList.remove("theme-light");
                document.body.classList.add("theme-dark");
            }
        };

        const closeSidebar = () => {
            if (
                document.getElementById("sidebar").classList.contains("active")
            ) {
                document.getElementById("sidebar").classList.remove("active");
            }
        };

        return {
            theme,
            handleTheme,
            closeSidebar,
        };
    },
};
</script>

<style scoped>
.sidebar-link.link-logout {
    color: #ffffff !important;
    background-color: #dc3545;
    transition: background-color 0.3s ease;
}
.sidebar-link.link-logout:hover {
    background-color: #ee4a5b !important;
    border: 1px solid #ee4a5b;
}
</style>
