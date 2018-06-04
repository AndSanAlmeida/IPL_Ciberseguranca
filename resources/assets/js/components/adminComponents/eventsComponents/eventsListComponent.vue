<template>
  <section class="tables">   
    <div class="container-fluid">
      <div class="row">    
        
        <div class="col-lg-12">
          <router-link to="/events/create" class="btn btn-primary">Adicionar Evento</router-link>
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
                      <router-link role="button" :to="{ name: 'eventsDetails', params: {id: row.item.id } }" class="btn btn-primary">Ver detalhes</router-link>
                      <router-link role="button" :to="{ name: 'eventsEdit', params: {id: row.item.id } }" class="btn btn-warning">Editar</router-link>
                      <button type="button" class="btn btn-danger" v-on:click="deleteEvento(row.item)">Eliminar</button>
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
        { key: 'status', label:'Estado'},
        { key: 'actions', label:'Ações'},
      ],
      currentPage: 1,
      perPage: 10
    }
  },
  methods: {
    editEvento: function(id) {
      router.push("/events/edit/"+id);
    },
    deleteEvento: function(evento) {
      this.$emit('delete-click', evento);
    }
  }
}
</script>