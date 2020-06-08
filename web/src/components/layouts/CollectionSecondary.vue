<template>
    <ul class="collection with-header">
        <li class="collection-header"><h4>{{title}}</h4></li>
        <li class="collection-item">
            <slot name="lista" />
        </li>
    </ul>
</template>
<script>

    export default {
        name: 'CollectionSecundary',
        props: ['title','action','name']
    }
</script>