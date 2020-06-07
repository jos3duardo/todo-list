<template>
    <site-layout>
        <table>
            <thead>
            <tr>
                <th>id</th>
                <th>Name</th>
                <th>Data</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in categorias" :key="item.id">
                <td>{{ item.id }}</td>
                <td>{{ item.name }}</td>
                <td>{{ item.created_at }}</td>
                <td>
                    <button class="btn waves-light waves-effect grey darken-3 z-depth-3" v-on:click="abreModal(item.id,item.name)">
                        <i class="material-icons">edit</i>
                    </button>
                    <button class="btn waves-light waves-effect grey darken-3 z-depth-3" v-on:click="apagaCategoria(item.id)">
                        <i class="material-icons">delete</i>
                    </button>
                </td>
            </tr>
            </tbody>
        </table>

        <modal-vue :titulo="'Editar Categoria '+ name" identificador="category">
            <span slot="content">
                <div class="col s12">
                    <div class="row">
                        <div class="input-field col s12 m12">
                            <input type="hidden" v-model="id">
                            <input id="edit_name" type="text" class="validate" v-model="name">
                            <label for="edit_name">Nome</label>
                        </div>
                    </div>
                </div>
            </span>
            <span slot="footer">
                <button class="btn waves-light waves-effect modal-close" v-on:click="editaCategoria(id)">Enviar</button>
            </span>
        </modal-vue>

        <modal-vue titulo="Criar Categoria" identificador="create">
            <span slot="content">
                <div class="col s12">
                    <div class="row">
                        <div class="input-field col s12 m12">
                            <input id="name" type="text" class="validate" v-model="nameCategory">
                            <label for="name">Nome</label>
                        </div>
                    </div>
                </div>
            </span>
            <span slot="footer">
                <button class="btn waves-light waves-effect modal-close" v-on:click="criarCategoria(id)">Enviar</button>
            </span>
        </modal-vue>

        <div class="fixed-action-btn">
            <a href="#create" class="btn-floating btn-large red modal-trigger" >
                <i class="large material-icons">mode_edit</i>
            </a>

        </div>
    </site-layout>
</template>
<script>
import SiteLayout from "../layouts/SiteLayout";
import ModalVue from "../components/layouts/ModalVue";

export default {
    name: 'Categoria',
    components:{
        SiteLayout,
        ModalVue,
    },
    data(){
        return{
            categorias: [],
            id: '',
            name: '',
            nameCategory: ''
        }
    },
    mounted() {
        let elems = document.querySelectorAll('.fixed-action-btn');
        let instances = M.FloatingActionButton.init(elems, {
            direction: 'top'
        });
    },
    created() {
        this.listarCategorias()
    },
    methods: {
        listarCategorias(){
            this.$http.get(this.$urlAPI+`category`,
                {
                    "headers": {"authorization": "Bearer " +  this.$store.getters.getToken}
                })
                .then( response => {
                    if(response.data.status){

                        this.categorias = response.data.data
                    }else{
                        // erros de validação
                        let errors = '';
                        for (let error of Object.values(response.data.errors)) {
                            errors += error + " \n";
                        }
                        M.toast({html: errors})
                    }
                })
                .catch(e => {
                    console.log(e)
                    // alert("Erro! Tente novamente mais tarde")
                    M.toast({html: 'Erro! Tente novamente mais tarde'})
                })
        },
        apagaCategoria(id){
            this.$http.post(this.$urlAPI+`category/`+id,
            {_method: 'delete'},
            {
                "headers": {"authorization": "Bearer " +  this.$store.getters.getToken}
            })
            .then( response => {
                if(response.data.status){
                    this.listarCategorias()
                    M.toast({html: 'Categoria apagada'})
                }else{
                    // erros de validação
                    let errors = '';
                    for (let error of Object.values(response.data.errors)) {
                        errors += error + " \n";
                    }
                    M.toast({html: errors})
                }
            })
            .catch(e => {
                console.log(e)
                // alert("Erro! Tente novamente mais tarde")
                M.toast({html: 'Erro! Tente novamente mais tarde'})
            })
        },
        abreModal(id,name){
            this.id = id
            this.name = name
            $('#category').modal('open');
        },
        editaCategoria(id){
            this.$http.put(this.$urlAPI+`category/`+id,{
                name: this.name
            },
            {
                "headers": {"authorization": "Bearer " +  this.$store.getters.getToken}
            })
            .then( response => {
                if(response.data.status){
                    M.toast({html: 'Categoria editada'})
                    this.id = ''
                    this.name = ''
                    this.listarCategorias()
                }else{
                    // erros de validação
                    let errors = '';
                    for (let error of Object.values(response.data.errors)) {
                        errors += error + " \n";
                    }
                    M.toast({html: errors})
                }
            })
            .catch(e => {
                console.log(e)
                // alert("Erro! Tente novamente mais tarde")
                M.toast({html: 'Erro! Tente novamente mais tarde'})
            })
        },
        criarCategoria(){
            this.$http.post(this.$urlAPI+`category`, {
                name: this.nameCategory
            },{
                "headers": {"authorization": "Bearer " +  this.$store.getters.getToken}
            })
                .then( response => {
                    if(response.data.status){
                        console.log(response)
                        M.toast({html: 'Categoria criada com sucesso'})
                        this.listarCategorias()
                        this.nameCategory = ''
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
    }
}
</script>
<style>

</style>