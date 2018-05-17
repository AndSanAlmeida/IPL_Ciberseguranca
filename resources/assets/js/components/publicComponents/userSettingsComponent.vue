<template>
	<section id="userSettings" class="section-padding">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<b-breadcrumb :items="items"/>
                    <div class="left-highlight">
                     	<h1>{{ title }}</h1>
                 	</div>
                 	<br><br>

                 	<avatarAccount></avatarAccount>
					<accountManagement></accountManagement>
					<changePassword></changePassword>
					<deleteAccount v-if="this.userType == 0"></deleteAccount>

				</div>
			</div>
		</div>
	</section>
</template>

<script type="text/javascript">
    import AvatarAccount from './userSettings/avatarAccountComponent.vue'
    import AccountManagement from './userSettings/accountManagementComponent.vue'
    import ChangePassword from './userSettings/changePasswordComponent.vue'
    import DeleteAccount from './userSettings/deleteAccountComponent.vue'

    export default {
        data: function () {
            return {
            	title: 'Perfil',
                items: [{
                    text: 'Início',
                    href: '/#/home'
                }, {
                    text: 'Perfil',
                    active: true
                }],
                userType: '',
            }
        },
        components: {
            'avatarAccount': AvatarAccount,
            'accountManagement': AccountManagement,
            'changePassword': ChangePassword,
            'deleteAccount': DeleteAccount 
        },
        methods: {
            getUserType: function () {
                axios.get('/api/user')
                    .then((response) => {
                        this.userType = response;
                    });
            }
        },
        created: function () {
            this.getUserType();
        }
    }
</script>
