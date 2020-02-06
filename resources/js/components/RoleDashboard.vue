<template>
    <div class="container">

        <nav v-if="!person_selected"
             class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
            <a class="navbar-brand"
               href="#">Role {{role.name}} ({{role.real_name}})</a>
        </nav>
        <nav v-else
             class="navbar navbar-expand-md navbar-dark bg-dark fixed-top text-white">
            <a class="navbar-brand"
               href="#">{{person.name}}</a>

            <a class="nav-link" @click="wipePerson">Zrušit</a>
        </nav>


        <div class="container"
             style="margin-top: 80px;">
            <div v-if="!person_selected">
                <h2>Výběr hráče</h2>

                <p>Vyber hráče podle barev na rukávu (zeshora dolů)</p>

                <div class="card">
                    <div class="card-header">1. barva</div>
                    <div class="card-body">
                        <a @click="setFirstColor(1)" class="btn-color text-danger">Červená</a>
                        <a @click="setFirstColor(2)" class="btn-color text-primary">Modrá</a>
                        <a @click="setFirstColor(3)" class="btn-color text-success">Zelená</a>
                        <a @click="setFirstColor(4)" class="btn-color text-warning">Žlutá</a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">2. barva</div>
                    <div class="card-body">
                        <a @click="setSecondColor(1)" class="btn-color text-danger">Červená</a>
                        <a @click="setSecondColor(2)" class="btn-color text-primary">Modrá</a>
                        <a @click="setSecondColor(3)" class="btn-color text-success">Zelená</a>
                        <a @click="setSecondColor(4)" class="btn-color text-warning">Žlutá</a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">3. barva</div>
                    <div class="card-body">
                        <a @click="setThirdColor(1)" class="btn-color text-danger">Červená</a>
                        <a @click="setThirdColor(2)" class="btn-color text-primary">Modrá</a>
                        <a @click="setThirdColor(3)" class="btn-color text-success">Zelená</a>
                        <a @click="setThirdColor(4)" class="btn-color text-warning">Žlutá</a>
                    </div>
                </div>

            </div>

            <div v-else>
                <div v-if="!quest_selected">
                    <div class="mb-3" v-if="quests_pending.length">
                        <h4 class="font-weight-bold mb-2 d-inline-block">Má zadané</h4> (ode mě)

                        <quest-icon :quest="quest" v-bind:key="quest.id" v-for="quest in quests_pending"
                                    @click.native="chooseQuest(quest)"/>

                        <hr>
                    </div>


                    <div class="mb-3" v-else-if="!quests_pending.length">
                        <h4 class="font-weight-bold mb-2 d-inline-block">Dostupné úkoly</h4>  (ode mě)

                        <quest-icon :quest="quest" v-bind:key="quest.id" v-for="quest in quests_available"
                                    @click.native="chooseQuest(quest)"/>

                        <br>
                        <i v-if="!quests_available.length" class="text-warning">Aktuálně není nic k dispozici.</i>

                        <hr>
                    </div>

                    <div class="mb-3" v-if="quests_external_pending.length">
                        <h4 class="font-weight-bold mb-2 d-inline-block">Chce u mě vyřešit</h4>

                        <quest-icon :quest="quest" v-bind:key="quest.id" v-for="quest in quests_external_pending"
                                    @click.native="chooseQuest(quest)"/>

                        <hr>
                    </div>
                </div>

                <div v-else>
                    <a class="btn btn-outline-secondary" @click="quest_selected = null">Zpět</a>

                    <h3>{{quest_selected.name}}</h3>

                    <p>{{quest_selected.description}}</p>

                    <div class="card">
                        <div class="card-header">Odměna</div>
                        <div class="card-body">
                            <reward-cash :cash="quest_selected.reward_cash"/>
                            {{quest_selected.reward_knowledge}}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import QuestIcon from "./QuestIcon";
    import RewardCash from "./RewardCash";

    export default {
        components: {RewardCash, QuestIcon},
        props: ['role'],

        data: () => {
            return {
                person_selected: false,

                person: {},
                quests_pending: [],
                quests_available: [],
                quests_external_pending: [],

                quest_selected: null,

                color_1: null,
                color_2: null,
                color_3: null,
            }
        },

        mounted() {
            console.log('Component mounted.');

            this.loadDataForPerson(1, 1, 1);
        },

        methods: {
            /**
             * Load data and quests for person.
             *
             * @param color_1
             * @param color_2
             * @param color_3
             */
            loadDataForPerson: function (color_1, color_2, color_3) {
                axios
                    .get('/api/role/' + this.role.id + '/person/color_1/' + color_1 + '/color_2/' + color_2 + '/color_3/' + color_3)
                    .then(response => {
                        console.log(response.data);

                        this.person = response.data.person;
                        this.quests_pending = response.data.quests_pending;
                        this.quests_available = response.data.quests_available;
                        this.quests_external_pending = response.data.external_quests_pending;

                        this.person_selected = true;
                    });
            },

            setFirstColor: function (color) {
                this.color_1 = color;
                this.checkColors();
            },

            setSecondColor: function (color) {
                this.color_2 = color;
                this.checkColors();
            },

            setThirdColor: function (color) {
                this.color_3 = color;
                this.checkColors();
            },

            checkColors: function () {
                if (this.color_1 && this.color_2 && this.color_3) {
                    this.loadDataForPerson(this.color_1, this.color_2, this.color_3)
                }
            },

            wipePerson: function () {
                this.person = null;
                this.quests_pending = [];
                this.quests_available = [];
                this.quests_external_pending = [];

                this.color_1 = null;
                this.color_2 = null;
                this.color_3 = null;

                this.person_selected = false;

                console.log('Person reset');
            },

            chooseQuest: function (quest) {
                this.quest_selected = quest;
            }
        }
    }
</script>

<style lang="scss">
    .btn-color {
        width: 23%;
        padding: 0;
        display: inline-block;

        &:hover {
            background-color: #636b6f;
        }
    }
</style>
