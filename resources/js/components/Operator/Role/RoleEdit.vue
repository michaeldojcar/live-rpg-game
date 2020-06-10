<template>
    <div class="container-fluid mt-3">

        <a class="btn btn-primary float-right" @click="submit">Uložit</a>
        <h4>Úprava postavy</h4>

        <div class="row">
            <div class="col-8">
                <div class="card my-2">
                    <div class="card-header">
                        Úprava postavy
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <label>Jméno postavy</label>
                            <input class="form-control" v-model="role.name" title="">
                        </div>

                        <div class="form-group">
                            <label>Skutečné jméno</label>
                            <input class="form-control" v-model="role.real_name" title="">
                        </div>
                        <div class="form-group">
                            <label>Charakteristika</label>
                            <textarea class="form-control" v-model="role.story" title=""/>
                        </div>
                        <div class="form-group">
                            <label>Typické činnosti</label>
                            <input class="form-control" v-model="role.action_recommends" title="">
                        </div>
                        <div class="form-group">
                            <label>Obvyklé umístění</label>
                            <input class="form-control" v-model="role.place_recommends" title="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "RoleEdit",

        data: () => {
            return {
                role: {},
            }
        },

        mounted() {
            this.refresh();
        },

        methods: {
            refresh() {
                axios
                    .get('/api/roles/' + this.$route.params.id)
                    .then(response => {
                        //  console.log(response.data);

                        this.role = response.data;
                    });
            },

            submit() {
                console.log('Storing role.');

                axios
                    .patch('/api/roles/' + this.role.id, {
                        name: this.role.name,
                        real_name: this.role.real_name,
                        story: this.role.story,
                        action_recommends: this.role.action_recommends,
                        place_recommends: this.role.place_recommends,
                    })
                    .then(response => {
                        console.log("Successfully updated.");
                        this.$router.push('/roles');
                    });


            }
        }
    }
</script>

<style scoped>

</style>
