<template>
    <div class="container-fluid mt-3">
        <a href="#" @click="createNew" class="btn btn-success float-right">+ Nový úkol</a>

        <h4>Větve questů</h4>

        <div class="alert alert-primary mt-3 w-50">
            Questy lze seskupit do souvisejících větví, v průběhu hry lze pracovat s jednotlivými větvemi - např.
            spustit questy pouze z některé větve.
        </div>

        <table class="w-50 table table-bordered">
            <tr>
                <th>Jméno</th>
                <th>Počet questů</th>
            </tr>
            <tr v-for="quest in quest_groups" :key="quest.id">
                <td>
                    <router-link :to="'/quests/' + quest.id + '/edit'">
                        {{quest.name}}
                    </router-link>
                </td>
                <td>{{quest.owner.name}}</td>
            </tr>
        </table>
    </div>
</template>

<script>
    export default {
        name: "QuestGroupIndex",

        data: () => {
            return {
                quest_groups: [],
            }
        },

        mounted() {
            axios
                .get('/api/quest_groups')
                .then(response => {
                    console.log(response.data);

                    this.quest_groups = response.data;
                });
        },

        methods: {
            createNew() {
                axios
                    .post('/api/quest_groups')
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
