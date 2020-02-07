<template>
    <div>
        <h2>Výběr hráče</h2>

        <p>Vyber hráče podle barev na rukávu (zeshora dolů)</p>

        <div class="card mb-2">
            <div class="card-header">1. barva</div>
            <div class="card-body">
                <a @click="setFirstColor(1)" class="btn-color text-danger">Červená</a>
                <a @click="setFirstColor(2)" class="btn-color text-primary">Modrá</a>
                <a @click="setFirstColor(3)" class="btn-color text-success">Zelená</a>
                <a @click="setFirstColor(4)" class="btn-color text-warning">Žlutá</a>
            </div>
        </div>

        <div class="card mb-2">
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

</style>
