<template>
  <section class="tables">   
    <div class="container-fluid">
      <div class="row">    
        
        <div class="col-lg-12">
          <button type="button" class="btn btn-primary" v-on:click="createEvent()">Criar Evento</button>
          <div class="card mt-2">
            <div class="card-header d-flex align-items-center">
              <h3 class="h4">Lista de Eventos</h3>
            </div>
            <div class="card-body">
              <div class="table-responsive">                       
                <div class="card">
                  <b-table responsive 
                    stacked="md"
                    :items="eventos" 
                    :fields="fields"
                    :current-page="currentPage"
                    :per-page="perPage"> 
                    <template slot="status" slot-scope="row">
                      {{row.item.status == 0 ? 'Por Realizar' : row.item.status == 0 ? 'A Decorrer' : 'Concluido'}}
                    </template>
                    <template slot="actions" slot-scope="row">
                      <button type="button" class="btn btn-primary" v-on:click="viewEvent(row.item)">Ver detalhes</button>
                      <button type="button" class="btn btn-warning" v-on:click="editEvent(row.item)">Editar</button>
                      <button type="button" class="btn btn-danger" v-on:click="deleteEvent(row.item)">Eliminar</button>
                    </template>
                  </b-table>
                  <hr>
                  <b-pagination :total-rows="eventos.length" 
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
  props: ['eventos'],
  data: function () {
    return {
      fields: [
        { key: 'id', label:'#'},
        { key: 'name', label:'Nome'},
        { key: 'organizer', label:'Organizador'},
        { key: 'date', label:'Data'},
        { key: 'max_inscritos', label:'Lotação'},
        { key: 'total_interested', label:'Total de Inscritos'},
        { key: 'status', label:'Estado'},
        { key: 'actions', label:'Ações'},
        
      ],
      currentPage: 1,
      perPage: 10
    }
  },
  methods: {
    deleteEvent: function(event) {
      this.$emit('deleteEvent', event);
    },
    editEvent: function(event) {
      this.$emit('editEvent', event);
    },
    createEvent: function() {
      this.$emit('createEvent');
    },
    viewEvent: function(event) {
      this.$emit('viewEvent', event);
    }
  }
}
</script>