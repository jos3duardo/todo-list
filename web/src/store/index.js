import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    usuario: sessionStorage.getItem('usuario') ? JSON.parse(sessionStorage.getItem('usuario')) : null,
    conteudoLinhaTempo: []
  },
  getters:{
    getUsuario: state => {
      return state.usuario
    },
    getToken: state => {
      return state.usuario.token
    }
  },
  mutations: {
    setUsuario(state, n){
      state.usuario = n
    },
    setpaginacaoConteudoLinhaTempo(state, lista){
      for (let item of lista){
        state.conteudoLinhaTempo.push(item)
      }
    }
  }
})
