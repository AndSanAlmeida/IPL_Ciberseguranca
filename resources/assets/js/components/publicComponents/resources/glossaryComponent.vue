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
                                <li class="glossary__nav__item" v-for="letter in lettersAvailable">
                                    <a href="#" class="card card__content" v-on:click="getGlossary(letter)">{{letter}}</a>
                                </li>
                            </ul>
                        </nav>
                        <!--END Glossary Nav-->

                        <div class="glossary__results">
            
                            <div class="glossary__results__row">
                                <div class="row">
                                    <div class="glossary__results__item col-sm-12" v-for="item in glossary">
                                        <h2 class="card__title">{{item.name}}</h2>
                                        <p><strong>[Definição] </strong>{{item.definition}}</p>
                                        <p><strong>[Fonte] </strong>{{item.source}}</p>
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
                lettersAvailable : [], 
            }
        },
        methods: {
            getGlossaryLetters: function() {
                axios.get('/api/glossary/letters')                    
                    .then(response => {
                        this.lettersAvailable = response.data;
                        this.getGlossary(this.lettersAvailable[0]);
                    }).catch((error) => {
                        
                });
            },
            getGlossary: function (letter) {                 
                axios.get('/api/glossary/byLetter/' + letter.toLowerCase())
                    .then(response => {
                        this.glossary = response.data.data;
                }).catch((error) => {

                });
            },
        },
        mounted: function () {      
            this.getGlossaryLetters();
        }
    }
</script>
