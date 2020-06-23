<template>
    <div class="container-fluid mt-3">
        <div class="card">
            <div class="card-body">
                <h4>Úprava hráče</h4>
                <div class="form-group">
                    <label>Jméno</label>
                    <input type="text" class="form-control" v-model="name">
                </div>

                <div class="form-group">
                    <label>Datum narození</label>
                    <input type="date" class="form-control" v-model="birth_date">
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: "PlayerEdit",

        data: () => {
            return {
                name: null,
                birth_date: null
            }
        },

        mounted() {
            this.refresh();
        },

        methods: {
            refresh() {
                axios
                    .get('/api/players/' + this.$route.params.id)
                    .then(response => {
                        console.log(response.data);

                        this.name = response.data.name;
                        this.birth_date = response.data.birth_date;
                    });
            }
        }
    }
</script>

<style scoped>

</style>
