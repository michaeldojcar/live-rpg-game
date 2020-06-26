<template>
    <div class="container-fluid mt-3">
        <h4>Úprava skupiny</h4>

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
        name: "GroupEdit",

        data: () => {
            return {
                group: {},
            }
        },

        mounted() {
            this.refresh();
        },

        methods: {
            refresh() {
                axios
                    .get('/api/groups/' + this.$route.params.id)
                    .then(response => {

                        this.group = response.data;
                    });
            },

            submit() {
                console.log('Storing role.');

                axios
                    .patch('/api/groups/' + this.group.id, {
                        name: this.role.name,
                    })
                    .then(response => {
                        console.log("Successfully updated.");
                        this.$router.push('/roles');
                    });


            }
        }
    }
</script>

<style scoped>

</style>
