<template>
    <div class="container">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
            <a class="navbar-brand"
               href="#">Role {{role.name}} ({{role.real_name}})</a>
        </nav>

        <div class="container"
             style="margin-top: 80px;">
            <h2>Výběr hráče</h2>


        </div>

        <div class="container"
             style="margin-top: 80px;">
            <div class="card">
                <div class="card-header">Aktivní úkol</div>
                <div class="card-body">

                </div>
            </div>

            <div class="card">
                <div class="card-header">Úkoly ke spuštění</div>
                <div class="card-body">

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['role'],

        data: () => {
            return {
                person_selected: false,
                person: {},
                quests_pending: [],
                quests_available: [],
                quests_external_pending: []
            }
        },

        mounted() {
            console.log('Component mounted.');

            this.loadDataForPerson(1, 1, 1)
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

                        this.pe
                    });
            }
        }
    }
</script>
