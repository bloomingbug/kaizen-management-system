<template>
    <Head>
        <title>Permissions - Aplikasi Kaizen</title>
        <meta name="description" content="Permission Aplikasi Kaizen" />
    </Head>

    <div class="page-heading">
        <h3>Permissions</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Permissions Table</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="input-group mb-3">
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="search"
                                    @keyup.enter="handleSearch"
                                    placeholder="search by permission name"
                                    aria-label="search by permission name"
                                    aria-describedby="button-search"
                                />
                                <button
                                    class="btn btn-primary"
                                    type="button"
                                    @click.prevent="handleSearch"
                                    id="button-search"
                                >
                                    Search
                                </button>
                            </div>
                            <div class="table-responsive">
                                <div v-if="permissions.data.length > 0">
                                    <table
                                        class="table table-hover mb-0 table-lg"
                                    >
                                        <thead>
                                            <tr>
                                                <th>Permission Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="permission in permissions.data"
                                                :key="permission"
                                            >
                                                <td>{{ permission.name }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div v-else>
                                    <div class="alert alert-danger">
                                        Data Tidak Tersedia!
                                    </div>
                                </div>
                                <Pagination :links="permissions.links" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import { ref, onMounted } from "vue";
import { router, Head } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";
import App from "../../Layouts/App.vue";
import Pagination from "../../Components/Pagination.vue";

export default {
    name: "PermissionsPage",

    layout: App,

    components: {
        Head,
        Pagination,
    },

    props: {
        session: Object,
        permissions: Object,
    },

    setup(props) {
        const search = ref(
            "" || new URL(document.location).searchParams.get("q")
        );

        const handleSearch = () => {
            router.get(
                "/admin/permissions",
                {
                    q: search.value,
                },
                { preserveScroll: true }
            );
        };

        onMounted(() => {
            if (props.session.error) {
                toast.error(props.session.error, { theme: "colored" });
            }
        });


        return {
            search,
            handleSearch,
        };
    },
};
</script>
