<template>
    <div :id="identificador" class="modal">
        <div class="modal-content">
            <h4>{{titulo}}</h4>
            <slot name="content"></slot>
        </div>
        <div class="modal-footer">
            <slot name="footer"></slot>
<!--            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Fecha</a>-->
        </div>
    </div>
</template>
<script>
export default {
    name: 'Modal',
    props: ['identificador','titulo'],
    data(){
        return {

        }
    },
    mounted() {
        let elems = document.querySelectorAll('.modal');
        let instances = M.Modal.init(elems);
    }
}
</script>
<style>
    .modal {
        width: 50%;
        height: 35%;
    }
</style>