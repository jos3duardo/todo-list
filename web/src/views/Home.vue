<template>
  <site-layout>
    <ul class="collapsible popout">
      <li v-for="lista in listas" :key="lista.id">
        <div class="collapsible-header"><i class="material-icons">event_note</i>{{lista.title}}</div>
        <div class="collapsible-body">
          <div class="row">
            <div class="col s12 m8">
              Data criação: {{ lista.data }}
            </div>
            <div class="col s12 m4 right-align">
              <a  href="#"
                  class="btn waves-light waves-effect grey darken-3 z-depth-3 modal-trigger tooltipped"
                  title="Criar tarefa"
                  v-on:click="abreModalNovaTarefa(lista.id)">
                <i class="material-icons">assignment</i>
              </a>
              <a title="Editar Lista de tarefa" :class="'btn waves-light waves-effect'+corBtn" v-on:click="editarLista(lista.id , lista.title)"><i class="material-icons">edit</i></a>
              <a title="Apagar Lista de tarefa" href="#" :class="'btn waves-light waves-effect modal-trigger'+ corBtn " v-on:click="apagarLista(lista.id)"><i class="material-icons">delete_forever</i></a>
            </div>
          </div>
          <div class="row">
            <ul class="collection">
              <li class="collection-item avatar" v-for="task in lista.tasks" :key="task.id">
                <div class="row">
                  <div class="col s2 m1">
                    <i class="material-icons circle blue-grey">library_books</i>
