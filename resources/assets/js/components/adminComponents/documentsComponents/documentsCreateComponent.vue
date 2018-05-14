<template>
  <div class="col-md-8 offset-md-2">
    <span class="anchor" id="formUserEdit"></span>

    <!-- form user info -->
    <div class="card card-outline-secondary">
      <div class="card-header">
        <h3 class="mb-0">Criar Documento</h3>
      </div>
      <div class="card-body">
        <form class="form" role="form" method="post" autocomplete="off" v-on:submit.prevent="submitForm" enctype="multipart/form-data">
          <div class="form-group row">
            <label class="col-lg-3 col-form-label form-control-label">Descrição</label>
            <div class="col-lg-9">
              <input class="form-control" type="text" v-model="description" required>
            </div>
          </div>
         <div class="form-group row">
          <label for="fileInput" class="col-sm-3 form-control-label">Ficheiro</label>
          <div class="col-sm-9">
            <input id="fileInput" type="file" accept=".pdf" class="form-control-file" v-on:change="onFileChange" required>
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
  <!-- /form user info -->
</div>
<!--/col-->
</template>
<script type="text/javascript">

import Datepicker from 'vuejs-datepicker';

export default {
  data: function() {
    return {
      description:'',
      file: '',
      fileName: '',
      attemptSubmit: false,
      serverError: false,
      serverErrorMessage: '',
    }
  },
  components: {
  },
  computed: {
    missingDescription: function () {
      return this.description.trim() === '' && !this.hasServerError && this.attemptSubmit;
    },
    hasClientError: function () {
      return (this.missingDescription);
    },
    hasServerError: function () {
      return this.serverError;
    },
    isFormInvalid: function () {
      return (this.hasClientError || this.hasServerError) && this.attemptSubmit;
    },

  },

  methods: {
    submitForm: function (event) {
      this.serverError = false;
      this.attemptSubmit = true;
      if (!this.isFormInvalid) {
        const data = {
          description: this.description,
          file: this.file,
        };

          console.log(data.file);
        axios.post('/api/documents/create', data)
        .then((response) => {
          console.log(response);
          swal("Documento adicionado com sucesso.", {
            icon: 'success',
            buttons: {
              ok: "Ok"
            },
          })
          .then((value) => {
            switch (value) {
              case "ok":
              window.location.href = '/admin/#/documents'
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
              window.location.href = '/admin/#/documents'
              break;
            }
          });
        },
        onFileChange(e) {
          var file1 = e.target.files[0];
          var reader = new FileReader();
          var vm = this;

          reader.onload = (e) => {
            vm.file = e.target.result;
          };
          reader.readAsDataURL(file1);
          console.log(this.file);
    
        },
      }
    }
    </script>
