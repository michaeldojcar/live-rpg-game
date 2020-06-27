<template>
    <div class="container-fluid mt-3">
        <router-link to="/players/new"
                     class="btn btn-success float-right">+ Nový hráč
        </router-link>

        <h4>Hráči</h4>

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
                            <router-link :to="'/players/'+player.id">{{player.name}}</router-link>
                        </td>
                        <td>
                            <router-link to=""
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
