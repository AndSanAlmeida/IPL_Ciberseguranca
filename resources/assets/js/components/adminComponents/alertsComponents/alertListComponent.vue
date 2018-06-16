<template>
  <section class="tables">   
    <div class="container-fluid">
      <div class="row">    
        
        <div class="col-lg-12">
          <div class="row ml-1">
            <button type="button" class="btn btn-primary mr-2" v-on:click="createAlerts()">Adicionar Alerta</button>
            <router-link to="/rssAlerts" class="btn btn-success">Gerir RSS</router-link>
          </div>
          <div class="card mt-2">
            <div class="card-header d-flex align-items-center">
              <h3 class="h4">Lista de Alertas</h3>
            </div>
            <div class="card-body">
              <!-- SEARCH -->
              <div class="col-lg-6 offset-lg-3">
                <b-form-group horizontal label="Pesquisar">
                  <b-input-group>
                    <b-form-input v-model="filter" placeholder="Escreva para Procurar" />
                    <b-input-group-append>
                      <b-btn :disabled="!filter" @click="filter = ''">Limpar</b-btn>
                    </b-input-group-append>
                  </b-input-group>
                </b-form-group>
              </div>
              <div class="table-responsive">                       
                <div class="card">
                  <b-table responsive 
                    stacked="md"
                    :items="alerts" 
                    :fields="fields"
                    :current-page="currentPage"
                    :per-page="perPage"
                    :filter="filter"> 
                    <template slot="title" slot-scope="row">
                      <span v-html="row.item.title[0]">
                    </span>
                    </template>
                    <template slot="pubDate" slot-scope="row">
                     {{prepareDate(row.item.pubDate[0])}}
                    </template>
                    <template slot="category" slot-scope="row">
                      <span v-html="row.item.category[0]">
                    </span>
                    </template>
                    <template slot="actions" slot-scope="row">
                      <button type="button" class="btn btn-sm btn-primary" v-on:click="viewAlerts(row.item)">Ver Detalhes</button>
                    </template>
                  </b-table>
                  <hr>
                  <b-pagination :total-rows="alerts.length" 
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
  props: ['alerts'],
  data: function() {
    return {
      fields: [
        { key: 'title', label:'Título'},
        { key: 'category', label:'Categoria'},
        { key: 'pubDate', label:'Data de Publicação'},
        { key: 'actions', label:'Ações'},
      ],
      currentPage: 1,
      perPage: 30,
      sortBy: 'pubDate',
      sortDesc: true,
      filter: null,
    }
  },
  methods: {
    viewAlerts: function(alerts) {
      this.$emit('viewAlerts', alerts);
    },
    createAlerts: function() {
      this.$emit('createAlerts');
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
  mounted: function() {
    this.alerts.sort(function(a,b){
      var c = new Date(a.pubDate[0]);
      var d = new Date(b.pubDate[0]);
      return d-c;
    });
  }
}
</script>