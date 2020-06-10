<template>
    <div class="container-fluid mt-3">
        <a href="#" @click="createNew" class="btn btn-success float-right">+ Nový úkol</a>

        <h4>Questy</h4>

        <div class="alert alert-primary mt-3 w-50">
            Zobrazeny jsou pouze mateřské questy, pod-questy lze načíst pod jednotlivými mateřskými questy.
        </div>

        <table class="w-50 table mt-4" style="border-radius: 0.25rem!important;">
            <div style="padding: 10px 15px">
                <tr class="w-100">
                    <th scope="col" class="w-50" style="border: none">Jméno</th>
                    <th scope="col" style="border: none"></th>
                    <th scope="col" class="w-50" style="border: none">Postava</th>
                </tr>
                <tr v-for="quest in quests" :key="quest.id">
                    <td>
                        <router-link :to="'/quests/'+quest.id+'/edit'">
                            {{quest.name}}
                        </router-link>
                    </td>
                    <td></td>
                    <td>{{quest.owner.name}}</td>
                </tr>
            </div>
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

                        this.$router.push('/quests/' + id + '/edit')
                    });
            }
        }
    }
</script>

<style scoped>

</style>
