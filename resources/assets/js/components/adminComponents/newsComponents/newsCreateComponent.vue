<template>
  <div class="col-md-8 offset-md-2">
    <span class="anchor" id="formUserEdit"></span>

    <div class="card card-outline-secondary">
      <div class="card-header">
        <h3 class="mb-0">Criar Notícia</h3>
      </div>
      <div class="card-body">
        <form class="form" role="form" autocomplete="off" v-on:submit.prevent="submitForm" enctype="multipart/form-data">
          <div class="form-group row">
            <label class="col-lg-3 col-form-label form-control-label">Título</label>
            <div class="col-lg-9">
              <input class="form-control" type="text" v-model="title">
              <div class="clearfix mt-2">
                <b-alert class="col-md-12" show variant="danger" v-cloak v-show="isFormInvalid && missingTitle ">Preencher título</b-alert>
                <b-alert class="col-md-12" show variant="danger" v-cloak v-show="isFormInvalid && hasInvalidCharsTitle ">Título contém símbolos inválidas</b-alert>
                <b-alert class="col-md-12" show variant="danger" v-cloak v-show="isFormInvalid && invalidSizeTitle ">Título demasiado longo (Max: 100)</b-alert>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-3 col-form-label form-control-label">Data</label>
            <div class="col-lg-9">
              <datepicker v-model="pubDate" input-class="form-control" required></datepicker>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-3 col-form-label form-control-label">Descrição</label>
            <div class="col-lg-9">
              <quill-editor v-model="description"
                ref="myQuillEditor"
                :options="editorOption">
              </quill-editor>
              <div class="clearfix mt-2">
                <b-alert class="col-md-12" show variant="danger" v-cloak v-show="isFormInvalid && missingDescription ">Preencher descrição</b-alert>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-3 col-form-label form-control-label">Fonte</label>
            <div class="col-lg-9">
              <input class="form-control" type="text" v-model="source">
              <div class="clearfix mt-2">
                <b-alert class="col-md-12" show variant="danger" v-cloak v-show="isFormInvalid && missingSource ">Preencher fonte</b-alert>
                <b-alert class="col-md-12" show variant="danger" v-cloak v-show="isFormInvalid && invalidSizeSource ">Fonte demasiado longa (Max: 200)</b-alert>
              </div>
            </div>
          </div>
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
</div>
</template>
<script type="text/javascript">
import 'quill/dist/quill.snow.css';
import { quillEditor } from 'vue-quill-editor';
import Datepicker from 'vuejs-datepicker';
export default {
  data: function() {
    return {
      title:'',
      description: '',
      pubDate: new Date(),
      source: '',
      editorOption: {
          theme: 'snow',
          modules: {
              toolbar: this.toolbarSettings()
          }
      },
      attemptSubmit: false,
      errorLoading: false,
      serverError: false,
      serverErrorMessage: '',
    }
  },
  components: {
    quillEditor,
    Datepicker
  },
  computed: {
    missingTitle: function () {
      return this.title.trim() === '' && !this.hasServerError && this.attemptSubmit;
    },
    hasInvalidCharsTitle: function() {
      if (this.title.indexOf(';') > -1) {
        return true;
      }
      if (this.title.indexOf('/') > -1) {
        return true;
      }
      if (this.title.indexOf('?') > -1) {
        return true;
      }
      if (this.title.indexOf(':') > -1) {
        return true;
      }
      if (this.title.indexOf('@') > -1) {
        return true;
      }
      if (this.title.indexOf('=') > -1) {
        return true;
      }
      if (this.title.indexOf('&') > -1) {
        return true;
      }
      return false;
    },
    invalidSizeTitle: function () {
      return this.title.trim().length > 100 && !this.hasServerError && this.attemptSubmit;
    },
    missingDescription: function () {
      return this.description.trim() === '' && !this.hasServerError && this.attemptSubmit;
    },
    missingSource: function () {
      return this.source.trim() === '' && !this.hasServerError && this.attemptSubmit;
    },
    missingSource: function () {
      return this.source.trim() === '' && !this.hasServerError && this.attemptSubmit;
    },
    invalidSizeSource: function () {
      return this.source.trim().length > 100 && !this.hasServerError && this.attemptSubmit;
    },
    hasClientError: function () {
      return (this.missingTitle || this.hasInvalidCharsTitle || this.invalidSizeTitle || this.missingDescription || this.missingSource || this.invalidSizeSource);
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
    submitForm: function (event) {
      this.serverError = false;
      this.attemptSubmit = true;
      if (this.isFormInvalid == false) {
        var newDate = this.getDate();
          
        const data = {
          title: this.title,
          description: this.description,
          source: this.source,
          pubDate: newDate,
        };

        axios.post('/api/news/create', data)
        .then((response) => {
          swal("Notícia criada com sucesso.", {
            icon: 'success',
            buttons: {
              ok: "Ok"
            },
          })
          .then((value) => {
            switch (value) {
              case "ok":
              this.exit();
              break;
            }
          });
        })
        .catch((error) => {
          this.serverError = true;
          console.log(error);
          this.serverErrorMessage = error.response.data.data;
        });
      }
    },
    getDate:function() {
      var month = this.pubDate.getUTCMonth() + 1; //months from 1-12
      var day = this.pubDate.getUTCDate();
      var year = this.pubDate.getUTCFullYear();

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
    exit: function() {
      this.$emit('exit');
    }


  }
}
</script>
<style type="text/css" media="screen">
    .ql-toolbar.ql-snow + .ql-container.ql-snow {
        min-height: 200px;
    }
</style>