<template>
    <div class="container-fluid">
        <h4>{{ role.name }}</h4>
        <p>Herní postava</p>


        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">Informace o postavě</div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td>Skutečné jméno</td>
                                <td>{{role.real_name}}</td>
                            </tr>

                            <tr>
                                <td>Stav</td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>Počet questů</td>
                                <td>{{role.quests_count}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <single-point-map v-if="role.latitude && role.longitude"
                                          :latitude="role.latitude"
                                          :longitude="role.longitude"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import SinglePointMap from "../Components/SinglePointMap";

    export default {
        name: "RoleShow",
        components: {SinglePointMap},
        data: () => {
            return {
                role: {},
            }
        },

        mounted() {
            this.refresh();
        },

        methods: {
            refresh() {
                axios
                    .get('/api/roles/' + this.$route.params.id)
                    .then(response => {

                        this.role = response.data;
                    });
            },
        }
    }
</script>

<style scoped>

</style>
