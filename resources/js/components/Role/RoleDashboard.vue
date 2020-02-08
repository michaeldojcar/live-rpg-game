<template>
    <div class="container">

        <nav v-if="!person_selected"
             class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
            <a class="navbar-brand"
               href="#">{{role.name}} ({{role.real_name}})</a>
        </nav>
        <nav v-else
             class="navbar navbar-expand-md navbar-dark bg-dark fixed-top text-white">
            <a class="navbar-brand"
               href="#">{{state.person.name}}</a>

            <a class="nav-link" @click="wipePerson">Zrušit</a>
        </nav>


        <div class="container"
             style="margin-top: 80px;">

            <!-- Person picker -->
            <person-color-picker v-if="!person_selected" :role="role"/>

            <div v-if="person_selected">
                <person-detail v-if="!quest_selected"/>

                <!-- Person quests -->
                <quest-detail v-else/>

            </div>

        </div>
    </div>
</template>

<script>
    import QuestIcon from "./QuestIcon";
    import RewardCash from "./RewardCash";
    import PersonColorPicker from "./PersonColorPicker";
    import PersonDetail from "./PersonDetail";
    import QuestDetail from "./QuestDetail";
    import mobile_state from "./mobile_state";

    export default {
        components: {PersonDetail, QuestDetail, PersonColorPicker, RewardCash, QuestIcon},
        props: ['role'],

        data: () => {
            return {
                state: mobile_state,
                latitude: null,
                longitude: null,
            }
        },

        mounted() {
            console.log('Mobile interface is ready.');

            this.startTracking()
        },

        computed: {
            person_selected: function () {
                return this.state.person !== null
            },

            quest_selected: function () {
                return this.state.quest_selected !== null
            }
        },

        methods: {
            wipePerson: function () {
                this.state.person = null;
                this.state.quests_pending = [];
                this.state.quests_available = [];
                this.state.quests_external_pending = [];

                console.log('Person exited');
            },

            startTracking: function () {
                setTimeout(() => {
                    this.sendTelemetrics();
                }, 5000);

                setInterval(() => {
                    this.sendTelemetrics()
                }, 20000);
            },

            sendTelemetrics: function () {
                console.log('Sending telemetries data.');

                // Location success callback
                let positionSuccess = (position) => {
                    this.latitude = position.coords.latitude;
                    this.longitude = position.coords.longitude;

                    axios
                        .post('/api/role/' + this.role.id + '/telemetries', {
                            latitude: this.latitude,
                            longitude: this.longitude
                        })
                        .then(response => {
                            console.log('Telemetries successfully sent.')
                        });
                };

                // Location failed callback
                let positionFailed = () => {
                    console.warn('Geolocation failed.');
                };

                // Try to get location
                if (navigator && navigator.geolocation) {

                    // Retrieve current location
                    navigator.geolocation.getCurrentPosition(positionSuccess, positionFailed, {
                        enableHighAccuracy: true,
                        maximumAge: 100
                    });

                } else {
                    console.warn('Geolokace není funkční')
                }
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
