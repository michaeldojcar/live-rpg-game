<template>
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-6">
                <h4>Úprava skupiny</h4>
            </div>
            <div class="col-6">
                <a class="btn btn-primary float-right"
                   @click="submit">Uložit</a>
            </div>
        </div>

        <div class="row">
            <div class="col-8">
                <div class="card my-2">
                    <div class="card-header">
                        Úprava skupiny
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <label>Jméno postavy</label>
                            <input class="form-control"
                                   v-model="name"
                                   title="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "GroupEdit",

        data: () => {
            return {
                id: null,
                name: null,
            }
        },

        mounted() {
            this.refresh();
        },

        methods: {
            refresh() {
                axios
                    .get('/api/groups/' + this.$route.params.id)
                    .then(response => {
                        this.id = response.data.id;
                        this.name = response.data.name;
                    });
            },

            submit() {
                axios
                    .patch('/api/groups/' + this.id, {
                        name: this.name,
                    })
                    .then(response => {
                        console.log("Successfully updated.");
                        this.$router.push('/groups');
                    });


            }
        }
    }
</script>

<style scoped>

</style>
