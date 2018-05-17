<template>
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header d-flex align-items-center">
        <h3 class="h4">Lista de Utilizadores</h3>
      </div>
      <div class="card-body">

        <!-- SEARCH -->
        <div class="col-lg-6 offset-lg-3">
          <b-form-group horizontal label="Pesquisar">
            <b-input-group>
              <b-form-input v-model="filter" placeholder="Escreva para Procurar" />
              <b-input-group-append>
                <b-btn :disabled="!filter" @click="filter = ''">Limpar</b-btn>
              </b-input-group-append>
            </b-input-group>
          </b-form-group>
        </div>
      
        <b-table responsive striped hover 
                  :items="users" 
                  :fields="fields"
                  :current-page="currentPage"
                  :per-page="perPage"
                  :filter="filter">
                    
          <template slot="reason" slot-scope="row">
              <span v-if="row.item.reason != null" v-html="row.item.reason"></span>
              <i v-else>Não definido</i>
          </template>

          <template slot="actions" slot-scope="row">
              <button type="button" v-if="canChangeState" class="btn btn-primary btn-sm" v-on:click.prevent="changeStateOfUser(row.item, newState, newStateString)">{{ newStateString }}</button>
              <button type="button" v-if="canDelete" class="btn btn-danger btn-sm" v-on:click.prevent="deleteUser(row.item)">Apagar</button>
              <button type="button" v-if="canDelete" class="btn btn-info btn-sm">Promover Admin</button>
          </template>

        </b-table>

        <b-pagination :total-rows="totalRows" :per-page="perPage" v-model="currentPage"/>      

        <!--<div class="table-responsive">                       
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
        </div>-->
      </div>
    </div>
  </div>
</template>

<script type="text/javascript">

    module.exports={
        props: ['users', 'state'],
        data() {
          return {
            fields: [
              { key: 'name', label: 'Nome Completo', sortable: true },
              { key: 'email', label: 'Email', sortable: true },
              { key: 'username', label: 'Username', sortable: true },
              { key: 'reason', label: 'Razão' },
              { key: 'actions', label: 'Ações' }
            ],
            currentPage: 1,
            perPage: 20,
            totalRows: this.users.length,
            filter: null
          };
        },
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
            }
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