<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <h4>{{quest_group.name}}</h4>
                <p>Větev questů</p>
            </div>
            <div class="col-6 text-right">
                <a class="btn btn-primary"
                   @click="submit">Uložit</a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Nastavení větve</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Název větve</label>
                            <input class="form-control"
                                   v-model="quest_group.name">
                        </div>

                        <div class="form-group">
                            <input type="checkbox"
                                   v-model="quest_group.active"> Větev je aktivní
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "QuestGroupEdit",

        data: () => {
            return {
                quest_group: {},
            }
        },

        mounted() {
            this.refresh();
        },

        methods: {
            refresh() {
                axios
                    .get('/api/quest_groups/' + this.$route.params.id)
                    .then(response => {
                        this.quest_group = response.data;
                    });
            },

            submit() {
                axios
                    .patch('/api/quest_groups/' + this.$route.params.id, this.quest_group)
                    .then(response => {
                        console.log(response.data);
                        this.refresh();

                        this.$router.push('/quest-groups')
                    });
            }
        }
    }
</script>

<style scoped>

</style>
