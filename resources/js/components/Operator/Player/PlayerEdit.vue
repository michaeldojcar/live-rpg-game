<template>
    <div class="container-fluid mt-3">

        <a class="btn btn-primary float-right"
           @click="submit">Uložit</a>
        <a class="btn btn-primary float-right"
           @click="discard">Smazat</a>

        <h4>Úprava hráče</h4>

        <div class="card">
            <div class="card-body">
                <h4>Úprava hráče</h4>
                <div class="form-group">
                    <label>Jméno</label>
                    <input type="text"
                           class="form-control"
                           v-model="player.name">
                </div>

                <div class="form-group">
                    <label>Datum narození</label>
                    <input type="date"
                           class="form-control"
                           v-model="player.birth_date">
                </div>

                <div class="form-group">
                    <label>Skupinka</label>
                    <select v-model="player.group_id">
                        <option v-for="group in groups"
                                :value="group.id">{{group.name}}
                        </option>
                    </select>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: "PlayerEdit",

        data: () => {
            return {
                // name: null,
                // birth_date: null
                player: {},

                groups: [],
            }
        },

        mounted() {
            this.refresh();
        },

        methods: {

            refresh() {
                axios
                    .get('/api/players/' + this.$route.params.id)
                    .then(response => {

                        this.player = response.data;
                    })

                axios
                    .get('/api/groups')
                    .then(response => {

                        this.groups = response.data;
                    })
            },

            submit() {
                console.log('Storing player.');

                axios
                    .patch('/api/players/' + this.player.id, {
                        name: this.player.name,
                        birth_date: this.player.birth_date,
                    })
                    .then(response => {
                        console.log("Successfully updated.");
                        this.$router.push('/players');
                    });
            },

            discard() {
                console.log('Deleting player.');

                axios
                    .delete('/api/players/' + this.player.id, {})

                    .then(response => {
                        console.log("Successfully deleted.");
                        this.$router.push('/players');
                    });
            },
        }
    }
</script>

<style scoped>

</style>
