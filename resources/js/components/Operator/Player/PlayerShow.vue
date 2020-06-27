<template>
    <div class="container-fluid">

        <div class="row">
            <div class="col-1 my-auto">
                <button class="btn btn-color bg-danger text-danger w-100" v-if="player.color_1 === 1">.</button>
                <button class="btn btn-color bg-primary text-primary w-100" v-if="player.color_1 === 2">.</button>
                <button class="btn btn-color bg-success text-success w-100" v-if="player.color_1 === 3">.</button>
                <button class="btn btn-color bg-warning text-warning w-100" v-if="player.color_1 === 4">.</button>
                <br>
                <button class="btn btn-color bg-danger text-danger  w-100" v-if="player.color_2 === 1">.</button>
                <button class="btn btn-color bg-primary text-primary w-100" v-if="player.color_2 === 2">.</button>
                <button class="btn btn-color bg-success text-success w-100" v-if="player.color_2 === 3">.</button>
                <button class="btn btn-color bg-warning text-warning w-100" v-if="player.color_2 === 4">.</button>
                <br>
                <button class="btn btn-color bg-danger text-danger  w-100" v-if="player.color_3 === 1">.</button>
                <button class="btn btn-color bg-primary text-primary w-100" v-if="player.color_3 === 2">.</button>
                <button class="btn btn-color bg-success text-success w-100" v-if="player.color_3 === 3">.</button>
                <button class="btn btn-color bg-warning text-warning w-100" v-if="player.color_3 === 4">.</button>
            </div>
            <div class="col-6 my-auto">
                <h3>{{ player.name }}</h3>
                <p>Skupinka</p>
            </div>
            <div class="col-5 text-right">
                <router-link :to="'/players/' + player.id + '/edit'"
                             class="btn btn-primary">Upravit hráče
                </router-link>
            </div>
        </div>


        <div class="row mt-4">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">Informace o hráči</div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td>Jméno</td>
                                <td>{{player.name}}</td>
                            </tr>

                            <tr>
                                <td>Věk</td>
                                <td>{{player.age}}</td>
                            </tr>

                            <tr>
                                <td>Skupinka</td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>Počet splněných questů</td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>Počet zlaťáků</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Počet obsidiánů</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Naposledy spatřen</td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!--            <div class="col-sm-6">-->
            <!--                <div class="card">-->
            <!--                    <div class="card-body">-->
            <!--                        <single-point-map v-if="role.latitude && role.longitude"-->
            <!--                                          :latitude="role.latitude"-->
            <!--                                          :longitude="role.longitude"/>-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--            </div>-->
        </div>
    </div>
</template>

<script>
    // import SinglePointMap from "../Components/SinglePointMap";

    export default {
        name: "PlayerShow",
        // components: {SinglePointMap},
        data: () => {
            return {
                player: {},
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

                        this.player = response.data;
                    });
            },
        }
    }
</script>

<style scoped>

</style>
