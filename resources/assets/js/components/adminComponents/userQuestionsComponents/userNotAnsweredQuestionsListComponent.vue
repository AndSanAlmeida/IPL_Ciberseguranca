<template>
  <section class="tables">   
    <div class="container-fluid">
      <div class="row">    
        
        <div class="col-lg-12">
          <div class="card mt-2">
            <div class="card-header d-flex align-items-center">
              <h3 class="h4">Questões dos Utilizadores - Por Responder</h3>
            </div>
            <div class="card-body">
              <div class="table-responsive">                       
                <div class="card">                  
                  <b-table responsive 
                    stacked="md"
                    :items="notAnswered" 
                    :fields="fields"
                    :current-page="currentPage"
                    :per-page="perPage"> 
                    <template slot="actions" slot-scope="row">
                      <button type="button" class="btn btn-sm btn-primary" v-on:click="seeMoreDetails(row.item)">Ver mais detalhes</button>
                      <button type="button" class="btn btn-sm btn-success" v-on:click="answerQuestion(row.item)">Responder</button>
                      <button type="button" class="btn btn-sm btn-danger" v-on:click="deleteNotAnswered(row.item)">Eliminar</button>
                    </template>
                  </b-table>
                  <hr>
                  <b-pagination :total-rows="notAnswered.length" 
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
  props: ['notAnswered'],
  data: function () {
    return {
      fields: [
        { key: 'id', label:'#'},
        { key: 'question', label:'Pergunta'},
        { key: 'actions', label:'Ações'},
      ],
      currentPage: 1,
      perPage: 10
    }
  },
  methods: {
    answerQuestion: function(question) {
      this.$emit('answerQuestion', question);
    },
    deleteNotAnswered: function(question) {
      this.$emit('deleteNotAnswered', question);
    },
    seeMoreDetails: function(question) {
      this.$emit('seeMoreDetails', question);
    },
  }
}
</script>