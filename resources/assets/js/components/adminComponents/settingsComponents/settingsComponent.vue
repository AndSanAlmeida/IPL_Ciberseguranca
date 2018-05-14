<template>
  <div>
    <header class="page-header">
      <div class="container-fluid">
        <h2 class="no-margin-bottom">Definições de Administrador</h2>
      </div>
    </header>

    <div class="container-fluid">
      <div class="row">    

        <div class="col-lg-12">
          <div class="card mt-4">
            <ul class="nav nav-tabs ml-2 mt-2 mr-2" id="myTab" role="tablist">
              <li class="nav-item col-lg-3 text-center">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#platformEmail" role="tab" aria-controls="platformEmail" aria-selected="true">Email da Plataforma</a>
              </li>
              <li class="nav-item col-lg-3 text-center">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#resources" role="tab" aria-controls="resources" aria-selected="false">Recursos</a>
              </li>
              <li class="nav-item col-lg-3 text-center">
                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#activity" role="tab" aria-controls="activity" aria-selected="false">Atividades</a>
              </li>
              <li class="nav-item col-lg-3 text-center">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#aboutUs" role="tab" aria-controls="aboutUs" aria-selected="false">Sobre Nós</a>
              </li>
            </ul>
            <div class="tab-content ml-2 mt-2 mr-2" id="myTabContent">
              <div class="tab-pane fade show active" id="platformEmail" role="tabpanel" aria-labelledby="platform-email-tab">
                <platformEmail></platformEmail>
              </div>
              <div class="tab-pane fade" id="resources" role="tabpanel" aria-labelledby="resources-tab">
                <resources></resources>
              </div>
              <div class="tab-pane fade" id="activity" role="tabpanel" aria-labelledby="resources-tab">
                <activities></activities>
              </div>
              <div class="tab-pane fade" id="aboutUs" role="tabpanel" aria-labelledby="about-us-tab">
                <aboutUs></aboutUs>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
</template>
<script type="text/javascript">
  
</script>