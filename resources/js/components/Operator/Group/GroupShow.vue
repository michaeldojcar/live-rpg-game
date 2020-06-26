<template>
    <div class="container-fluid mt-3">
        <h3>{{group.name}}</h3>
        <p>Skupina hráčů</p>

        <div class="row">
            <div class="col-7">
             <table class="table">
                 <tr>
                 <th>Jméno</th>
                 </tr>

                 <tr v-for="player in group.members">
                     <td>{{player.name}}</td>
                 </tr>

             </table>
            </div>
            <div class="col-5">

            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: "GroupShow",

        data: () => {
            return {
                group: {}
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

                        this.group = response.data;
                    });
            }
        }
    }
</script>

<style scoped>

</style>
