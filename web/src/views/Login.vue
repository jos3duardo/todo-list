<template>
    <login-layout >
      <span slot="menuesquerdo" >
        <img src="https://playground.xyz/jobs/img/hero.png" class="responsive-img" srcset="">
      </span>
      <span slot="principal">
        <span >
          <h2>Login</h2>
          <div class="row">
            <div class="col s12 m12">
            <input type="text" placeholder="Usuario" autocomplete="off" v-model="username">
            </div>
            <div class="col s12 m12">
              <input type="password" placeholder="Senha" autocomplete="off" v-model="password">
            </div>
            <div class="col s12 m6">
              <button class="btn waves-light waves-effect" v-on:click="login()">Entrar</button>
            </div>
            <div class="col s12 m6">
              <router-link id="espaco" to="/cadastro" class="btn waves-light waves-effect orange">Cadastra-se</router-link>
            </div>
          </div>
        </span>
      </span>


    </login-layout>

</template>

<script>
  import LoginLayout from "../layouts/LoginLayout";

  export default {
    name: 'Login',
    components: {
      LoginLayout,
    },
    data () {
      return {
       username: '',
       password: ''
      }
    },
    methods: {
        login(){
          console.log("ok");
          this.$http.post(this.$urlAPI+`login`, {
            username: this.username,
            password:this.password
          })
          .then(response => {
            console.log(response)
            if(response.data.status){
              // login com sucesso
              this.$store.commit('setUsuario', response.data.user)
              sessionStorage.setItem('usuario', JSON.stringify(response.data.user))
              this.$router.push('/')
            }else if(response.data.status === false && response.data.validate){
              // erros de validação
              console.log('erros de validação')
              let errors = '';
              for (let erro of Object.values(response.data.errors)){
                errors = erro + " ";
              }
              alert(errors)
            }else{
              //login não existe
              console.log('login não existe')
              alert('Login invalido')
            }
          })
          .catch(e => {
            console.log(e)
          })
        }
    },
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  h1, h2 {
    font-weight: normal;
  }

  #login{
    margin-top: 16px;
  }
</style>
