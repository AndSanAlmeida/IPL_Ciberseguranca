<template>
  <div class="col-md-8 offset-md-2">
    <span class="anchor" id="formUserEdit"></span>

    <!-- form user info -->
    <div class="card card-outline-secondary">
      <div class="card-header">
        <h3 class="mb-0">Criar Newsletter</h3>
      </div>
      <div class="card-body">
        <form class="form" role="form" method="post" autocomplete="off" v-on:submit.prevent="submitForm" enctype="multipart/form-data">
          <div class="form-group row">
            <label class="col-lg-3 col-form-label form-control-label">Título</label>
            <div class="col-lg-9">
              <input class="form-control" type="text" v-model="title">
              <div class="clearfix mt-2">
                <b-alert class="col-md-12" show variant="danger" v-cloak v-show="isFormInvalid && missingTitle ">Preencher título</b-alert>
                <b-alert class="col-md-12" show variant="danger" v-cloak v-show="isFormInvalid && invalidSizeTitle ">Título demasiado longo (Max: 100)</b-alert>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-3 col-form-label form-control-label">Data</label>
            <div class="col-lg-9">
              <datepicker v-model="date" input-class="form-control" required></datepicker>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-3 col-form-label form-control-label">Description</label>
            <div class="col-sm-9">
              <quill-editor v-model="description" 
                ref="myQuillEditor"
                :options="editorOption"
                required>
              </quill-editor>
              <div class="clearfix mt-2">
                <b-alert class="col-md-12" show variant="danger" v-cloak v-show="isFormInvalid && missingDescription ">Preencher descrição</b-alert>
              </div>
            </div>
            
          </div>
          <div  v-if="!loading && hasNews" class="form-group row">
            <label class="col-lg-3 col-form-label form-control-label">Notícias em destaque</label>
            <div class="col-lg-9">
              <b-table responsive 
              id = "tableNews" 
              :items="news" 
              :fields="fields"
              :current-page="currentPage"
              :per-page="perPage"> 
              <template slot="title" slot-scope="row">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" :value="row.item.title" v-model="newsSelected">
                  <label class="form-check-label">
                    <span v-html="row.item.title[0]"></span>
                  </label>
                </div>
              </template>
              
            </b-table>
            <b-pagination :total-rows="news.length" 
                v-if="!loading  && hasNews"
                :per-page="perPage" 
                v-model="currentPage"
                align="center"/> 
            </div>
            <div v-if="!loading && !hasNews">
              <div class="alert alert-warning" role="alert">
                Não foram encontradas notícias.
              </div>
            </div> 
        </div>

        <div  v-if="!loading && !hasNews" class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Notícias em destaque</label>
          <div class="col-lg-9">
            <div class="clearfix mt-2">
              <b-alert class="col-md-12" show variant="warning" v-cloak>Não existe notícias disponíveis.</b-alert>
            </div>
          </div>
        </div>
        <div v-if="loading" class="loader mt-4"></div> 

        <hr>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label"></label>
          <div class="col-lg-9 text-right">
            <input class="btn btn-secondary" value="Cancelar" type="button" v-on:click="cancel">
            <input class="btn btn-primary" type="submit" value="Confirmar">
          </div>
        </div>
      </form>
    </div>
  </div>
  <!-- /form user info -->
</div>
<!--/col-->
</template>
<script type="text/javascript">

import Datepicker from 'vuejs-datepicker';
import 'quill/dist/quill.snow.css';
import { quillEditor } from 'vue-quill-editor';

