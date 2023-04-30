<template>
    <Head>
        <title>Departements - Aplikasi Kaizen</title>
        <meta name="description" content="Departements Aplikasi Kaizen" />
    </Head>

    <div class="page-heading">
        <h3>Departements</h3>
    </div>

    <div class="page-content">
        <section class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Departements Table</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="input-group mb-3">
                                <Link
                                    :href="`/admin/departements/create`"
                                    v-if="
                                        hasAnyPermission(['departement.create'])
                                    "
                                    class="btn btn-primary"
                                >
                                    <i class="fas fa-plus"></i>
                                    Tambah
                                </Link>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="search"
                                    @keyup.enter="handleSearch"
                                    placeholder="search by departement name"
                                    aria-label="search by departement name"
                                    aria-describedby="button-search"
                                />
                                <button
                                    class="btn btn-primary"
                                    type="button"
                                    id="button-search"
                                    @click.prevent="handleSearch"
                                >
                                    <i class="fas fa-search"></i>
                                    Search
                                </button>
                            </div>

                            <div class="table-responsive">
                                <div v-if="departements.data.length > 0">
                                    <table
                                        class="table table-hover mb-0 table-lg"
                                    >
                                        <thead>
                                            <tr>
                                                <th>Nama</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="(
                                                    departement, index
                                                ) in departements.data"
                                                :key="index"
                                                @click.prevent.stop="
                                                    $refs.vueSimpleContextMenu.showMenu(
                                                        $event,
                                                        departement.id
                                                    )
                                                "
                                                @contextmenu.prevent.stop="
                                                    $refs.vueSimpleContextMenu.showMenu(
                                                        $event,
                                                        departement.id
                                                    )
                                                "
                                            >
                                                <td>{{ departement.name }}</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <Pagination :links="departements.links" />
                                </div>
                                <div v-else>
                                    <div class="alert alert-danger">
                                        Data Tidak Tersedia!
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <vue-simple-context-menu
            element-id="context-menu"
            :options="options"
            ref="vueSimpleContextMenu"
            @option-clicked="optionClicked"
        />
    </div>
</template>

<script>
import { ref, onBeforeMount, onMounted } from "vue";
import { Head, Link, router } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import { toast } from "vue3-toastify";
import App from "../../Layouts/App.vue";
import Pagination from "../../Components/Pagination.vue";

export default {
    name: "DepartementPage",

    layout: App,

    components: {
        Head,
        Link,
        Pagination,
    },

    props: {
        departements: Object,
        session: Object,
        errors: Object,
        auth: Object,
    },

    setup(props) {
        const search = ref(
            "" || new URL(document.location).searchParams.get("q")
        );

        const handleSearch = () => {
            router.get("/admin/departements", { q: search.value });
        };

        const destroy = (id) => {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#187de4",
                cancelButtonColor: "#383838",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    router.delete(`/admin/departements/${id}`, {
                        preserveScroll: true,
                        onSuccess: () => {
                            toast.success("Departement deleted successfully", {
                                theme: "colored",
                            });
                        },

                        onError: (errors) => {
                            toast.error("Failed to delete departement!", {
                                theme: "colored",
                            });
                        },
                    });
                }
            });
        };

        const options = [];

        const optionClicked = (e) => {
            if (e.option.name === "Edit") {
                router.get(`/admin/departements/${e.item}/edit`);
            } else if (e.option.name === "Delete") {
                destroy(e.item);
            }
        };

        onBeforeMount(() => {
            if (props.auth.permissions["departement.edit"]) {
                options.push({ name: "Edit" });
            }

            if (props.auth.permissions["departement.delete"]) {
                options.push({ name: "Delete", class: "text-danger" });
            }
        });

        onMounted(() => {
            if (props.session.error) {
                toast.error(props.session.error, { theme: "colored" });
            }
        });


        return {
            search,
            handleSearch,
            destroy,
            options,
            optionClicked,
        };
    },
};
</script>

<style></style>
