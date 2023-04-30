<template>
    <Head>
        <title>Categories - Aplikasi Kaizen</title>
        <meta name="description" content="Categories Aplikasi Kaizen" />
    </Head>

    <div class="page-heading">
        <h3>Categories</h3>
    </div>

    <div class="page-content">
        <section class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Categories Table</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="input-group mb-3">
                                <Link
                                    :href="`/admin/categories/create`"
                                    v-if="hasAnyPermission(['category.create'])"
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
                                    placeholder="search by category name"
                                    aria-label="search by category name"
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
                                <div v-if="categories.data.length > 0">
                                    <table
                                        class="table table-hover table-lg mb-0"
                                    >
                                        <thead>
                                            <tr>
                                                <th>Nama</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="(
                                                    category, index
                                                ) in categories.data"
                                                :key="index"
                                                @contextmenu.prevent.stop="
                                                    $refs.VueSimpleContextMenu.showMenu(
                                                        $event,
                                                        category.id
                                                    )
                                                "
                                                @click.prevent.stop="
                                                    $refs.VueSimpleContextMenu.showMenu(
                                                        $event,
                                                        category.id
                                                    )
                                                "
                                            >
                                                <td>{{ category.name }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <Pagination :links="categories.links" />
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
            ref="VueSimpleContextMenu"
            :options="options"
            @option-clicked="optionClicked"
        />
    </div>
</template>

<script>
import { Head, Link, router } from "@inertiajs/vue3";
import { ref, onBeforeMount, onMounted } from "vue";
import Swal from "sweetalert2";
import { toast } from "vue3-toastify";
import App from "../../Layouts/App.vue";
import Pagination from "../../Components/Pagination.vue";

export default {
    name: "CategoriesPage",

    layout: App,

    components: {
        Head,
        Link,
        Pagination,
    },

    props: {
        errors: Object,
        session: Object,
        categories: Object,
        auth: Object,
    },

    setup(props) {
        const search = ref(
            "" || new URL(document.location).searchParams.get("q")
        );

        const options = [];

        const handleSearch = () => {
            router.get(
                "/admin/categories",
                { q: search.value },
                { preserveScroll: true }
            );
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
            }).then((response) => {
                if (response.isConfirmed) {
                    router.delete(`/admin/categories/${id}`, {
                        preserveScroll: true,

                        onSuccess: () => {
                            toast.success("Category deleted successfully", {
                                theme: "colored",
                            });
                        },

                        onError: () => {
                            toast.error("Failed to delete category!", {
                                theme: "colored",
                            });
                        },
                    });
                }
            });
        };

        const optionClicked = (e) => {
            if (e.option.name == "Edit") {
                router.get(`/admin/categories/${e.item}/edit`);
            } else if (e.option.name == "Delete") {
                destroy(e.item);
            }
        };

        onBeforeMount(() => {
            if (props.auth.permissions["category.edit"]) {
                options.push({
                    name: "Edit",
                });
            }

            if (props.auth.permissions["category.delete"]) {
                options.push({
                    name: "Delete",
                    class: "text-danger",
                });
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
            options,
            optionClicked,
        };
    },
};
</script>

<style scoped></style>
