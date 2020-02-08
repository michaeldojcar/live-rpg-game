<template>
    <div>
        <div class="mb-3" v-if="state.quests_pending.length">
            <h4 class="font-weight-bold mb-2 d-inline-block">Má zadané </h4>
            <p>(ode mě)</p>

            <quest-icon :quest="quest" v-bind:key="quest.id" v-for="quest in state.quests_pending"
                        @click.native="chooseQuest(quest)"/>

            <hr>
        </div>


        <div class="mb-3" v-else>
            <h4 class="font-weight-bold mb-2 d-inline">Dostupné úkoly 🔁</h4>
            <p>(které můžu nabídnout)</p>

            <quest-icon :quest="quest" v-bind:key="quest.id" v-for="quest in state.quests_available"
                        @click.native="chooseQuest(quest)"/>

            <br>
            <i v-if="!state.quests_available.length" class="text-warning">Aktuálně není nic k dispozici.</i>

            <hr>
        </div>

        <div class="mb-3" v-if="state.quests_external_pending.length">
            <h4 class="font-weight-bold mb-2 d-inline-block">Chce u mě vyřešit</h4>

            <quest-icon :quest="quest" v-bind:key="quest.id" v-for="quest in state.quests_external_pending"
                        @click.native="chooseQuest(quest)"/>

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
