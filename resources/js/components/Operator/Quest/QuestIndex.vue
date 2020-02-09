<template>
    <div class="container-fluid mt-3">
        <router-link to="#" class="btn btn-success float-right">+ Nový úkol</router-link>

        <h4>Úkoly</h4>

        <table class="w-50 table table-bordered">
            <tr>
                <th>Jméno</th>
                <th>Postava</th>
            </tr>
            <tr v-for="quest in quests" :key="quest.id">
                <td>
                    <router-link to="#">
                        {{quest.name}}</router-link>
                </td>
                <td>{{quest.owner.name}}</td>
            </tr>
        </table>
    </div>
</template>

<script>
    export default {
        name: "RoleIndex",

        data: () => {
            return {
                quests: [],
            }
        },

        mounted() {
            this.refresh();
        },

        methods: {
            refresh() {
                axios
                    .get('/api/quests')
                    .then(response => {
                        console.log(response.data);

                        this.quests = response.data;
                    });
            }
        }
    }
</script>

<style scoped>

</style>
