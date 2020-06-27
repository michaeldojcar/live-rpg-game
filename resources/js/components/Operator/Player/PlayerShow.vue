<template>
    <div class="container-fluid">

        <div class="row">
            <div class="col-1 my-auto">
                <button class="btn btn-color bg-danger text-danger w-100"
                        v-if="player.color_1 === 1">.
                </button>
                <button class="btn btn-color bg-primary text-primary w-100"
                        v-if="player.color_1 === 2">.
                </button>
                <button class="btn btn-color bg-success text-success w-100"
                        v-if="player.color_1 === 3">.
                </button>
                <button class="btn btn-color bg-warning text-warning w-100"
                        v-if="player.color_1 === 4">.
                </button>
                <br>
                <button class="btn btn-color bg-danger text-danger  w-100"
                        v-if="player.color_2 === 1">.
                </button>
                <button class="btn btn-color bg-primary text-primary w-100"
                        v-if="player.color_2 === 2">.
                </button>
                <button class="btn btn-color bg-success text-success w-100"
                        v-if="player.color_2 === 3">.
                </button>
                <button class="btn btn-color bg-warning text-warning w-100"
                        v-if="player.color_2 === 4">.
                </button>
                <br>
                <button class="btn btn-color bg-danger text-danger  w-100"
                        v-if="player.color_3 === 1">.
                </button>
                <button class="btn btn-color bg-primary text-primary w-100"
                        v-if="player.color_3 === 2">.
                </button>
                <button class="btn btn-color bg-success text-success w-100"
                        v-if="player.color_3 === 3">.
                </button>
                <button class="btn btn-color bg-warning text-warning w-100"
                        v-if="player.color_3 === 4">.
                </button>
            </div>
            <div class="col-6 my-auto">
                <h3>{{ player.name }}</h3>
                <p v-if="player.group">Hráč, {{player.group.name}}</p>
                <p v-else>Hráč</p>
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
                                <td v-if="player.group">{{player.group.name}}</td>
                            </tr>

                            <tr>
                                <td>Počet splněných questů</td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>Počet zlaťáků</td>
                                <td>{{player.cash}}</td>
                            </tr>
                            <tr>
                                <td>Počet obsidiánů</td>
                                <td>{{player.points}}</td>
                            </tr>
                            <tr>
                                <td>Naposledy spatřen</td>
                                <td>
                                    {{player.last_seen | moment('D.MM. YYYY h:mm:ss')}}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td>Stav hráče:
                                    <span v-if="player.is_online"
                                          class="text-success font-weight-bold">Online</span>
                                    <span v-else
                                          class="text-danger font-weight-bold">Offline</span>
                                </td>
                                <td>
                                    Kontakt {{player.last_seen_string}}
                                </td>
                            </tr>
                        </table>

                        <single-point-map v-if="player.latitude && player.longitude"
                                          :latitude="player.latitude"
                                          :longitude="player.longitude"/>
                        <div class="alert alert-warning"
                             v-else>
                            Hráč nemá zaznamenanou nedávnou polohu.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import SinglePointMap from "../Components/SinglePointMap";

    export default {
        name: "PlayerShow",

        components: {SinglePointMap},

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
