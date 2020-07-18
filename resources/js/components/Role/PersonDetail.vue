<template>
    <div>
        <div class="mb-3" v-if="state.quests_pending.length">
            <h4 class="font-weight-bold mb-2 d-inline-block">Úkoly </h4>
            <p>(ode mě)</p>

            <quest-icon :quest="quest" v-bind:key="quest.id" v-for="quest in state.quests_pending"
                        @click.native="chooseQuest(quest)"/>

            <hr>
        </div>

        <div class="mb-3" v-if="state.quests_external_pending.length">
            <h4 class="font-weight-bold mb-2 d-inline-block">Chce u mě vyřešit</h4>
            <p>(od jiných postav)</p>

            <quest-icon :quest="quest" v-bind:key="quest.id" v-for="quest in state.quests_external_pending"
                        @click.native="chooseQuest(quest)"/>

            <hr>
        </div>

        <div class="mb-3" v-if="!state.quests_external_pending.length && !state.quests_pending.length">
            <p>Hráč aktuálně u Tebe nemá nic, co by mohl dělat. Popovídej si s nim.</p>

            <hr>
        </div>
    </div>
</template>

<script>
    import QuestIcon from "./QuestIcon";
    import mobile_state from "./mobile_state";

    export default {
        name: "PersonDetail",
        components: {QuestIcon},

        data: () => {
            return {
                state: mobile_state
            }
        },

        methods: {
            chooseQuest: function (quest) {
                this.state.quest_selected = quest;
            }
        }
    }
</script>

<style scoped>

</style>
