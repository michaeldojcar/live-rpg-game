<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-2 mt-3">
                <h4>Mapa</h4>
            </div>
            <div class="col-10">
                <l-map
                    style="height: 100vh; width: 100%"
                    :zoom="zoom"
                    :center="center"
                    @update:zoom="zoomUpdated"
                    @update:center="centerUpdated"
                    @update:bounds="boundsUpdated"
                >
                    <l-tile-layer :url="url"/>

                    <l-marker v-if="roles.length"
                              v-for="role in roles"
                              :latLng="role.latlong"
                              :key="role.id"
                             name="sss">

                    </l-marker>
                </l-map>
            </div>
        </div>
    </div>
</template>

<script>
    import {LMap, LTileLayer, LMarker} from 'vue2-leaflet';


    export default {
        name: "role-map",

        components: {LMap, LTileLayer, LMarker},

        data() {
            return {
                url: 'http://{s}.tile.osm.org/{z}/{x}/{y}.png',
                zoom: 17,
                center: [49.482, 17.6819],
                bounds: null,

                roles: [],
            };
        },

        mounted() {
            setInterval(this.refresh, 5000);


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
                    .get('/api/roles')
                    .then(response => {
                        console.log(response.data);

                        this.roles = response.data;
                    });
            }
        }
    }
</script>

<style scoped>

</style>
