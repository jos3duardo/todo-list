<template>
  <div>
    <nav :class="cor || 'blue'">
      <div class="nav-wrapper container">
        <router-link :to="url || '/'" class="brand-logo">{{logo || 'Sistema'}}</router-link>
        <a v-if="usuario" href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        <ul class="right hide-on-med-and-down">
          <slot></slot>
        </ul>
      </div>
    </nav>

    <ul class="sidenav" id="mobile-demo">
      <li><a href="/"><i class="material-icons">home</i> Tarefas</a></li>
      <li><a href="/perfil"><i class="material-icons">person</i> Perfil</a></li>
      <li><a href="/categoria"><i class="material-icons">apps</i> Categoria</a></li>
      <li><a v-on:click="sair()"><i class="material-icons">reply_all</i> Sair</a></li>
    </ul>

  </div>
</template>

<script>

  export default {
    name: 'NavBar',
    props: ['cor','logo','url'],
    data () {
      return {
        usuario: '',
      }
    },
    methods: {
      sair(){
        this.$store.commit('setUsuario',null);
        sessionStorage.clear()
        this.usuario = false
        this.$router.push('/login')
      }
    },
    mounted() {
      let usuarioAux =  this.$store.getters.getUsuario
      if (usuarioAux){
        this.usuario = true

      }
      var elems = document.querySelectorAll('.sidenav');
      var instances = M.Sidenav.init(elems);
    }
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
