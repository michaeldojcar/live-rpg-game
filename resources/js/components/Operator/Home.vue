<template>
    <div class="container-fluid mt-3">
        <h4>Hlavní přehled</h4>

        <h5>Aktuální stav hry</h5>

        <table class="table table-bordered w-50">
            <tr>
                <td>Aktivní větev úkolů</td>
                <td>
                    <div v-for="group in active_quest_groups">
                        {{group.name}}
                    </div>
                    <div v-if="!active_quest_groups.length" class="text-muted">žádná větev není aktivní</div>
                </td>
            </tr>
            <tr>
                <td>Celkem splněno úkolů</td>
                <td>0</td>
            </tr>
            <tr>
                <td>Mince v oběhu u hráčů</td>
                <td>3480</td>
            </tr>
            <tr>
                <td>Hráči</td>
                <td>{{player_count}}</td>
            </tr>
            <tr>
                <td>Postavy</td>
                <td>{{role_count}}</td>
            </tr>
            <tr>
                <td>Questy</td>
                <td>{{quest_count}} + {{sub_quest_count}} pod-questy</td>
            </tr>
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
