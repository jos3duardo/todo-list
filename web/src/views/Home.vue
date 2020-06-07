<template>
  <site-layout>
    <ul class="collapsible popout">
      <li v-if="listas" v-for="lista in listas" :key="lista.id">
        <div class="collapsible-header"><i class="material-icons">event_note</i>{{lista.title}}</div>
        <div class="collapsible-body">
          <div class="row">
            <div class="col s12 m8">
              Data criação: {{ lista.data }}
            </div>
            <div class="col s12 m4 right-align">
              <a  href="#!"
                  class="btn waves-light waves-effect grey darken-3 z-depth-3 modal-trigger tooltipped"
                  data-position="top"
                  data-tooltip="I am a tooltip"
                  v-on:click="criarTarefa(lista.id , lista.title)">
                <i class="material-icons">assignment</i>
              </a>
              <a :class="'btn waves-light waves-effect'+corBtn" v-on:click="editarLista(lista.id , lista.title)"><i class="material-icons">edit</i></a>
              <a  href="#!" :class="'btn waves-light waves-effect modal-trigger'+ corBtn " v-on:click="apagarLista(lista.id)"><i class="material-icons">delete_forever</i></a>
            </div>
          </div>
          <hr>
        </div>
      </li>
    </ul>

    <modal-vue titulo="Criar nova lista de tarefas" identificador="lista">
      <span slot="content">
        <div class="col s12">
          <div class="row">
            <div class="input-field col s12 m12">
              <input id="list_name" type="text" class="validate" v-model="novaTarefa">
              <label for="list_name">Nome da Lista</label>
            </div>
          </div>
        </div>
      </span>
      <span slot="footer">
        <button class="btn waves-light waves-effect modal-close" v-on:click="criaLista()">Enviar</button>
      </span>
    </modal-vue>

    <modal-vue titulo="Editar lista de tarefas" identificador="editar">
      <span slot="content">
        <div class="col s12">
          <div class="row">
            <div class="input-field col s12 m12">
              <input type="hidden" class="validate" v-model="idTarefa">
              <input id="list" type="text" class="validate" v-model="tituloTarefa">
              <label for="list">Nome da Lista</label>
            </div>
          </div>
        </div>
      </span>
      <span slot="footer">
        <button class="btn waves-light waves-effect modal-close" v-on:click="atualizarLista(idTarefa, tituloTarefa)">Enviar</button>
      </span>
    </modal-vue>

    <modal-vue titulo="Criar Categoria" identificador="category">
      <span slot="content">
        <div class="col s12">
          <div class="row">
            <div class="input-field col s12 m12">
              <input id="last_name" type="text" class="validate" v-model="nomeCategoria">
              <label for="last_name">Nome</label>
            </div>
          </div>
        </div>
      </span>
      <span slot="footer">
        <button class="btn waves-light waves-effect modal-close" v-on:click="criarCategoria()">Enviar</button>
      </span>
    </modal-vue>

    <modal-task-vue titulo="Criar Tarefa" identificador="tarefa">
      <span slot="content">
        <div class="row">
          <div class="input-field col s12">
            <i class="material-icons prefix">mode_edit</i>
            <input id="first_name" type="text" class="validate">
            <label for="first_name">Nome</label>
          </div>
        </div>

        <div class="row">
          <div class="input-field col s12 m6">
            <i class="Tiny material-icons prefix">date_range</i>
            <input id="data_start" type="text"  class="datepicker">
            <label for="data_start">Data inicio</label>
          </div>
          <div class="input-field col s12 m6">
            <i class="Tiny material-icons prefix">date_range</i>
            <input id="data_stop" type="text" class="datepicker">
            <label for="data_stop">Data termino</label>
          </div>
        </div>

        <div class="row">
          <div class="col s12">
            <div class="row">
              <div class="input-field col s12">
                <i class="material-icons prefix">apps</i>
                <input type="text" id="autocomplete-input" class="autocomplete">
                <label for="autocomplete-input">Categoria</label>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="input-field col s12">
            <i class="Tiny material-icons prefix">mode_edit</i>
            <textarea id="icon_prefix2" class="materialize-textarea"></textarea>
            <label for="icon_prefix2">First Name</label>
          </div>
        </div>
      </span>


      <span slot="footer">
        <button class="btn waves-light waves-effect modal-close" v-on:click="criarCategoria()">Enviar</button>
      </span>
    </modal-task-vue>


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
import ModalTaskVue from "../components/layouts/ModalTaskVue";

