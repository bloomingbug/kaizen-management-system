<template>
    <Head>
        <title>Users - Aplikasi Kaizen</title>
        <meta name="description" content="Users Aplikasi Kaizen" />
    </Head>

    <div class="page-heading">
        <h3>Users</h3>
    </div>

    <div class="page-content">
        <section class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Users Table</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="input-group mb-3">
                                <Link
                                    :href="`/admin/users/create`"
                                    v-if="hasAnyPermission(['user.create'])"
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
                                    placeholder="search by name"
                                    aria-label="search by name"
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
                                <div v-if="users.data.length > 0">
                                    <table
                                        class="table table-hover mb-0 table-lg"
                                    >
                                        <thead>
                                            <tr>
                                                <th style="width: 20%">Name</th>
                                                <th>Email</th>
                                                <th>Roles</th>
                                                <th>Jabatan</th>
                                                <th>Departement</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="(
                                                    user, index
                                                ) in users.data"
                                                :key="index"
                                                @click.prevent.stop="
                                                    $refs.vueSimpleContextMenu.showMenu(
                                                        $event,
                                                        user.id
                                                    )
                                                "
                                                @contextmenu.prevent.stop="
                                                    $refs.vueSimpleContextMenu.showMenu(
                                                        $event,
                                                        user.id
                                                    )
                                                "
                                            >
                                                <td>{{ user.name }}</td>
                                                <td>{{ user.email }}</td>
                                                <td>
                                                    <span
                                                        v-for="(
                                                            role, index
                                                        ) in user.roles"
                                                        :key="index"
                                                        class="badge rounded-pill bg-primary me-1"
                                                        >{{ role.name }}</span
                                                    >
                                                </td>
                                                <td>{{ user.jabatan }}</td>
                                                <td>
                                                    {{ user.departement.name }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <Pagination :links="users.links" />
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
    name: "UsersPage",

    layout: App,

    components: {
        Head,
        Link,
        Pagination,
    },

    props: {
        session: Object,
        users: Object,
        auth: Object,
    },

    setup(props) {
        const search = ref(
            "" || new URL(document.location).searchParams.get("q")
        );

        const handleSearch = () => {
            router.get("/admin/users", { q: search.value });
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
                    router.delete(`/admin/users/${id}`, {
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

        const options = [];

        const optionClicked = (e) => {
            if (e.option.name === "Edit") {
                router.get(`/admin/users/${e.item}/edit`);
            } else if (e.option.name === "Delete") {
                destroy(e.item);
            } else if (e.option.name === "Change Password") {
                router.get(`/admin/users/change-password/${e.item}/edit`);
            }
        };

        onBeforeMount(() => {
            if (props.auth.permissions["user.edit"]) {
                options.push(
                    {
                        name: "Edit",
                    },
                    {
                        name: "Change Password",
                    }
                );
            }
            if (props.auth.permissions["user.delete"]) {
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
            destroy,
            options,
            optionClicked,
        };
    },
};
</script>

<style></style>
