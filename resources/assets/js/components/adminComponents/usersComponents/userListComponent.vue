<template>
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
                <th v-if="showReason">Razão</th>
                <th v-if="canDelete">Ações</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="user in users"  :key="user.id">
                <td>{{user.name}}</td>
                <td>{{user.email}}</td>
                <td>{{user.username}}</td>
                <td v-if="showReason">
                    <span v-if="user.reason != null" v-html="user.reason"></span>
                    <i v-else>Não definido</i>
                </td>
                <td>
                  <button type="button" v-if="canChangeState" class="btn btn-primary btn-sm" v-on:click.prevent="changeStateOfUser(user, newState, newStateString)">{{ newStateString }}</button>
                  <button type="button" v-if="canDelete" class="btn btn-danger btn-sm" v-on:click.prevent="deleteUser(user)">Apagar</button>
                  <button type="button" v-if="canDelete" class="btn btn-info btn-sm">Promover Admin</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script type="text/javascript">

    module.exports={
        props: ['users', 'state'],
        computed: {
            canChangeState: function () {
                return  this.state == 1 || this.state == 0;
            },
            canDelete: function (){
                return  this.state == 1 || this.state == 0;
            },
            newState: function(){
                return this.state == 0 ? '1' : '0';
            },
            newStateString: function(){
                return this.state == 0 ? 'Bloquear' : 'Activar';
            },
            showReason: function (){
                return  this.state == 1 || this.state == 0;
            },
        },
        methods: {
            deleteUser: function(user){
                this.$emit('delete-click', user);
            },
            changeStateOfUser: function(user, newState, newStateString){
                this.$emit('change-state-click', user, newState, newStateString);
            },
        }
    }
</script>