<template>
    <Head>
        <title>Details Ide Kaizen - Aplikasi Kaizen</title>
        <meta name="description" content="Detail Kaizen Aplikasi Kaizen" />
    </Head>

    <div id="detailKaizen" class="detail-kaizen mt-3 mb-5">
        <div class="container overflow-hidden">
            <div class="row">
                <div class="col-12 offset-md-2 col-md-8">
                    <div v-if="session.flash" class="text-center">
                        <img
                            src="/assets/icons/check.svg"
                            height="100"
                            alt="Check Icons"
                            class="d-block mx-auto mb-2"
                        />

                        <h3 class="fw-bold">Kaizen berhasil dikirim!</h3>
                        <p>
                            Kami sangat mengapresiasi pengajuan kaizen yang
                            telah Anda berikan. Terima kasih telah membantu
                            perusahaan untuk terus berinovasi dan menciptakan
                            perbaikan yang berkelanjutan.
                        </p>
                    </div>
                    <div class="card my-4">
                        <div class="card-content">
                            <div class="card-header">
                                <h4 class="card-title text-center">
                                    Data Ide Kaizen
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th scope="row" style="width: 30%">
                                                No. Kaizen
                                            </th>
                                            <td>:</td>
                                            <td>{{ kaizen.no }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row" style="width: 30%">
                                                Tanggal Pengajuan
                                            </th>
                                            <td>:</td>
                                            <td>
                                                {{ tanggalPengajuan }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row" style="width: 30%">
                                                Yang Mengajukan
                                            </th>
                                            <td>:</td>
                                            <td>{{ kaizen.name }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row" style="width: 30%">
                                                Status
                                            </th>
                                            <td>:</td>
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
                                                        "PIC: " +
                                                        kaizen.status_pic.name
                                                    }}</span
                                                >
                                                <span
                                                    v-if="
                                                        kaizen.status_pic
                                                            .name != 'Rejected'
                                                    "
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
                                                        "Secretary: " +
                                                        kaizen.status_secretary
                                                            .name
                                                    }}</span
                                                >
                                            </td>
                                        </tr>
                                        <tr v-if="kaizen.review_pic">
                                            <th scope="row" style="width: 30%">
                                                Review PIC
                                            </th>
                                            <td>:</td>
                                            <td>{{ kaizen.review_pic }}</td>
                                        </tr>
                                        <tr v-if="kaizen.review_secretary">
                                            <th scope="row" style="width: 30%">
                                                Review Secretary
                                            </th>
                                            <td>:</td>
                                            <td>
                                                {{ kaizen.review_secretary }}
                                            </td>
                                        </tr>
                                        <tr
                                            v-if="
                                                kaizen.point_pic &&
                                                kaizen.point_secretary
                                            "
                                        >
                                            <th scope="row" style="width: 30%">
                                                Nilai Akhir
                                            </th>
                                            <td>:</td>
                                            <td class="fw-bold fs-3">
                                                <span class="fw-bold p-0">
                                                    {{
                                                        (kaizen.point_pic +
                                                            kaizen.point_secretary) /
                                                        2
                                                    }}
                                                </span>
                                            </td>
                                        </tr>
                                    </table>

                                    <div class="description">
                                        <h5 class="mb-3 fs-5">
                                            Deskripsi Keadaan Saat Ini
                                        </h5>
                                        <img
                                            v-if="
                                                kaizen.image_old.slice(-7) !=
                                                'kaizens'
                                            "
                                            :src="kaizen.image_old"
                                            alt="Gambar Keadaan Saat Ini"
                                            class="w-100 h-auto mb-4"
                                        />
                                        <p>{{ kaizen.description_old }}</p>
                                    </div>

                                    <div class="description">
                                        <h5 class="mb-3 fs-5">
                                            Deskripsi Usulan
                                        </h5>
                                        <img
                                            v-if="
                                                kaizen.image_old.slice(-7) !=
                                                'kaizens'
                                            "
                                            :src="kaizen.image_new"
                                            alt="Gambar Usulan"
                                            class="w-100 h-auto mb-4"
                                        />
                                        <p>{{ kaizen.description_new }}</p>
                                    </div>

                                    <div class="description">
                                        <h5 class="mb-3 fs-5">Manfaat</h5>
                                        <p>{{ kaizen.benefit }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer clearfix">
                            <a
                                :href="`/print/${kaizen.id}`"
                                target="_blank"
                                class="btn btn-primary float-end"
                            >
                                <i class="fas fa-file-download"></i>
                                Download
                            </a>
                        </div>
                    </div>

                    <Footer />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Head } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";
import moment from "moment";
import Footer from "../../Components/Footer.vue";

export default {
    name: "KaizenDetailPage",

    props: {
        kaizen: Object,
    },

    components: {
        Head,
        Footer,
    },

    setup(props) {
        const tanggalPengajuan = ref("");

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

            tanggalPengajuan.value = moment(props.kaizen.created_at).format(
                "DD MMMM YYYY"
            );
        });

        return {
            tanggalPengajuan,
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

.detail-kaizen .description {
    margin-top: 2rem;
    border: 3px dashed #435ebe;
    border-radius: 15px;
    padding: 24px 16px 0px 16px;
}
</style>
