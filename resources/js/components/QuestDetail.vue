<template>
    <div>
        <a class="btn btn-outline-secondary float-right" @click="state.quest_selected = null">Zpět</a>

        <h3>{{state.quest_selected.name}}</h3>

        <p>{{state.quest_selected.description}}</p>

        <div class="card">
            <div class="card-header">Odměna</div>
            <div class="card-body">
                <reward-cash :cash="state.quest_selected.reward_cash"/>
                {{state.quest_selected.reward_knowledge}}
            </div>
        </div>

        <div style="position: absolute; bottom: 15px">

            <a class="btn btn-success align-bottom" @click="assign" v-if="state.quest_selected.pivot.status === 2">Zadat</a>
        </div>



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
            assign: function () {

            }
        }
    }
</script>

<style scoped>

</style>