export default {
  name: 'Home',
  components: {
    SiteLayout,
    FloatActiontButtonVue,
    ModalVue,
    ModalTaskVue
  },
   data(){
    return {
      corBtn: ' grey darken-3 z-depth-3',
      novaTarefa: '',
      nomeCategoria: '',
      categorias: {},
      tituloTarefa:'',
      idTarefa:'',
      listas:[],
      modais: [
        { modal: 'lista', icon: 'event_note', cor:'grey darken-3 z-depth-3' },
        { modal: 'category', icon: 'apps', cor:'grey darken-3 z-depth-3' },

      ]
    }
  },
  mounted () {
    let elems = document.querySelectorAll('.collapsible');
    let instances = M.Collapsible.init(elems,{
      accordion: false
    });

    let elem = document.querySelectorAll('.tooltipped');
    let instance = M.Tooltip.init(elem);

    let el = document.querySelectorAll('.autocomplete');
    let inst = M.Autocomplete.init(el, {
      data: this.categorias
    });

    let dates = document.querySelectorAll('.datepicker');
    let instanceDates = M.Datepicker.init(dates,{
      autoClose: true,
      selectYears: 10,
      i18n: {
        months: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
        monthsShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        weekdays: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sabádo'],
        weekdaysShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
        weekdaysAbbrev: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S'],
        today: 'Hoje',
        clear: 'Limpar',
        cancel: 'Sair',
        done: 'Confirmar',
        labelMonthNext: 'Próximo mês',
        labelMonthPrev: 'Mês anterior',
        labelMonthSelect: 'Selecione um mês',
        labelYearSelect: 'Selecione um ano',
      }
    });
  },
  created() {
    this.listarListaTarefas()
    this.listarCategorias()

  },
  methods:{
    listarCategorias(){
      this.$http.get(this.$urlAPI+`categoriyes`,
        {
          "headers": {"authorization": "Bearer " +  this.$store.getters.getToken}
        })
        .then( response => {
          if(response.data.status){
            for (let item of (response.data.categories)) {
              this.categorias += item.name
            }
          }
          // erros de validação
          let errors = '';
          for (let error of Object.values(response.data.errors)) {
            errors += error + " \n";
          }
          M.toast({html: errors})
        })
        .catch(e => {
          console.log(e)
          // alert("Erro! Tente novamente mais tarde")
          M.toast({html: 'Erro! Tente novamente mais tarde'})
        })
    },
    listarListaTarefas(){
      this.$http.get(this.$urlAPI+`list-task`,
      {
        "headers": {"authorization": "Bearer " +  this.$store.getters.getToken}
      })
      .then( response => {
        this.listas = response.data.listas
        // M.toast({html: 'Lista atualizada'})
      })
      .catch(e => {
        console.log(e)
        // alert("Erro! Tente novamente mais tarde")
        M.toast({html: 'Erro! Tente novamente mais tarde'})
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
          M.toast({html: 'Lista criada com sucesso'})
          this.listar()
          this.novaTarefa = ''
        }else if(response.data.status === false) {
          // erros de validação
          let errors = '';
          for (let error of Object.values(response.data.errors)) {
            errors += error + " \n";
          }
          M.toast({html: errors})
          // alert(errors);
        }
      })
      .catch(e => {
        console.log(e)
        M.toast({html: 'Erro! Tente novamente mais tarde'})
        // alert("Erro! Tente novamente mais tarde")
      })
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
          M.toast({html: errors})
          // alert(errors);
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
        console.log(response)
        if(response.data.status){
          M.toast({html: response.data.message})
          this.listar()
        }
        // erros de validação
        let errors = '';
        for (let error of Object.values(response.data.errors)) {
          errors += error + " \n";
        }
        M.toast({html: errors})
        // alert(errors);
      })
      .catch(e => {
        console.log(e)
        // M.toast({html: '1Erro! Tente novamente mais tarde'})
        // alert("Erro! Tente novamente mais tarde")
      })
    },
    criarCategoria(){
      this.$http.post(this.$urlAPI+`category`, {
        name: this.nomeCategoria
      },{
        "headers": {"authorization": "Bearer " +  this.$store.getters.getToken}
      })
      .then( response => {
        if(response.data.status){
          console.log(response)
          M.toast({html: 'Categoria criada com sucesso'})
          this.listar()
          this.novaTarefa = ''
        }else if(response.data.status === false) {
          // erros de validação
          let errors = '';
          for (let error of Object.values(response.data.errors)) {
            errors += error + " \n";
          }
          M.toast({html: errors})
          // alert(errors);
        }
      })
      .catch(e => {
        console.log(e)
        M.toast({html: 'Erro! Tente novamente mais tarde'})
        // alert("Erro! Tente novamente mais tarde")
      })
    },
    criarTarefa(id){
      $('#tarefa').modal('open');
    }
  }
}
</script>
<style>
  button{
    margin: 0 8px;
  }
  .datepicker-container.modal-content {
    display: -webkit-box !important;
    display: -webkit-flex !important;
    display: -ms-flexbox !important;
    display: flex !important;
    -webkit-box-orient: vertical !important;
    -webkit-box-direction: normal !important;
    -webkit-flex-direction: column !important;
    -ms-flex-direction: column !important;
    flex-direction: column !important;
    padding: 0 !important;
  }

  .datepicker-date-display {
    -webkit-box-flex: 1;
    -webkit-flex: 1 auto;
    -ms-flex: 1 auto;
    flex: 1 auto;
    background-color: #26a69a;
    color: #fff;
    padding: 20px 22px;
    font-weight: 500;
  }

  @media only screen and (min-width: 601px) {
    .datepicker-date-display {
      /*-webkit-box-flex: 0;*/
      /*-webkit-flex: -2 1 270px;*/
      -ms-flex: 0 1 270px;
      /* flex: 0 1 270px; */
      /*display: -webkit-box !important;*/
      /*display: -webkit-flex !important;*/
      /*display: -ms-flexbox !important;*/
      /*display: flex !important;*/
      /*-webkit-box-orient: vertical !important;*/
      /*-webkit-box-direction: normal !important;*/
      /*-webkit-flex-direction: column !important;*/
      /*-ms-flex-direction: column !important;*/
      /*flex-direction: column !important;*/
      /*padding: 0 !important;*/
    }
  }
</style>