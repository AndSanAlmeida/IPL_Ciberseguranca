<template>
  <div>
   <navbar-top></navbar-top>
    <div class="page-content d-flex align-items-stretch">
        <navbar-left></navbar-left>
        <div class="content-inner">
            <router-view></router-view>
            <admin-footer></admin-footer>
        </div>
    </div> 
  </div>
</template>
<script>
  import navbarLeft from '../adminComponents/partialsComponents/navbarLeftComponent.vue';
  import navbarTop from '../adminComponents/partialsComponents/navbarTopComponent.vue';
  import footer from '../adminComponents/partialsComponents/footerComponent.vue';
  export default {
    components: {
      'navbar-left': navbarLeft,
      'navbar-top': navbarTop,
      'admin-footer': footer,

    }, 
  }
</script>