export default {
  data: function() {
    return {
      title: '',
      description: '',
      date: new Date(),
      newsSelected: [],
      news: [],

      // config table
      fields: [
        { key: 'title', label:'Título'},
      ],
      currentPage: 1,
      perPage: 30,

      // Quill editor config
      editorOption: {
          theme: 'snow',
          modules: {
              toolbar: this.toolbarSettings()
          }
      },

      loading: true,
      attemptSubmit: false,
      errorLoading: false,
      serverError: false,
      serverErrorMessage: '',
    }
  },
  components: {
    Datepicker,
    quillEditor
  },
  computed: {
    hasNews: function () {
      return this.news.length != 0;
    },
    missingTitle: function () {
      return this.title.trim() === '' && !this.hasServerError && this.attemptSubmit;
    },
    invalidSizeTitle: function () {
      return this.title.trim().length > 100 && !this.hasServerError && this.attemptSubmit;
    },
    missingDescription: function () {
      return this.description.trim() === '' && !this.hasServerError && this.attemptSubmit;
    },
    hasClientError: function () {
      return (this.missingTitle || this.invalidSizeTitle || this.missingDescription);
    },
    hasServerError: function () {
      return this.serverError;
    },
    isFormInvalid: function () {
      return (this.hasClientError || this.hasServerError) && this.attemptSubmit;
    },
    

  },
  
  methods: {
    toolbarSettings: function() {
        return [
          ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
          ['blockquote', 'code-block'],
          [{ 'list': 'ordered'}, { 'list': 'bullet' }],
          [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
          [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
          [{ 'direction': 'rtl' }],                         // text direction
          [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
          ['clean']                                         // remove formatting button
        ];
    },
    exit: function() {
      this.$emit('exit');
    },
    getDate:function() {
      var month = this.date.getUTCMonth() + 1; //months from 1-12
      var day = this.date.getUTCDate();
      var year = this.date.getUTCFullYear();
      var newdate = new Date(year,month,day);

      newdate = newdate.toISOString().slice(0, 19).replace('T', ' ');
      newdate = this.formatDate(newdate);

      return newdate;
    },

    formatDate: function(date) {
      var d = new Date(date),
      month = '' + d.getMonth(),
      day = '' + (d.getDate()+1),
      year = d.getFullYear();

      if (month.length < 2) month = '0' + month;
      if (day.length < 2) day = '0' + day;

      return [year, month, day].join('-');
    },
    submitForm: function (event) {
      this.serverError = false;
      this.attemptSubmit = true;
      if (!this.isFormInvalid) {
        var newDate = this.getDate();
        const data = {
          title: this.title,
          description: this.description,
          date: newDate,
          news: this.newsSelected,
        };

        axios.post('/api/newsletters/create', data)
        .then((response) => {
          swal("Newsletter adicionada com sucesso.", {
            icon: 'success',
            buttons: {
              ok: "Ok"
            },
          });
          this.exit();

        })
        .catch((error) => {
          this.serverError = true;
          console.log(error);
          this.serverErrorMessage = error.response.data.data;
        });
      }
    },
    getDBNews: function() {
        axios.get('/api/news')
            .then((response) => {
                for (var j = 0; j < response.data.data.length; j++) {
                    var singleNews = response.data.data[j];
                    var newsObject = {title: {}, description: {}, pubDate: {}, link: {}}
                    
                    newsObject.title[0] = singleNews.title;
                    newsObject.description[0] = singleNews.description;
                    newsObject.pubDate[0] = singleNews.pub_date;
                    newsObject.link[0] = singleNews.source;
                    if (newsObject.title[0] != '' && newsObject.title[0] != null) {
                      this.news = this.news.concat(newsObject);
                    }
                    
                }
                this.news.sort(function(a,b){
                  var c = new Date(a.pubDate[0]);
                  var d = new Date(b.pubDate[0]);
                  return d-c;
                });
                this.loading = false;
                this.errorLoading = false;
                
            })
            .catch((error) => {
                this.errorLoading = true;
                this.loading = false;
            });
    },
    orderNews: function() {
        
    },
    cancel: function() {
      swal("Deseja realmente sair?", {
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
            this.exit();
            break;
        }
      });
    },
  },
  created: function() {
    this.getDBNews();
  },
}
</script>
<style type="text/css" media="screen">
  #tableNews>thead{
    display: none;
  }
  .ql-toolbar.ql-snow + .ql-container.ql-snow {
    min-height: 200px;
  }
</style>
