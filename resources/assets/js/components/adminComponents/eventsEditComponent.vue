<template>
  <div class="col-md-8 offset-md-2">
    <span class="anchor" id="formUserEdit"></span>

    <!-- form user info -->
    <div class="card card-outline-secondary">
        <div class="card-header">
            <h3 class="mb-0">Editar Evento</h3>
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
                    <label class="col-lg-3 col-form-label form-control-label">Descrição</label>
                    <div class="col-lg-9">
                        <select class="custom-select" v-model="status">
                          <option value="0">Por Realizar</option>
                          <option value="1">A Decorrer</option>
                          <option value="2">Concluido</option>
                        </select>
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
    import swal from 'sweetalert';

    export default {
        data: function() {
            return {
                id: this.$route.params.id,
                name: '',
                localization: '',
                description: '',
                date: '',
                status: '',
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
            getEvento: function(id) {
                axios.get('/api/events/'+this.id)
                    .then((response) => {
                        this.name = response.data.name;
                        this.localization = response.data.localization;
                        this.description = response.data.description;
                        this.date = new Date(response.data.date);
                        this.status = response.data.status;
                    })
                    .catch((error) => {
                        this.serverError = true;
                        console.log(error);
                        this.serverErrorMessage = error.response.data.data;
                    });
            },
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
                    status: this.status
                    };

                    axios.post('/api/events/'+ this.id +'/update', data)
                    .then((response) => {
                        swal("Evento alterado com sucesso.", {
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
            }
        },
        mounted: function () {
            this.getEvento();
        }
    }
</script>