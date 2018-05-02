<template>
  <div class="col-md-8 offset-md-2">
    <span class="anchor" id="formUserEdit"></span>

    <!-- form user info -->
    <div class="card card-outline-secondary">
      <div class="card-header">
        <h3 class="mb-0">Criar Evento</h3>
      </div>
      <div class="card-body">
        <form class="form" role="form" autocomplete="off" v-on:submit.prevent="submitForm" enctype="multipart/form-data">
          <div class="form-group row">
            <label class="col-lg-3 col-form-label form-control-label">Nome do Evento</label>
            <div class="col-lg-9">
              <input class="form-control" type="text" v-model="name" required>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-3 col-form-label form-control-label">Localização</label>
            <div class="col-lg-9">
              <input class="form-control" type="text" v-model="localization" required>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-lg-3 col-form-label form-control-label">Data</label>
            <div class="col-lg-9">
              <datepicker v-model="date" input-class="form-control" required typeable></datepicker>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-lg-3 col-form-label form-control-label">Descrição</label>
            <div class="col-lg-9">
             <textarea class="form-control" v-model="description" rows="7" required ></textarea>
           </div>
         </div>
         <div class="form-group row">
          <label for="fileInput" class="col-sm-3 form-control-label">Imagem</label>
          <div class="col-sm-9" v-if="!image">
            <input id="fileInput" type="file" accept="image/x-png,image/gif,image/jpeg" class="form-control-file" v-on:change="onFileChange" required>
          </div>
          <div class="col-sm-9" v-if="image">
            <img :src="image" class="img-fluid" alt="Imagem do evento"/>
            <button class="btn btn-sm btn-danger mt-3 float-right" @click="removeImage"  type="button">Remover Imagem</button>
          </div>
        </div>

        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label"></label>
          <div class="col-lg-9">
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
      name:'',
      localization:'',
      description:'',
      date: new Date(),
      image: '',
      attemptSubmit: false,
      serverError: false,
      serverErrorMessage: '',
    }
  },
  components: {
    Datepicker
  },
  computed: {
    missingName: function () {
      return this.name.trim() === '' && !this.hasServerError && this.attemptSubmit;
    },
    missingLocalization: function () {
      return this.localization.trim() === '' && !this.hasServerError && this.attemptSubmit;
    },
    missingDescription: function () {
      return this.description.trim() === '' && !this.hasServerError && this.attemptSubmit;
    },
    hasClientError: function () {
      return (this.missingName || this.missingLocalization || this.missingDescription);
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
        var newDate = this.getDate();
        const data = {
          name: this.name,
          localization: this.localization,
          description: this.description,
          date: newDate,
          image: this.image,
        };


        axios.post('/api/events/create', data)
        .then((response) => {
          swal("Evento criado com sucesso.", {
            buttons: {
              ok: "Ok"
            },
          })
          .then((value) => {
            switch (value) {
              case "ok":
              window.location.href = '/admin/#/events'
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
          var month = this.date.getUTCMonth() + 1; //months from 1-12
          var day = this.date.getUTCDate();
          var year = this.date.getUTCFullYear();

          var newdate = new Date(year,month,day);
          newdate = newdate.toISOString().slice(0, 19).replace('T', ' ');

          newdate = this.formatDate(newdate);

          console.log(newdate);
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
              window.location.href = '/admin/#/events'
              break;
            }
          });
        },
        onFileChange(e) {
          var files = e.target.files || e.dataTransfer.files;
          if (!files.length)
            return;
          this.createImage(files[0]);
        },
        createImage(file) {
          var image = new Image();
          var reader = new FileReader();
          var vm = this;

          reader.onload = (e) => {
            vm.image = e.target.result;
          };
          reader.readAsDataURL(file);
        },
        removeImage: function (e) {
          this.image = '';

        }

      }
    }
    </script>
