<template>
	<section id="resources" class="section-padding">
		<div class="row">
			<div class="container">
				<div class="col-md-8 col-sm-12">
                    <b-breadcrumb :items="items"/>
                    <div class="left-highlight">
                     	<h1>{{ title }}</h1>
                 	</div>

                    <main class="site-content" id="main">
                        <div class="container py-4">
                            <nav class="glossary__nav mb-4">
                                <ul class="list-inline">
                                    <li class="glossary__nav__item active">
                                        <a class="card card__content" data-nav="A" data-toggle="glossary" href="#">A</a>
                                    </li>
                                    <li class="glossary__nav__item">
                                        <a class="card card__content" data-nav="B" data-toggle="glossary" href="#">B</a>
                                    </li>
                                    <li class="glossary__nav__item">
                                        <a class="card card__content" data-nav="C" data-toggle="glossary" href="#">C</a>
                                    </li>
                                    <li class="glossary__nav__item">
                                        <a class="card card__content" data-nav="D" data-toggle="glossary" href="#">D</a>
                                    </li>
                                </ul>
                            </nav>
                            <!--END Glossary Nav-->

                            <div class="glossary__results mb-6">
                
                                <div class="glossary__results__row" data-term="A">
                                    <h3 class="glossary__results__term title-style--three mb-3">A</h3>
                                    <div class="row">
                                        <div class="glossary__results__item col-md-3 col-sm-6" data-item="Application Cycle Management">
                                            <a class="card card__content" href="#">
                                            <h4 class="card__title">Application Cycle Management</h4>
                                            <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste vel, magnam incidunt obcaecati.</p></a>
                                        </div>
                                        <!--END Glossary Result item-->
                                        <div class="glossary__results__item col-md-3 col-sm-6" data-item="API">
                                            <a class="card card__content" href="#">
                                            <h4 class="card__title">API</h4>
                                            <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste vel, magnam incidunt obcaecati.</p></a>
                                        </div>
                                        <!--END Glossary Result item-->
                                        <div class="glossary__results__item col-md-3 col-sm-6" data-item="AVR">
                                            <a class="card card__content" href="#">
                                            <h4 class="card__title">AVR</h4>
                                            <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste vel, magnam incidunt obcaecati.</p></a>
                                        </div>
                                        <!--END Glossary Result item-->
                                        <div class="glossary__results__item col-md-3 col-sm-6" data-item="ARP">
                                            <a class="card card__content" href="#">
                                            <h4 class="card__title">ARP</h4>
                                            <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste vel, magnam incidunt obcaecati.</p></a>
                                        </div>
                                        <!--END Glossary Result item-->
                                    </div>
                                </div>
                                <!--END Glossary Results Row-->

                                <div class="glossary__results__row" data-term="B">
                                    <h3 class="glossary__results__term title-style--three mb-3">B</h3>
                                    <div class="row">
                                        <div class="glossary__results__item col-md-3 col-sm-6" data-item="Bandwidth">
                                            <a class="card card__content" href="#">
                                            <h4 class="card__title">Bandwidth</h4>
                                            <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste vel, magnam incidunt obcaecati.</p></a>
                                        </div>
                                        <!--END Glossary Result item-->
                                        <div class="glossary__results__item col-md-3 col-sm-6" data-item="Back Office">
                                            <a class="card card__content" href="#">
                                            <h4 class="card__title">Back Office</h4>
                                            <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste vel, magnam incidunt obcaecati.</p></a>
                                        </div>
                                        <!--END Glossary Result item-->
                                        <div class="glossary__results__item col-md-3 col-sm-6" data-item="Bluetooth">
                                            <a class="card card__content" href="#">
                                            <h4 class="card__title">Bluetooth</h4>
                                            <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste vel, magnam incidunt obcaecati.</p></a>
                                        </div>
                                        <!--END Glossary Result item-->
                                        <div class="glossary__results__item col-md-3 col-sm-6" data-item="Backbone Network">
                                            <a class="card card__content" href="#">
                                            <h4 class="card__title">Backbone Network</h4>
                                            <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste vel, magnam incidunt obcaecati.</p></a>
                                        </div>
                                        <!--END Glossary Result item-->
                                    </div>
                                </div>
                                <!--END Glossary Results Row-->

                                <div class="glossary__results__row" data-term="C">
                                    <h3 class="glossary__results__term title-style--three mb-3">C</h3>
                                    <div class="row">
                                        <div class="glossary__results__item col-md-3 col-sm-6" data-item="Cable">
                                            <a class="card card__content" href="#">
                                            <h4 class="card__title">Cable</h4>
                                            <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste vel, magnam incidunt obcaecati.</p></a>
                                        </div>
                                        <!--END Glossary Result item-->
                                        <div class="glossary__results__item col-md-3 col-sm-6" data-item="Citizen">
                                            <a class="card card__content" href="#">
                                            <h4 class="card__title">Citizen</h4>
                                            <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste vel, magnam incidunt obcaecati.</p></a>
                                        </div>
                                        <!--END Glossary Result item-->
                                        <div class="glossary__results__item col-md-3 col-sm-6" data-item="Coat">
                                            <a class="card card__content" href="#">
                                            <h4 class="card__title">Coat</h4>
                                            <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste vel, magnam incidunt obcaecati.</p></a>
                                        </div>
                                        <!--END Glossary Result item-->
                                        <div class="glossary__results__item col-md-3 col-sm-6" data-item="Cynagenmod">
                                            <a class="card card__content" href="#">
                                            <h4 class="card__title">Cynagenmod</h4>
                                            <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste vel, magnam incidunt obcaecati.</p></a>
                                        </div>
                                        <!--END Glossary Result item-->
                                    </div>
                                </div>
                                <!--END Glossary Results Row-->

                                <div class="glossary__results__row" data-term="D">
                                    <h3 class="glossary__results__term title-style--three mb-3">D</h3>
                                    <div class="row">
                                        <div class="glossary__results__item col-md-3 col-sm-6" data-item="Data">
                                            <a class="card card__content" href="#">
                                            <h4 class="card__title">Data</h4>
                                            <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste vel, magnam incidunt obcaecati.</p></a>
                                        </div>
                                        <!--END Glossary Result item-->
                                        <div class="glossary__results__item col-md-3 col-sm-6" data-item="Delta">
                                            <a class="card card__content" href="#">
                                            <h4 class="card__title">Delta</h4>
                                            <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste vel, magnam incidunt obcaecati.</p></a>
                                        </div>
                                        <!--END Glossary Result item-->
                                        <div class="glossary__results__item col-md-3 col-sm-6" data-item="Dragon">
                                            <a class="card card__content" href="#">
                                            <h4 class="card__title">Dragon</h4>
                                            <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste vel, magnam incidunt obcaecati.</p></a>
                                        </div>
                                        <!--END Glossary Result item-->
                                        <div class="glossary__results__item col-md-3 col-sm-6" data-item="Dynasty">
                                            <a class="card card__content" href="#">
                                            <h4 class="card__title">Dynasty</h4>
                                            <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste vel, magnam incidunt obcaecati.</p></a>
                                        </div>
                                        <!--END Glossary Result item-->
                                    </div>
                                </div>
                                <!--END Glossary Results Row-->
                            </div>
                            <!--END Glossary Results-->
                        </div>
                    </main>
                    <!-- END Main content -->


                </div>
                <div class="col-md-4 col-sm-12 container-nav">
                    <div class="container-nav-title">
                        <h3><strong>{{ title }}</strong></h3>
                    </div>

                    <resourcesNav></resourcesNav>
                    
                </div>
			</div>
		</div>
	</section>
