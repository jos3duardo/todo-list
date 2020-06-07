<template>
  <site-layout>
    <ul class="collapsible popout">
      <li v-if="listas" v-for="lista in listas" :key="lista.id">
        <div class="collapsible-header"><i class="material-icons">event_note</i>{{lista.title}}</div>
        <div class="collapsible-body">
          <div class="row">
            <div class="col s8 m8">
              Data criação: {{ lista.data }}
            </div>
            <div class="col s4 m4 right-align">
              <button class="btn waves-light waves-effect grey darken-3 z-depth-3" v-on:click="editarLista(lista.id , lista.title)"><i class="material-icons">edit</i></button>
              <a  href="#!" class="waves-effect waves-light btn modal-trigger" v-on:click="apagarLista(lista.id)"><i class="material-icons">delete_forever</i> </a>
            </div>
          </div>
          <hr>
        </div>
      </li>
    </ul>

    <modal-vue titulo="Criar nova lista de tarefas" identificador="lista">
      <div class="col s12">
        <div class="row">
          <div class="input-field col s12 m12">
            <input id="list_name" type="text" class="validate" v-model="novaTarefa">
            <label for="list_name">Nome da Lista</label>
          </div>
        </div>
      </div>
      <span slot="footer">
        <button class="btn waves-light waves-effect modal-close" v-on:click="criaLista()">Enviar</button>
      </span>
    </modal-vue>

    <modal-vue titulo="Editar lista de tarefas" identificador="editar">
      <div class="col s12">
        <div class="row">
          <div class="input-field col s12 m12">
            <input type="hidden" class="validate" v-model="idTarefa">
            <input id="last_name" type="text" class="validate" v-model="tituloTarefa">
            <label for="last_name">Nome da Lista</label>
          </div>
        </div>
      </div>
      <span slot="footer">
        <button class="btn waves-light waves-effect modal-close" v-on:click="atualizarLista(idTarefa, tituloTarefa)">Enviar</button>
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
      tituloTarefa:'',
      idTarefa:'',
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
    this.listar()
  },
  methods:{
    listar(){
      this.$http.get(this.$urlAPI+`list-task`,
      {
        "headers": {"authorization": "Bearer " +  this.$store.getters.getToken}
      })
      .then( response => {
        this.listas = response.data.listas
      })
      .catch(e => {
        console.log(e)
        alert("Erro! Tente novamente mais tarde")
      })
    },
    criaLista(){
      this.$http.post(this.$urlAPI+`list-task`, {
        title: this.novaTarefa
      },{
        "headers": {"authorization": "Bearer " +  this.$store.getters.getToken}
      })
      .then( response => {
        if(response.data.status){
          console.log(response)
          this.listar()
          this.novaTarefa = ''
        }else if(response.data.status === false) {
          // erros de validação
          let errors = '';
          for (let error of Object.values(response.data.errors)) {
            errors += error + " \n";
          }
          alert(errors);
        }
      })
      .catch(e => {
        console.log(e)
        alert("Erro! Tente novamente mais tarde")
      })
    },
    categoria(){
      // console.log(this.categoria)
    },
    editarLista(id,titulo){
      this.idTarefa = id;
      this.tituloTarefa = titulo;
      $('#editar').modal('open');
    },
    atualizarLista(idTarefa, tituloTarefa){
      this.$http.put(this.$urlAPI+`list-task/`+idTarefa, {
        title: tituloTarefa
      },{
        "headers": {"authorization": "Bearer " +  this.$store.getters.getToken}
      })
      .then( response => {
        if (response.data.status) {
          this.listar()
          this.tituloTarefa = ''
        } else if (response.data.status === false) {
          // erros de validação
          let errors = '';
          for (let error of Object.values(response.data.errors)) {
            errors += error + " \n";
          }
          alert(errors);
        }
      })
    },
    apagarLista(id){
      this.$http.post(this.$urlAPI+`list-task/`+id,
      {_method: 'delete'}
      ,{
        "headers": {"authorization": "Bearer " +  this.$store.getters.getToken}
      })
      .then( response => {
        if(response.data.status){
          this.listar()
        }else if(response.data.status === false) {
          // erros de validação
          let errors = '';
          for (let error of Object.values(response.data.errors)) {
            errors += error + " \n";
          }
          alert(errors);
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
<style>
  button{
    margin: 0 8px;
  }
</style>