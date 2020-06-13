<template>
    <div>
        <h4>Výběr hráče</h4>

        <p>Pro výběr hráče vyťukej jeho barvy.</p>

        <div class="wrapper">
            <div class=" mb-2">
                <button @click="setFirstColor(1)" class="btn-color bg-danger" :class="{selected: color_1 === 1 }">
                    Červená
                </button>
                <button @click="setFirstColor(2)" class="btn-color bg-primary">Modrá</button>
                <button @click="setFirstColor(3)" class="btn-color bg-success">Zelená</button>
                <button @click="setFirstColor(4)" class="btn-color bg-warning">Žlutá</button>
            </div>

            <div class="mb-2">
                <button @click="setSecondColor(1)" class="btn-color bg-danger">Červená</button>
                <button @click="setSecondColor(2)" class="btn-color bg-primary">Modrá</button>
                <button @click="setSecondColor(3)" class="btn-color bg-success">Zelená</button>
                <button @click="setSecondColor(4)" class="btn-color bg-warning">Žlutá</button>
            </div>

            <div>
                <button @click="setThirdColor(1)" class="btn-color bg-danger">Červená</button>
                <button @click="setThirdColor(2)" class="btn-color bg-primary">Modrá</button>
                <button @click="setThirdColor(3)" class="btn-color bg-success">Zelená</button>
                <button @click="setThirdColor(4)" class="btn-color bg-warning">Žlutá</button>
            </div>
        </div>
    </div>
</template>

<script>
    import MobileState from "./mobile_state";

    export default {
        name: "PersonColorPicker",

        props: ['role'],

        data: () => {
            return {
                state: MobileState,

                color_1: null,
                color_2: null,
                color_3: null,
            }
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

                        this.state.person = response.data.person;
                        this.state.quests_pending = response.data.quests_pending;
                        this.state.quests_available = response.data.quests_available;
                        this.state.quests_external_pending = response.data.external_quests_pending;
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
        }
    }
</script>

<style scoped>
    .btn-color {
        height: 60px;
        box-shadow: grey 0 0 3px;

        font-size: 12px;

        border: none;
    }

    .wrapper {
        position: absolute;
        bottom: 20px;
        width: calc(100vw - 45px);
    }

    .selected {
        border: 5px dashed red;
    }
</style>
