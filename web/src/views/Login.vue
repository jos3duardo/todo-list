<template>
  <login-template>
      <span slot="menuesquerdo">
        <img src="https://static.todamateria.com.br/upload/re/de/redessociaisinteracaopessoas-cke.jpg" class="responsive-img" srcset="">
      </span>
      <span slot="principal">

        <span>
          <h2>Login</h2>
          <input type="email" placeholder="E-mail" autocomplete="off" v-model="email">
          <input type="password" placeholder="Senha" autocomplete="off" v-model="password">
          <button class="btn waves-light waves-effect" v-on:click="login()">Entrar</button>
          <router-link to="/cadastro" class="btn waves-light waves-effect orange">Cadastra-se</router-link>
        </span>
      </span>


  </login-template>

</template>

<script>
  import LoginTemplate from "../../templates/LoginTemplate";

  export default {
    name: 'Login',
    components: {
      LoginTemplate,
    },
    data () {
      return {
       email: '',
       password: ''
      }
    },
    methods: {
        login(){
          console.log("ok");
          this.$http.post(this.$urlAPI+`login`, {
            username: this.email,
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
</style>
