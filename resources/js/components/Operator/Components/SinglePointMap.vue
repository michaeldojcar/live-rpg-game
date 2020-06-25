<template>
    <l-map
        style="height: 500px; width: 100%;"
        :zoom="zoom"
        :center="center">
        <l-tile-layer
            v-for="tileProvider in tileProviders"
            :key="tileProvider.name"
            :name="tileProvider.name"
            :visible="tileProvider.visible"
            :url="tileProvider.url"
            :attribution="tileProvider.attribution"
            layer-type="base"/>

        <l-control-layers position="topright"/>

        <l-marker :latLng="[this.latitude, this.longitude]"
                  name="">
            <l-popup>Nejnovější poloha</l-popup>
        </l-marker>
    </l-map>
</template>

<script>
    import {LControlLayers, LMap, LMarker, LPopup, LTileLayer} from 'vue2-leaflet';

    export default {
        name: "SinglePointMap",

        components: {LMap, LTileLayer, LMarker, LPopup, LControlLayers},

        props: ['latitude', 'longitude'],

        data: () => {
            return {
                url: 'https://mt0.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',
                zoom: 17,
                center: [0, 0],
                bounds: null,

                tileProviders: [
                    {
                        name: 'Google satelitní',
                        visible: true,
                        url: 'https://mt0.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',
                        attribution: 'Map data: &copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>, <a href="http://viewfinderpanoramas.org">SRTM</a> | Map style: &copy; <a href="https://opentopomap.org">OpenTopoMap</a> (<a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY-SA</a>)'
                    },
                    {
                        name: 'OpenStreetMap FR',
                        visible: false,
                        attribution: '&copy; <a target="_blank" href="http://osm.org/copyright">OpenStreetMap</a> contributors',
                        url: 'https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png'
                    },
                    {
                        name: 'OpenStreetMap.org',
                        visible: false,
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
            }
        },

        mounted() {
            this.center = [this.latitude, this.longitude];
        }
    }
</script>

<style scoped>

</style>
