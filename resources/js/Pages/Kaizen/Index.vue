<template>
    <Head>
        <title>Kaizen - Aplikasi Kaizen</title>
        <meta name="description" content="Kaizen Page Aplikasi Kaizen" />
    </Head>

    <div class="page-heading">
        <h3>Kaizen</h3>
    </div>

    <div class="page-content">
        <section class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Kaizen Table</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="input-group mb-3">
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="search"
                                    @keyup.enter="handleSearch"
                                    placeholder="search by nomor kaizen"
                                    aria-label="search by nomor kaizen"
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
                            <div
                                v-if="kaizens.data.length > 0"
                                class="table-responsive"
                            >
                                <table class="table table-hover mb-0 table-lg">
                                    <thead>
                                        <tr>
                                            <th style="width: 20%">No</th>
                                            <th>Name</th>
                                            <th>Departement</th>
                                            <th>Target</th>
                                            <th>Status (PIC)</th>
                                            <th>Status (Secretary)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="kaizen in kaizens.data"
                                            :key="kaizen"
                                            id="rowData"
                                            @click.prevent.stop="
                                                $refs.vueSimpleContextMenu.showMenu(
                                                    $event,
                                                    kaizen.id
                                                )
                                            "
                                            @contextmenu.prevent.stop="
                                                $refs.vueSimpleContextMenu.showMenu(
                                                    $event,
                                                    kaizen.id
                                                )
                                            "
                                        >
                                            <td>{{ kaizen.no }}</td>
                                            <td>{{ kaizen.name }}</td>
                                            <td>
                                                {{ kaizen.departement.name }}
                                            </td>
                                            <td>
                                                {{ kaizen.category.name }}
                                            </td>
                                            <td>
                                                <span
                                                    class="badge rounded-pill px-3 py-2 me-3"
                                                    :class="{
                                                        'bg-info':
                                                            kaizen.status_pic
                                                                .name ==
                                                            'Terkirim',
                                                        'bg-danger':
                                                            kaizen.status_pic
                                                                .name ==
                                                            'Rejected',
                                                        'bg-warning':
                                                            kaizen.status_pic
                                                                .name ==
                                                            'Pending',
                                                        'bg-success':
                                                            kaizen.status_pic
                                                                .name ==
                                                            'Approved',
                                                    }"
                                                    >{{
                                                        kaizen.status_pic.name
                                                    }}</span
                                                >
                                            </td>
                                            <td>
                                                <span
                                                    class="badge rounded-pill px-3 py-2 me-3"
                                                    :class="{
                                                        'bg-info':
                                                            kaizen
                                                                .status_secretary
                                                                .name ==
                                                            'Terkirim',
                                                        'bg-danger':
                                                            kaizen
                                                                .status_secretary
                                                                .name ==
                                                            'Rejected',
                                                        'bg-warning':
                                                            kaizen
                                                                .status_secretary
                                                                .name ==
                                                            'Pending',
                                                        'bg-success':
                                                            kaizen
                                                                .status_secretary
                                                                .name ==
                                                            'Approved',
                                                    }"
                                                    >{{
                                                        kaizen.status_secretary
                                                            .name
                                                    }}</span
                                                >
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <Pagination :links="kaizens.links" />
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
import { Head, router } from "@inertiajs/vue3";
import { ref, onBeforeMount, onMounted } from "vue";
import { toast } from "vue3-toastify";
import Swal from "sweetalert2";
import App from "../../Layouts/App.vue";
import Pagination from "../../Components/Pagination.vue";

export default {
    name: "KaizenPage",

    layout: App,

    components: {
        Head,
        Pagination,
    },

    props: {
        kaizens: Object,
        auth: Object,
        session: Object,
    },

    setup(props) {
        const search = ref(
            "" || new URL(document.location).searchParams.get("q")
        );

        const handleSearch = () => {
            router.get(
                "/admin/kaizens",
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
                    router.delete(`/admin/kaizens/${id}`, {
                        preserveScroll: true,
                        onSuccess: () => {
                            toast.success("Kaizen deleted successfully", {
                                theme: "colored",
                            });
                        },
                        onerror: () => {
                            toast.error("Something went wrong", {
                                theme: "colored",
                            });
                        },
                    });
                }
            });
        };

        const options = [];

        const optionClicked = (e) => {
            if (e.option.name == "Review Secretary") {
                router.get(`/admin/kaizens/${e.item}/secretary`);
            } else if (e.option.name == "Review PIC") {
                router.get(`/admin/kaizens/${e.item}/pic`);
            } else if (e.option.name == "Info") {
                router.get(`/admin/kaizens/${e.item}`);
            } else if (e.option.name == "Delete") {
                destroy(e.item);
            }
        };

        onBeforeMount(() => {
            if (props.auth.permissions["kaizen.show"]) {
                options.push({
                    name: "Info",
                    class: "text-info",
                });
            }
            if (props.auth.permissions["kaizen.pic"]) {
                options.push({
                    name: "Review PIC",
                    class: "text-warning",
                });
            }
            if (props.auth.permissions["kaizen.secretary"]) {
                options.push({
                    name: "Review Secretary",
                    class: "text-warning",
                });
            }
            if (props.auth.permissions["kaizen.delete"]) {
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

<style></style>
