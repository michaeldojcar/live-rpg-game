<template>
    <div class="container-fluid mt-3">
        <h4 class="mb-3">Quest: {{quest.name}}</h4>

        <div class="row">
            <div class="col-2">
                <div class="card mb-3" v-for="q in quest.chain_quests" v-bind:key="q.id"
                     :class="{'text-white bg-success': !q.parent_quest_id, 'text-white bg-light': q.parent_quest_id}">
                    <div class="card-header" v-if="!q.parent_quest_id">Mateřský quest</div>
                    <div class="card-body">
                        <router-link style="color: black" :class="{'ml-2': q.parent_quest_id}":to="'/quests/' + q.id + '/edit'">{{q.name}}</router-link>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        Nastavení questu
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <label>Název</label>
                            <input class="form-control" v-model="quest.name" title="">
                        </div>

                        <div class="form-group">
                            <label>Zadání</label>
                            <textarea class="form-control" v-model="quest.description" title=""/>
                        </div>

                        <div class="form-group">
                            <label>Vydat odměnu hned po zadání</label>
                            <select v-model="quest.is_dumb">
                                <option value="0">Ne</option>
                                <option value="1">Ano</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Řešitel</label>
                            <select class="form-control" v-model="quest.quest_owner_id">
                                <option v-for="role in roles" :value="role.id">{{role.name}}</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Kritérium odemknutí</label>
                            <input v-model="quest.name" title="">
                        </div>

                        <div class="form-group">
                            <label>Povolit více pokusů</label>
                            <select v-model="quest.allow_more_attempts">
                                <option value="1">Ano</option>
                                <option value="0">Ne - jen jeden pokus</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Opakování</label>
                            <select v-model="quest.allow_finish_repeatedly">
                                <option value="0">Lze dokončit pouze jednou</option>
                                <option value="1">Lze dokončit opakovaně</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Odměna je známá dopředu</label>
                            <select v-model="quest.is_reward_public">
                                <option value="0">Ne</option>
                                <option value="1">Ano</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-3">
                <div class="card">
                    <div class="card-header">Odměna</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Stříbrňáky</label>
                            <input type="number" class="form-control" v-model="quest.reward_cash" title="">
                        </div>

                        <div class="form-group">
                            <label>Informace</label>
                            <textarea class="form-control" v-model="quest.reward_knowledge" title=""/>
                        </div>

                        <div class="form-group">
                            <label>Odemknutí tajného questu</label>
                            <input class="form-control" v-model="quest.reward_quest_unlock_id" title="">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-2">
                <a class="btn btn-primary">Uložit</a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "QuestEdit",

        data: () => {
            return {
                quest: {},
                roles: []
            }
        },

        watch: {
            '$route.params.id': function (id) {
                this.refresh()
                console.log('changed');
            }
        },

        mounted() {
            this.refresh();
        },

        // beforeRouteUpdate(to, from, next) {
        //     this.refresh();
        //     next()
        // },

        methods: {
            refresh() {
                axios
                    .get('/api/quests/' + this.$route.params.id + '/edit')
                    .then(response => {
                        console.log(response.data);

                        this.quest = response.data.quest;
                        this.roles = response.data.roles;
                    });
            },

            submit() {

            }
        }
    }
</script>

<style scoped>

</style>
