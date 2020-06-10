<template>
    <div class="container-fluid mt-3">
        <h4 class="mb-4">Hlavní přehled</h4>

        <h5 class="mb-2">Aktuální stav hry</h5>

        <table class="table w-50 mt-4" style="border-radius: 0.25rem!important;">
            <div style="padding: 10px 15px">
                <tr class="w-100">
                    <th class="w-50" scope="col" style="border: none">Aktivní větev úkolů</th>
                    <th style="border: none"></th>
                    <th class="w-50" scope="col" style="border: none">
                        <div v-for="group in active_quest_groups">
                            {{group.name}}
                        </div>
                        <div v-if="!active_quest_groups.length" class="text-muted">žádná větev není aktivní</div>
                    </th>
                </tr>
                <tr>
                    <td>Celkem splněno úkolů</td>
                    <td></td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>Mince v oběhu u hráčů</td>
                    <td></td>
                    <td>3480</td>
                </tr>
                <tr>
                    <td>Hráči</td>
                    <td></td>
                    <td>{{player_count}}</td>
                </tr>
                <tr>
                    <td>Postavy</td>
                    <td></td>
                    <td>{{role_count}}</td>
                </tr>
                <tr>
                    <td>Questy</td>
                    <td></td>
                    <td>{{quest_count}} + {{sub_quest_count}} pod-questy</td>
                </tr>
            </div>

        </table>
    </div>
</template>

<script>
    export default {
        name: "home",

        components: {},

        data() {
            return {
                active_quest_groups: [],
                role_count: 0,
                player_count: 0,
                quest_count: 0,
                sub_quest_count: 0,
            }
        },

        mounted() {
            axios
                .get('/api/overview')
                .then(response => {
                    console.log(response.data);

                    this.active_quest_groups = response.data.active_quest_groups;
                    this.quest_count = response.data.quest_count;
                    this.sub_quest_count = response.data.sub_quest_count;
                    this.player_count = response.data.player_count;
                    this.role_count = response.data.role_count;
                });
        },
    }
</script>

<style scoped>

</style>