</template>

<script type="text/javascript">

    $(function(){
        initGlossaryFilter();
    });

    // Filter Glossary items
    function initGlossaryFilter(){

        //On load set 'A' to 'active'
        $(document).ready(function(){
            /*var x = $(".glossary__nav li.active a").attr("data-nav");
            var y = $(".glossary__results__row").attr("data-term");
            if(x == y){
                $(".glossary__results__row").removeClass("inactive");
            }*/
            $(".glossary__results__row").addClass("inactive");
        });
        
        // Filter using navigation
        $(".glossary__nav a").click(function(){
            var nav = $(this).attr("data-nav");
            console.log(nav);

            // Remove & Add active class
            $(".glossary__nav__item").removeClass("active");
            $(this).parent().toggleClass("active");

            // Hide all the results
            $(".glossary__results__row").addClass("inactive");

            // Loop through the row
            $(".glossary__results__row").each(function(){
                var term = $(this).attr("data-term");

                if(nav == term){
                    $(this).removeClass("inactive");
                }
            });

            // Only return false if data-toggle is glossary
            if($(this).attr("data-toggle") == "glossary"){
                return false;
            }
        });
    }


    export default {
        data: function(){
            return {
                title: 'Glossário',
                items: [{
                    text: 'Início',
                    href: '/#/home'
                }, {
                    text: 'Recursos',
                    href: '/#/resources'
                }, {
                    text: 'Glossário',
                    active: true
                }]
            }
        },
    }
</script>