<template>
    <div class="container-fluid mt-3">
        <h4 class="mb-4">Hlavní přehled</h4>
        <div class="row">
            <div class="col-7">
                <h5 class="mb-4">Aktuální stav hry</h5>

                <div class="row">
                    <div class="box light">
                        <h4>Postavy</h4>
                        <h1>8<span>/23</span></h1>
                        <h6>Online</h6>
                    </div>
                    <div class="box dark">
                        <h4>Hráči</h4>
                        <h1>26<span>/54</span></h1>
                        <h6>Online</h6>
                    </div>
                    <div class="box light">
                        <h4>Questy</h4>
                        <h1>39<span>/1125</span></h1>
                        <h6>spuštěny</h6>
                    </div>
                    <div class="box dark">
                        <h4>Dnes</h4>
                        <h1>26<span> </span></h1>
                        <h6>Splněných questů</h6>
                    </div>
                </div>
            </div>
            <div class="col-5">
                <h5 class="mb-4">Nejnovější změny</h5>

                <table class="table">
                    <log-detail v-for="log in latest_logs" :log="log" :key="log.id"></log-detail>
                </table>
            </div>
        </div>

        <table class="table w-50 mt-4">
            <div style="padding: 10px 15px">
                <tr class="w-100">
                    <th class="w-50" scope="col" style="border: none">Aktivní větev úkolů</th>
                    <th style="border: none"></th>
                    <th class="w-50" scope="col" style="border: none">
                        <div v-for="group in active_quest_groups">
                            {{group.name}}
                        </div>
                        <div v-if="!active_quest_groups.length" class="text-muted">žádná větev není aktivní</div>
                    </th>
                </tr>
                <tr>
                    <td>Celkem splněno úkolů</td>
                    <td></td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>Mince v oběhu u hráčů</td>
                    <td></td>
                    <td>3480</td>
                </tr>
                <tr>
                    <td>Hráči</td>
                    <td></td>
                    <td>{{player_count}}</td>
                </tr>
                <tr>
                    <td>Postavy</td>
                    <td></td>
                    <td>{{role_count}}</td>
                </tr>
                <tr>
                    <td>Questy</td>
                    <td></td>
                    <td>{{quest_count}} + {{sub_quest_count}} pod-questy</td>
                </tr>
            </div>

        </table>
    </div>
</template>

<script>
    import LogDetail from "./Logs/LogDetail";

    export default {
        name: "home",

        components: {LogDetail},

        data() {
            return {
                active_quest_groups: [],
                role_count: 0,
                player_count: 0,
                quest_count: 0,
                sub_quest_count: 0,
                latest_logs: [],

                interval: null
            }
        },

        mounted() {
            this.loadData()

            this.interval = setInterval(() => {
                this.loadData()
            }, 7000)
        },

        beforeDestroy() {
            clearInterval(this.interval)
        },

        methods: {
            loadData() {
                axios
                    .get('/api/overview')
                    .then(response => {
                        console.log(response.data);

                        this.active_quest_groups = response.data.active_quest_groups;
                        this.quest_count = response.data.quest_count;
                        this.sub_quest_count = response.data.sub_quest_count;
                        this.player_count = response.data.player_count;
                        this.role_count = response.data.role_count;
                        this.latest_logs = response.data.latest_logs;
                    });
            }
        }
    }
</script>

<style scoped lang="scss">
    .box {
        padding: 20px 25px;
        width: 180px;
        height: 180px;
        border: 0.5px solid rgb(38, 158, 175, 0.3);
        outline: 3px solid rgb(38, 158, 175);
        /*-moz-outline-radius: 0.25rem;*/
        outline-offset: -13px;
        margin: 0 15px;

        h1 {
            color: white;
            text-align: left;
            font-size: 60px;
            padding-top: 0;
            padding-bottom: 20px;
            line-height: 60px;
            font-family: "DM Mono", monospace;
            text-shadow: 5px 5px 5px rgb(0, 0, 0, 0.5);

            span {
                font-size: 20px;
                /*color: rgb(38, 158, 175);*/
                line-height: 60px;
            }
        }

        h4 {
            color: rgb(38, 158, 175);
            margin-bottom: 0px;
            text-align: left;
            text-transform: uppercase;
            font-size: 20px;
        }

        h6 {
            color: #00ae00;
            text-align: left;
            text-transform: uppercase;
            font-size: 12px;
            position: relative;
            bottom: 0px;
        }
    }

    .light {
        background-color: rgba(38, 158, 175, 0.40);
        /*border: 2px solid rgb(38, 158, 175);*/
    }

    .dark {
        background-color: transparent;
        /*border: 2px solid rgb(38, 158, 175);*/
    }

</style>
