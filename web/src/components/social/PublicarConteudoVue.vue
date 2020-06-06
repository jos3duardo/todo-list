<template>
  <div class="row">
    <grid-vue class="input-field" tamanho="12">
      <input type="text" v-model="content.title">
      <textarea v-if="content.title" v-model="content.text" id="conteudoId" placeholder="Conteudo" class="materialize-textarea"></textarea>
      <input  v-if="content.title && content.text" type="text" placeholder="link" v-model="content.link">
      <input  v-if="content.title && content.text" type="text" placeholder="Url da imagem" v-model="content.image">

      <label for="conteudoId">O que está acontecendo?</label>
    </grid-vue>
    <p>
      <button @click="addContent" v-if="content.title && content.text" class="btn waves-effect waves-light  right" >Publicar</button>
    </p>
  </div>
</template>

<script>
  import GridVue from "../layouts/GridVue";

  export default {
    name: 'PublicarConteudoVue',
    props: [],
    data () {
      return {
        content: {title: '', text: '', link: '', image: '' }
      }
    },
    methods:{
      addContent(){
       this.$http.post(this.$urlAPI+'content/add', {
         title: this.content.title,
         text: this.content.text,
         link: this.content.link,
         image: this.content.image
       }, {"headers": {"authorization": "Bearer " + this.$store.getters.getToken}})
        .then(response => {
          console.log(response.data)

          if (response.data.status){
            this.content = {title: '', text: '', link: '', image: '' }
            this.$store.commit('setConteudoLinhaTempo', response.data.contents.data)
          }else if(response.data.status === false && response.data.validate){
            // erros de validação
            // console.log('erros de validação')
            let errors = '';
            for (let error of Object.values(response.data.errors)){
              errors = error + " ";
            }
            alert(errors)
          }
        })
        .catch(e => {
          console.log(e)
          alert("Erro! tente mais tarde!")
        })
      }
    },
    components: {
      GridVue,
    },
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
