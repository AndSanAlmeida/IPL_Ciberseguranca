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
              <div class="table-responsive">                       
                <div class="card">
                  <p class="text-center" v-if="glossary.length == 0" >Não existe entradas do glossário disponíveis.</p>
                  <table class="table table-striped table-hover" v-if="glossary.length != 0" >
                    <thead>
                      <tr>
                        <th>#</th>
                        <td>Chave</td>
                        <th>Nome</th>
                        <th>Definição</th>
                        <th>Ações</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="glossaryItem in glossary"  :key="glossaryItem.id">
                        <td>{{glossaryItem.id}}</td>
                        <td>{{glossaryItem.key}}</td>
                        <td>{{glossaryItem.name}}</td>
                        <td>{{glossaryItem.definition}}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary" v-on:click="viewGlossary(glossaryItem)">Ver Detalhes</button>
                            <button type="button" class="btn btn-sm btn-warning" v-on:click="editGlossary(glossaryItem)">Editar</button>
                            <button type="button" class="btn btn-sm btn-danger" v-on:click="deleteGlossary(glossaryItem)">Eliminar</button>
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
  props: ['glossary'],
  computed: {

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