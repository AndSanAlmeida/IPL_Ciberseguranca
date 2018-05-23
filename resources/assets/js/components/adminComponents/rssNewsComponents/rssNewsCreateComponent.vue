<template>
  <div class="col-md-8 offset-md-2">
    <span class="anchor" id="formUserEdit"></span>

    <!-- form user info -->
    <div class="card card-outline-secondary">
      <div class="card-header">
        <h3 class="mb-0">Adicionar RSS de Notícias</h3>
      </div>
      <div class="card-body">
        <form class="form" role="form" autocomplete="off" v-on:submit.prevent="submitForm" enctype="multipart/form-data">
          <div class="form-group row">
            <label class="col-lg-3 col-form-label form-control-label">Descrição</label>
            <div class="col-lg-9">
              <input class="form-control" type="text" v-model="website" required>
            </div>
          </div>
          <div class="clearfix">
              <div class="alert alert-danger" role="alert" v-cloak v-show="isFormInvalid && missingDescription ">
                  <p v-if="missingDescription">Preencher descrição</p>
              </div>
          </div>
         <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">URL</label>
          <div class="col-lg-9">
              <input class="form-control" type="url" v-model="url" required>
         </div>
       </div>
       <div class="clearfix">
            <div class="alert alert-danger" role="alert" v-cloak v-show="isFormInvalid && missingLink ">
                <p v-if="missingLink">Preencher url</p>
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

export default {
  data: function() {
    return {
      website:'',
      url: '',
    }
  },
  components: {
  },
  computed: {
    missingDescription: function () {
      return this.website.trim() === '' && !this.hasServerError && this.attemptSubmit;
    },
    missingLink: function () {
      return this.url.trim() === '' && !this.hasServerError && this.attemptSubmit;
    },
    hasClientError: function () {
      return (this.missingDescription || this.missingLink);
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
          website: this.website,
          url: this.url,
        };


        axios.post('/api/rssNews/create', data)
        .then((response) => {
          swal("RSS de notícias adicionado com sucesso.", {
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
