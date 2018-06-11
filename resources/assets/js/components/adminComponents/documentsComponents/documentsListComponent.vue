<template>
  <section class="tables">   
    <div class="container-fluid">
      <div class="row">    
        
        <div class="col-lg-12">
          <button type="button" class="btn btn-primary" v-on:click="createDocument()">Adicionar Documento</button>
          <div class="card mt-2">
            <div class="card-header d-flex align-items-center">
              <h3 class="h4">Lista de Documentos</h3>
            </div>
            <div class="card-body">
              <div class="table-responsive">                       
                <div class="card">
                  <b-table responsive 
                    stacked="md"
                    :items="documents" 
                    :fields="fields"
                    :current-page="currentPage"
                    :per-page="perPage"> 
                    <template slot="actions" slot-scope="row">
                      <a class="btn btn-sm btn-primary" :href="row.item.path" :download=row.item.description>Ver documento</a>
                      <button type="button" class="btn btn-sm btn-warning" v-on:click="editDocument(row.item)">Editar</button>
                      <button type="button" class="btn btn-sm btn-danger" v-on:click="deleteDocument(row.item)">Eliminar</button>
                    </template>
                  </b-table>
                  <hr>
                  <b-pagination :total-rows="documents.length" 
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
  props: ['documents'],
  data: function () {
    return {
      fields: [
        { key: 'id', label:'#'},
        { key: 'description', label:'Descrição'},
        { key: 'actions', label:'Ações'},
      ],
      currentPage: 1,
      perPage: 10
    }
  },
  methods: {
    deleteDocument: function(document) {
      this.$emit('deleteDocument', document);
    },
    editDocument: function(document) {
      this.$emit('editDocument', document);
    },
    createDocument: function() {
      this.$emit('createDocument');
    }
  }
}
</script>

