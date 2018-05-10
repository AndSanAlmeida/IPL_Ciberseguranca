<template>
  <section class="tables">   
    <div class="container-fluid">
      <div class="row">    
        
        <div class="col-lg-12">
          <router-link to="/usefulLinks/create" class="btn btn-primary">Adicionar Link Útil</router-link>
          <div class="card mt-2">
            <div class="card-header d-flex align-items-center">
              <h3 class="h4">Lista de Links Uteis</h3>
            </div>
            <div class="card-body">
              <div class="table-responsive">                       
                <div class="card">
                  <p class="text-center" v-if="usefulLinks.length == 0" >Não existe links úteis disponíveis.</p>
                  <table class="table table-striped table-hover" v-if="usefulLinks.length != 0" >
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Descrição</th>
                        <th>URL</th>
                        <th>Ações</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="link in usefulLinks" :key="link.id">
                        <td>{{link.id}}</td>
                        <td>{{link.description}}</td>
                        <td>{{link.link}}</td>
                        <td>
                            <router-link :to="{ name: 'usefulLinksEdit', params: {id: link.id } }" class="btn btn-sm btn-warning">Editar</router-link>
                            <button type="button" class="btn btn-sm btn-danger" v-on:click="deleteUsefulLink(link)">Eliminar</button>
                        
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
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
  props: ['usefulLinks'],
  computed: {

  },
  methods: {
    deleteUsefulLink: function(link) {
      this.$emit('delete-click', link);
    }
  }
}
</script>