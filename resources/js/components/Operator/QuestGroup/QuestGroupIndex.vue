<template>
    <div class="container-fluid mt-3">
        <a href="#" @click="createNew" class="btn btn-success float-right">+ Nový úkol</a>

        <h4>Větve questů</h4>

        <div class="alert alert-primary mt-3 w-50">
            Questy lze seskupit do souvisejících větví, v průběhu hry lze pracovat s jednotlivými větvemi - např.
            spustit questy pouze z některé větve.
        </div>
        <table class="table w-50 mt-4" style="border-radius: 0.25rem!important;">
            <div style="padding: 10px 15px">
                <tr class="w-100">
                    <th class="w-50" scope="col" style="border: none">Jméno větve</th>
                    <th style="border: none"></th>
                    <th class="w-50" scope="col" style="border: none">Stav</th>
                </tr>
                <tr v-for="quest in quest_groups" :key="quest.id">
                    <td>
                        <router-link :to="'/quests/' + quest.id + '/edit'">
                            {{quest.name}}
                        </router-link>
                    </td>
                    <td></td>
                    <td>
                        <span v-if="quest.active" class="text-success font-weight-bold">Aktivní</span>
                        <span v-else class="text-danger">Neaktivní</span>
                    </td>
                </tr>
            </div>
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
