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
                  <p class="text-center" v-if="eventos.length == 0" >Não há eventos disponíveis.</p>
                  <table class="table table-striped table-hover" v-if="eventos.length != 0" >
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Orgazinador</th>
                        <th>Data</th>
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
                        <td>{{evento.status == 0 ? 'Por Realizar' : evento.status == 0 ? 'A Decorrer' : 'Concluido'}}</td>
                        <td>
                          <div class="btn-group btn-group-sm" role="group" aria-label="Ações">
                            <router-link :to="{ name: 'eventsDetails', params: {id: evento.id } }" class="btn btn-primary">Ver detalhes</router-link>
                            <router-link :to="{ name: 'eventsEdit', params: {id: evento.id } }" class="btn btn-warning">Editar</router-link>
                            <button type="button" class="btn btn-danger" v-on:click="deleteEvento(evento)">Eliminar</button>
                          </div>
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
    editEvento: function(id) {
      router.push("/events/edit/"+id);
    },
    deleteEvento: function(evento) {
      this.$emit('delete-click', evento);
    }
  }
}
</script>