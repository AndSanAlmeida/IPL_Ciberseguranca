<nav class="side-navbar">
  <!-- Sidebar Header-->
  <div class="sidebar-header d-flex align-items-center">
    <div class="avatar"><img src="{{ URL::asset('img/admin/avatar-1.jpg') }}" alt="Imagem Perfil" class="img-fluid rounded-circle"></div>
    <div class="title">
      <h1 class="h4">Username</h1>
      <p>Admin</p>
    </div>
  </div>
  <!-- Sidebar Navidation Menus-->
  <span class="heading">Main</span>
  <ul class="list-unstyled">
    <li class="{{ url()->current()==url('/admin/#/home') ? 'active' : '' }} }}">
      <a href="{{ url('/admin/#/home') }}" title="Home"><i class="icon-home"></i>Home</a>
    </li>
    <li class="{{ url()->current()==url('/admin/#/users') ? 'active' : '' }}">
      <a href="{{ url('/admin/#/users') }}" title="Users"> <i class="icon-user"></i>Utilizadores</a>
    </li>
    <li class="active"><a href="#"> <i class="icon-paper-airplane"></i>Eventos </a></li>
    <li><a href="#"> <i class="icon-padnote"></i>Posts </a></li>
    <li><a href="#"> <i class="icon-page"></i>Notícias </a></li>
    <li><a href="#"> <i class="icon-list"></i>Glossário </a></li>
    <li><a href="#"> <i class="icon-website"></i>Alertas </a></li>
    <li><a href="#"> <i class="icon-rss-feed"></i>RSS </a></li>
    <li><a href="#"> <i class="icon-bill"></i>Links Úteis </a></li>
    <li><a href="#"> <i class="icon-interface-windows"></i>Definições </a></li>
    <li><a href="#"> <i class="fa fa-bar-chart"></i>Estatísticas </a></li>
    <!-- <li><a href="#exampledropdownDropdown" aria-expanded="false" data-toggle="collapse"> <i class="icon-interface-windows"></i>Example dropdown </a>
      <ul id="exampledropdownDropdown" class="collapse list-unstyled ">
        <li><a href="#">Page</a></li>
        <li><a href="#">Page</a></li>
        <li><a href="#">Page</a></li>
      </ul>
    </li>-->
  </ul>
</nav>