<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-2 mt-3">
                <h4>Mapa hry</h4>

                <a class="btn btn-outline-secondary btn-sm mb-2"
                   @click="resetPosition">Zaměřit areál hry</a>

                <br>
                <h5 class="d-inline-block">Aktivní postavy</h5>
                <span class="badge badge-success">{{roles.length}}</span>

                <table class="table">
                    <tr v-for="role in roles"
                        :key="role.id">
                        <td class="pr-3">{{role.name }}</td>
                        <td class="font-italic">{{role.real_name}}</td>
                    </tr>
                </table>

                <h5 class="d-inline-block">Aktivní hráči</h5>
                <span class="badge badge-success">{{players.length}}</span>

                <table class="table">
                    <tr v-for="player in players"
                        :key="player.id">
                        <td class="pr-3">{{player.name }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-10 pr-0 text-black">
                <l-map
                    style="height: calc(100vh - 59px); width: 100%; margin-top: -30px;"
                    :zoom="zoom"
                    :center="center"
                    @update:zoom="zoomUpdated"
                    @update:center="centerUpdated"
                    @update:bounds="boundsUpdated"
                >
                    <l-tile-layer
                        v-for="tileProvider in tileProviders"
                        :key="tileProvider.name"
                        :name="tileProvider.name"
                        :visible="tileProvider.visible"
                        :url="tileProvider.url"
                        :attribution="tileProvider.attribution"
                        layer-type="base"/>

                    <l-control-layers position="topright"/>

                    <l-marker v-if="roles.length"
                              v-for="role in roles"
                              :latLng="[role.latitude, role.longitude]"
                              :key="role.id"
                              name="sss">
                        <l-popup>Postava: {{role.name }} - {{role.real_name}}</l-popup>
                    </l-marker>

                    <l-marker v-if="player.length"
                              v-for="player in players"
                              :latLng="[player.latitude, player.longitude]"
                              :key="player.id + 1000"
                              name="s">
                        <l-popup>Hráč {{player.name }}</l-popup>
                    </l-marker>
                </l-map>
            </div>
        </div>
    </div>
</template>

<script>
    import {LControlLayers, LMap, LMarker, LPopup, LTileLayer} from 'vue2-leaflet';


    export default {
        name: "role-map",

        components: {LMap, LTileLayer, LMarker, LPopup, LControlLayers},

        data() {
            return {
                url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                zoom: 16,
                center: [49.4836, 17.6842],
                bounds: null,

                tileProviders: [
                    {
                        name: 'OpenStreetMap FR',
                        visible: false,
                        attribution: '&copy; <a target="_blank" href="http://osm.org/copyright">OpenStreetMap</a> contributors',
                        url: 'https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png'
                    },
                    {
                        name: 'Google satelitní',
                        visible: false,
                        url: 'https://mt0.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',
                        attribution: 'Map data: &copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>, <a href="http://viewfinderpanoramas.org">SRTM</a> | Map style: &copy; <a href="https://opentopomap.org">OpenTopoMap</a> (<a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY-SA</a>)'
                    },
                    {
                        name: 'OpenStreetMap.org',
                        visible: true,
                        attribution: '&copy; <a target="_blank" href="http://osm.org/copyright">OpenStreetMap</a> contributors',
                        url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png'
                    },
                    {
                        name: 'OpenTopoMap',
                        visible: false,
                        url: 'https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png',
                        attribution: 'Map data: &copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>, <a href="http://viewfinderpanoramas.org">SRTM</a> | Map style: &copy; <a href="https://opentopomap.org">OpenTopoMap</a> (<a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY-SA</a>)'
                    }, {
                        name: 'Thunderforest Lava',
                        visible: false,
                        url: 'https://{s}.tile.thunderforest.com/spinal-map/{z}/{x}/{y}.png',
                        attribution: 'Map data: &copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>, <a href="http://viewfinderpanoramas.org">SRTM</a> | Map style: &copy; <a href="https://opentopomap.org">OpenTopoMap</a> (<a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY-SA</a>)'
                    },
                    {
                        name: 'Thunderforest',
                        visible: false,
                        url: 'https://{s}.tile.thunderforest.com/transport-dark/{z}/{x}/{y}.png',
                        attribution: 'Map data: &copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>, <a href="http://viewfinderpanoramas.org">SRTM</a> | Map style: &copy; <a href="https://opentopomap.org">OpenTopoMap</a> (<a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY-SA</a>)'
                    }
                ],

                fetchInterval: null,
                roles: [],
                players: [],
            };
        },

        mounted() {
            this.refresh();

            this.fetchInterval = setInterval(this.refresh, 5000);
        },

        beforeDestroy() {
            clearInterval(this.fetchInterval)
        },

        methods: {
            zoomUpdated(zoom) {
                this.zoom = zoom;
            },
            centerUpdated(center) {
                this.center = center;
            },
            boundsUpdated(bounds) {
                this.bounds = bounds;
            },
            refresh() {
                axios
                    .get('/api/map')
                    .then(response => {
                        console.log(response.data);

                        this.roles = response.data.roles;
                        this.players = response.data.players;
                    });
            },

            resetPosition() {
                this.center = [49.4836, 17.6842];
            }
        }
    }
</script>

<style scoped
       lang="scss">
    .text-black {
        p, a {
            color: black !important;

            .leaflet-control-zoom-in, .leaflet-control-zoom-out {
                color: black !important;
            }

        }
    }
</style>
