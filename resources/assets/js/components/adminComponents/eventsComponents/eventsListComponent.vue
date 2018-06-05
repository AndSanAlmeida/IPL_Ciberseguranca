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
                  <p class="text-center" v-if="eventos.length == 0" >Não há eventos disponíveis.</p>
                  <table class="table table-striped table-hover" v-if="eventos.length != 0" >
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Orgazinador</th>
                        <th>Data</th>
                        <th>Lotação</th>
                        <th>Estado</th>
                        <th>Ações</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="evento in eventos"  :key="evento.id">
                        <td>{{evento.id}}</td>
                        <td>{{evento.name}}</td>
                        <td>{{evento.organizer}}</td>
                        <td>{{evento.date}}</td>
                        <td>{{evento.max_inscritos}}</td>
                        <td>{{evento.status == 0 ? 'Por Realizar' : evento.status == 0 ? 'A Decorrer' : 'Concluido'}}</td>
                        <td>
                            <button type="button" class="btn btn-primary" v-on:click="viewEvent(evento)">Ver detalhes</button>
                            <button type="button" class="btn btn-warning" v-on:click="editEvent(evento)">Editar</button>
                            <button type="button" class="btn btn-danger" v-on:click="deleteEvent(evento)">Eliminar</button>
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
  props: ['eventos'],
  computed: {

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