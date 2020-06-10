<template>
    <div class="container-fluid mt-3">
        <a class="btn btn-primary float-right" @click="submit">Uložit</a>

        <h4 class="mb-3" v-if="quest.parent_quest_id">Pod-quest: {{quest.name}}</h4>
        <h4 class="mb-3" v-else>Quest: {{quest.name}}</h4>


        <div class="row">
            <div class="col-2">
                <div v-for="q in quest.chain_quests" v-bind:key="q.id">
                    <div class="card mb-2 mt-2"
                         :class="{'text-white bg-success': !q.parent_quest_id, 'text-white bg-light': q.parent_quest_id}">
                        <div class="card-header" v-if="!q.parent_quest_id">Mateřský quest</div>
                        <div class="card-body">
                            <small class="text-muted"></small>
                            <router-link style="color: black"
                                         :to="'/quests/' + q.id + '/edit'">{{q.name}}
                            </router-link>
                        </div>
                    </div>

                    <div class="text-center">
                        <i class="fas fa-arrow-down mr-5 text-danger"></i>
                        <i class="fas fa-arrow-up text-success"></i>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card my-2">
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


                        <!--                        <div class="form-group">-->
                        <!--                            <label>Kritérium odemknutí</label>-->
                        <!--                            <input v-model="quest.name" title="">-->
                        <!--                        </div>-->

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
                <div class="card my-2">
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

            <div class="col-3">
                <div class="card my-2">
                    <div class="card-header">Kritéria přidělení</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Postava</label>
                            <select class="form-control" v-model="quest.quest_owner_id">
                                <option v-for="role in roles" :value="role.id">{{role.name}}</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Větev questů</label>
                            <select class="form-control" v-model="quest.quest_group_id">
                                <option v-for="group in quest_groups" :value="group.id">{{group.name}}</option>
                            </select>
                        </div>

                        <div class="form-group" v-if="!quest.parent_quest_id">
                            <label>Minimální věk</label>
                            <input type="number" class="form-control" v-model="quest.age_from" title="">
                        </div>

                        <div class="form-group" v-if="!quest.parent_quest_id">
                            <label>Maximální věk</label>
                            <input type="number" class="form-control" v-model="quest.age_to" title="">
                        </div>
                    </div>
                </div>


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
                roles: [],
                quest_groups: [],
            }
        },

        watch: {
            '$route.params.id': function (id) {
                this.refresh();
            }
        },

        mounted() {
            this.refresh();
        },

        methods: {
            refresh() {
                axios
                    .get('/api/quests/' + this.$route.params.id + '/edit')
                    .then(response => {
                        console.log(response.data);

                        this.quest = response.data.quest;
                        this.roles = response.data.roles;
                        this.quest_groups = response.data.quest_groups;
                    });
            },

            submit() {
                axios
                    .patch('/api/quests/' + this.$route.params.id, this.quest)
                    .then(response => {
                        console.log(response.data);
                        this.refresh();

                        if (this.quest.parent_quest_id) {
                            this.$router.push('/quests/' + this.quest.parent_quest_id + '/edit')
                        } else {
                            this.$router.push('/quests')
                        }
                    });
            }
        }
    }
</script>

<style scoped>

</style>
