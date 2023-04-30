<template>
    <Head>
        <title>Login - Aplikasi Kaizen</title>
        <meta
            name="description"
            content="Halaman login untuk admin pengelola aplikasi kaizen"
        />
    </Head>

    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        <a href="index.html">
                            <span class="fw-bold fs-2">Kaizen</span>
                        </a>
                    </div>
                    <h1 class="auth-title">Log in.</h1>
                    <p class="auth-subtitle mb-5">
                        Log in with the account provided by the admin.
                    </p>

                    <form @submit.prevent="form.post('/login')">
                        <div
                            class="form-group position-relative has-icon-left mb-4"
                        >
                            <input
                                type="text"
                                :class="{ 'is-invalid': errors.email }"
                                class="form-control form-control-xl"
                                v-model="form.email"
                                placeholder="Email"
                                required
                                autocomplete="username"
                            />
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                            <div
                                class="text-danger text-sm"
                                v-if="errors.email"
                            >
                                {{ errors.email }}
                            </div>
                        </div>

                        <div
                            class="form-group position-relative has-icon-left mb-4"
                        >
                            <input
                                type="password"
                                :class="{ 'is-invalid': errors.password }"
                                class="form-control form-control-xl"
                                v-model="form.password"
                                placeholder="Password"
                                required
                                autocomplete="current-password"
                            />
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                            <div
                                class="text-danger text-sm"
                                v-if="errors.password"
                            >
                                {{ errors.password }}
                            </div>
                        </div>

                        <div
                            class="form-check form-check-lg d-flex align-items-end"
                        >
                            <input
                                class="form-check-input me-2"
                                type="checkbox"
                                id="rememberMe"
                                v-model="form.remember"
                            />
                            <label
                                class="form-check-label text-gray-600"
                                for="rememberMe"
                            >
                                Keep me logged in
                            </label>
                        </div>
                        <button
                            class="btn btn-primary btn-block btn-lg shadow-lg mt-5"
                        >
                            Log in
                        </button>
                    </form>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right"></div>
            </div>
        </div>
    </div>
</template>

<script>
import { Head } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";
import { onMounted } from "vue";
import { toast } from "vue3-toastify";

export default {
    name: "LoginPage",

    components: {
        Head,
    },

    props: {
        errors: Object,
        session: Object,
    },

    setup(props) {
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

            if (props.session.error) {
                toast.error(props.session.error, { theme: "colored" });
            }
        });

        const form = useForm({
            email: "",
            password: "",
            remember: false,
        });

        return {
            form,
        };
    },
};
</script>

<style scoped>
@import "../../../../public/assets/css/pages/auth.css";
</style>

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
</style>
