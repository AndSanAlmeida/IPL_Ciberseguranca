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
                  <p class="text-center" v-if="questions.length == 0" >Não existem questões do utilizador</p>
                  <table class="table table-striped table-hover" v-if="questions.length != 0" >
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Pergunta</th>
                        <th>Resposta</th>
                        <th>Ações</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="question in questions" :key="question.id">
                        <td>{{question.id}}</td>
                        <td>{{question.question}}</td>
                        <td>{{question.answer}}</td>
                        <td>
                          <button type="button" class="btn btn-sm btn-primary" v-on:click="seeMoreDetails(question)">Ver mais detalhes</button>
                          <button type="button" class="btn btn-sm btn-danger" v-on:click="deleteQuestions(question)">Eliminar</button>
                          <button type="button" class="btn btn-sm btn-success" v-if="!question.isFAQ" v-on:click="useInFAQ(question)">Usar em FAQ</button>
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
  props: ['questions'],
  computed: {

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
    }
  }
}
</script>