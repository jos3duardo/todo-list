<template>
  <span>
    <header>
      <nav-bar-vue cor="green darken-1" url="/" logo="Social">
        <li v-if="!usuario"> <router-link to="/login">Login</router-link></li>
        <li v-if="!usuario"> <router-link to="/cadastro">Cadastra-se</router-link></li>
        <li v-if="usuario"> <router-link to="/perfil">{{usuario.name}}</router-link></li>
      </nav-bar-vue>
    </header>
    <main>
      <div class="container">
        <div class="row">
          <grid-vue tamanho="8">
             <card-menu-vue>
              <slot name="menuesquerdo"/>
             </card-menu-vue>
          </grid-vue>
          <grid-vue tamanho="4">
            <slot name="principal"></slot>
          </grid-vue>

        </div>
      </div>
    </main>
    <footer-vue cor="green darken-1" logo="Social" descricao="Teste de descrição" ano="2020">
        <li><a class="grey-text text-lighten-3" href="#!">Link 1</a></li>
        <li><a class="grey-text text-lighten-3" href="#!">Link 2</a></li>
        <li><a class="grey-text text-lighten-3" href="#!">Link 3</a></li>
        <li><a class="grey-text text-lighten-3" href="#!">Link 4</a></li>
    </footer-vue>
  </span>
</template>

<script>
  import NavBarVue from "../components/layouts/NavBarVue";
  import FooterVue from "../components/layouts/FooterVue";
  import GridVue from "../components/layouts/GridVue";
  import CardMenuVue from "../components/layouts/CardMenuVue";

  export default {
    name: 'LoginTemplate',
    data(){
      return {
        usuario: false
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
        this.usuario = this.$store.getters.getUsuario
        this.$router.push('/')
      }
    },
    methods: {

    }
  }
</script>

<style>

</style>
