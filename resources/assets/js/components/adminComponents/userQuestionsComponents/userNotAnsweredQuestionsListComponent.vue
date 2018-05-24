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
                  <p class="text-center" v-if="notAnswered.length == 0" >Não existem perguntas por responder</p>
                  <table class="table table-striped table-hover" v-if="notAnswered.length != 0" >
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Pergunta</th>
                        <th>Ações</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="question in notAnswered" :key="question.id">
                        <td>{{question.id}}</td>
                        <td>{{question.question}}</td>
                        <td>
                          <button type="button" class="btn btn-sm btn-primary" v-on:click="seeMoreDetails(question)">Ver mais detalhes</button>
                          <button type="button" class="btn btn-sm btn-success" v-on:click="answerQuestion(question)">Responder</button>
                          <button type="button" class="btn btn-sm btn-danger" v-on:click="deleteNotAnswered(question)">Eliminar</button>
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
  props: ['notAnswered'],
  computed: {

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