<template>
  <site-layout>
    <ul class="collapsible popout">
      <li>
        <div class="collapsible-header"><i class="material-icons">filter_drama</i>First</div>
        <div class="collapsible-body"><span>Lorem ipsum dolor sit amet.</span></div>
      </li>
      <li>
        <div class="collapsible-header"><i class="material-icons">place</i>Second</div>
        <div class="collapsible-body"><span>Lorem ipsum dolor sit amet.</span></div>
      </li>
      <li>
        <div class="collapsible-header"><i class="material-icons">whatshot</i>Third</div>
        <div class="collapsible-body"><span>Lorem ipsum dolor sit amet.</span></div>
      </li>
    </ul>
    <modal-vue identificador="modal1"></modal-vue>
    <float-actiont-button-vue>
      <a class="btn-floating red waves-effect waves-light btn modal-trigger" href="#modal1">
        <i class="material-icons">insert_chart</i>
      </a>
    </float-actiont-button-vue>
  </site-layout>
</template>

<script>
import SiteLayout from "../layouts/SiteLayout";
import FloatActiontButtonVue from "../components/layouts/FloatActiontButtonVue";
import ModalVue from "../components/layouts/ModalVue";

  document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.collapsible');
    var instances = M.Collapsible.init(elems,{
      accordion: false
    });
  });

export default {
  name: 'Home',
  components: {
    SiteLayout,
    FloatActiontButtonVue,
    ModalVue
  }
}
</script>
