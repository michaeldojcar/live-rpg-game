<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <router-link class="navbar-brand" to="/">Řízení hry</router-link>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <router-link class="nav-link" to="/"><i class="fas fa-home"></i> Hlavní přehled</router-link>
                </li>

                <li class="nav-item">
                    <router-link class="nav-link" to="/map"><i class="fas fa-map-marked-alt"></i> Mapa</router-link>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Statistiky
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <router-link class="dropdown-item" to="/stats/quests-knowledge">Rozšíření informací</router-link>

                        <div class="dropdown-divider"></div>

                    </div>
                </li>

                <li class="nav-item">
                    <router-link class="nav-link" to="/options"><i class="fas fa-cog"></i> Nastavení</router-link>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <router-link class="nav-link" to="/quests"><i class="fas fa-check"></i> Questy</router-link>
                </li>

                <li class="nav-item">
                    <router-link class="nav-link" to="/quest-groups"><i class="fas fa-check-double"></i> Větve</router-link>
                </li>


                <li class="nav-item">
                    <router-link class="nav-link" to="/roles"><i class="fas fa-user-check"></i> Postavy</router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="/players"><i class="fas fa-user"></i> Hráči</router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="/groups"><i class="fas fa-users"></i> Skupiny</router-link>
                </li>
                <!--                <li class="nav-item dropdown">-->
                <!--                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
                <!--                        Simulace-->
                <!--                    </a>-->
                <!--                    <div class="dropdown-menu" aria-labelledby="navbarDropdown2">-->
                <!--                        <a class="dropdown-item" href="#">Action</a>-->
                <!--                        <a class="dropdown-item" href="#">Another action</a>-->
                <!--                        <div class="dropdown-divider"></div>-->
                <!--                        <a class="dropdown-item" href="#">Something else here</a>-->
                <!--                    </div>-->
                <!--                </li>-->
            </ul>
        </div>
    </nav>
</template>

<script>
    export default {
        name: "Navbar"
    }
</script>

<style scoped>

</style>
