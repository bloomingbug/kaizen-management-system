<template>
    <Head>
        <title>Edit User - Aplikasi Kaizen</title>
        <meta name="description" content="Tambah role user Aplikasi Kasir" />
    </Head>

    <div class="page-heading">
        <h3>Edit User</h3>
    </div>

    <div class="page-content">
        <section class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Form Edit User</h4>
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
                                                id="name"
                                                v-model="form.name"
                                                placeholder="Masukan nama pengguna"
                                                autofocus
                                                required
                                            />
                                        </div>

                                        <div
                                            v-if="errors.name"
                                            class="alert alert-danger"
                                        >
                                            {{ errors.name }}
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
                                                id="email"
                                                v-model="form.email"
                                                placeholder="Masukan alamat email"
                                                readonly
                                                disabled
                                                autocomplete="username"
                                            />
                                        </div>

                                        <div
                                            v-if="errors.email"
                                            class="alert alert-danger"
                                        >
                                            {{ errors.email }}
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
import { onMounted } from "vue";
import { toast } from "vue3-toastify";
import App from "../../Layouts/App.vue";

export default {
    name: "EditUserPage",

    layout: App,

    props: {
        errors: Object,
        session: Object,
        roles: Object,
        user: Object,
        departements: Object,
    },

    components: {
        Head,
    },

    setup(props) {
        const form = useForm({
            name: props.user.name,
            email: props.user.email,
            roles: props.user.roles.map((role) => role.name),
            jabatan: props.user.jabatan,
            departement_id: props.user.departement_id,
        });

        const submit = () => {
            router.put(`/admin/users/${props.user.id}`, form, {
                preserveScroll: true,
                onSuccess: () => {
                    toast.success("User edited successfully", {
                        theme: "colored",
                    });
                },
                onError: (errors) => {
                    toast.error("Failed to edit user!", {
                        theme: "colored",
                    });
                },
            });
        };

        onMounted(() => {
            if (props.session.error) {
                toast.error(props.session.error, { theme: "colored" });
            }
        });

        return {
            form,
            submit,
        };
    },
};
</script>

<style scoped></style>
