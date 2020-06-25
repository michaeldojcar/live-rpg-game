<template>
    <div class="container-fluid mt-3">
        <router-link to="/players/new" class="btn btn-success float-right">+ Nový hráč</router-link>

        <h4>Hráči</h4>

        <table class="w-50 table mt-4">
            <div style="padding: 10px 15px">
                <tr class="w-100">
                    <th scope="col" class="w-75" style="border: none">Jméno</th>
                    <th scope="col" style="border: none"></th>
                    <th scope="col" class="w-50" style="border: none">Věk</th>
                </tr>
                <tr v-for="player in players" :key="player.id">
                    <td>
                        <router-link :to="'/players/'+player.id+'/edit'">{{player.name}}</router-link>
                    </td>
                    <td></td>
                    <td>{{player.age}}</td>
                </tr>
            </div>
        </table>
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
