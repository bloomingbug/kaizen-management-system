<template>
    <Head>
        <title>Formulir Ide Kaizen - Aplikasi Kaizen</title>
    </Head>

    <div id="form" class="form-kaizen mb-5">
        <div class="container overflow-hidden">
            <div class="row">
                <div class="col-12 offset-md-2 col-md-8">
                    <div class="card mt-3 mb-4">
                        <div class="card-content">
                            <img
                                src="assets/images/cover/form.jpg"
                                alt="Cover Form"
                                class="card-img-top img-fluid w-100 overflow-hidden"
                            />
                            <div class="card-body">
                                <h3 class="card-title fs-2 mb-3">
                                    Formulir Ide Kaizen
                                </h3>
                                <p class="card-text">
                                    Mari bersama-sama berinovasi untuk
                                    menciptakan perbaikan yang lebih baik! Kami
                                    menghargai ide kaizen yang Anda berikan dan
                                    percaya bahwa setiap kontribusi dapat
                                    membantu perusahaan tumbuh dan berkembang.
                                    Kami berterima kasih atas semangat Anda
                                    dalam memberikan usulan yang konstruktif
                                    untuk meningkatkan kinerja dan efisiensi.
                                    Teruslah berinovasi dan menjadi bagian dari
                                    perubahan positif di perusahaan!
                                </p>
                                <p class="card-text">
                                    <span class="text-sm text-danger">*</span>
                                    Wajib diisi
                                </p>
                            </div>
                        </div>
                    </div>

                    <form
                        class="mb-3"
                        method="post"
                        enctype="multipart/form-data"
                        @submit.prevent="submit"
                    >
                        <div
                            v-if="session.error"
                            class="alert alert-warning"
                            role="alert"
                        >
                            {{ session.error }}
                        </div>

                        <div class="card my-3">
                            <div class="card-content">
                                <div class="card-body">
                                    <label
                                        for="name"
                                        class="card-title form-label"
                                        >Nama Lengkap
                                        <span class="text-sm text-danger"
                                            >*</span
                                        >
                                    </label>
                                    <input
                                        type="text"
                                        id="name"
                                        v-model="form.name"
                                        class="form-control"
                                        :class="{ 'is-invalid': errors.name }"
                                        placeholder="Masukan nama lengkap anda"
                                        autofocus
                                    />
                                    <div v-if="errors.name">
                                        <span class="text-sm text-danger">{{
                                            errors.name
                                        }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card my-3">
                            <div class="card-content">
                                <div class="card-body">
                                    <label
                                        for="departement"
                                        class="card-title form-label"
                                        >Departement
                                        <span class="text-sm text-danger"
                                            >*</span
                                        ></label
                                    >
                                    <select
                                        class="form-select"
                                        :class="{
                                            'is-invalid': errors.departement_id,
                                        }"
                                        v-model="form.departement_id"
                                        id="departement"
                                    >
                                        <option
                                            value=""
                                            selected
                                            hidden
                                            disabled
                                        >
                                            -- Pilih Departement --
                                        </option>
                                        <option
                                            v-for="departement in departements"
                                            :key="departement.id"
                                            :value="departement.id"
                                        >
                                            {{ departement.name }}
                                        </option>
                                    </select>
                                    <div v-if="errors.departement_id">
                                        <span class="text-sm text-danger">{{
                                            errors.departement_id
                                        }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card my-3">
                            <div class="card-content">
                                <div class="card-body">
                                    <label
                                        for="category"
                                        class="card-title form-label"
                                        >Target Improvement
                                        <span class="text-sm text-danger"
                                            >*</span
                                        ></label
                                    >
                                    <select
                                        class="form-select"
                                        :class="{
                                            'is-invalid': errors.category_id,
                                        }"
                                        v-model="form.category_id"
                                        id="category"
                                    >
                                        <option
                                            value=""
                                            selected
                                            hidden
                                            disabled
                                        >
                                            -- Pilih Target Improvement --
                                        </option>
                                        <option
                                            v-for="category in categories"
                                            :key="category.id"
                                            :value="category.id"
                                        >
                                            {{ category.name }}
                                        </option>
                                    </select>
                                    <div v-if="errors.category_id">
                                        <span class="text-sm text-danger">{{
                                            errors.category_id
                                        }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card my-3">
                            <div class="card-content">
                                <div class="card-body">
                                    <label
                                        for="descriptionOld"
                                        class="card-title form-label"
                                    >
                                        Keadaan Saat Ini
                                        <span class="text-sm text-danger"
                                            >*</span
                                        ></label
                                    >
                                    <textarea
                                        id="descriptionOld"
                                        class="form-control"
                                        :class="{
                                            'is-invalid':
                                                errors.description_old,
                                        }"
                                        v-model="form.description_old"
                                        rows="5"
                                        placeholder="Deskripsikan keadaan saat ini..."
                                    ></textarea>
                                    <div v-if="errors.description_old">
                                        <span class="text-sm text-danger">{{
                                            errors.description_old
                                        }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card my-3">
                            <div class="card-content">
                                <div class="card-body">
                                    <label
                                        for="imageOld"
                                        class="card-title form-label"
                                        >Foto Keadaan Saat Ini (Opsional)
                                    </label>
                                    <input
                                        type="file"
                                        id="imageOld"
                                        @input="
                                            form.image_old =
                                                $event.target.files[0]
                                        "
                                        class="form-control"
                                        :class="{
                                            'is-invalid': errors.image_old,
                                        }"
                                    />
                                    <span class="text-sm text-secondary"
                                        >Format .jpg, .jpeg, .png (Max.
                                        2MB)</span
                                    >
                                    <div v-if="errors.image_old">
                                        <span class="text-sm text-danger">{{
                                            errors.image_old
                                        }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card my-3">
                            <div class="card-content">
                                <div class="card-body">
                                    <label
                                        for="descriptionNew"
                                        class="card-title form-label"
                                    >
                                        Usulan Perbaikan
                                        <span class="text-sm text-danger"
                                            >*</span
                                        ></label
                                    >
                                    <textarea
                                        id="descriptionNew"
                                        class="form-control"
                                        :class="{
                                            'is-invalid':
                                                errors.description_new,
                                        }"
                                        v-model="form.description_new"
                                        rows="5"
                                        placeholder="Deskripsikan usulan perbaikan..."
                                    ></textarea>
                                    <div v-if="errors.description_new">
                                        <span class="text-sm text-danger">{{
                                            errors.description_new
                                        }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card my-3">
                            <div class="card-content">
                                <div class="card-body">
                                    <label
                                        for="imageNew"
                                        class="card-title form-label"
                                        >Foto Usulan (Opsional)
                                    </label>
                                    <input
                                        type="file"
                                        id="imageNew"
                                        @input="
                                            form.image_new =
                                                $event.target.files[0]
                                        "
                                        class="form-control"
                                        :class="{
                                            'is-invalid': errors.image_new,
                                        }"
                                    />
                                    <span class="text-sm text-secondary"
                                        >Format .jpg, .jpeg, .png (Max.
                                        2MB)</span
                                    >
                                    <div v-if="errors.image_new">
                                        <span class="text-sm text-danger">{{
                                            errors.image_new
                                        }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card my-3">
                            <div class="card-content">
                                <div class="card-body">
                                    <label
                                        for="descriptionNew"
                                        class="card-title form-label"
                                    >
                                        Manfaat / Keuntungan
                                        <span class="text-sm text-danger"
                                            >*</span
                                        ></label
                                    >
                                    <textarea
                                        id="descriptionNew"
                                        class="form-control"
                                        :class="{
                                            'is-invalid': errors.benefit,
                                        }"
                                        v-model="form.benefit"
                                        rows="5"
                                        placeholder="Manfaat yang dihasilkan..."
                                    ></textarea>
                                    <div v-if="errors.benefit">
                                        <span class="text-sm text-danger">{{
                                            errors.benefit
                                        }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div
                            class="progress progress-primary mb-3"
                            v-if="form.progress"
                        >
                            <div
                                class="progress-bar progress-bar-striped progress-bar-animated"
                                role="progressbar"
                                :style="{
                                    width: form.progress.percentage + '%',
                                }"
                            >
                                {{ form.progress.percentage + "%" }}
                            </div>
                        </div>

                        <div class="clearfix">
                            <button
                                type="submit"
                                class="btn btn-primary btn-lg float-end"
                                :disabled="form.processing"
                            >
                                <i class="fas fa-paper-plane me-2"></i>
                                Kirim
                            </button>
                        </div>
                    </form>
                    <Footer />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Head, useForm } from "@inertiajs/vue3";
import { onMounted } from "vue";
import { toast } from "vue3-toastify";
import Footer from "../../Components/Footer.vue";

export default {
    name: "FormKaizenPage",

    props: {
        errors: Object,
        session: Object,
        categories: Object,
        departements: Object,
    },

    components: { Head, Footer },

    setup(props) {
        const form = useForm({
            departement_id: "",
            category_id: "",
            name: "",
            description_old: "",
            description_new: "",
            image_old: "",
            image_new: "",
            benefit: "",
        });

        const submit = () => {
            form.post("/", {
                onSuccess: () => {},
                onError: () => {
                    toast.error("Failed to send kaizen!", {
                        theme: "colored",
                    });
                },
            });
        };

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

            if (props.session.error) {
                toast.error(props.session.error, { theme: "colored" });
            }
        });

        return {
            form,
            submit,
        };
    },
};
</script>

<style>
.form-kaizen .card-img-top {
    object-fit: cover;
    object-position: center;
}

@media screen and (max-width: 768px) {
    .form-kaizen .card-img-top {
        min-height: 120px;
    }
}

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
</style>
