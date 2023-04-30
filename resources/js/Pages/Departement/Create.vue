<template>
    <Head>
        <title>Add Department - Aplikasi Kaizen</title>
        <meta name="description" content="Tambah Departement Aplikasi Kaizen" />
    </Head>

    <div class="page-heading">
        <h3>Add Department</h3>
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Form Add Departement</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form @submit.prevent="submit">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label"
                                        >Nama Departement</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        :class="{
                                            'is-invalid': errors.name,
                                        }"
                                        id="name"
                                        v-model="form.name"
                                        placeholder="Masukan nama departement"
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

                                <button
                                    type="submit"
                                    class="btn btn-primary shadow-sm"
                                    :disabled="form.processing"
                                >
                                    <i class="fas fa-save"></i>
                                    Simpan
                                </button>

                                <button
                                    type="reset"
                                    class="btn btn-secondary shadow-sm ms-2"
                                >
                                    <i class="fas fa-circle-notch"></i>
                                    Reset
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Head, router, useForm } from "@inertiajs/vue3";
import { onMounted } from "vue";
import App from "../../Layouts/App.vue";
import { toast } from "vue3-toastify";

export default {
    name: "CreateDepartementPage",

    layout: App,

    components: {
        Head,
    },

    props: {
        errors: Object,
        session: Object
    },

    setup(props) {
        const form = useForm({
            name: "",
        });

        const submit = () => {
            router.post("/admin/departements", form, {
                preserveScroll: true,

                onSuccess: () => {
                    toast.success("Department added successfully.", {
                        theme: "colored",
                    });
                },

                onError: () => {
                    toast.error("Failed to add department.", {
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

<style></style>
