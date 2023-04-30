<template>
    <footer>
        <div class="footer mb-0 text-muted">
            {{ year }} &copy; Aplikasi Kaizen
        </div>
    </footer>
</template>

<script>
export default {
    setup() {
        const year = new Date().getFullYear();

        return {
            year,
        };
    },
};
</script>

<style scoped></style>
