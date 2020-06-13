<template>
    <div>
        <!--        <a class="btn btn-outline-secondary float-right" @click="state.quest_selected = null">Zpět</a>-->

        <h4>{{state.quest_selected.name}}</h4>
        <div class="card my-3">
            <div class="card-header">
                Zadání
            </div>
            <div class="card-body">
                <p>{{state.quest_selected.description}}</p>
                <p class="text-success text-bold" v-if="state.quest_selected.is_dumb === 1">Bez úkolu</p>
                <p class="text-danger text-bold" v-if="!state.quest_selected.allow_more_attempts">Pouze jeden pokus!</p>
            </div>
        </div>


        <div class="card mb-3">
            <div class="card-header">Odměna</div>
            <div class="card-body">
                <div v-if="state.quest_selected.reward_cash">
                    <reward-cash :cash="state.quest_selected.reward_cash"/>
                </div>
                {{state.quest_selected.reward_knowledge}}
                <p class="text-danger text-bold" v-if="state.quest_selected.is_reward_public === 1">Sdělit odměnu dopředu!</p>
                <p class="text-success text-bold" v-if="state.quest_selected.is_dumb === 1">Vydat hned!</p>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <button class="btn btn-outline-secondary w-100 text-center" @click="state.quest_selected = null">Zpět
                </button>
            </div>
            <div class="col-6">
                <button class="btn btn-warning w-100 text-center" v-if="state.quest_selected.pivot.status === 2">Zadat</button>
                <button class="btn btn-success w-100 text-center" v-if="state.quest_selected.pivot.status === 3">Dokončit</button>
                <button class="btn btn-danger w-100 text-center mt-3" v-if="!state.quest_selected.allow_more_attempts && state.quest_selected.pivot.status === 3">Nesplněno</button>
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
                // TODO:
            },

            setDone(){
              // TODO:
            },

            setFailed(){
                // TODO:
            }
        }
    }
</script>

<style scoped>
    .text-bold {
    font-weight: 700;
    }
</style>
