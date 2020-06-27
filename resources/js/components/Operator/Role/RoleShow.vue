<template>
    <div class="container-fluid">

        <div class="row">
            <div class="col-6">
                <h3>{{ role.name }}</h3>
                <p>Herní postava</p>
            </div>
            <div class="col-6 text-right">
                <router-link :to="'/roles/' + role.id + '/edit'"
                             class="btn btn-primary">Upravit postavu
                </router-link>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-7">
                <div class="card">
                    <div class="card-header">Informace o postavě</div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td>Skutečné jméno</td>
                                <td>{{role.real_name}}</td>
                            </tr>

                            <tr>
                                <td>Příběh</td>
                                <td>{{role.story}}</td>
                            </tr>

                            <tr>
                                <td>Běžný výskyt</td>
                                <td>{{role.place_recommends}}</td>
                            </tr>

                            <tr>
                                <td>Doporučené akce</td>
                                <td>{{role.action_recommends}}</td>
                            </tr>

                            <tr>
                                <td>Naposledy spatřen</td>
                                <td>{{role.last_seen}}</td>
                            </tr>

                            <tr>
                                <td>Počet questů</td>
                                <td>{{role.quests_count}}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">Questy</div>
                    <div class="card-body">
                        <table class="table">
                            <tr v-for="quest in role.quests" :key="quest.id">
                                <td>
                                    <router-link :to="'/quests/'+quest.id+'/edit'">{{quest.name}}</router-link>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-sm-5">
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td>Stav hráče:
                                    <span v-if="role.is_online"
                                          class="text-success font-weight-bold">Online</span>
                                    <span v-else
                                          class="text-danger font-weight-bold">Offline</span>
                                </td>
                                <td>
                                    Kontakt {{role.last_seen_string}}
                                </td>
                            </tr>
                        </table>

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
