<template>
    <div class="fixed-action-btn">
        <a class="btn-floating btn-large red pulse">
            <i class="large material-icons">mode_edit</i>
        </a>

            <slot></slot>
<!--            <li><a class="btn-floating yellow darken-1"><i class="material-icons">format_quote</i></a></li>-->
<!--            <li><a class="btn-floating green"><i class="material-icons">publish</i></a></li>-->
<!--            <li><a class="btn-floating blue"><i class="material-icons">attach_file</i></a></li>-->
    </div>
</template>
<script>


    export default {
        name: 'FloatActionButton',
        mounted() {
            let elems = document.querySelectorAll('.fixed-action-btn');
            let instances = M.FloatingActionButton.init(elems, {
                direction: 'top'
            });
        }
    }
</script>