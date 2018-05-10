<template>
  <section class="tables">   
    <div class="container-fluid">
      <div class="row">    
        
        <div class="col-lg-12">
          <router-link to="/glossary/create" class="btn btn-primary">Adicionar Notícia</router-link>
          <div class="card mt-2">
            <div class="card-header d-flex align-items-center">
              <h3 class="h4">Lista de Notícias</h3>
            </div>
            <div class="card-body">
              <div class="table-responsive">                       
                <div class="card">
                  <p class="text-center" v-if="news.length == 0" >Não existe notícias disponíveis.</p>
                  <table class="table table-striped table-hover" v-if="news.length != 0" >
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Definição</th>
                        <th>Ações</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="newsItem in news" :key="newsItem.id">
                        <td>{{newsItem.id}}</td>
                        <td>{{newsItem.name}}</td>
                        <td>{{newsItem.definition}}</td>
                        <td>
                            <router-link :to="{ name: 'glossaryDetails', params: {id: glossaryItem.id } }" class="btn btn-sm btn-primary">Ver detalhes</router-link>
                            <router-link :to="{ name: 'glossaryEdit', params: {id: glossaryItem.id } }" class="btn btn-sm btn-warning">Editar</router-link>
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
  props: ['news'],
  computed: {

  },
  methods: {
    deleteNews: function(news) {
      this.$emit('delete-click', news);
    }
  }
}
</script>