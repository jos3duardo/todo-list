<template>
  <site-layout>
    <h3 class="center-align">Perfil</h3>
    <div class="row">
      <div class="col s4 m2">
        <img :src="usuario.image" class="responsive-img" srcset="">
      </div>
      <div class="col s12 m10">
        <span>
          <input type="text" placeholder="Nome" v-model="name">
          <input type="text" placeholder="Usuario" v-model="username">
          <input type="email" placeholder="E-mail" autocomplete="off" v-model="email">
        </span>
      </div>
    </div>
    <div class="row">
      <div class="col s12 m12">
        <span>
          <div class="file-field input-field">
            <div class="btn">
              <span>Imagem</span>
              <input type="file" v-on:change="salvarImagem" autocomplete="off" value=" ">
            </div>
            <div class="file-path-wrapper">
              <input class="file-path validate" type="text">
            </div>
          </div>
        </span>
      </div>
      <div class="row">
        <div class="col s12 m6">
          <input type="password" placeholder="Senha" autocomplete="off" v-model="password">
        </div>
        <div class="col s12 m6">
            <input type="password" placeholder="Confirme sua Senha" autocomplete="off" v-model="password_confirmation">
        </div>
      </div>
      <div class="row">
        <div class="col s12">
          <button class="btn waves-light waves-effect" v-on:click="perfil()">Atualizar</button>
        </div>
      </div>
    </div>
  </site-layout>
</template>

<script>
  import SiteLayout from "../layouts/SiteLayout";

  export default {
    name: 'Perfil',
    components: {
      SiteLayout
    },
    data () {
      return {
        usuario: false,
        name: '',
        username: '',
        email: '',
        password: '',
        password_confirmation: '',
        imagem: '',
        id:''
      }
    },
    created() {
      let usuarioAux =  this.$store.getters.getUsuario
      if (usuarioAux){
        console.log(usuarioAux),
        this.usuario = this.$store.getters.getUsuario
        this.name = this.usuario.name;
        this.username = this.usuario.username;
        this.email = this.usuario.email;
        this.id = this.usuario.id;

      }
    },
    methods: {
      salvarImagem(e){
        let arquivo = e.target.files || e.dataTransfer.files;
        if (!arquivo.length){
          return;
        }
        let reader = new FileReader();
        reader.onloadend = (e) => {
          this.imagem = e.target.result
        };
        reader.readAsDataURL(arquivo[0]);
      },
      perfil(){
        console.log(this.$store.getters.getToken)
        this.$http.put(this.$urlAPI+`users/${this.id}`, {

            name: this.name,
            username: this.username,
            email: this.email,
            password:this.password,
            password_confirmation: this.password_confirmation,
            image: this.imagem

        },{"headers": {"authorization": "Bearer " +  this.$store.getters.getToken}})
          .then(response => {
            console.log(this.$store.getters.getToken)
            if(response.data.status){
              this.usuario = response.data.user
              this.$store.commit('setUsuario', response.data.user)
              sessionStorage.setItem('usuario', JSON.stringify(this.usuario));
              alert('Perfil atualizado')
            }else if(response.data.status === false){
              // erros de validação
              // console.log('erros de validação')
              let errors = '';
              for (let error of Object.values(response.data.errors)){
                errors += error + " \n";
              }
              alert(errors)
            }
          })
          .catch(e => {
            console.log(e)
            alert("Erro! Tente novamente mais tarde")
          })
      }
    }
  }
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  h1, h2 {
    font-weight: normal;
  }
</style>
