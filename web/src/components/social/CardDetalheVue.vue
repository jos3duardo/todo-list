<template>
  <span>
    <div v-if="imagem && imagem != '#'" class="card-image">
      <a v-if="link && link != '#'" :href="link" target="_blank">
        <img :src="imagem">
        <span class="card-title">{{ titulo || '' }}</span>
      </a>
      <span v-if="!link || link == '#'">
        <img :src="imagem">
        <span class="card-title">{{ titulo || '' }}</span>
      </span>
    </div>

    <div v-if="texto" class="card-content">
      <span v-if="!imagem || imagem  == '#'">
        <span class="card-title">{{ titulo || '' }}</span>
      </span>

      <p>{{ texto }}</p>
      <p v-if="link && link != '#'"> <a :href="link" target="_blank">Confira mais aqui...</a> </p>
    </div>
  </span>

</template>

<script>

  export default {
    name: 'CardDetalheVue',
    props: ['imagem', 'titulo', 'texto', 'link'],
    components: {
    },
    data () {
      return {

      }
    }
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
