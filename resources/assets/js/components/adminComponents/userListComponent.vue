<template>
  <section class="tables">   
      <div class="container-fluid">
        <div class="row">    
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header d-flex align-items-center">
                <h3 class="h4">Lista de Utilizadores</h3>
              </div>
              <div class="card-body">
                <div class="table-responsive">                       
                  <table class="table table-striped table-hover">
                    <thead>
                      <tr>
                        <th>Nome Completo</th>
                        <th>Email</th>
                        <th>Username</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="user in users"  :key="user.id">
                        <td>{{user.name}}</td>
                        <td>{{user.email}}</td>
                        <td>{{user.username}}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </section>
</template>
<script type="text/javascript">
  module.exports={
        props: ['users'],
        computed: {

        },
        methods: {

        }
    }
</script>