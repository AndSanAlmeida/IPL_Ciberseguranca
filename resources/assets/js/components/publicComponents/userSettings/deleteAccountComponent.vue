<template>
	<div class="row">
        <div class="col-md-8 col-xs-12">
			<hr>
			<form class="form-horizontal">
	        	<div class="form-group">
	        		<div class="col-md-offset-3 col-md-9 col-xs-12">
	        			<h3>Apagar Conta?</h3>
	               		<button type="button" class="btn btnSave" data-toggle="modal" data-target="#accDeleteModal">Apagar</button>
	        		</div>
	            </div> 
            </form>

			<!-- Account Delete Modal -->
	        <div class="modal fade" id="accDeleteModal" tabindex="-1" role="dialog" aria-labelledby="accDeleteModalLabel" aria-hidden="true">
	            <div class="modal-dialog" role="document">
	                <div class="modal-content">
	                    <div class="modal-header">
	                        <h4 class="modal-title" id="accDeleteModalLabel"><strong>Apagar Conta</strong></h4>
	                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                            <span aria-hidden="true">&times;</span>
	                        </button>
	                    </div>
	                    <div class="modal-body text-center">
	                        <p>Pretende realmente Apagar a sua Conta?</p>
	                        <button type="button" class="btn btnCancel" data-dismiss="modal">Não</button>
	                        <button type="button" class="btn btnSave" @click="deleteAccount">Sim</button>
	                    </div>
	                </div>
	            </div>
	        </div>

        </div>
    </div>
</template>

<script type="text/javascript">
	export default {
        methods: {
            deleteAccount: function(){
	            axios.delete('api/deleteOwnAccount')
                .then(response => {
                	localStorage.removeItem("access_token");
                    window.location.href = '/';
          		});
            },
        },
    }
</script>