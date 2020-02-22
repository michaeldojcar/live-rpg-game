<template>
    <div class="container-fluid mt-3">
        <a href="#" @click="createNew" class="btn btn-success float-right">+ Nový úkol</a>

        <h4>Questy</h4>

        <div class="alert alert-primary mt-3 w-50">
            Zobrazeny jsou pouze mateřské questy, pod-questy lze načíst pod jednotlivými mateřskými questy.
        </div>

        <table class="w-50 table table-bordered">
            <tr>
                <th>Jméno</th>
                <th>Postava</th>
            </tr>
            <tr v-for="quest in quests" :key="quest.id">
                <td>
                    <router-link :to="'/quests/'+quest.id+'/edit'">
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
        name: "RoleIndex",

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

                        this.$router.push('/quests/'+ id + '/edit')
                    });
            }
        }
    }
</script>

<style scoped>

</style>
