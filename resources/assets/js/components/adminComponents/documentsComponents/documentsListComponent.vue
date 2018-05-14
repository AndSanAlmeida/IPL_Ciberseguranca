<template>
  <section class="tables">   
    <div class="container-fluid">
      <div class="row">    
        
        <div class="col-lg-12">
          <router-link to="/documents/create" class="btn btn-primary">Adicionar Documento</router-link>
          <div class="card mt-2">
            <div class="card-header d-flex align-items-center">
              <h3 class="h4">Lista de Documentos</h3>
            </div>
            <div class="card-body">
              <div class="table-responsive">                       
                <div class="card">
                  <p class="text-center" v-if="documents.length == 0" >Não existe documentos disponíveis.</p>
                  <table class="table table-striped table-hover" v-if="documents.length != 0" >
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Descrição</th>
                        <th>Ações</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="document in documents" :key="document.id">
                        <td>{{document.id}}</td>
                        <td>{{document.description}}</td>
                        <td>
                            <a class="btn btn-sm btn-primary" :href="document.path" :download=document.description>Ver documento</a>
                            <router-link :to="{ name: 'documentsEdit', params: {id: document.id } }" class="btn btn-sm btn-warning">Editar</router-link>
                            <button type="button" class="btn btn-sm btn-danger" v-on:click="deleteDocument(document)">Eliminar</button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
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
  computed: {

  },
  methods: {
    deleteDocument: function(document) {
      this.$emit('delete-click', document);
    },
  }
}
</script>

