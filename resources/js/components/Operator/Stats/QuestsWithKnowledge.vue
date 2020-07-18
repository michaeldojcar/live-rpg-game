<template>
    <div class="container-fluid mt-3">
        <h4>Statistika</h4>
        <p>Questy s informacemi</p>

        <div class="alert alert-primary mt-3 w-75">
            Tato statistika ukazuje, jak jsou rozšířené questy s informacemi.
        </div>

        <table class="table w-75 mt-4">
            <tr>
                <th>Větev</th>
                <th style="border: none">Název</th>
                <th>Informace</th>
                <th style="border: none">Stav</th>
            </tr>
            <tr v-for="quest in quests"
                :key="quest.id">
                <td>{{quest.quest_group.name}}</td>
                <td>
                    <router-link :to="'/quests/' + quest.id + '/edit'">
                        {{quest.name}}
                    </router-link>
                </td>
                <td>{{quest.reward_knowledge}}</td>
                <td>{{quest.spread}} %</td>
            </tr>
        </table>
    </div>
</template>

<script>
    export default {
        name: "QuestsWithKnowledge",

        data: () => {
            return {
                quests: [],
            }
        },

        mounted() {
            axios
                .get('/api/stats/knowledge-quests')
                .then(response => {
                    console.log(response.data);

                    this.quests = response.data;
                });
        }
    }
</script>

<style scoped>

</style>
