<template>
	<div>
		<header class="page-header">
		  <div class="container-fluid">
		    <h2 class="no-margin-bottom">{{title}}</h2>
		  </div>
		</header>
        
        <!-- ERRORS -->
        <div class="alert alert-warning" role="alert" v-if="!hasItems && canShowContent">
            <p>Não foram encontrados {{title}}.</p>
        </div>

        <div class="alert alert-danger" role="alert" v-if="errorLoading">
            <p>Erro ao pesquisar os dados tente novamente.</p>
        </div>

        <!-- LOADING -->
        <div class="col-md-12">
            <h1 class="m-5 text-center" v-if="loading">A carregar...</h1>
        </div>
        
        <!-- ============ -->

		<eventsList 
			v-if="hasItems && canShowContent" 
			:eventos="eventos" 
			@delete-click="deleteEvent">
		</eventsList>

	</div>
</template>

<script type="text/javascript">
    import EventsList from './eventsListComponent.vue';
    import swal from 'sweetalert';

    export default {
        data: function () {
            return {
            	title: 'Eventos',
                eventos: [],
                loading: true,
                errorLoading: false,
            }
        },
        computed: {
            hasItems: function () {
                return this.eventos.length > 0;
            },
            canShowContent: function () {
                return !this.errorLoading && !this.loading;
            },
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
		              no: {
		              	text: "Não",
		              	className: "btn-light",
		              },
		              yes: {
		              	text: "Sim",
		              	className: "btn-info",
		              },
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
		                    	icon: "success",
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