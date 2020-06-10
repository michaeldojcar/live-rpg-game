<template>
    <div class="container-fluid mt-3">
        <router-link to="#" class="btn btn-success float-right">+ Nová skupinka</router-link>

        <h4>Skupiny</h4>

        <table class="w-50 table mt-4" style="border-radius: 0.25rem!important;">
            <div style="padding: 10px 15px">
                <tr class="w-100">
                    <th scope="col" class="w-55" style="border: none">Jméno skupinky</th>
                    <th scope="col" style="border: none"></th>
                    <th scope="col" class="w-50" style="border: none"></th>
                </tr>
                <tr v-for="group in groups" :key="group.id">
                    <td>
                        <router-link to="#">{{group.name}}</router-link>
                    </td>
                    <td></td>
                    <td></td>
                </tr>
            </div>
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
