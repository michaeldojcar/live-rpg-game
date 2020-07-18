<template>
    <div class="container-fluid mt-3">
        <button @click="createNew" class="btn btn-success float-right">+ Nová větev</button>

        <h4>Větve questů</h4>

        <div class="alert alert-primary mt-3 w-75">
            Questy lze seskupit do souvisejících větví, v průběhu hry lze pracovat s jednotlivými větvemi - např.
            spustit questy pouze z některé větve.
        </div>

        <table class="table w-75 mt-4">
            <tr>
                <th>Jméno větve</th>
                <th style="border: none">Počet questů</th>
                <th style="border: none">Stav</th>
            </tr>
            <tr v-for="quest_group in quest_groups" :key="quest_group.id">
                <td>
                    <router-link :to="'/quest-groups/' + quest_group.id + '/edit'">
                        {{quest_group.name}}
                    </router-link>
                </td>
                <td>{{quest_group.quests_count}}</td>
                <td>
                    <span v-if="quest_group.active" class="text-success font-weight-bold">Aktivní</span>
                    <span v-else class="text-danger">Neaktivní</span>
                </td>
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

                        this.$router.push('/quest-groups/' + id + '/edit')
                    });
            }
        }
    }
</script>

<style scoped>

</style>
