<template>
    <div class="container-fluid mt-3">
        <div class="card">
            <div class="card-body">
                <h4>Úprava hráče</h4>

            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: "PlayerEdit",

        data: () => {
            return {
                roles: [],
            }
        },

        mounted() {
            this.refresh();
        },

        methods: {
            refresh() {
                axios
                    .get('/api/roles')
                    .then(response => {
                        console.log(response.data);

                        this.roles = response.data;
                    });
            }
        }
    }
</script>

<style scoped>

</style>
