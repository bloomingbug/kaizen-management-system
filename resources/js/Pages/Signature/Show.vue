<template>
    <Head>
        <title>Tanda Tangan Elektronik - Aplikasi Kaizen</title>
        <meta
            name="description"
            content="Detail Kaizen {{ kaizen.no }} Aplikasi Kaizen"
        />
    </Head>

    <div id="detailKaizen" class="signature mt-3 mb-5">
        <div class="container overflow-hidden">
            <div class="row">
                <div class="col-12 offset-md-2 col-md-8">
                    <div class="text-center">
                        <img
                            src="/assets/icons/signature.svg"
                            height="100"
                            alt="Check Icons"
                            class="d-block mx-auto mb-2"
                        />

                        <h3 class="fw-bold">Tanda Tangan Elektronik</h3>
                    </div>
                    <div class="card my-4">
                        <div class="card-content">
                            <div class="card-header">
                                <h4 class="card-title text-center">
                                    Dokumen ini telah ditandatangani secara
                                    elektronik oleh,
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th scope="row" style="width: 30%">
                                                Nama
                                            </th>
                                            <td>:</td>
                                            <td>{{ signature.user.name }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row" style="width: 30%">
                                                Jabatan
                                            </th>
                                            <td>:</td>
                                            <td>
                                                {{
                                                    signature.user.jabatan
                                                        ? signature.user.jabatan
                                                        : ""
                                                }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row" style="width: 30%">
                                                Departement
                                            </th>
                                            <td>:</td>
                                            <td>
                                                {{
                                                    signature.user.departement
                                                        .name
                                                        ? signature.user
                                                              .departement.name
                                                        : ""
                                                }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row" style="width: 30%">
                                                Pada
                                            </th>
                                            <td>:</td>
                                            <td>
                                                {{ tanggalTTD }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row" style="width: 30%">
                                                No. Dokumen
                                            </th>
                                            <td>:</td>
                                            <td>
                                                {{ dokumen.no }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row" style="width: 30%">
                                                Dokumen
                                            </th>
                                            <td>:</td>
                                            <td>
                                                <a
                                                    :href="`/print/${dokumen.id}`"
                                                    target="_blank"
                                                    class="btn btn-primary btn-sm rounded-pill px-3 py-1"
                                                    >Lihat</a
                                                >
                                            </td>
                                        </tr>
                                    </table>

                                    <div
                                        class="d-flex justify-content-center mt-5 position-relative"
                                    >
                                        <div class="text-sm text-card-footer">
                                            Dokumen ini tetap dianggap sah
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <Footer />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Head, Link } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";
import moment from "moment";
import Footer from "../../Components/Footer.vue";

export default {
    name: "SignatureDetailPage",

    props: {
        signature: Object,
        dokumen: Object,
        session: Object,
    },

    components: {
        Head,
        Link,
        Footer,
    },

    setup(props) {
        const tanggalTTD = ref("");

        const domain = window.location.hostname;

        onMounted(() => {
            if (localStorage.getItem("dark")) {
                if (localStorage.getItem("dark") === "true") {
                    document.body.classList.add("theme-dark");
                } else {
                    document.body.classList.add("theme-light");
                }
            } else {
                if (
                    window.matchMedia &&
                    window.matchMedia("(prefers-color-scheme:dark)").matches
                ) {
                    document.body.classList.add("theme-dark");
                } else {
                    document.body.classList.add("theme-light");
                }
            }

            tanggalTTD.value = moment(props.signature.created_at).format(
                "ddd, DD MMMM YYYY HH:mm:ss"
            );
        });

        return {
            tanggalTTD,
            domain,
        };
    },
};
</script>

<style>
/* Scrollbar minimalis */
::-webkit-scrollbar {
    width: 0.3rem;
}
::-webkit-scrollbar-track {
    background: #f1f1f1;
}
::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 50rem;
}

.signature .description {
    margin-top: 2rem;
    border: 3px dashed #435ebe;
    border-radius: 15px;
    padding: 24px 16px 0px 16px;
}

.text-card-footer {
    position: relative;
    display: block;
    width: 100%;
    text-align: center;
}
.text-card-footer::before {
    content: "";
    position: absolute;
    top: -10px;
    left: 0;
    right: 0;
    width: 100%;
    height: 0.5px;
    background-color: #e0e0e0;
}

body.theme-dark .signature .table > :not(caption) > * > * {
    background-color: #435ebe;
    border: 1px solid #435ebe;
    box-shadow: inset 0 0 0 9999px var(--bs-table-accent-bg);
    padding: 0.5rem;
}

body.theme-dark .signature .table > :not(caption) > * > *:hover {
    background-color: #3950a2;
    border: 1px solid #3950a2;
    box-shadow: inset 0 0 0 9999px var(--bs-table-accent-bg);
    padding: 0.5rem;
}

body.theme-dark .signature .table > :not(caption) > * > *.active {
    background-color: #3950a2;
    border: 1px solid #3950a2;
    box-shadow: inset 0 0 0 9999px var(--bs-table-accent-bg);
    padding: 0.5rem;
}

body.theme-dark .signature .table > :not(caption) > * > *.focus {
    background-color: #3950a2;
    border: 1px solid #3950a2;
    box-shadow: inset 0 0 0 9999px var(--bs-table-accent-bg);
    padding: 0.5rem;
}
</style>
