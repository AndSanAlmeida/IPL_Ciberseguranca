<template>
  <div class="col-md-8 offset-md-2">
                    <span class="anchor" id="formUserEdit"></span>

                    <!-- form user info -->
                    <div class="card card-outline-secondary">
                        <div class="card-header">
                            <h3 class="mb-0">Criar Evento</h3>
                        </div>
                        <div class="card-body">
                            <form class="form" role="form" autocomplete="off" v-on:submit.prevent="submitForm">
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
                                    <label class="col-lg-3 col-form-label form-control-label"></label>
                                    <div class="col-lg-9">
                                        <input type="reset" class="btn btn-secondary" value="Cancelar">
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
        missingDate: function () {
            return this.username.trim() === '' && !this.hasServerError && this.attemptSubmit;
        },
        missingDescription: function () {
            return this.description.trim() === '' && !this.hasServerError && this.attemptSubmit;
        },
        hasClientError: function () {
            return (this.missingUsername || this.missingPassword);
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
              var newDate = getDate();
                const data = {
                    name: this.name,
                    localization: this.localization,
                    description: this.description,
                    date: newDate,
                };
                
                /*
                axios.post('/api/events/create', data)
                .then((response) => {
                    
                    
                })
                .catch((error) => {
                    this.serverError = true;
                    console.log(error);
                    this.serverErrorMessage = error.response.data.data;
                });*/
            }
        },
        getDate:function() {
          var month = this.date.getUTCMonth() + 1; //months from 1-12
          var day = this.date.getUTCDate();
          var year = this.date.getUTCFullYear();

          newdate = year + "-" + month + "-" + day;
          return newdate;
        }
  }
}
</script>