<template>
  <section class="tables">   
    <div class="container-fluid">
      <div class="row">    
        
        <div class="col-lg-12">
          <button type="button" class="btn btn-primary" v-on:click="createNewsletter()">Adicionar Newsletter</button>
          <div class="card mt-2">
            <div class="card-header d-flex align-items-center">
              <h3 class="h4">Lista de Newsletters</h3>
            </div>
            <div class="card-body">
              <div class="table-responsive">                       
                <div class="card">
                  <p class="text-center" v-if="newsletters.length == 0" >Não existe newsletters disponíveis.</p>
                  <table class="table table-striped table-hover" v-if="newsletters.length != 0" >
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Descrição</th>
                        <th>Data</th>
                        <th>Ações</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="newsletter in newsletters" :key="newsletter.id">
                        <td>{{newsletter.id}}</td>
                        <td>{{newsletter.description}}</td>
                        <td>{{newsletter.date}}</td>
                        <td>
                            <a class="btn btn-sm btn-primary" :href="newsletter.path" :download=newsletter.description>Ver documento</a>
                            <button type="button" class="btn btn-sm btn-warning" v-on:click="editNewsletter(newsletter)">Editar</button>
                            <button type="button" class="btn btn-sm btn-danger" v-on:click="deleteNewsletter(newsletter)">Eliminar</button>
                            <button type="button" class="btn btn-sm btn-success" v-if="newsletter.isPublished == 0" v-on:click="publishNewsletter(newsletter)">Publicar</button>
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
  props: ['newsletters'],
  computed: {

  },
  methods: {
    deleteNewsletter: function(newsletter) {
      this.$emit('deleteNewsletter', newsletter);
    },
    editNewsletter: function(newsletter) {
      this.$emit('editNewsletter', newsletter);
    },
    createNewsletter: function() {
      this.$emit('createNewsletter');
    },
    publishNewsletter: function(newsletter) {
      this.$emit('publishNewsletter', newsletter);
    }
  }
}
</script>

