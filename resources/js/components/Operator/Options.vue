<template>
    <div>
        <div class="container-fluid">
            <h4>Nastavení hry</h4>

            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">Globální zpráva pro postavy</div>
                        <div class="card-body">
                            <input v-model="admin_message"
                                   placeholder="vložte zprávu"
                                   class="form-control">

                            <div class="float-right mt-3">
                                <a class="btn btn-danger ml-2">Odebrat zprávu</a>

                                <a class="btn btn-primary ">Uložit</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</template>

<script>
    import {Collection} from 'collect.js';

    export default {
        name: "Options",

        data: () => {
            return {
                admin_message: null,
            }
        },

        mounted() {
            axios.get('/api/options').then(response => {

                // Load data from API
                this.admin_message = new Collection(response.data)
                    .where('key', '=', 'admin_message')
                    .first()
                    .value
            })
        },

        methods: {
         //   submit()
        }
    }
</script>

<style scoped>

</style>
