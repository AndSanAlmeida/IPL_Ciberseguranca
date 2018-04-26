<template>
	<div>
		<header class="page-header">
		  <div class="container-fluid">
		    <h2 class="no-margin-bottom">Utilizadores</h2>
		  </div>
		</header>

		<!--<div class="alert alert-success" role="alert" v-if="showSuccess">
            <p>{{successMessage}}</p>
        </div>

        <h1 v-if="loading">A carregar...</h1>

        <div class="alert alert-danger" role="alert" v-if="errorLoading">
            <p>Erro ao pesquisar os dados tente novamente.</p>
        </div>

        <div class="alert alert-warning" role="alert">
            <p>Não foram encontrados utilizadores.</p>
        </div>-->

		<userList :users="users"></userList>

	</div>
</template>

<script type="text/javascript">
    import UserList from './userListComponent.vue';
    import swal from 'sweetalert';

    export default {
        data: function () {
            return {
                searchText: '',
                stateOfAccount: '0',
                stateOfAccountProp: '0',
                options: [
                    {text: 'Activa', value: '0'},
                    {text: 'Bloqueada', value: '1'},
                    {text: 'Apagada', value: '-1'}
                ],
                users: [],
                showSuccess: false,
                successMessage: '',
                loading: true,
                errorLoading: false,
            }
        },
        methods: {
            getUsers: function () {
                this.loading = true;
                this.errorLoading = false;
                this.stateOfAccountProp = this.stateOfAccount;
                const data = {
                    searchText: this.searchText,
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
        },
        components: {
            'userList': UserList,
        },
        mounted() {
            this.getUsers();
        }
    }
</script>