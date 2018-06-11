<template>
  <section class="tables">   
    <div class="container-fluid">
      <div class="row">    
        
        <div class="col-lg-12">
          <button type="button" class="btn btn-primary" v-on:click="createGlossary()">Adicionar Entrada no Glossário</button>
          <div class="card mt-2">
            <div class="card-header d-flex align-items-center">
              <h3 class="h4">Entradas do Glossário</h3>
            </div>
            <div class="card-body">

              <!-- SEARCH -->
              <div class="col-lg-6 offset-lg-3">
                <b-form-group horizontal label="Pesquisar">
                  <b-input-group>
                    <b-form-input v-model="filter" placeholder="Escreva para Procurar" />
                    <b-input-group-append>
                      <b-btn :disabled="!filter" @click="filter = ''">Limpar</b-btn>
                    </b-input-group-append>
                  </b-input-group>
                </b-form-group>
              </div>

              <div class="table-responsive">                       
                <div class="card">
                  <b-table responsive 
                    stacked="md"
                    :items="glossary" 
                    :fields="fields"
                    :current-page="currentPage"
                    :per-page="perPage"
                    :filter="filter"> 
                    <template slot="actions" slot-scope="row">
                      <button type="button" class="btn btn-sm btn-primary" v-on:click="viewGlossary(row.item)">Ver Detalhes</button>
                      <button type="button" class="btn btn-sm btn-warning" v-on:click="editGlossary(row.item)">Editar</button>
                      <button type="button" class="btn btn-sm btn-danger" v-on:click="deleteGlossary(row.item)">Eliminar</button>
                    </template>
                  </b-table>
                  <hr>
                  <b-pagination :total-rows="glossary.length" 
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
  props: ['glossary'],
  data: function () {
    return {
      fields: [
        { key: 'id', label:'#'},
        { key: 'key', label:'Chave', sortable: true},
        { key: 'name', label:'Nome'},
        { key: 'actions', label:'Ações'},
      ],
      currentPage: 1,
      perPage: 10,
      filter: null
    }
  },
  methods: {
    deleteGlossary: function(glossary) {
      this.$emit('deleteGlossary', glossary);
    },
    editGlossary: function(glossary) {
      this.$emit('editGlossary', glossary);
    },
    createGlossary: function() {
      this.$emit('createGlossary');
    },
    viewGlossary: function(glossary) {
      this.$emit('viewGlossary', glossary);
    }
  }
}
</script>