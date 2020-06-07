<template>
    <div :id="identificador" class="modal">
        <div class="modal-content">
            <h5>{{titulo}}</h5>
            <slot name="content"></slot>
<!--        </div>-->
<!--        <div class="modal-footer">-->
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
<style scoped>
    .modal { max-height: 100%; overflow: visible}
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
</style>