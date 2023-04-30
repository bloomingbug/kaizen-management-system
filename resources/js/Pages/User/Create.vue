<template>
    <Head>
        <title>Add User - Aplikasi Kaizen</title>
        <meta name="description" content="Tambah role user Aplikasi Kasir" />
    </Head>

    <div class="page-heading">
        <h3>Add User</h3>
    </div>

    <div class="page-content">
        <section class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Form Add User</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form method="post" @submit.prevent="submit">
                                <div class="row mb-3">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="name" class="form-label"
                                                >Nama User</label
                                            >
                                            <input
                                                type="text"
                                                class="form-control"
                                                :class="{
                                                    'is-invalid': errors.name,
                                                }"
                                                id="name"
                                                v-model="form.name"
                                                placeholder="Masukan nama pengguna"
                                                autofocus
                                                required
                                            />

                                            <div
                                                v-if="errors.name"
                                                class="text-sm text-danger"
                                            >
                                                {{ errors.name }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label
                                                for="email"
                                                class="form-label"
                                                >Email</label
                                            >
                                            <input
                                                type="email"
                                                class="form-control"
                                                :class="{
                                                    'is-invalid': errors.email,
                                                }"
                                                id="email"
                                                v-model="form.email"
                                                placeholder="Masukan alamat email"
                                                required
                                                autocomplete="username"
                                            />
                                            <div
                                                v-if="errors.email"
                                                class="text-sm text-danger"
                                            >
                                                {{ errors.email }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label
                                                for="jabatan"
                                                class="form-label"
                                                >Jabatan</label
                                            >
                                            <input
                                                type="text"
                                                class="form-control"
                                                :class="{
                                                    'is-invalid':
                                                        errors.jabatan,
                                                }"
                                                id="jabatan"
                                                v-model="form.jabatan"
                                                placeholder="Masukan jabatan"
                                                autofocus
                                                required
                                            />

                                            <div
                                                v-if="errors.jabatan"
                                                class="text-sm text-danger"
                                            >
                                                {{ errors.jabatan }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label
                                                for="departement"
                                                class="form-label"
                                                >Departement</label
                                            >
                                            <select
                                                id="departement"
                                                v-model="form.departement_id"
                                                class="form-select"
                                            >
                                                <option
                                                    value=""
                                                    selected
                                                    hidden
                                                    disabled
                                                >
                                                    -- Pilih Departement --
                                                </option>
                                                <option
                                                    v-for="departement in departements"
                                                    :key="departement.id"
                                                    :value="departement.id"
                                                >
                                                    {{ departement.name }}
                                                </option>
                                            </select>

                                            <div
                                                v-if="errors.departement_id"
                                                class="text-sm text-danger"
                                            >
                                                {{ errors.departement_id }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label
                                                for="password"
                                                class="form-label"
                                                >Password</label
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
                                                    placeholder="Masukan password"
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

                                            <div
                                                v-if="errors.password"
                                                class="text-sm text-danger"
                                            >
                                                {{ errors.password }}
                                            </div>
                                            <div
                                                v-else-if="
                                                    passwordLength == false
                                                "
                                                class="text-sm text-danger"
                                            >
                                                Password minimal 8 karakter
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label
                                                for="password_confirmation"
                                                class="form-label"
                                                >Konfirmasi Password</label
                                            >
                                            <div class="input-group">
                                                <input
                                                    type="password"
                                                    class="form-control"
                                                    id="password_confirmation"
                                                    v-model="
                                                        form.password_confirmation
                                                    "
                                                    @keyup="checkPasswordIsSame"
                                                    placeholder="Masukan password kembali"
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

                                            <div
                                                v-if="
                                                    errors.password_confirmation
                                                "
                                                class="text-sm text-danger"
                                            >
                                                {{
                                                    errors.password_confirmation
                                                }}
                                            </div>
                                            <div
                                                v-else-if="
                                                    passwordMatch == false
                                                "
                                                class="text-sm text-danger"
                                            >
                                                Password tidak sama
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <label for="name" class="form-label"
                                        ><i class="ri-arrow-left-s-line"></i
                                        >Roles</label
                                    >
                                    <br />
                                    <div
                                        class="badge bg-success m-1"
                                        v-for="(role, index) in roles"
                                        :key="index"
                                    >
                                        <input
                                            type="checkbox"
                                            v-model="form.roles"
                                            :id="`check-${index}`"
                                            :value="role.name"
                                            class="form-check-input"
                                        />

                                        <label
                                            :for="`check-${index}`"
                                            class="form-check-label ps-1"
                                            >{{ role.name }}</label
                                        >
                                    </div>
                                </div>

                                <div
                                    v-if="errors.roles"
                                    class="alert alert-danger"
                                >
                                    {{ errors.roles }}
                                </div>

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
    name: "CreateUserPage",

    layout: App,

    props: {
        errors: Object,
        session: Object,
        roles: Object,
        departements: Object,
    },

    components: {
        Head,
    },

    setup(props) {
        const form = useForm({
            name: "",
            email: "",
            password: "",
            password_confirmation: "",
            roles: [],
            departement_id: "",
        });

        const passwordMatch = ref();
        const passwordLength = ref();

        const submit = () => {
            if (passwordMatch.value == false) {
                toast.error("Password tidak sama!", {
                    theme: "colored",
                });
            } else {
                router.post("/admin/users", form, {
                    preserveScroll: true,
                    onSuccess: () => {
                        toast.success("User added successfully", {
                            theme: "colored",
                        });
                    },
                    onError: (errors) => {
                        toast.error("Failed to add user!", {
                            theme: "colored",
                        });
                    },
                });
            }
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
            submit,
            showPassword,
            passwordMatch,
            passwordLength,
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
