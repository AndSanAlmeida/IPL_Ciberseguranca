<template>
	<div>
		<header class="page-header">
		  <div class="container-fluid">
		    <h2 class="no-margin-bottom">Notícias</h2>
		  </div>
		</header>

		<button v-on:click="getRSS">rss</button>

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
        	getRSS:function () {
        		axios.get('https://www.cncs.gov.pt/recursos/noticias/feed-rss/index.xml')
                    .then(response => {
                        $('item', response.data).each(function(){
                     	title = $('title', this).text();
                     	link = $('link', this).text();
                     	description = $('description', this).text();
                    }).catch((error) => {
                    this.loading = false;
                    this.errorLoading = true;
                });

                    //Here you can do anything you want with those temporary
                    //variables, e.g. put them in some place in your html document
                    //or store them in an associative array
                })
        	},/*
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
		    }*/
        },
        components: {
            'newsList': NewsList,
        },
    }
</script>