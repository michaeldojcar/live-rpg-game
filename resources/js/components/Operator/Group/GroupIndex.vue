<template>
    <div class="container-fluid mt-3">
        <router-link to="#" class="btn btn-success float-right">+ Nová skupinka</router-link>

        <h4>Skupiny</h4>

        <table class="w-50 table table-bordered">
            <tr>
                <th>Jméno</th>
            </tr>
            <tr v-for="group in groups" :key="group.id">
                <td>
                    <router-link to="#">{{group.name}}</router-link>
                </td>
            </tr>
        </table>
    </div>
</template>

<script>
    export default {
        name: "GroupIndex",

        data: () => {
            return {
                groups: [],
            }
        },

        mounted() {
            this.refresh();
        },

        methods: {
            refresh() {
                axios
                    .get('/api/groups')
                    .then(response => {
                        console.log(response.data);

                        this.groups = response.data;
                    });
            }
        }
    }
</script>

<style scoped>

</style>
