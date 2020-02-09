<template>
    <div class="container-fluid mt-3">
        <h4>Nová postava</h4>

        <table class="w-50 table table-bordered">
            <tr>
                <th>Jméno</th>
                <th>Reálné jméno</th>
            </tr>
            <tr v-for="role in roles" :key="role.id">
                <td>
                    <router-link to="#">{{role.name}}</router-link>
                </td>
                <td>{{role.real_name}}</td>
            </tr>
        </table>
    </div>
</template>

<script>
    export default {
        name: "RoleCreate",

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
