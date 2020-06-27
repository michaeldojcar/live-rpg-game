<template>
    <div class="container-fluid mt-3">
        <router-link to="/groups/new"
                     class="btn btn-success float-right">+ Nová skupina
        </router-link>

        <h4>Skupiny</h4>

        <table class="w-50 table mt-4">
            <tr class="w-100">
                <th>Jméno skupiny</th>
            </tr>
            <tr v-for="group in groups"
                :key="group.id">
                <td>
                    <router-link :to="'/groups/' + group.id">{{group.name}}</router-link>
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
