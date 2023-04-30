<template>
    <Head>
        <title>Review Secretary - Aplikasi Kasir</title>
        <meta
            name="description"
            content="Kaizen Review by Secretary Aplikasi Kasi"
        />
    </Head>

    <div class="page-heading">
        <h3>Review Kaizen as Secretary</h3>
    </div>

    <div class="page-content sign-kaizen">
        <section class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            Review Kaizen {{ kaizen.no }}
                        </h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form
                                @submit.prevent="submit"
                                class="form-update mb-5"
                            >
                                <div class="form-group">
                                    <label for="status" class="form-label"
                                        >Status
                                        <span class="text-danger"
                                            >*</span
                                        ></label
                                    >
                                    <select
                                        v-model="form.status_secretary_id"
                                        id="status"
                                        class="form-select"
                                        :class="{
                                            'is-invalid':
                                                errors.point_secretary,
                                        }"
                                        required
                                        autofocus
                                    >
                                        <option
                                            v-for="status in statuses"
                                            :key="status.id"
                                            :value="status.id"
                                        >
                                            {{ status.name }}
                                        </option>
                                    </select>
                                    <div
                                        v-if="errors.status_secretary_id"
                                        class="text-sm text-danger"
                                    >
                                        {{ errors.status_secretary_id }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="point" class="form-label"
                                        >Point
                                        <span class="text-danger"
                                            >*</span
                                        ></label
                                    >
                                    <input
                                        type="number"
                                        class="form-control"
                                        :class="{
                                            'is-invalid':
                                                errors.point_secretary,
                                        }"
                                        id="point"
                                        v-model="form.point_secretary"
                                        placeholder="Masukan jumlah point"
                                        required
                                    />
                                    <div
                                        v-if="errors.point_secretary"
                                        class="text-sm text-danger"
                                    >
                                        {{ errors.point_secretary }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="review" class="form-label"
                                        >Review
                                        <span class="text-danger"
                                            >*</span
                                        ></label
                                    >
                                    <textarea
                                        class="form-control"
                                        :class="{
                                            'is-invalid':
                                                errors.review_secretary,
                                        }"
                                        id="review"
                                        v-model="form.review_secretary"
                                        placeholder="Masukan review..."
                                        required
                                        rows="5"
                                    ></textarea>
                                    <div
                                        v-if="errors.review_secretary"
                                        class="text-sm text-danger"
                                    >
                                        {{ errors.review_secretary }}
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
                                    class="btn btn-warning shadow-sm ms-2"
                                    type="reset"
                                >
                                    <i class="fas fa-circle-notch"></i>
                                    Reset
                                </button>
                            </form>

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
                                        alt="Gambar Keadaan Saat Ini"
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
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import { Head, useForm, router, Link } from "@inertiajs/vue3";
import { ref, onBeforeMount, onMounted } from "vue";
import { toast } from "vue3-toastify";
import moment from "moment";
import App from "../../Layouts/App.vue";

export default {
    name: "PageKaizenSignSecretary",

    layout: App,

    components: {
        Head,
        Link,
    },

    props: {
        session: Object,
        kaizen: Object,
        statuses: Object,
        errors: Object,
    },

    setup(props) {
        const form = useForm({
            review_secretary: props.kaizen.review_secretary,
            point_secretary: props.kaizen.point_secretary,
            status_secretary_id: props.kaizen.status_secretary.id,
        });

        const submit = () => {
            router.put(`/admin/kaizens/${props.kaizen.id}/secretary`, form, {
                onSuccess: () => {
                    toast.success("Kaizen has been reviewed", {
                        theme: "colored",
                    });
                },
                onError: () => {
                    toast.error("Failed to review kaizen", {
                        theme: "colored",
                    });
                },
            });
        };

        const tanggalPengajuan = ref("");

        onBeforeMount(() => {
            tanggalPengajuan.value = moment(props.kaizen.created_at).format(
                "DD MMMM YYYY"
            );
        });

        onMounted(() => {
            if (props.session.error) {
                toast.error(props.session.error, { theme: "colored" });
            }
        });

        return {
            form,
            tanggalPengajuan,
            submit,
        };
    },
};
</script>

<style>
.sign-kaizen .description {
    margin-top: 2rem;
    border: 3px dashed #435ebe;
    border-radius: 15px;
    padding: 24px 16px 0px 16px;
}
</style>
