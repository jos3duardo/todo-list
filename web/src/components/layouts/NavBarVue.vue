<template>
  <div class="navbar-fixed">

  <!--  <nav :class="cor || 'blue'">-->
<!--    <div class="nav-wrapper container">-->
<!--      <router-link :to="url || '/'" class="brand-logo">{{logo || 'Sistema'}}</router-link>-->
<!--      <ul id="nav-mobile" class="right hide-on-med-and-down">-->
<!--        <slot></slot>-->
<!--      </ul>-->
<!--    </div>-->
<!--  </nav>-->

    <ul id="dropdown1" class="dropdown-content right">
      <li><a href="/">Home</a></li>
      <li><a href="/perfil">Perfil</a></li>
      <li><a v-on:click="sair()">Sair</a></li>
    </ul>
  <nav :class="cor || 'blue'">
    <div class="nav-wrapper container">
      <a class="dropdown-trigger show-on-small hide-on-large-only" href="#!" data-target="dropdown1">
        <i class="material-icons right">menu</i>
      </a>
      <router-link :to="url || '/'" class="brand-logo">{{logo || 'Sistema'}}</router-link>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
        <slot></slot>
      </ul>
    </div>
  </nav>

  </div>
</template>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.dropdown-trigger');
    var instances = M.Dropdown.init(elems, {
      alignment:'left',
      autoTrigger: true
    });
  });
  export default {
    name: 'NavBar',
    props: ['cor','logo','url'],
    data () {
      return {
        usuario: true,
      }
    },
    methods: {
      sair(){
        this.$store.commit('setUsuario',null);
        sessionStorage.clear()
        this.usuario = false
        this.$router.push('/login')
      }
    }
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
