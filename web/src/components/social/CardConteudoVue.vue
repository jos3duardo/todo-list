<template>
  <div class="row">
    <div class="card">
      <div class="card-content">
        <div class="row valign-wrapper">
          <grid-vue tamanho="1">
            <router-link :to="'/pagina/'+usuarioId+'/'+$slug(nome,{lower:true})">
              <img :src="perfil" :alt="nome" class="circle responsive-img"> <!-- notice the "circle" class -->
            </router-link>
          </grid-vue>

          <grid-vue tamanho="11">
              <span class="black-text">

                  <strong><router-link :to="'/pagina/'+usuarioId+'/'+$slug(nome,{lower:true})">{{nome}} </router-link></strong> - <small>{{data}}</small>

              </span>
          </grid-vue>
        </div>

        <slot></slot>
      </div>
      <div class="card-action">
        <p>
          <a style="cursor: pointer" @click="curtida(id)">
            <i class="material-icons">{{curtiu}}</i>{{curtidas}}
          </a>
          <a style="cursor: pointer" @click="abreComentarios()">
            <i class="material-icons">insert_comment</i>{{ listaComentarios.length }}
          </a>
        </p>
        <p v-if="exibirComentario" class="right-align">
          <input type="text" v-model="textoComentario" placeholder="Comentar">
          <button v-if="textoComentario" @click="comentar(id)" class="btn waves-effect waves-light orange">
            <i class="material-icons">send</i>
          </button>
        </p>
        <p v-if="exibirComentario">
          <ul class="collection">
            <li class="collection-item avatar" v-for="item in comentarios" :key="item.id">
              <img :src="item.user.image" alt="" class="circle">
              <span class="title">{{ item.user.name }}<small> - {{ item.data }} </small></span>
              <p>{{item.text}} </p>
            </li>
          </ul>
        </p>
      </div>
    </div>
  </div>

</template>

<script>
  import GridVue from "../layouts/GridVue";

  export default {
    name: 'CardConteudoVue',
    props: ['id','perfil', 'nome', 'data','curtidas','curtiuConteudo','comentarios','usuarioId'],
    components: {
      GridVue,
    },
    data () {
      return {
        curtiu: this.curtiuConteudo ? 'favorite': 'favorite_border',
        totalCurtidas: this.curtidas,
        exibirComentario: false,
        textoComentario: '',
        listaComentarios: this.comentarios || []
      }
    },
    methods: {
      curtida(id){
        let url = ''
        if (this.$route.name === "Home"){
          url = 'content/like/'
        }else{
          url = 'content/like/page/'
        }
        console.log(this.$urlAPI+url+id)
        this.$http.put(this.$urlAPI+url+id,{},
          {"headers": {"authorization": "Bearer " +  this.$store.getters.getToken}})
        .then( response => {
          console.log(response)
          if (response.data.status){
            this.totalCurtidas = response.data.likes
            this.$store.commit('setConteudoLinhaTempo', response.data.list.contents.data)
            if(this.curtiu == 'favorite_border'){
              this.curtiu = 'favorite';
            }else{
              this.curtiu = 'favorite_border';
            }
          }else{
            alert(response.data.error)
          }
        })
        .catch(e => {
          console.log(e)
          alert("Erro! Tente novamente mais tarde")
        })
      },
      abreComentarios(){
        this.exibirComentario = !this.exibirComentario
      },
      comentar(id){
        if (!this.textoComentario){
          return
        }
        let url = ''
        if (this.$route.name === "Home"){
          url = 'content/comments/'
        }else{
          url = 'content/comments/page/'
        }
        this.$http.put(this.$urlAPI+url+id,{texto: this.textoComentario},
          {"headers": {"authorization": "Bearer " +  this.$store.getters.getToken}})
          .then( response => {
            // console.log(response)
            if (response.status){
              this.textoComentario = ""
              this.$store.commit('setConteudoLinhaTempo', response.data.list.contents.data)
            }else{
              alert(response.data.error)
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

</style>
