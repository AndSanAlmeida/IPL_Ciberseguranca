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
              <li class="nav-item col-lg-4 text-center">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Email da Plataforma</a>
              </li>
              <li class="nav-item col-lg-4 text-center">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Sobre Nós</a>
              </li>
              <li class="nav-item col-lg-4 text-center">
                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contactos</a>
              </li>
            </ul>
            <div class="tab-content ml-2 mt-2 mr-2" id="myTabContent">
              <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <platformEmail></platformEmail>
              </div>
              <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <aboutUs></aboutUs>
              </div>
              <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
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