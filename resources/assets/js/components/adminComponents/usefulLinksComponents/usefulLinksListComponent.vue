<template>
  <section class="tables">   
    <div class="container-fluid">
      <div class="row">    
        
        <div class="col-lg-12">
          <button type="button" class="btn btn-primary" v-on:click="createLink()">Adicionar Link Útil</button>
          <div class="card mt-2">
            <div class="card-header d-flex align-items-center">
              <h3 class="h4">Lista de Links Uteis</h3>
            </div>
            <div class="card-body">
              <div class="table-responsive">                       
                <div class="card">
                  <b-table responsive 
                    stacked="md"
                    :items="usefulLinks" 
                    :fields="fields"
                    :current-page="currentPage"
                    :per-page="perPage"> 
                    <template slot="actions" slot-scope="row">
                      <button type="button" class="btn btn-sm btn-warning" v-on:click="editLink(row.item)">Editar</button>
                      <button type="button" class="btn btn-sm btn-danger" v-on:click="deleteLink(row.item)">Eliminar</button>
                    </template>
                  </b-table>
                  <hr>
                  <b-pagination :total-rows="usefulLinks.length" 
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
  props: ['usefulLinks'],
  data: function () {
    return {
      fields: [
        { key: 'id', label:'#'},
        { key: 'description', label:'Descrição'},
        { key: 'link', label:'URL'},
        { key: 'actions', label:'Ações'},
      ],
      currentPage: 1,
      perPage: 10
    }
  },
  methods: {
    editLink: function(link) {
      this.$emit('editLink', link);
    },
    deleteLink: function(link) {
      this.$emit('deleteLink', link);
    },
    createLink: function() {
      this.$emit('createLink');
    }
  }
}
</script>