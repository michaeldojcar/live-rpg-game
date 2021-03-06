import * as VueGoogleMaps from "vue2-google-maps";

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import {Icon} from 'leaflet'
import 'leaflet/dist/leaflet.css'
import VueRouter from 'vue-router'
import RoleMap from "./components/Operator/RoleMap";
import Home from "./components/Operator/Home";
import RoleIndex from "./components/Operator/Role/RoleIndex";
import RoleCreate from "./components/Operator/Role/RoleCreate";
import RoleEdit from "./components/Operator/Role/RoleEdit";
import PlayerIndex from "./components/Operator/Player/PlayerIndex";
import PlayerCreate from "./components/Operator/Player/PlayerCreate";
import PlayerEdit from "./components/Operator/Player/PlayerEdit";
import GroupIndex from "./components/Operator/Group/GroupIndex";
import GroupCreate from "./components/Operator/Group/GroupCreate";
import GroupEdit from "./components/Operator/Group/GroupEdit";
import QuestIndex from "./components/Operator/Quest/QuestIndex";
import QuestEdit from "./components/Operator/Quest/QuestEdit";
import QuestGroupIndex from "./components/Operator/QuestGroup/QuestGroupIndex";
import QuestGroupEdit from "./components/Operator/QuestGroup/QuestGroupEdit";
import Options from "./components/Operator/Options";
import RoleShow from "./components/Operator/Role/RoleShow";
import GroupShow from "./components/Operator/Group/GroupShow";
import PlayerShow from "./components/Operator/Player/PlayerShow";
import QuestsWithKnowledge from "./components/Operator/Stats/QuestsWithKnowledge";

// this part resolve an issue where the markers would not appear
delete Icon.Default.prototype._getIconUrl;

Icon.Default.mergeOptions({
    iconRetinaUrl: require('leaflet/dist/images/marker-icon-2x.png'),
    iconUrl: require('leaflet/dist/images/marker-icon.png'),
    shadowUrl: require('leaflet/dist/images/marker-shadow.png')
});

Vue.use(VueRouter);
Vue.use(require('vue-moment'));

const router = new VueRouter({
    routes: [
        {path: '/', component: Home},
        {path: '/map', component: RoleMap},
        {path: '/stats/players', component: RoleMap},
        {path: '/stats/groups', component: RoleMap},
        {path: '/stats/quests-knowledge', component: QuestsWithKnowledge},
        {path: '/game-health', component: RoleMap},

        {path: '/roles', component: RoleIndex},
        {path: '/roles/new', component: RoleCreate},
        {path: '/roles/:id', component: RoleShow},
        {path: '/roles/:id/edit', component: RoleEdit},

        {path: '/players', component: PlayerIndex},
        {path: '/players/new', component: PlayerCreate},
        {path: '/players/:id', component: PlayerShow},
        {path: '/players/:id/edit', component: PlayerEdit},

        {path: '/groups', component: GroupIndex},
        {path: '/groups/new', component: GroupCreate},
        {path: '/groups/:id', component: GroupShow},
        {path: '/groups/:id/edit', component: GroupEdit},

        {path: '/quests', component: QuestIndex},
        {path: '/quests/:id/edit', component: QuestEdit},

        {path: '/quest-groups', component: QuestGroupIndex},
        {path: '/quest-groups/:id/edit', component: QuestGroupEdit},

        {path: '/options', component: Options},
    ]
});

const app = new Vue({
    el: '#app',
    router,
});
