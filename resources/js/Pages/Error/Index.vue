<script setup lang="ts">
defineProps<{
    status: number;
    message: string;
}>();
</script>

<template>
    <div id="error">
        <div class="error-page container">
            <div class="col-md-8 col-12 offset-md-2">
                <div class="text-center">
                    <img
                        v-if="status == 403"
                        class="img-error"
                        src="/assets/images/samples/error-403.svg"
                        alt="Forbidden"
                    />
                    <img
                        v-else-if="status == 404"
                        class="img-error"
                        src="/assets/images/samples/error-404.svg"
                        alt="Not Found"
                    />

                    <img
                        v-else
                        class="img-error"
                        src="/assets/images/samples/error-500.svg"
                        alt="Error"
                    />

                    <h1 class="error-title">Error {{ status }}</h1>
                    <p class="fs-5 text-gray-600">
                        {{ message }}
                    </p>
                    <a href="/" class="btn btn-lg btn-outline-primary mt-3"
                        >Go Home</a
                    >
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
@import "../../../../public/assets/css/pages/error.css";
</style>

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
</style>
