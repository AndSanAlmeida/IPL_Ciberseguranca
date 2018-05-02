<template>
  <div>
    <header class="page-header">
      <div class="container-fluid">
        <h2 class="no-margin-bottom">Dashboard</h2>
      </div>
    </header>

    <!-- Users -->
    <section class="dashboard-counts no-padding-bottom">
      <div class="container-fluid">
        <div class="row bg-white has-shadow">
          <!-- Item -->
          <div class="col-xl-3 col-sm-6">
            <div class="item d-flex align-items-center">
              <div class="icon bg-violet"><i class="icon-user"></i></div>
              <div class="title"><span>Número de<br>Utilizadores</span>
              </div>
              <div class="number"><strong>{{numUsers}}</strong></div>
            </div>
          </div>
          <!-- Item -->
          <div class="col-xl-3 col-sm-6">
            <div class="item d-flex align-items-center">
              <div class="icon bg-green"><i class="icon-user"></i></div>
              <div class="title"><span>Novos<br>Utilizadores</span>
              </div>
              <div class="number"><strong>{{newUsers}}</strong></div>
            </div>
          </div>
          <!-- Item -->
          <div class="col-xl-3 col-sm-6">
            <div class="item d-flex align-items-center">
              <div class="icon bg-red"><i class="icon-user"></i></div>
              <div class="title"><span>Utilizadores<br>Bloqueados</span>
              </div>
              <div class="number"><strong>{{blockedUsers}}</strong></div>
            </div>
          </div>
          <!-- Item -->
          <div class="col-xl-3 col-sm-6">
            <div class="item d-flex align-items-center">
              <div class="icon bg-red"><i class="icon-user"></i></div>
              <div class="title"><span>Utilizadores<br>Ativos no Forum</span>
              </div>
              <div class="number"><strong>{{activeUsers}}</strong></div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script type="text/javascript">
  export default {
        data: function () {
            return {
                users: [],
                numUsers: 0,
                blockedUsers: 0,
                newUsers: 0,
                activeUsers: 0,
            }
        },
        methods: {
            getUsers: function () {
                axios.get('/api/users')
                    .then(response => {
                        this.users = response.data.data;
                        this.numUsers = this.users.length;
                        this.getBlockedUsers();
                        this.getNewUsers();
                        this.getActiveUsers();
                    })
                    .catch(error => {
                        console.log(error.response)
                    });

            },
            getBlockedUsers: function () {
                let blocked = 0;
                this.users.forEach(function (user, key) {
                    if (user.blocked === 1) {
                        blocked++;
                    }
                });

                this.blockedUsers = blocked;

            },
            getNewUsers: function () {
                let newp = 0;
                this.users.forEach(function (user, key) {
                    if (user.activated === 0 && user.blocked === 0) {
                        newp++;
                    }
                });

                this.newUsers = newp;
            },
            getActiveUsers: function () {
              let active = 0;
                this.users.forEach(function (user, key) {
                    if (user.total_forum_posts != 0 || user.total_forum_comments != 0 ) {
                        active++;
                    }
                });

                this.activeUsers = active;
            }
        },
        computed: {},
        components: {},
        mounted: function () {
            this.getUsers();
        }
    }
</script>
<style>
  
</style>
