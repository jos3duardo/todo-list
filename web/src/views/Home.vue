<template>
  <site-layout>
    <ul class="collapsible popout">
      <li v-if="listas" v-for="lista in listas" :key="lista.id">
        <div class="collapsible-header"><i class="material-icons">event_note</i>{{lista.title}}</div>
        <div class="collapsible-body"><span>Lorem ipsum dolor sit amet.</span></div>
      </li>
    </ul>

<!--    <modal-vue v-for="item in modais" :key="item.modal" :identificador="item.modal" :titulo="item.title">-->
<!--      <form class="col s12">-->
<!--        <div class="row">-->
<!--          <div class="input-field col s6">-->
<!--            <input id="last_name" type="text" class="validate" v-model="item.name">-->
<!--            <label for="last_name">{{item.label}}</label>-->
<!--          </div>-->
<!--          <span slot="footer">-->
<!--          <button class="btn waves-light waves-effect" v-on:click="cadastro()">Enviar</button>-->

<!--          </span>-->
<!--        </div>-->
<!--      </form>-->
<!--    </modal-vue>-->

    <modal-vue titulo="Criar nova lista de tarefas" identificador="lista">
      <div class="col s12">
        <div class="row">
          <div class="input-field col s12 m12">
            <input id="last_name" type="text" class="validate" v-model="novaTarefa">
            <label for="last_name">Nome da Lista</label>
          </div>
        </div>
      </div>
      <span slot="footer">
        <button class="btn waves-light waves-effect modal-close" v-on:click="lista()">Enviar</button>
      </span>
    </modal-vue>

    <float-actiont-button-vue>
      <ul>
        <li v-for="item in modais" :key="item.modal">
          <a  :href="'#'+item.modal" :class="'btn-floating waves-effect waves-light btn modal-trigger '+item.cor">
          <i class="material-icons">{{item.icon}}</i>
          </a>
        </li>
      </ul>
    </float-actiont-button-vue>

  </site-layout>
</template>

<script>
import SiteLayout from "../layouts/SiteLayout";
import FloatActiontButtonVue from "../components/layouts/FloatActiontButtonVue";
import ModalVue from "../components/layouts/ModalVue";

export default {
  name: 'Home',
  components: {
    SiteLayout,
    FloatActiontButtonVue,
    ModalVue
  },
   data(){
    return{
      novaTarefa: '',
      novaCategoria: '',
      listas:[],
      modais: [
        { modal: 'lista', title: 'Criar Lista de Tarefa', icon: 'event_note', cor: 'red', label: 'Nome da Lista', action: 'lista', name: 'novaTarefa' },
        { modal: 'Outro', title: 'Criar categoria', icon: 'publish', cor: 'blue', label: 'Nome da Categoria', action: 'categoria', name: 'novaCategoria' }
      ]
    }
  },
  mounted: function () {
    let elems = document.querySelectorAll('.collapsible');
    let instances = M.Collapsible.init(elems,{
      accordion: false
    });
  },
  created() {
    this.$http.get(this.$urlAPI+`list-task`,
      {
        "headers": {"authorization": "Bearer " +  this.$store.getters.getToken}
      })
      .then( response => {
        console.log(response)
        this.listas = response.data.listas
      })
      .catch(e => {
        console.log(e)
        alert("Erro! Tente novamente mais tarde")
      })
  },
  methods:{
    lista(){
      console.log()
      this.$http.post(this.$urlAPI+`list-task`, {
        title: this.novaTarefa
      },{
        "headers": {"authorization": "Bearer " +  this.$store.getters.getToken}
      })
      .then( response => {
        console.log(response)
        this.listas.push(response.data[0])
        this.novaTarefa = ''
      })
      .catch(e => {
        console.log(e)
        alert("Erro! Tente novamente mais tarde")
      })
    },
    categoria(){
      console.log(this.categoria)
    }
  }
}
</script>
