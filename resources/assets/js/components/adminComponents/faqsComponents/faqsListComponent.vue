<template>
  <section class="tables">   
    <div class="container-fluid">
      <div class="row">    
        
        <div class="col-lg-12">
          <button type="button" class="btn btn-primary" v-on:click="createFaq()">Adicionar FAQ</button>
          <div class="card mt-2">
            <div class="card-header d-flex align-items-center">
              <h3 class="h4">Lista de Faqs</h3>
            </div>
            <div class="card-body">
              <div class="table-responsive">                       
                <div class="card">
                  <b-table responsive 
                    stacked="md"
                    :items="faqs" 
                    :fields="fields"
                    :current-page="currentPage"
                    :per-page="perPage"> 
                    <template slot="actions" slot-scope="row">
                      <button type="button" class="btn btn-sm btn-primary" v-on:click="seeMoreDetails(row.item)">Ver mais detalhes</button>
                      <button type="button" class="btn btn-sm btn-warning" v-on:click="editFaq(row.item)">Editar</button>
                      <button type="button" class="btn btn-sm btn-danger" v-on:click="deleteFaq(row.item)">Eliminar</button>
                    </template>
                  </b-table>
                  <hr>
                  <b-pagination :total-rows="faqs.length" 
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
  props: ['faqs'],
  data: function () {
    return {
      fields: [
        { key: 'id', label:'#'},
        { key: 'question', label:'Questão'},
        { key: 'actions', label:'Ações'},
      ],
      currentPage: 1,
      perPage: 10
    }
  },
  methods: {
    editFaq: function(faq) {
      this.$emit('editFaq', faq);
    },
    deleteFaq: function(faq) {
      this.$emit('deleteFaq', faq);
    },
    createFaq: function() {
      this.$emit('createFaq');
    },
    seeMoreDetails: function(faq) {
      this.$emit('seeMoreDetails', faq);
    },
  }
}
</script>