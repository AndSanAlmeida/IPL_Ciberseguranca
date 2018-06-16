<template>
  <section class="tables">   
    <div class="container-fluid">
      <div class="row">    
        
        <div class="col-lg-12">
          <button type="button" class="btn btn-primary" v-on:click="createNewsletter()">Adicionar Newsletter</button>
          <div class="card mt-2">
            <div class="card-header d-flex align-items-center">
              <h3 class="h4">Lista de Newsletters</h3>
            </div>
            <div class="card-body">
              <div class="table-responsive">                       
                <div class="card">
                  <b-table responsive 
                    stacked="md"
                    :items="newsletters" 
                    :fields="fields"
                    :current-page="currentPage"
                    :per-page="perPage"> 
                    <template slot="actions" slot-scope="row">
                      
                      <button type="button" class="btn btn-sm btn-success" v-if="row.item.isPublished == 0" v-on:click="publishNewsletter(row.item)">Publicar</button>
                      <button type="button" class="btn btn-sm btn-primary" v-on:click="showNewsletter(row.item)">Mostrar</button>
                      <button type="button" class="btn btn-sm btn-danger" v-on:click="deleteNewsletter(row.item)">Eliminar</button>
                    </template>
                  </b-table>
                  <hr>
                  <b-pagination :total-rows="newsletters.length" 
                      :per-page="perPage" 
                      v-model="currentPage"
                      align="center"/>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script type="text/javascript">
module.exports={
  props: ['newsletters'],
  data: function () {
    return {
      fields: [
        { key: 'id', label:'#'},
        { key: 'title', label:'Título'},
        { key: 'date', label:'Data'},
        { key: 'actions', label:'Ações'},
      ],
      currentPage: 1,
      perPage: 10
    }
  },
  methods: {
    showNewsletter: function(newsletter) {
      this.$emit('showNewsletter', newsletter);
    },
    deleteNewsletter: function(newsletter) {
      this.$emit('deleteNewsletter', newsletter);
    },
    createNewsletter: function() {
      this.$emit('createNewsletter');
    },
    publishNewsletter: function(newsletter) {
      this.$emit('publishNewsletter', newsletter);
    }
  }
}
</script>

