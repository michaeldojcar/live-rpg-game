<template>
    <div class="container-fluid">

        <div class="row">
            <div class="col-6">
                <h3>{{ player.name }}</h3>
                <p>Skupinka</p>
            </div>
            <div class="col-6 text-right">
                <router-link :to="'/players/' + player.id + '/edit'"
                             class="btn btn-primary">Upravit postavu
                </router-link>
            </div>
        </div>


        <div class="row">
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
