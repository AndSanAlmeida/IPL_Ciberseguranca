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
                  <p class="text-center" v-if="faqs.length == 0" >Não existe FAQs disponíveis.</p>
                  <table class="table table-striped table-hover" v-if="faqs.length != 0" >
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Questão</th>
                        <th>Ações</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="faq in faqs" :key="faq.id">
                        <td>{{faq.id}}</td>
                        <td>{{faq.question}}</td>
                        <td>
                          <button type="button" class="btn btn-sm btn-primary" v-on:click="seeMoreDetails(faq)">Ver mais detalhes</button>
                          <button type="button" class="btn btn-sm btn-warning" v-on:click="editFaq(faq)">Editar</button>
                          <button type="button" class="btn btn-sm btn-danger" v-on:click="deleteFaq(faq)">Eliminar</button>
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
  props: ['faqs'],
  computed: {

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