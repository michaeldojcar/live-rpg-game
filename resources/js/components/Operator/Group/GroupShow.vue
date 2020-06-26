<template>
    <div class="container-fluid mt-3">
        <h3>{{group.name}}</h3>
        <p>Skupina hráčů</p>

        <div class="row">
            <div class="col-7">
                <table class="w-50 table table-bordered">
                    <tr>
                        <th>Jméno</th>
                        <th>Reálné jméno</th>
                    </tr>
                    <tr v-for="role in roles"
                        :key="role.id">
                        <td>
                            <router-link to="#">{{role.name}}</router-link>
                        </td>
                        <td>{{role.real_name}}</td>
                    </tr>
                </table>
            </div>
            <div class="col-5">

            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: "GroupShow",

        data: () => {
            return {
                group: {}
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
            }
        }
    }
</script>

<style scoped>

</style>
