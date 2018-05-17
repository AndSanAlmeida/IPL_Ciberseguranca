<template>
  <div class="col-md-8 offset-md-2">
    <span class="anchor" id="formUserEdit"></span>

    <!-- form user info -->
    <div class="card card-outline-secondary">
      <div class="card-header">
        <h3 class="mb-0">Criar FAQ</h3>
      </div>
      <div class="card-body">
        <form class="form" role="form" autocomplete="off" v-on:submit.prevent="submitForm" enctype="multipart/form-data">
          <div class="form-group row">
            <label class="col-lg-3 col-form-label form-control-label">Questão</label>
            <div class="col-lg-9">
              <input class="form-control" type="text" v-model="question" required>
            </div>
          </div>
          <div class="clearfix">
              <div class="alert alert-danger" role="alert" v-cloak v-show="isFormInvalid && missingQuestion ">
                  <p v-if="missingQuestion">Preencher questão</p>
              </div>
          </div>
         <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Resposta</label>
          <div class="col-lg-9">
              <input class="form-control" type="text" v-model="answer" required>
         </div>
       </div>
       <div class="clearfix">
            <div class="alert alert-danger" role="alert" v-cloak v-show="isFormInvalid && missingAnswer ">
                <p v-if="missingAnswer">Preencher Link</p>
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
      question:'',
      answer: '',
    }
  },
  components: {
  },
  computed: {
    missingQuestion: function () {
      return this.question.trim() === '' && !this.hasServerError && this.attemptSubmit;
    },
    missingAnswer: function () {
      return this.answer.trim() === '' && !this.hasServerError && this.attemptSubmit;
    },
    hasClientError: function () {
      return (this.missingQuestion || this.missingAnswer);
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
          question: this.question,
          answer: this.answer,
        };

        axios.post('/api/faqs/create/clean', data)
        .then((response) => {
          swal("FAQ criada com sucesso.", {
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
