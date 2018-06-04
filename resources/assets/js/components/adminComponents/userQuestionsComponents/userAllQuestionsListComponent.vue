<template>
  <section class="tables">   
    <div class="container-fluid">
      <div class="row">    
        <div class="col-lg-12">
          <div class="card mt-2">
            <div class="card-header d-flex align-items-center">
              <h3 class="h4">Histórico de Questões dos Utilizadores</h3>
            </div>
            <div class="card-body">
              <div class="table-responsive">                       
                <div class="card">
                  <b-table responsive 
                    stacked="md"
                    :items="questions" 
                    :fields="fields"
                    :current-page="currentPage"
                    :per-page="perPage"> 
                    <template slot="actions" slot-scope="row">
                      <button type="button" class="btn btn-sm btn-primary" v-on:click="seeMoreDetails(row.item)">Ver mais detalhes</button>
                      <button type="button" class="btn btn-sm btn-danger" v-on:click="deleteQuestions(row.item)">Eliminar</button>
                      <button type="button" class="btn btn-sm btn-success" v-if="!row.item.isFAQ" v-on:click="useInFAQ(row.item)">Usar em FAQ</button>
                    </template>
                  </b-table>
                  <hr>
                  <b-pagination :total-rows="questions.length" 
                      :per-page="perPage" 
                      v-model="currentPage"
                      align="center"/>
                </div>
              </div>
              <div class="text-right">
                <button v-on:click="redirect()" class="btn btn-primary" >Voltar</button>
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
  props: ['questions'],
  data: function () {
    return {
      fields: [
        { key: 'id', label:'#'},
        { key: 'question', label:'Pergunta'},
        { key: 'answer', label:'Resposta'},
        { key: 'actions', label:'Ações'},
      ],
      currentPage: 1,
      perPage: 10
    }
  },
  methods: {
    useInFAQ: function(question) {
      this.$emit('answerQuestion', question);
    },
    deleteQuestions: function(question) {
      this.$emit('deleteQuestion', question);
    },
    seeMoreDetails: function(question) {
      this.$emit('seeMoreDetails', question);
    },
    redirect: function() {
      this.$router.push("/userQuestions");
    }
  }
}
</script>