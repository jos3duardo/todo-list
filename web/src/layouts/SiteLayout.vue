<template>
  <span>
    <header>
      <nav-bar-vue cor="grey darken-1" url="/" :logo="logo">
        <li> <router-link to="/">Home</router-link></li>
        <li v-if="!usuario"> <router-link to="/login">Login</router-link></li>
        <li v-if="!usuario"> <router-link to="/cadastro">Cadastra-se</router-link></li>
        <li v-if="usuario"> <router-link to="/perfil">{{usuario.name}}</router-link></li>
        <li v-if="usuario"> <a v-on:click="sair()">Sair</a></li>
      </nav-bar-vue>
    </header>
    <main>
      <div class="container">
         <div class="row">
          <grid-vue tamanho="12">
           <slot></slot>
          </grid-vue>
         </div>
      </div>
    </main>
  </span>
</template>

<script>
  import NavBarVue from "../components/layouts/NavBarVue";
  import FooterVue from "../components/layouts/FooterVue";
  import GridVue from "../components/layouts/GridVue";
  import CardMenuVue from "../components/layouts/CardMenuVue";

  export default {
    name: 'SiteLayout',
    data(){
      return {
        usuario: false,
        logo: 'Tarefas'
      }
    },
    components: {
      NavBarVue,
      FooterVue,
      GridVue,
      CardMenuVue
    },
    created() {
      let usuarioAux = this.$store.getters.getUsuario
      if (usuarioAux){
        this.usuario =  this.$store.getters.getUsuario
      }else{
        this.$router.push('/login')
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

<style>

</style>
