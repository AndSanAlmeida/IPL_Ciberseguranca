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
              <h3 class="h4">Lista de RSS de Notícias</h3>
            </div>
            <div class="card-body">
              <div class="table-responsive">                       
                <div class="card">
                  <b-table responsive 
                    stacked="md"
                    :items="rssNews" 
                    :fields="fields"
                    :current-page="currentPage"
                    :per-page="perPage"> 
                    <template slot="website" slot-scope="row">
                      <span v-html="row.item.website"></span>
                    </template>
                    <template slot="url" slot-scope="row">
                      <span v-html="row.item.url"></span>
                    </template>
                    <template slot="actions" slot-scope="row">
                      <button type="button" class="btn btn-sm btn-warning" v-on:click="editRssNews(row.item)">Editar</button>
                      <button type="button" class="btn btn-sm btn-danger" v-on:click="deleteRssNews(row.item)">Eliminar</button>
                    </template>
                  </b-table>
                  <hr>
                  <b-pagination :total-rows="rssNews.length" 
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
  props: ['rssNews'],
  data: function () {
    return {
      fields: [
        { key: 'id', label:'#'},
        { key: 'website', label:'Website'},
        { key: 'url', label:'URL'},
        { key: 'actions', label:'Ações'},
      ],
      currentPage: 1,
      perPage: 10
    }
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