<template>
       <div class="row mt-0">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark" id="titlePage">{{ labels.page }}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right font-weight-bold">
                    <li class="breadcrumb-item">{{ labels.isChild === true ? labels.parent : labels.page }}</li>
                    <li v-show="labels.isChild" class="breadcrumb-item ">{{ labels.page }}</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
</template>
<script>
export default {
    props : ['labels']
}
</script>
<style lang="css">
    .breadcrumb-item + .breadcrumb-item::before {
        content: ">";
    }
</style>