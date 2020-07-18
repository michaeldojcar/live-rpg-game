<template>
    <div>
        <!--        <a class="btn btn-outline-secondary float-right" @click="state.quest_selected = null">Zpět</a>-->

        <h4>{{state.quest_selected.name}}</h4>

        <div class="card my-3">
            <div class="card-header">
                Zadání
                <span v-if="state.quest_selected.parent_role" class="text-muted small">(posílá <b>{{state.quest_selected.parent_role}}</b>)</span>
            </div>
            <div class="card-body">
                <p>{{state.quest_selected.description}}</p>
                <p class="text-success text-bold"
                   v-if="state.quest_selected.is_dumb === 1">Bez úkolu</p>
                <p class="text-danger text-bold"
                   v-if="!state.quest_selected.allow_more_attempts">Pouze jeden pokus!</p>
            </div>
            <div class="card-footer" v-if="state.quest_selected.subquest_role">
                <span class="">Poslat na pod-quest → <b>{{state.quest_selected.subquest_role}}</b></span>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">Odměna</div>
            <div class="card-body">
                <div v-if="state.quest_selected.reward_cash">
                    <reward-cash :cash="state.quest_selected.reward_cash"/>
                </div>
                <div v-if="state.quest_selected.reward_knowledge">
                    <b>Informace:</b> {{state.quest_selected.reward_knowledge}}
                </div>

                <p class="text-danger text-bold"
                   v-if="state.quest_selected.is_reward_public === 1">Sdělit odměnu dopředu!</p>
                <p class="text-success text-bold"
                   v-if="state.quest_selected.is_dumb === 1">Vydat hned!</p>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <button class="btn btn-outline-secondary w-100 text-center"
                        @click="state.quest_selected = null">Zpět
                </button>
            </div>
            <div class="col-6">
                <button class="btn btn-warning w-100 text-center"
                        v-if="state.quest_selected.pivot.status === 2"
                        @click="setPending">Zadat
                </button>
                <button class="btn btn-success w-100 text-center"
                        v-if="state.quest_selected.pivot.status === 3"
                        @click="setDone">Dokončit
                </button>
                <button class="btn btn-danger w-100 text-center mt-3"
                        v-if="!state.quest_selected.allow_more_attempts && state.quest_selected.pivot.status === 3"
                        @click="setFailed">Nesplněno
                </button>
            </div>
        </div>

        <!--        <div style="position: absolute; bottom: 15px">-->

        <!--            <a class="btn btn-success align-bottom" @click="assign"-->
        <!--               v-if="state.quest_selected.pivot.status === 2">Zadat</a>-->
        <!--        </div>-->


    </div>
</template>

<script>
    import mobile_state from "./mobile_state";

    export default {
        name: "QuestDetail",

        data: () => {
            return {
                state: mobile_state
            }
        },

        methods: {
            setPending() {
                axios.post('/api/player/' + this.state.person.id + '/quest/' + this.state.quest_selected.id + '/pending')
                    .then((response) => {
                        this.loadDataForPerson()
                        this.state.quest_selected = null;
                    })
            },

            setDone() {
                axios.post('/api/player/' + this.state.person.id + '/quest/' + this.state.quest_selected.id + '/done')
                    .then((response) => {
                        this.loadDataForPerson()
                        this.state.quest_selected = null;
                    })
            },

            setFailed() {
                axios.post('/api/player/' + this.state.person.id + '/quest/' + this.state.quest_selected.id + '/failed')
                    .then((response) => {
                        this.loadDataForPerson()
                        this.state.quest_selected = null;
                    })
            },

            /**
             * Load data and quests for person.
             */
            loadDataForPerson() {
                axios
                    .get('/api/role/' + this.state.role.id + '/person/by_id/' + this.state.person.id)
                    .then(response => {
                        console.log(response.data);

                        this.state.person = response.data.person;
                        this.state.quests_pending = response.data.quests_pending;
                        this.state.quests_external_pending = response.data.external_quests_pending;
                    });
            },
        }
    }
</script>

<style scoped>
    .text-bold {
        font-weight: 700;
    }
</style>
