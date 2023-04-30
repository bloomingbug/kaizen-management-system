<template>
    <Head>
        <title>Details Kaizen - Aplikasi Kaizen</title>
        <meta name="description" content="Details Kaizen Aplikasi Kaizen" />
    </Head>

    <div class="page-heading">
        <h3>Details Kaizen</h3>
    </div>

    <div class="page-content show-kaizen">
        <section class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            Details Kaizen {{ kaizen.no }}
                        </h4>
                    </div>
                    <div class="card-content">
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
                                            Status PIC
                                        </th>
                                        <td>:</td>
                                        <td>
                                            {{ kaizen.status_pic.name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="width: 30%">
                                            Review PIC
                                        </th>
                                        <td>:</td>
                                        <td>{{ kaizen.review_pic }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="width: 30%">
                                            Point PIC
                                        </th>
                                        <td>:</td>
                                        <td>{{ kaizen.point_pic }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="width: 30%">
                                            Status Secretary
                                        </th>
                                        <td>:</td>
                                        <td>
                                            {{ kaizen.status_secretary.name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="width: 30%">
                                            Review Secretary
                                        </th>
                                        <td>:</td>
                                        <td>
                                            {{ kaizen.review_secretary }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="width: 30%">
                                            Point Secretary
                                        </th>
                                        <td>:</td>
                                        <td>{{ kaizen.point_secretary }}</td>
                                    </tr>
                                    
                                    <tr>
                                        <th scope="row" style="width: 30%">
                                            Nilai Akhir
                                        </th>
                                        <td>:</td>
                                        <td class="fw-bold fs-3">
                                            <span
                                                v-if="
                                                    kaizen.point_pic &&
                                                    kaizen.point_secretary
                                                "
                                                class="fw-bold p-0"
                                            >
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
                                    <h5 class="mb-3 fs-5">Deskripsi Usulan</h5>
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
                    <div
                        class="card-footer d-flex justify-content-between align-items-center"
                    >
                        <Link href="/admin/kaizens" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i>
                            Back
                        </Link>
                        <a
                            :href="`/print/${kaizen.id}`"
                            target="_blank"
                            class="btn btn-primary"
                        >
                            <i class="fas fa-file-download"></i>
                            Download
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import { Head, Link } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";
import moment from "moment";
import App from "../../Layouts/App.vue";

export default {
    name: "PageKaizenShow",

    layout: App,

    components: {
        Head,
        Link,
    },

    props: {
        kaizen: Object
    },
    setup(props) {
        const tanggalPengajuan = ref("");

        onMounted(() => {
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
.show-kaizen .description {
    margin-top: 2rem;
    border: 3px dashed #435ebe;
    border-radius: 15px;
    padding: 24px 16px 0px 16px;
}
</style>
