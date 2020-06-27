<template>
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-6">
                <h4>Hráči</h4>
            </div>
            <div class="col-6 text-right">
                <router-link to="/players/new"
                             class="btn btn-success float-righgt">+ Nový hráč
                </router-link>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <table class="table mt-4">
                    <tr>
                        <th>Jméno</th>
                        <th>Skupina</th>
                        <th>Věk</th>
                    </tr>
                    <tr v-for="player in players"
                        :key="player.id">
                        <td>
                            <router-link :to="'/players/' + player.id">
                                {{player.name}}
                            </router-link>
                        </td>
                        <td>
                            <router-link :to="'/groups/' + player.group.id"
                                         v-if="player.group">{{player.group.name}}
                            </router-link>
                        </td>
                        <td>{{player.age}}</td>
                    </tr>
                </table>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: "PlayerIndex",

        data: () => {
            return {
                players: [],
            }
        },

        mounted() {
            this.refresh();
        },

        methods: {
            refresh() {
                axios
                    .get('/api/players')
                    .then(response => {
                        console.log(response.data);

                        this.players = response.data;
                    });
            }
        }
    }
</script>

<style scoped>

</style>
