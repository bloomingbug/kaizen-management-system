<template>
    <Head>
        <title>Change Password User - Aplikasi Kaizen</title>
        <meta name="description" content="Tambah role user Aplikasi Kasir" />
    </Head>

    <div class="page-heading">
        <h3>Change Password User</h3>
    </div>

    <div class="page-content">
        <section class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Form Change Password User</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form method="post" @submit.prevent="submit">
                                <input
                                    type="hidden"
                                    name="username"
                                    v-model="form.email"
                                    disabled
                                    autocomplete="username"
                                />
                                <div class="form-group">
                                    <label
                                        for="current_password"
                                        class="form-label"
                                        >Password Saat Ini</label
                                    >
                                    <div class="input-group">
                                        <input
                                            type="password"
                                            class="form-control"
                                            id="current_password"
                                            v-model="form.current_password"
                                            placeholder="Masukan password saat ini"
                                            required
                                            autocomplete="current-password"
                                        />
                                        <button
                                            class="btn btn-show-password"
                                            type="button"
                                            @click.prevent="
                                                showPassword('current_password')
                                            "
                                        >
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div
                                    v-if="errors.current_password"
                                    class="alert alert-danger"
                                >
                                    {{ errors.current_password }}
                                </div>

                                <div class="form-group">
                                    <label for="password" class="form-label"
                                        >Password Baru</label
                                    >
                                    <div class="input-group">
                                        <input
                                            type="password"
                                            class="form-control"
                                            id="password"
                                            v-model="form.password"
                                            @keyup="
                                                checkPasswordLength();
                                                checkPasswordIsSame();
                                            "
                                            placeholder="Masukan password baru"
                                            required
                                            autocomplete="new-password"
                                        />
                                        <button
                                            class="btn btn-show-password"
                                            type="button"
                                            @click.prevent="
                                                showPassword('password')
                                            "
                                        >
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div
                                    v-if="errors.password"
                                    class="alert alert-danger"
                                >
                                    {{ errors.password }}
                                </div>
                                <div
                                    v-else-if="passwordLength == false"
                                    class="alert alert-danger"
                                >
                                    Password minimal 8 karakter
                                </div>

                                <div class="form-group">
                                    <label
                                        for="password_confirmation"
                                        class="form-label"
                                        >Password Baru</label
                                    >
                                    <div class="input-group">
                                        <input
                                            type="password"
                                            class="form-control"
                                            id="password_confirmation"
                                            v-model="form.password_confirmation"
                                            @keyup="
                                                checkPasswordLength();
                                                checkPasswordIsSame();
                                            "
                                            placeholder="Masukan password baru"
                                            required
                                            autocomplete="new-password"
                                        />
                                        <button
                                            class="btn btn-show-password"
                                            type="button"
                                            @click.prevent="
                                                showPassword(
                                                    'password_confirmation'
                                                )
                                            "
                                        >
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div
                                    v-if="errors.password_confirmation"
                                    class="alert alert-danger"
                                >
                                    {{ errors.password_confirmation }}
                                </div>
                                <div
                                    v-else-if="passwordMatch == false"
                                    class="alert alert-danger"
                                >
                                    Password tidak sama
                                </div>

                                <div class="mt-4">
                                    <button
                                        type="submit"
                                        class="btn btn-primary shadow-sm"
                                        :disabled="form.processing"
                                    >
                                        <i class="fas fa-save"></i>
                                        Simpan
                                    </button>
                                    <button
                                        class="btn btn-warning shadow-sm ms-2"
                                        type="reset"
                                    >
                                        <i class="fas fa-circle-notch"></i>
                                        Reset
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import { Head, router, useForm } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";
import { toast } from "vue3-toastify";
import App from "../../Layouts/App.vue";

export default {
    name: "ChangePasswordPage",

    layout: App,

    props: {
        session: Object,
        errors: Object,
        session: Object,
        user: Object,
    },

    components: {
        Head,
    },

    setup(props) {
        const form = useForm({
            email: props.user.email,
            current_password: "",
            password: "",
            password_confirmation: "",
        });

        const passwordMatch = ref();
        const passwordLength = ref();

        const submit = () => {
            router.put(`/admin/users/update-password/${props.user.id}`, form, {
                preserveScroll: true,
                onSuccess: () => {
                    toast.success("Password updated successfully.", {
                        theme: "colored",
                    });
                },
                onError: (errors) => {
                    toast.error("Failed to update password!", {
                        theme: "colored",
                    });
                },
            });
        };

        const showPassword = (id) => {
            const input = document.getElementById(id);
            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }

            const icon = document.querySelector(
                `input#${id} + button.btn.btn-show-password i `
            );
            if (icon.classList.contains("fa-eye")) {
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        };

        const checkPasswordIsSame = () => {
            if (form.password !== form.password_confirmation) {
                passwordMatch.value = false;
            } else {
                passwordMatch.value = true;
            }
        };

        const checkPasswordLength = () => {
            if (form.password.length < 8) {
                passwordLength.value = false;
            } else {
                passwordLength.value = true;
            }
        };

        onMounted(() => {
            if (props.session.error) {
                toast.error(props.session.error, { theme: "colored" });
            }
        });

        return {
            form,
            passwordMatch,
            passwordLength,
            submit,
            showPassword,
            checkPasswordIsSame,
            checkPasswordLength,
        };
    },
};
</script>

<style scoped>
button.btn.btn-show-password {
    background-color: #fff;
    border-style: solid;
    border-color: #dce7f1;
    border-width: 1px 1px 1px 0;
    border-radius: 0 0.25rem 0.25rem 0;
}
body.theme-dark button.btn.btn-show-password {
    border-color: #35354f;
    background-color: #1b1b29;
}

input.form-control[type="password"] {
    border-width: 1px 0 1px 1px;
}
</style>
