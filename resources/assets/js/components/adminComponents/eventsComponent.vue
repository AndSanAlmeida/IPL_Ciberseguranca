<template>
	<div>
		<header class="page-header">
		  <div class="container-fluid">
		    <h2 class="no-margin-bottom">Eventos</h2>
		  </div>
		</header>

		<eventsList :eventos="eventos"></eventsList>

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
        },
        components: {
            'eventsList': EventsList,
        },
        mounted() {
            this.getEvents();
        }
    }
</script>