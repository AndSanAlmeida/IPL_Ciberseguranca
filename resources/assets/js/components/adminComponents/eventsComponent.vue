<template>
	<div>
		<header class="page-header">
		  <div class="container-fluid">
		    <h2 class="no-margin-bottom">Eventos</h2>
		  </div>
		</header>

		<eventsList :eventos="eventos" @delete-click="deleteEvent"></eventsList>

	</div>
</template>

<script type="text/javascript">
    import EventsList from './eventsListComponent.vue';
    import swal from 'sweetalert';

    export default {
        data: function () {
            return {
                eventos: [],
                showSuccess: false,
                successMessage: '',
                loading: true,
                errorLoading: false,
            }
        },
        methods: {
            getEvents: function () {
                this.loading = true;
                this.errorLoading = false;
                
                axios.get('/api/events')
                    .then(response => {
                        this.eventos = response.data.data;
                        this.loading = false;
                    }).catch((error) => {
                    this.loading = false;
                    this.errorLoading = true;
                });
            },
            deleteEvent : function(evento){
		      swal("Pertende realmente apagar o evento?", {
		          icon: "warning",
		          buttons: {
		              no: "Não",
		              yes: "Sim",
		          },
		      })
		      .then((value) => {
		          switch (value) {
		              case "no":
		                break;
		           
		              case "yes":
		                axios.delete('/api/event/'+evento.id+'/delete')
		                  .then((response) => {
		                    swal("Evento apagado com sucesso.", {
		                            buttons: {
		                                ok: "Ok"
		                            },
		                        })
		                        .then((value) => {
		                            switch (value) {
		                                case "ok":
		                                	this.getEvents();
		                                	break;
		                            }
		                        });
		                  })
		                  .catch((error) => {

		                  });                  
		                  break;
		          }
		      });
		    }
        },
        components: {
            'eventsList': EventsList,
        },
        mounted() {
            this.getEvents();
        }
    }
</script>