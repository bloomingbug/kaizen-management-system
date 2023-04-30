<template>
    <Head>
        <title>Edit Role - Aplikasi Kaizen</title>
        <meta name="description" content="Tambah role user Aplikasi Kasir" />
    </Head>

    <div class="page-heading">
        <h3>Edit Role</h3>
    </div>

    <div class="page-content">
        <section class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Form Edit Role</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form method="post" @submit.prevent="submit">
                                <div class="form-group">
                                    <label for="name" class="form-label"
                                        >Nama Role</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        :class="{ 'is-invalid': errors.name }"
                                        id="name"
                                        v-model="form.name"
                                        placeholder="Masukan nama role"
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

                                <div class="form-group">
                                    <label for="name" class="form-label"
                                        >Permissions</label
                                    >
                                    <br />
                                    <div
                                        class="badge bg-success m-1"
                                        v-for="(
                                            permission, index
                                        ) in permissions"
                                        :key="index"
                                    >
                                        <input
                                            type="checkbox"
                                            v-model="form.permissions"
                                            :id="`check-${index}`"
                                            :value="permission.name"
                                            class="form-check-input"
                                        />

                                        <label
                                            :for="`check-${index}`"
                                            class="form-check-label ps-1"
                                            >{{ permission.name }}</label
                                        >
                                    </div>

                                    <div
                                        v-if="errors.permissions"
                                        class="text-sm text-danger"
                                    >
                                        {{ errors.permissions }}
                                    </div>
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
    name: "CreateRolePage",

    layout: App,

    props: {
        errors: Object,
        session: Object,
        permissions: Object,
        role: Object,
    },

    components: {
        Head,
    },
    setup(props) {
        const form = useForm({
            name: props.role.name,
            permissions: props.role.permissions.map(
                (permission) => permission.name
            ),
        });

        const submit = () => {
            router.put(`/admin/roles/${props.role.id}`, form, {
                preserveScroll: true,
                onSuccess: () => {
                    toast.success("Role edited successfully", {
                        theme: "colored",
                    });
                },
                onError: (errors) => {
                    toast.error("Failed to edit role!", {
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
