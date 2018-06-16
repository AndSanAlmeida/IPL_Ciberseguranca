<template>
	<div>
		<header class="page-header">
		  <div class="container-fluid">
		    <h2 class="no-margin-bottom">{{title}}</h2>
		  </div>
		</header>
        
        <!-- ERRORS -->
        <div class="alert alert-warning" role="alert" v-if="!hasItems && canShowContent && showList && !showCreate">
            <p>Não foram encontrados {{title}}.</p>
            <hr>
            <p class="mb-0"><a href="javascript:;" class="alert-link" title="Criar Entrada" v-on:click="createEvent()">Criar {{title}}</a></p>
        </div>

        <div class="alert alert-danger" role="alert" v-if="errorLoading">
            <p>Erro ao pesquisar os dados tente novamente.</p>
        </div>

        <!-- LOADING -->
        <div v-if="loading" class="loader mt-3"></div>
        
        <!-- ============ -->

		<eventsList 
			v-if="hasItems && canShowContent && showList"
			:eventos="eventos" 
			@exit="exit"
			@createEvent="createEvent"
			@viewEvent="viewEvent"
			@editEvent="editEvent"
			@deleteEvent="deleteEvent">
		</eventsList>

		<eventCreate
			v-if="showCreate"
			@exit="exit">
		</eventCreate> 

		<eventEdit
			:item="item"
			v-if="showEdit"
			@exit="exit">
		</eventEdit>

		<eventView
			:item="item"
			v-if="showView"
			@exit="exit">
		</eventView>

	</div>
</template>

<script type="text/javascript">
    import EventsList from './eventsListComponent.vue';
    import EventsCreate from './eventsCreateComponent.vue';
    import EventsEdit from './eventsEditComponent.vue';
    import EventsView from './eventsDetailsComponent.vue';
    import swal from 'sweetalert';

    export default {
        data: function () {
            return {
            	title: 'Eventos',
                eventos: [],
                loading: true,
                showList: true,
                showCreate: false,
                showView:false,
                showEdit: false,
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
        	exit: function(){
        		this.showList = true;
                this.showCreate = false;
                this.showEdit = false;
                this.showView = false;
                this.getEvents();
        	},
        	createEvent: function() {
        		this.showList = false;
                this.showCreate = true;
                this.showEdit = false;
                this.showView = false;
        	},
        	viewEvent: function(item) {
        		this.item = item;
        		this.showList = false;
                this.showCreate = false;
                this.showEdit = false;
                this.showView = true;
        	},
        	editEvent: function(item) {
        		this.item = item;
        		this.showList = false;
                this.showCreate = false;
                this.showEdit = true;
                this.showView = false;
        	},
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
		      swal("Pretende realmente apagar o evento?", {
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
		                                	break;
		                            }
		                        });
                                this.getEvents();
		                  })
		                  .catch((error) => {
                            this.loading = false;
                            this.errorLoading = true;
		                  });                  
		                  break;
		          }
		      });
		    }
        },
        components: {
            'eventsList': EventsList,
            'eventCreate': EventsCreate,
            'eventEdit': EventsEdit, 
            'eventView': EventsView,
        },
        mounted() {
            this.getEvents();
        }
    }
</script>