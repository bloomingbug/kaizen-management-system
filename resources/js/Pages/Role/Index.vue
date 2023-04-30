<template>
    <Head>
        <title>Roles - Aplikasi Kaizen</title>
        <meta name="description" content="Roles Aplikasi Kaizen" />
    </Head>

    <div class="page-heading">
        <h3>Roles</h3>
    </div>

    <div class="page-content">
        <section class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Roles Table</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="input-group mb-3">
                                <Link
                                    :href="`/admin/roles/create`"
                                    v-if="hasAnyPermission(['role.create'])"
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
                                    placeholder="search by roles name"
                                    aria-label="search by roles name"
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
                                <div v-if="roles.data.length > 0">
                                    <table
                                        class="table table-hover mb-0 table-lg"
                                    >
                                        <thead>
                                            <tr>
                                                <th style="width: 20%">
                                                    Roles Name
                                                </th>
                                                <th>Permissions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="role in roles.data"
                                                :key="role"
                                                id="rowData"
                                                @click.prevent.stop="
                                                    $refs.vueSimpleContextMenu.showMenu(
                                                        $event,
                                                        role.id
                                                    )
                                                "
                                                @contextmenu.prevent.stop="
                                                    $refs.vueSimpleContextMenu.showMenu(
                                                        $event,
                                                        role.id
                                                    )
                                                "
                                            >
                                                <td>{{ role.name }}</td>
                                                <td>
                                                    <span
                                                        class="badge bg-primary m-1"
                                                        v-for="permission in role.permissions"
                                                        :key="permission"
                                                        >{{
                                                            permission.name
                                                        }}</span
                                                    >
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <Pagination :links="roles.links" />
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
import { Head, Link, router } from "@inertiajs/vue3";
import { ref, onBeforeMount, onMounted } from "vue";
import Swal from "sweetalert2";
import { toast } from "vue3-toastify";
import App from "../../Layouts/App.vue";
import Pagination from "../../Components/Pagination.vue";

export default {
    name: "RolesPage",

    layout: App,

    components: {
        Head,
        Link,
        Pagination,
    },

    props: {
        session: Object,
        roles: Object,
        auth: Object,
    },

    setup(props) {
        const search = ref(
            "" || new URL(document.location).searchParams.get("q")
        );

        const options = [];

        const handleSearch = () => {
            router.get(
                "/admin/roles",
                { q: search.value },
                {
                    preserveScroll: true,
                }
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
            }).then((result) => {
                if (result.isConfirmed) {
                    router.delete(`/admin/roles/${id}`, {
                        preserveScroll: true,
                        onSuccess: () => {
                            toast.success("Role deleted successfully", {
                                theme: "colored",
                            });
                        },
                        onError: (errors) => {
                            toast.error("Failed to delete role!", {
                                theme: "colored",
                            });
                        },
                    });
                }
            });
        };

        const optionClicked = (e) => {
            if (e.option.name === "Edit") {
                router.get(`/admin/roles/${e.item}/edit`);
            } else if (e.option.name === "Delete") {
                destroy(e.item);
            }
        };

        onBeforeMount(() => {
            if (props.auth.permissions["role.edit"]) {
                options.push({
                    name: "Edit",
                });
            }
            if (props.auth.permissions["role.delete"]) {
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
            options,
            handleSearch,
            optionClicked,
        };
    },
};
</script>

<style></style>
