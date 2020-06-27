<template>
    <div class="container-fluid mt-3">
        <a href="#"
           @click="createNew"
           class="btn btn-success float-right">+ Nový úkol</a>

        <h4>Questy</h4>

        <table class="table mt-4">
            <tr>
                <th>Jméno</th>
                <th>Postava</th>
                <th>Peníze</th>
            </tr>
            <tr v-for="quest in quests"
                :key="quest.id">
                <td>
                    <router-link :to="'/quests/'+quest.id+'/edit'">
                        {{quest.name}}
                    </router-link>
                </td>
                <td>{{quest.owner.name}}</td>
                <td>
                    <reward-cash :cash="quest.reward_cash"></reward-cash>
                </td>
            </tr>
        </table>
    </div>
</template>

<script>
    import RewardCash from "../../Role/RewardCash";
    export default {
        name: "RoleIndex",
        components: {RewardCash},
        data: () => {
            return {
                quests: [],
            }
        },

        mounted() {
            axios
                .get('/api/quests')
                .then(response => {
                    console.log(response.data);

                    this.quests = response.data;
                });
        },

        methods: {
            createNew() {
                axios
                    .post('/api/quests')
                    .then(response => {
                        console.log(response.data);

                        let id = response.data.id;
                        console.log(id);

                        this.$router.push('/quests/' + id + '/edit')
                    });
            }
        }
    }
</script>

<style scoped>

</style>
