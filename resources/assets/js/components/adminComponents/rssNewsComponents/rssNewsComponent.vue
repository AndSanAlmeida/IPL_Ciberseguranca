<template>
	<div>
		<header class="page-header">
		  <div class="container-fluid">
		    <h2 class="no-margin-bottom">RSS de Notícias</h2>
		  </div>
		</header>

		<rssNewsList 
			:rssNews="rssNews" 
			v-if="showList"
			@addRSSNews="addRSSNews"
			@editRssNews="editRssNews"
			@getRSSNews="getRSSNews"
			@deleteRSSNews="deleteRSSNews">
		</rssNewsList>

		<rssNewsCreate
			v-if="showCreate"
			@exit="exit">
		</rssNewsCreate> 

		<rssNewsEdit
			:rss="rss" 
			v-if="showEdit"
			@exit="exit">
		</rssNewsEdit> 
	</div>
</template>

<script type="text/javascript">
    import RssNewsList from './rssNewsListComponent.vue';
    import RssNewsCreate from './rssNewsCreateComponent.vue';
    import RssNewsEdit from './rssNewsEditComponent.vue';
    
    import swal from 'sweetalert';

    export default {
        data: function () {
            return {
            	rss: '',
                rssNews: [],
                showList: true,
                showCreate: false,
                showEdit: false,
                showSuccess: false,
                successMessage: '',
                loading: true,
                errorLoading: false,
            }
        },
        methods: {
        	addRSSNews: function() {
        		this.showList = false;
                this.showCreate = true;
                this.showEdit = false;
        	},
        	editRssNews: function(rss) {
        		this.rss = rss;
        		this.showList = false;
                this.showCreate = false;
                this.showEdit = true;
        	},
        	getRSSNews: function() {
        		this.loading = true;
                this.errorLoading = false;
                
                axios.get('/api/rssNews')
                    .then(response => {
                        this.rssNews = response.data.data;
                        this.loading = false;
                    }).catch((error) => {
                    	this.loading = false;
                    	this.errorLoading = true;
                	});
        	},
        	exit: function(){
        		this.showList = true;
                this.showCreate = false;
                this.showEdit = false;
               	this.getRSSNews();
        	},
        	deleteRSSNews: function(rss) {
        		swal("Pertende realmente apagar este RSS?", {
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
		                axios.delete('/api/rssNews/'+rss.id+'/delete')
		                  .then((response) => {
		                    swal("RSS apagado com sucesso.", {
		                    	icon: "success",
		                            buttons: {
		                                ok: "Ok"
		                            },
		                        })
		                        .then((value) => {
		                            switch (value) {
		                                case "ok":
		                                	this.getRSSNews();
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
            'rssNewsList': RssNewsList,
            'rssNewsCreate': RssNewsCreate,
            'rssNewsEdit': RssNewsEdit,
        },
        created: function() {
        	this.getRSSNews();
        }
    }
</script>