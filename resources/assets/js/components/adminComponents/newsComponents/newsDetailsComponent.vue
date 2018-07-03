<template>
    <div class="col-md-8 offset-md-2">
        <span class="anchor" id="formUserEdit"></span>

        <div class="card card-outline-secondary">
            <div class="card-header">
                <h1 class="mb-0 text-center"><span v-html="item.title[0]"></span></h1>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-12">
                  <p><b>Data: </b>{{prepareDate(item.pubDate[0])}}</span></p>

                  <p v-if="item.description != null" style="overflow: hidden;" v-html="item.description[0]"></p>

                  <p><b>Fonte: </b></p><a :href="item.link[0]"><span v-html="item.link[0]"></span></a>

                  <div class="form-group row">
                      <label class="col-lg-3 col-form-label form-control-label"></label>
                      <div class="col-lg-9">
                          <input class="btn btn-secondary float-right" value="Voltar" type="button" v-on:click="cancel">
                      </div>
                  </div>
                </div>
              </div>
                
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
    export default {
        props: ['item'],
        data: function() {
            return {
                serverError: false,
                serverErrorMessage: '',
            }
        },
        methods: {
            cancel: function() {
                this.exit();
            },
            exit: function() {
                this.$emit('exit');
            },
            prepareDate: function(item) {
              var today = new Date(item);
              var dd = today.getDate();
              var mm = today.getMonth()+1; //January is 0!
              var yyyy = today.getFullYear();

              if(dd<10){
                  dd='0'+dd;
              } 
              if(mm<10){
                  mm='0'+mm;
              } 
              return today = dd+'/'+mm+'/'+yyyy;
            }
        },
        mounted: function () {
        }
    }
</script>

<style type="text/css" media="screen">
 
</style>