<!--                    <a href="#!"  class="btn btn-small" >-->
<!--                      <i class="small material-icons">exposure_plus_1</i>-->
<!--                    </a>-->

                  </div>
                  <div class="col s10 m12">
                    <span class="title">{{task.titulo}}</span>
                    <p>iniciado em <b class="green-text">{{ task.inicio}}</b> previsão de tremino em <b class="red-text">{{ task.fim}}</b></p>
                    <p>{{ task.status }}</p>
                    <p><b>Categoria:</b> {{ task.categoria }}</p>
                    <p><b>Texto: </b>{{ task.texto}}</p>
                  </div>
                </div>

                <a href="#!" title="Apaga tarefa" class="secondary-content" v-on:click="apagaTarefa(task.id)"><i class="material-icons red-text">delete</i></a>
                <hr>
                <ul class="collection">
                  <div class="row">
                    <div class="col s2 m1">
                      <a href="#!"  class="btn btn-small"  v-on:click="abreModalLembrete(task.id, task.titulo)"><i class="small material-icons">exposure_plus_1</i></a>
                    </div>
                    <div class="col s10 m11">
                      <h6 class="center-align">Lembretes</h6>
                    </div>
                  </div>
                  <hr>
                  <li class="collection-item" v-for="lembrete in task.lembretes" :key="lembrete.id">
                    <button href="#!"  class="left btn-small red" v-on:click="apagarLembrete(lembrete.id)"><i class="material-icons">close</i></button>
                    {{lembrete.titulo}}
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
      </li>
    </ul>

    <modal-vue :titulo="'Criar Lembrete para tarefa: '+task_titulo" identificador="lembrete">
      <span slot="content">
        <div class="col s12">
          <div class="row">
            <div class="input-field col s12 m12">
              <input id="lembrete" type="text" class="validate" v-model="nomeLembrete">
              <label for="lembrete">Nome</label>
            </div>
          </div>
        </div>
      </span>
      <span slot="footer">
        <button class="btn waves-light waves-effect modal-close" v-on:click="criarLembrete()">Enviar</button>
      </span>
    </modal-vue>

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
          <div class="input-field col s12 m12">
            <i class="material-icons prefix">mode_edit</i>
            <input id="first_name" type="text" class="validate" v-model="title">
            <label for="first_name">Nome</label>
          </div>
          <div class="input-field col s12 m6">
            <i class=" material-icons prefix">date_range</i>
            <input id="data_start" type="text" class="datepicker validate" readonly>
            <label for="data_start">Data inicio</label>
          </div>
          <div class="input-field col s12 m6">
            <i class="material-icons prefix">date_range</i>
            <input id="data_stop" type="text" class="datepicker" readonly >
            <label for="data_stop">Data termino</label>
          </div>
          <div class="row">
            <div class="input-field col s2 m1">
              <a class='prefix dropdown-trigger btn' href='#' data-target='selecionaCategoria'><i class="material-icons">apps</i></a>
            </div>
            <div class="input-field col s10 m11">
              <label for="category"></label>
              <input id="category" type="text" readonly v-model="categoriaNome">
            </div>
          </div>

          <div class="input-field col s12 m12">
            <i class="material-icons prefix">border_color</i>
            <textarea id="icon_prefix2" class="materialize-textarea" v-model="text"></textarea>
            <label for="icon_prefix2">Texto</label>
          </div>
        </div>
        <!-- Dropdown Trigger -->


              <!-- Dropdown Structure -->
        <ul id='selecionaCategoria' class='dropdown-content'>
          <li v-on:click="setIdcategori(category.id, category.name, item)" :class="'collection-item ' + category.active  " v-for="(category,item) in categoriasTestes" :key="category.id">
            <a href="#!">
                {{category.name}}
            </a>
          </li>
        </ul>

      </span>
      <span slot="footer">
        <button class="btn waves-light waves-effect modal-close" v-on:click="criarTarefa()">Enviar</button>
      </span>
    </modal-task-vue>


    <float-actiont-button-vue>
      <ul>
        <li v-for="item in modais" :key="item.modal">
          <a :title="item.title"  :href="'#'+item.modal" :class="'btn-floating waves-effect waves-light btn modal-trigger '+item.cor">
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
    ModalTaskVue,
  },
  data(){
    return {
      active:'',
      listaId:'',
      corBtn: ' grey darken-3 z-depth-3',
      title:'',
      date:'a',
      category_id:'',
      date_stop:'',
      task_id: '',
      task_titulo: '',
      text:'',
      novaTarefa:'',
      nomeCategoria: '',
      categorias: [],
      categoriaNome: '',
      categoriasTestes: [],
      tituloTarefa:'',
      idTarefa:'',
      nomeLembrete: '',
      listas: [],
      modais: [
        { modal: 'lista', icon: 'event_note', cor:'grey darken-3 z-depth-3', title:'Criar lista de tarefas'},
        { modal: 'category', icon: 'apps', cor:'grey darken-3 z-depth-3', title: 'Criar categoria' },
      ],
    }
  },
  mounted () {
    this.listarCategorias()

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

    let elemSelect = document.querySelectorAll('select');
    let instancesSelect = M.FormSelect.init(elemSelect,{
      dropdownOptions: this.categoriasTestes
    });

    let dropElem = document.querySelectorAll('.dropdown-trigger');
    let dropInstances = M.Dropdown.init(dropElem,{
      alignment: 'top',
      // isScrollable: true
    });

    let dates = document.querySelectorAll('.datepicker');
    let instanceDatePicker = M.Datepicker.init(dates,{
      autoClose: true,
      format:'dd/mm/yyyy',
      i18n: {
        months: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
        monthsShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        weekdays: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sabádo'],
        weekdaysShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
        weekdaysAbbrev: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S'],
        today: 'Hoje',
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
    let elems = document.querySelectorAll('select');
    let instances = M.FormSelect.init(elems);

    this.listarListaTarefas()

  },
  methods:{
    listarCategorias(){
      this.$http.get(this.$urlAPI+`categories`,
        {
          "headers": {"authorization": "Bearer " +  this.$store.getters.getToken}
        })
        .then( response => {
          console.log(response)
          if(response.data.status){
            for (let cat of (response.data.categories)) {
              let obj = new Object();
              obj.id = cat.id
              obj.name = cat.name
              obj.active = ''
              this.categoriasTestes.push(obj)
            }
          }else{
            // erros de validação
            let errors = '';
            for (let error of Object.values(response.data.errors)) {
              errors += error + " <br>";
            }
            M.toast({html: errors, classes: 'red'})
          }
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
          this.listarListaTarefas()
          this.novaTarefa = ''
        }else if(response.data.status === false) {
          // erros de validação
          let errors = '';
          for (let error of Object.values(response.data.errors)) {
            errors += error + " <br>";
          }
          M.toast({html: errors, classes: 'red'})
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
          this.listarListaTarefas()
          this.tituloTarefa = ''
        } else if (response.data.status === false) {
          // erros de validação
          let errors = '';
          for (let error of Object.values(response.data.errors)) {
            errors += error + " <br>";
          }
          M.toast({html: errors, classes: 'red'})
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
          this.listarListaTarefas()
        }
        // erros de validação
        let errors = '';
        for (let error of Object.values(response.data.errors)) {
          errors += error + " <br>";
        }
        M.toast({html: errors, classes: 'red'})
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
          this.listarListaTarefas()
          this.novaCategoria = ''
        }else if(response.data.status === false) {
          // erros de validação
          let errors = '';
          for (let error of Object.values(response.data.errors)) {
            errors += error + " <br>";
          }
          M.toast({html: errors, classes: 'red'})
        }
      })
      .catch(e => {
        console.log(e)
        M.toast({html: 'Erro! Tente novamente mais tarde'})
        // alert("Erro! Tente novamente mais tarde")
      })
    },
    criarLembrete(){
      this.$http.post(this.$urlAPI+`sticky-note`, {
        title: this.nomeLembrete,
        task_id: this.task_id
      },{
        "headers": {"authorization": "Bearer " +  this.$store.getters.getToken}
      })
      .then( response => {
        if(response.data.status){
          console.log(response)
          M.toast({html: 'Lembrete criada com sucesso'})
          this.listarListaTarefas()
          this.nomeLembrete = ''
        }else if(response.data.status === false) {
          // erros de validação
          let errors = '';
          for (let error of Object.values(response.data.errors)) {
            errors += error + " <br>";
          }
          M.toast({html: errors, classes: 'red'})
        }
      })
      .catch(e => {
        console.log(e)
        M.toast({html: 'Erro! Tente novamente mais tarde'})
        // alert("Erro! Tente novamente mais tarde")
      })
    },
    criarTarefa(id){
      let date = $('#data_start').val()
      let date_stop = $('#data_stop').val()
      this.$http.post(this.$urlAPI+`task`, {
        title: this.title,
        date: date,
        category_id: this.category_id,
        list_task_id: this.listaId,
        date_stop: date_stop,
        text: this.text
      },{
        "headers": {"authorization": "Bearer " +  this.$store.getters.getToken}
      })
      .then( response => {
        console.log(response)
        if(response.data.status){
          M.toast({html: 'Tarefa criada com sucesso'})
          this.novaTarefa = ''
          this.listarListaTarefas()
        }else {
          // erros de validação
          let errors = '';
          for (let error of Object.values(response.data.errors)) {
            errors += error + " <br>";
          }
          M.toast({html: errors, classes: 'red'})
        }
      })
      .catch(e => {
        console.log(e)
        M.toast({html: 'Erro! Tente novamente mais tarde'})
        // alert("Erro! Tente novamente mais tarde")
      })

    },
    abreModalNovaTarefa(id){
      this.listaId = id
      $('#tarefa').modal('open');
    },
    setIdcategori(id,title, key){
      this.category_id = id
      this.categoriaNome = title
      this.categoriasTestes.forEach(item => {
        if (id === item.id ){
          item.active = 'active'
        }else{
          item.active = ''
        }
      })

    },
    abreModalLembrete(id, titulo){
      this.task_id = id
      this.task_titulo = titulo
      $('#lembrete').modal('open');
    },
    apagarLembrete(id){
      this.$http.post(this.$urlAPI+`sticky-note/`+id,
      {_method: 'delete'}
      ,{
        "headers": {"authorization": "Bearer " +  this.$store.getters.getToken}
      })
      .then( response => {
        console.log(response)
        if(response.data.status){
          M.toast({html: response.data.message})
          this.listarListaTarefas()
        }else{
          // erros de validação
          let errors = '';
          for (let error of Object.values(response.data.errors)) {
            errors += error + " <br>";
          }
          M.toast({html: errors, classes: 'red'})
        }

      })
      .catch(e => {
        console.log(e)
        // M.toast({html: '1Erro! Tente novamente mais tarde'})
        // alert("Erro! Tente novamente mais tarde")
      })
    },
    apagaTarefa(id){
      this.$http.post(this.$urlAPI+`task/`+id,
      {_method: 'delete'}
      ,{
        "headers": {"authorization": "Bearer " +  this.$store.getters.getToken}
      })
      .then( response => {
        console.log(response)
        if(response.data.status){
          M.toast({html: response.data.message})
          this.listarListaTarefas()
        }else{
          // erros de validação
          let errors = '';
          for (let error of Object.values(response.data.errors)) {
            errors += error + " <br>";
          }
          M.toast({html: errors, classes: 'red'})
        }
      })
      .catch(e => {
        console.log(e)
        // M.toast({html: '1Erro! Tente novamente mais tarde'})
        // alert("Erro! Tente novamente mais tarde")
      })
    }
  }
}
</script>
<style>
  button{
    margin: 0 8px;
  }
  .dropdown{
    width: 500px !important;
  }
  .dropdown-content{
    width: 300px !important;
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