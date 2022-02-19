<template lang="">
    <div class="container-lg">
        <div class="d-flex w-100">
            <PageList/>
            <PageProp/>
        </div>
    </div>
</template>

<script>
import PageList from './component/PageList.vue'
import PageProp from './component/PageProp.vue'

export default {
    name:"app",
    components:{
        PageList,
        PageProp
    }
}
</script>