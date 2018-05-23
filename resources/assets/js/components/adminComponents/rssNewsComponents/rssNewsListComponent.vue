<template>
  <section class="tables">   
    <div class="container-fluid">
      <div class="row">    
        
        <div class="col-lg-12">
          <div class="row ml-1">
            <button type="button" class="btn btn-primary mr-2" v-on:click="addRSSNews()">Adicionar RSS</button>
            <router-link to="/news" class="btn btn-secondary float-right">Voltar às notícias</router-link>
               
          </div>
          <div class="card mt-2">
            <div class="card-header d-flex align-items-center">
              <h3 class="h4">Lista de Notícias</h3>
            </div>
            <div class="card-body">
              <div class="table-responsive">                       
                <div class="card">
                  <p class="text-center" v-if="rssNews.length == 0" >Não existe rss de notícias disponíveis.</p>
                  <table class="table table-striped table-hover" v-if="rssNews.length != 0" >
                    <thead>
                      <tr>
                        <th>Website</th>
                        <th>Url</th>
                        <th>Ações</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="rss in rssNews">
                        <td><span v-html="rss.website"></span></td>
                        <td><span v-html="rss.url"></span></td>
                        <td>
                            <button type="button" class="btn btn-sm btn-warning" v-on:click="editRssNews(rss)">Editar</button>
                            <button type="button" class="btn btn-sm btn-danger" v-on:click="deleteRssNews(rss)">Eliminar</button>
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
  props: ['rssNews'],
  computed: {

  },
  methods: {
    viewRssNews: function(rss) {
      this.$emit('viewNews', rss);
    },
    addRSSNews: function() {
      this.$emit('addRSSNews');
    },
    editRssNews: function(rss) {
      this.$emit('editRssNews', rss);
    },
    deleteRssNews: function(rss) {
      this.$emit('deleteRSSNews', rss);
    }
  },
  created: function() {
  }
}
</script>