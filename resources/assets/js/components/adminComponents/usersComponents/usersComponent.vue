<template>
	<div>
		<header class="page-header">
		  <div class="container-fluid">
		    <h2 class="no-margin-bottom">{{title}}</h2>
		  </div>
		</header>
        
        <!-- ERRORS -->
        <div class="alert alert-warning" role="alert" v-if="!hasItems && canShowContent">
            <p>Não foram encontrados {{title}}.</p>
        </div>

        <div class="alert alert-danger" role="alert" v-if="errorLoading">
            <p>Erro ao pesquisar os dados tente novamente.</p>
        </div>
        
        <!-- ============ -->
        
        <section>
            <div class="container-fluid">
                <div class="row">

                    <!-- SEARCH -->
                    <div class="col-lg-6 offset-lg-3" v-if="hasItems && canShowContent">
                        <div class="card">
                          <div class="card-header d-flex align-items-center">
                            <h3 class="h4">Listar Por</h3>
                          </div>
                          <div class="card-body">
                            <form class="form-horizontal">
                              <div class="form-group row">
                                <label for="stateOfAccount" class="col-sm-3 form-control-label">Estado da Conta</label>
                                <div class="col-sm-6 select">
                                  <select v-model="stateOfAccount" name="stateOfAccount" id="stateOfAccount" class="form-control">
                                    <option v-for="option in options" v-bind:value="option.value">
                                        {{ option.text }}
                                    </option>
                                  </select>
                                </div>
                                <div class="col-sm-3">
                                    <button type="button" v-on:click="getUsers" class="btn btn-primary">Pesquisar</button>                                  
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                    </div>

                    <!-- LOADING -->
                    <div class="col-md-12">
                        <div v-if="loading" class="align-loader mt-4">
                            <div class="loader"></div>
                        </div>
                    </div>
                        
                    <!-- USER LIST -->
                    <userList :users="users" :state="stateOfAccountProp" v-if="hasItems && canShowContent"
                        @delete-click="deleteUser" @change-state-click="changeStateOfUser" @promote-click="promoteUser"></userList>

                </div>
            </div>
            
        </section>

		

	</div>
</template>

<script type="text/javascript">
    import UserList from './userListComponent.vue';
    import swal from 'sweetalert';

    export default {
        data: function () {
            return {
                title: 'Utilizadores',
                stateOfAccount: '0',
                stateOfAccountProp: '0',
                options: [
                    {text: 'Activa', value: '0'},
                    {text: 'Bloqueada', value: '1'},
                ],
                users: [],
                loading: true,
                errorLoading: false,
            }
        },
        computed: {
            hasItems: function () {
                return this.users.length > 0;
            },
            canShowContent: function () {
                return !this.errorLoading && !this.loading;
            },
        },
        methods: {
            getUsers: function () {
                this.loading = true;
                this.errorLoading = false;
                this.stateOfAccountProp = this.stateOfAccount;
                const data = {
                    stateOfAccount: this.stateOfAccount
                };
                axios.post('/api/users', data)
                    .then(response => {
                        this.users = response.data.data;
                        this.loading = false;
                    }).catch((error) => {
                    this.loading = false;
                    this.errorLoading = true;
                });
            },
            deleteUser: function (user) {
                swal({
                    title: "Apagar?",
                    icon: "warning",
                    text: "Pretende realmente apagar o utilizador?",
                    buttons: {
                        no: {
                              text: "Cancelar",
                              className: "btn-light",
                        },
                        yes: {
                              text: "Apagar!",
                              className: "btn-danger",
                        }
                    }
                }).then((result) => {
                    switch(result) {
                        case "no": break;
                        case "yes": 
                            axios.delete('/api/users/' + user.id)
                                .then(response => {
                                    swal({
                                        title: "Operação completa!",
                                        text: "Utilizador apagado com sucesso!",
                                        icon: "success",
                                    });
                                this.getUsers();
                            });
                        break;
                    }
                })
            },
            promoteUser: function (user) {
                swal({
                    title: "Promover?",
                    icon: "warning",
                    text: "Pretende realmente promover o utilizador?",
                    buttons: {
                        no: {
                          text: "Cancelar",
                          className: "btn-light",
                        },
                        yes: {
                          text: "Promover!",
                          className: "btn-primary",
                        }
                    }
                }).then((result) => {
                    switch(result) {
                        case "no": break;
                        case "yes": 
                            axios.post('/api/users/' + user.id +'/promote')
                                .then(response => {
                                    swal({
                                        title: "Operação completa!",
                                        text: "Utilizador promovido com sucesso!",
                                        icon: "success",
                                    });
                                this.getUsers();
                            });
                        break;
                    }
                })
            },
            changeStateOfUser: function (user, newState, newStateString) {
                swal({
                    title: newStateString + "!",
                    text: 'Pretende realmente ' + newStateString + ' o utilizador?',
                    icon: 'warning',
                    content: {
                        element: "input",
                        attributes: {
                            placeholder: "Mensagem"
                        },
                    },
                    button: {
                        text: newStateString + "!"
                    },
                }).then((result) => {
                    if (result != '') {
                        const data = {
                            newState: newState,
                            reason: result,
                        };
                        axios.put('/api/users/' + user.id, data)
                            .then(response => {
                                swal({
                                    title: "Operação completa!",
                                    text: "Utilizador bloqueado com sucesso!",
                                    icon: "success",
                                });
                                this.getUsers();
                            });
                    } else {
                        swal("Preencher mensagem.", {
                            icon: "warning",
                            buttons: {
                                ok: "Ok"
                            },
                        }).then((result) => {
                            switch (result) {
                                case "ok": break;
                            }
                        });
                    }
                })
            }
        },
        components: {
            'userList': UserList,
        },
        mounted() {
            this.getUsers();
        }
    }
</script>