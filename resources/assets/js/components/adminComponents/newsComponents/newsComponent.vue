<template>
	<div>
		<header class="page-header">
		  <div class="container-fluid">
		    <h2 class="no-margin-bottom">Notícias</h2>
		  </div>
		</header>

		<newsList :news="news" @delete-click="deleteNews"></newsList>

	</div>
</template>

<script type="text/javascript">
    import NewsList from './newsListComponent.vue';
    import swal from 'sweetalert';

    export default {
        data: function () {
            return {
                news: [],
                showSuccess: false,
                successMessage: '',
                loading: true,
                errorLoading: false,
            }
        },
        methods: {
            getNews: function () {
                this.loading = true;
                this.errorLoading = false;
                
                axios.get('/api/news')
                    .then(response => {
                        this.news = response.data.data;
                        this.loading = false;
                    }).catch((error) => {
                    this.loading = false;
                    this.errorLoading = true;
                });
            },
            deleteNews : function(news){
		      swal("Pertende realmente apagar esta notícia?", {
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
		                axios.delete('/api/news/'+news.id+'/delete')
		                  .then((response) => {
		                    swal("Notícia apagada com sucesso.", {
		                    	icon: "success",
		                            buttons: {
		                                ok: "Ok"
		                            },
		                        })
		                        .then((value) => {
		                            switch (value) {
		                                case "ok":
		                                	this.getNews();
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
            'newsList': NewsList,
        },
        mounted() {
            this.getNews();
        }
    }
</script>