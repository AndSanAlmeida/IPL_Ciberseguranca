<template>
  <div class="col-md-8 offset-md-2">
    <span class="anchor" id="formUserEdit"></span>

    <!-- form user info -->
    <div class="card card-outline-secondary">
      <div class="card-header">
        <h3 class="mb-0">Criar Entrada do Glossário</h3>
      </div>
      <div class="card-body">
        <form class="form" role="form" autocomplete="off" v-on:submit.prevent="submitForm" enctype="multipart/form-data">
          <div class="form-group row">
            <label class="col-lg-3 col-form-label form-control-label">Nome da Entrada</label>
            <div class="col-lg-9">
              <input class="form-control" type="text" v-model="name" required>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-3 col-form-label form-control-label">Definição</label>
            <div class="col-lg-9">
             <textarea class="form-control" v-model="definition" rows="7" required ></textarea>
           </div>
         </div>
         <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Fonte</label>
          <div class="col-lg-9">
           <textarea class="form-control" v-model="source" rows="7" required ></textarea>
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
      name:'',
      definition: '',
      source:'',
    }
  },
  components: {
  },
  computed: {
    missingName: function () {
      return this.name.trim() === '' && !this.hasServerError && this.attemptSubmit;
    },
    missiingDefinition: function() {
      return this.definition.trim() === '' && !this.hasServerError && this.attemptSubmit;
    },
    missingSource: function () {
      return this.source.trim() === '' && !this.hasServerError && this.attemptSubmit;
    },
    hasClientError: function () {
      return (this.missingName || this.missiingDefinition || this.missingSource);
    },
    hasServerError: function () {
      return this.serverError;
    },
    isFormInvalid: function () {
      return (this.hasClientError || this.hasServerError) && this.attemptSubmit;
    },

  },

  methods: {
    exit: function() {
        this.$emit('exit');
    },
    submitForm: function (event) {
      this.serverError = false;
      this.attemptSubmit = true;
      if (!this.isFormInvalid) {
        const data = {
          name: this.name,
          definition: this.definition,
          source: this.source,
        };


        axios.post('/api/glossary/create', data)
        .then((response) => {
          swal("Entrada do glossário criada com sucesso.", {
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


  }
}
</script>
