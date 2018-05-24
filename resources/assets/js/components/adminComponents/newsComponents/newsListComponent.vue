<template>
  <section class="tables">   
    <div class="container-fluid">
      <div class="row">    
        
        <div class="col-lg-12">
          <div class="row ml-1">
            <button type="button" class="btn btn-primary mr-2" v-on:click="createNews()">Adicionar Notícia</button>
            <router-link to="/rssNews" class="btn btn-success">Gerir RSS</router-link>
          </div>
          <div class="card mt-2">
            <div class="card-header d-flex align-items-center">
              <h3 class="h4">Lista de Notícias</h3>
            </div>
            <div class="card-body">
              <div class="table-responsive">                       
                <div class="card">
                  <p class="text-center" v-if="news.length == 0" >Não existe notícias disponíveis.</p>
                  <b-table responsive 
                    stacked="md"
                    :items="news" 
                    :fields="fields"
                    :current-page="currentPage"
                    :per-page="perPage"> 
                    <template slot="title" slot-scope="row">
                      <span v-html="row.item.title[0]">
                    </span>
                    </template>
                    <template slot="pubDate" slot-scope="row">
                     {{prepareDate(row.item.pubDate[0])}}
                    </template>
                    <template slot="actions" slot-scope="row">
                      <button type="button" class="btn btn-sm btn-primary" v-on:click="viewNews(row.item)">Ver Detalhes</button>
                    </template>
                  </b-table>
              
                  <b-pagination :total-rows="news.length" 
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
  props: ['news'],
  data: function() {
    return {
      fields: [
        { key: 'title', label:'Título'},
        { key: 'pubDate', label:'Data de Publicação'},
        { key: 'actions', label:'Ações'},
      ],
      currentPage: 1,
      perPage: 20,
      sortBy: 'pubDate',
      sortDesc: true,
    }
  },
  computed: {
  
  },
  methods: {
    viewNews: function(news) {
      this.$emit('viewNews', news);
    },
    createNews: function() {
      this.$emit('createNews');
    },
    prepareDate: function(item) {
      var today = new Date(item);
      var dd = today.getDate();
      var mm = today.getMonth()+1; //January is 0!
      var yyyy = today.getFullYear();

      if(dd<10){
          dd='0'+dd;
      } 
      if(mm<10){
          mm='0'+mm;
      } 
      return dd+'/'+mm+'/'+yyyy;
    },
  },
  created: function() {
    this.news.sort(function(a,b){
      var c = new Date(a.pubDate[0]);
      var d = new Date(b.pubDate[0]);
      return d-c;
    });
  }
}
</script>