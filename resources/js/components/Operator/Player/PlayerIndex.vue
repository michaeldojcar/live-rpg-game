<template>
    <div class="container-fluid mt-3">
        <router-link to="#" class="btn btn-success float-right">+ Nový hráč</router-link>

        <h4>Hráči</h4>

        <table class="w-50 table table-bordered">
            <tr>
                <th>Jméno</th>
                <th>Věk</th>
            </tr>
            <tr v-for="player in players" :key="player.id">
                <td>
                    <router-link to="#">{{player.name}}</router-link>
                </td>
                <td>{{player.age}}</td>
            </tr>
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
