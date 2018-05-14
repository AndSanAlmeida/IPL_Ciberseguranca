<template>
	<section id="resources" class="section-padding">
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-sm-12">
                    <b-breadcrumb :items="items"/>
                    <div class="left-highlight">
                     	<h1>{{ title }}</h1>
                 	</div>

                    <div id="glossary">
                        <nav class="glossary__nav">
                            <ul class="list-inline text-center">
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

                        <div class="glossary__results">
            
                            <div class="glossary__results__row inactive" data-term="A">
                                <div class="row">
                                    <div class="glossary__results__item col-sm-12">
                                        <h2 class="card__title">Application Cycle Management</h2>
                                        <p><strong>[Definição] </strong>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste vel, magnam incidunt obcaecati.</p>
                                        <p><strong>[Fonte] </strong>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste vel, magnam incidunt obcaecati.</p>
                                    </div>
                                    <!--END Glossary Result item-->
                                    <div class="glossary__results__item col-sm-12">
                                        <h2 class="card__title">API</h2>
                                        <p><strong>[Definição] </strong>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste vel, magnam incidunt obcaecati.</p>
                                        <p><strong>[Fonte] </strong>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste vel, magnam incidunt obcaecati.</p>
                                    </div>
                                    <!--END Glossary Result item-->
                                    <div class="glossary__results__item col-sm-12">
                                        <h2 class="card__title">AVR</h2>
                                        <p><strong>[Definição] </strong>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste vel, magnam incidunt obcaecati.</p>
                                        <p><strong>[Fonte] </strong>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste vel, magnam incidunt obcaecati.</p>
                                    </div>
                                    <!--END Glossary Result item-->
                                    <div class="glossary__results__item col-sm-12">
                                        <h2 class="card__title">ARP</h2>
                                        <p><strong>[Definição] </strong>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste vel, magnam incidunt obcaecati.</p>
                                        <p><strong>[Fonte] </strong>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste vel, magnam incidunt obcaecati.</p>
                                    </div>
                                    <!--END Glossary Result item-->
                                </div>
                            </div>
                            <!--END Glossary Results Row-->

                        </div>
                        <!--END Glossary Results-->
                    </div>
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

    // Filter Glossary items
    function initGlossaryFilter(){

        //On load set 'A' to 'active'
        $(document).ready(function(){

            //Get NAV Attribute
            var nav = $(".glossary__nav li.active a").attr("data-nav");

            // Loop through the row
            $(".glossary__results__row").each(function(){
                var term = $(this).attr("data-term");

                if(nav == term){
                    $(this).removeClass("inactive");
                }
            });
        });
        
        // Filter using navigation
        $(".glossary__nav a").click(function(){
            var nav = $(this).attr("data-nav");

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
        mounted: function () {
            initGlossaryFilter();
        }
    }
</script>