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
                                <div  v-for="letter in letters" >
                                    <li class="glossary__nav__item"  v-if="lettersAvailable.includes(letter)">
                                        <a class="card card__content' : 'card card__content'" v-on:click="getGlossary(letter)" data-toggle="glossary" href="#">{{letter}}</a>
                                    </li>
                                </div>
                            </ul>
                        </nav>
                        <!--END Glossary Nav-->

                        <div class="glossary__results">
            
                            <div class="glossary__results__row inactive">
                                <div class="row">
                                    <div class="glossary__results__item col-sm-12" v-for="glossaryItem in glossary">
                                        <h2 class="card__title">{{glossaryItem.name}}</h2>
                                        <p><strong>[Definição] </strong>{{glossaryItem.definition}}</p>
                                        <p><strong>[Fonte] </strong>{{glossaryItem.source}}</p>
                                    </div>
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

            $(".glossary__nav li:first").addClass("active");
            
            //Get NAV Attribute
            var nav = $(".glossary__nav li a").attr("data-nav");

            // Loop through the row
            $(".glossary__results__row").each(function(){
                var term = $(this).attr("data-term");

                if(nav == term){
                    $(this).removeClass("inactive");
                }
            });
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
                }],
                glossary: [],
                letters: ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 
                          'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'],
                lettersAvailable : [],
                loading: false,
                
            }
        },
        methods: {
            getGlossaryLetters: function() {
                axios.get('/api/glossary/letters')
                    .then(response => {
                        this.lettersAvailable = response.data;
                        this.getGlossary(this.lettersAvailable[0]);
                    }).catch((error) => {
                    this.loading = false;
                    this.errorLoading = true;
                });
            },
            getGlossary: function (letter) {
                this.loading = true;
                this.errorLoading = false;
                
                axios.get('/api/glossary/byLetter/'+letter.toLowerCase())
                    .then(response => {
                        this.glossary = response.data.data;
                        this.loading = false;
                    }).catch((error) => {
                    this.loading = false;
                    this.errorLoading = true;
                });
            },
        },
        mounted: function () {
            initGlossaryFilter();
            this.getGlossaryLetters();
        }
    }
</script>
