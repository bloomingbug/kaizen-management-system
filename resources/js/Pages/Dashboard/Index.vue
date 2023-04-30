<template>
    <Head>
        <title>Dashboard - Aplikasi Kaizen</title>
        <meta name="description" content="Dashboard Aplikasi Kaizen" />
    </Head>

    <div class="page-heading">
        <h3>Dashboard</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="row">
                    <div
                        v-if="hasAnyPermission(['kaizen.secretary'])"
                        class="col-6 col-lg-3 col-md-6"
                    >
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div
                                        class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start"
                                    >
                                        <div class="stats-icon blue mb-2">
                                            <i class="fas fa-plus"></i>
                                        </div>
                                    </div>
                                    <div
                                        class="col-md-8 col-lg-12 col-xl-12 col-xxl-7"
                                    >
                                        <h6 class="text-muted font-semibold">
                                            Need Approval Secre.
                                        </h6>
                                        <h6 class="font-extrabold mb-0">
                                            {{ sumKaizenNewSecretary }}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        v-if="hasAnyPermission(['kaizen.pic'])"
                        class="col-6 col-lg-3 col-md-6"
                    >
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div
                                        class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start"
                                    >
                                        <div class="stats-icon blue mb-2">
                                            <i class="fas fa-plus"></i>
                                        </div>
                                    </div>
                                    <div
                                        class="col-md-8 col-lg-12 col-xl-12 col-xxl-7"
                                    >
                                        <h6 class="text-muted font-semibold">
                                            Need Approval PIC
                                        </h6>
                                        <h6 class="font-extrabold mb-0">
                                            {{ sumKaizenNewPic }}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div
                                        class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start"
                                    >
                                        <div class="stats-icon blue mb-2">
                                            <i class="fas fa-info-circle"></i>
                                        </div>
                                    </div>
                                    <div
                                        class="col-md-8 col-lg-12 col-xl-12 col-xxl-7"
                                    >
                                        <h6 class="text-muted font-semibold">
                                            Kaizen Today
                                        </h6>
                                        <h6 class="font-extrabold mb-0">
                                            {{ sumKaizenToday }}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div
                                        class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start"
                                    >
                                        <div class="stats-icon blue mb-2">
                                            <i class="fas fa-info-circle"></i>
                                        </div>
                                    </div>
                                    <div
                                        class="col-md-8 col-lg-12 col-xl-12 col-xxl-7"
                                    >
                                        <h6 class="text-muted font-semibold">
                                            Kaizen This Month
                                        </h6>
                                        <h6 class="font-extrabold mb-0">
                                            {{ sumKaizenThisMonth }}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div
                                        class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start"
                                    >
                                        <div class="stats-icon blue mb-2">
                                            <i class="fas fa-info-circle"></i>
                                        </div>
                                    </div>
                                    <div
                                        class="col-md-8 col-lg-12 col-xl-12 col-xxl-7"
                                    >
                                        <h6 class="text-muted font-semibold">
                                            Total Kaizen
                                        </h6>
                                        <h6 class="font-extrabold mb-0">
                                            {{ sumKaizen }}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div
                                        class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start"
                                    >
                                        <div class="stats-icon green mb-2">
                                            <i class="fas fa-check"></i>
                                        </div>
                                    </div>
                                    <div
                                        class="col-md-8 col-lg-12 col-xl-12 col-xxl-7"
                                    >
                                        <h6 class="text-muted font-semibold">
                                            Kaizen Approved
                                        </h6>
                                        <h6 class="font-extrabold mb-0">
                                            {{ sumKaizenApproved }}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div
                                        class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start"
                                    >
                                        <div class="stats-icon bg-warning mb-2">
                                            <i class="fas fa-circle-notch"></i>
                                        </div>
                                    </div>
                                    <div
                                        class="col-md-8 col-lg-12 col-xl-12 col-xxl-7"
                                    >
                                        <h6 class="text-muted font-semibold">
                                            Kaizen Pending
                                        </h6>
                                        <h6 class="font-extrabold mb-0">
                                            {{ sumKaizenPending }}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div
                                        class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start"
                                    >
                                        <div class="stats-icon red mb-2">
                                            <i class="fas fa-times"></i>
                                        </div>
                                    </div>
                                    <div
                                        class="col-md-8 col-lg-12 col-xl-12 col-xxl-7"
                                    >
                                        <h6 class="text-muted font-semibold">
                                            Kaizen Rejected
                                        </h6>
                                        <h6 class="font-extrabold mb-0">
                                            {{ sumKaizenRejected }}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-7">
                        <div class="card">
                            <div class="card-header">
                                <h4>Kaizen 30 Hari Terakhir</h4>
                            </div>
                            <div class="card-body">
                                <apexcharts
                                    type="area"
                                    :options="optionsLine"
                                    :series="seriesLine"
                                ></apexcharts>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-5">
                        <div class="card">
                            <div class="card-header">
                                <h4>Kaizen Kategori</h4>
                            </div>
                            <div class="card-body">
                                <apexcharts
                                    type="donut"
                                    :options="optionsDonut"
                                    :series="seriesDonut"
                                ></apexcharts>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Kaizen Terbaru</h4>
                            </div>
                            <div class="card-body">
                                <div v-if="kaizensNew.length > 0">
                                    <div class="table-responsive">
                                        <table
                                            class="table table-hover table-lg"
                                        >
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Category</th>
                                                    <th>Departement</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr
                                                    v-for="kaizen in kaizensNew"
                                                    :key="kaizen.id"
                                                >
                                                    <td>{{ kaizen.no }}</td>
                                                    <td>
                                                        {{
                                                            kaizen.category.name
                                                        }}
                                                    </td>
                                                    <td>
                                                        {{
                                                            kaizen.departement
                                                                .name
                                                        }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div
                                    v-else
                                    class="alert alert-danger border-0 shadow-sm rounded-4"
                                >
                                    Data Tidak Tersedia!
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
import { Head } from "@inertiajs/vue3";
import VueApexCharts from "vue3-apexcharts";
import LayoutApp from "../../Layouts/App.vue";

export default {
    name: "DashboardPage",

    layout: LayoutApp,

    components: {
        Head,
        apexcharts: VueApexCharts,
    },

    props: {
        auth: Object,

        sumKaizenToday: Number,
        sumKaizenThisMonth: Number,
        sumKaizen: Number,
        sumKaizenApproved: Number,
        sumKaizenRejected: Number,
        sumKaizenPending: Number,
        sumKaizenNewSecretary: Number,
        sumKaizenNewPic: Number,

        kaizensNew: Object,

        categoryDonut: Array,
        countDonut: Array,

        dateLine: Array,
        countLine: Array,

        session: Object,
    },

    setup(props) {
        const getRandomColor = () => {
            let letters = "0123456789ABCDEF".split("");
            let color = "#";

            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }

            return color;
        };

        const randomBackgroundColor = (length) => {
            let data = [];

            for (let i = 0; i < length; i++) {
                data.push(getRandomColor());
            }

            return data;
        };

        const optionsLine = {
            stroke: {
                curve: "smooth",
            },
            chart: {
                id: "data-kaizen-berdasarkan-tanggal",
            },
            xaxis: {
                // data = props.dateLine and handling when empty
                categories: props.dateLine[0] != "" ? props.dateLine : ["-"],
            },
            colors: randomBackgroundColor(1),
        };

        const seriesLine = [
            {
                name: "Jumlah Kaizen",
                // data = props.countLine and handling when empty
                data: props.countLine[0] != "" ? props.countLine : [0],
            },
        ];

        const optionsDonut = {
            chart: {
                id: "data-kaizen-berdasarkan-status",
                toolbar: {
                    show: true,
                    offsetX: 0,
                    offsetY: 0,
                    tools: {
                        download: true,
                        selection: true,
                        zoom: true,
                        zoomin: true,
                        zoomout: true,
                        pan: true,
                    },
                    autoSelected: "zoom",
                },
            },
            labels: props.categoryDonut[0] != "" ? props.categoryDonut : ["-"],
            colors: randomBackgroundColor(props.categoryDonut.length),
            legend: {
                position: "bottom",
            },
        };

        const seriesDonut = props.countDonut[0] != "" ? props.countDonut : [0];

        return {
            optionsLine,
            seriesLine,
            optionsDonut,
            seriesDonut,
        };
    },
};
</script>

<style scoped>
.stats-icon.bg-warning .fas.fa-circle-notch {
    animation: spin 3s linear infinite;
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}
</style>
