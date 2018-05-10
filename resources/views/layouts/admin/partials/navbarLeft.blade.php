<nav class="side-navbar">
  <!-- Sidebar Header-->
  <div class="sidebar-header d-flex align-items-center">
    <div class="avatar"><img src="{{ URL::asset('img/admin/avatar-1.jpg') }}" alt="Imagem de Perfil" class="img-fluid rounded-circle"></div>
    <div class="title">
      <h1 class="h4">Username</h1>
      <p>Administrador</p>
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
    <li><a href="{{ url('/admin/#/events') }}"> <i class="icon-paper-airplane"></i>Eventos </a></li>
    <li><a href="{{ url('/admin/#/news') }}"> <i class="icon-page"></i>Notícias </a></li>
    <li><a href="{{ url('/admin/#/alerts') }}"> <i class="icon-website"></i>Alertas </a></li>
    <li><a href="{{ url('/admin/#/glossary') }}"> <i class="icon-list"></i>Glossário </a></li>
    <li><a href="{{ url('/admin/#/usefulLinks') }}"> <i class="icon-bill"></i>Links Úteis </a></li>
    <li><a href="{{ url('/admin/#/documents') }}"> <i class="icon-website"></i>Documentos</a></li>
    <li><a href="{{ url('/admin/#/settings') }}"> <i class="icon-interface-windows"></i>Definições </a></li>
  </ul>
</nav>