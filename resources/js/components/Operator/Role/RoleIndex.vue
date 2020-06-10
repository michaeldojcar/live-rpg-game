<template>
    <div class="container-fluid mt-3">
        <router-link to="#" class="btn btn-success float-right">+ Nová postava</router-link>

        <h4>Postavy</h4>

        <table class="table w-50 mt-4" style="border-radius: 0.25rem!important;">
            <div style="padding: 10px 15px">
                <tr class="w-100">
                    <th class="w-50" scope="col" style="border: none">Jméno</th>
                    <th class="w-50" style="border: none">Reálné jméno</th>
                    <th class="w-25" scope="col" style="border: none">Úkoly</th>
                <tr v-for="role in roles" :key="role.id">
                    <td>
                        <router-link to="#">{{role.name}}</router-link>
                    </td>
                    <td>{{role.real_name}}</td>
                    <td>{{role.quests_count}}</td>
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
                roles: [],
            }
        },

        mounted() {
            this.refresh();
        },

        methods: {
            refresh() {
                axios
                    .get('/api/roles')
                    .then(response => {
                        console.log(response.data);

                        this.roles = response.data;
                    });
            }
        }
    }
</script>

<style scoped>

</style>
