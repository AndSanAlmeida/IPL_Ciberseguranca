<template>
  <section class="tables">   
    <div class="container-fluid">
      <div class="row">    
        
        <div class="col-lg-12">
          <div class="row ml-1">
            <button type="button" class="btn btn-primary mr-2" v-on:click="addRSSAlerts()">Adicionar RSS</button>
            <router-link to="/alerts" class="btn btn-secondary float-right">Voltar aos alertas</router-link>
               
          </div>
          <div class="card mt-2">
            <div class="card-header d-flex align-items-center">
              <h3 class="h4">Lista de RSS de Alertas</h3>
            </div>
            <div class="card-body">
              <div class="table-responsive">                       
                <div class="card">
                  <b-table responsive 
                    stacked="md"
                    :items="rssAlerts" 
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
                      <button type="button" class="btn btn-sm btn-warning" v-on:click="editRssAlerts(row.item)">Editar</button>
                      <button type="button" class="btn btn-sm btn-danger" v-on:click="deleteRssAlerts(row.item)">Eliminar</button>
                    </template>
                  </b-table>
                  <hr>
                  <b-pagination :total-rows="rssAlerts.length" 
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
  props: ['rssAlerts'],
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
    viewRssAlerts: function(rss) {
      this.$emit('viewAlerts', rss);
    },
    addRSSAlerts: function() {
      this.$emit('addRSSAlerts');
    },
    editRssAlerts: function(rss) {
      this.$emit('editRssAlerts', rss);
    },
    deleteRssAlerts: function(rss) {
      this.$emit('deleteRSSAlerts', rss);
    }
  },
  created: function() {
  }
}
</script>