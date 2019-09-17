<template>
	<div class="d-flex justify-content-center">
		<div class="col-lg-7 col-md-8">
			<div class="invoice-wrap">

				<div class="card_header mb-4">
	                <h3 class="font-weight-semibold mt-3 dark">Project name variants</h3>
	                <div class="pull-right">
		                <router-link :to="`/services/edit/${this.$route.params.slug}`" class="mb-1 mt-1 mr-1 btn btn-warning list-add-button text-light" >
		                  <i class="fas fa-edit"></i> Edit service
		                </router-link>		         
			            <a class="list-add-button">
			                <button type="button" class="btn dropdown-toggle action-btn" data-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
			                <div class="dropdown-menu dropdown-menu-right" role="menu">
				                <router-link to="/services/create" class="dropdown-item text-1" >
				                   Add new service
				                </router-link>	
				                <router-link :to="`/services/variants/${this.$route.params.slug}`" class="dropdown-item text-1" >
				                   Variants
				                </router-link>	
				                <router-link :to="`/services/data/${this.$route.params.slug}`" class="dropdown-item text-1" >
				                   Project data
				                </router-link>
				                <a class="dropdown-item text-1">Delete variants</a>
			                </div>
			            </a>
	                </div>
	              </div>

				<div class="invoice-body">

				<form @submit.prevent="updateService">

					<!-- service top form start -->
					<section>
			            <div class="row w-100">
			                <div class="col-md-12 mb-4">
			                    <div class="form-group custom-size">
			                        <label for="name">Option category <span>*</span></label>
									<input type="text" v-model="form.name" class="form-control" id="name" :class="{ 'is-invalid': form.errors.has('name') }" placeholder="e.g. Size, Word Count, or Number of Links">
                  					<has-error :form="form" field="name"></has-error>
			                    </div>
			                </div>
			                <div class="col-md-12 mb-2">
								<div class="form-group">
									<label for="block-form-module">Option values</label> 
									<table id="dynamic_field" class="table table-bordered">
										<thead>
											<tr>
												<th>Option</th>
												<th>Price</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td width="50%">
													<input type="text" name="designation[]" placeholder="e.g. Small" class="form-control name_list">
												</td> 
												<td width="40%">
													<input type="number" name="designation[]" placeholder="0.00" class="form-control name_list">
												</td>
												<td width="10%" class="text-center">
													<button type="button" name="add" id="addRow" class="btn btn-primary">
														<i class="fa fa-plus"></i>
													</button>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
			                </div>
 
			            </div>
			        </section>
					<!-- service top form end -->

				</form>
                <!-- notification warning messge modal -->
                <notifications group="checkErrors" position="top center" />

				</div><!-- /. invoice-hader -->

			</div>
		</div>
	</div>
</template>

<script>
	

export default{
	data(){
		return{

            form: new Form({
            	name:'',
            	description:'',
            	thumbnail_img:'',
            	service_type:'',
            	one_time_price:'',
            	recurring_price:'',
            	recurring_duration:'',
            	recurring_for:'',
            	is_active:'',
            	isSetDeadline:'',
            	deadline:'',
            	deadline_type:'',
            }),
		}
	},

	methods:{

		/*
		*  Load Service Data
		*/
        loadServiceData(){
	        axios.get(`/api/services/${this.$route.params.slug}`)
	        	.then((response)=>{
	        		//console.log(response.data.name);
		            //this.form.fill(response.data)
	        		this.form.name = response.data.name;
	        		this.form.description = response.data.description;
	        		this.form.thumbnail_img = response.data.thumbnail ? response.data.thumbnail : '';
	        		this.form.service_type = response.data.service_type;
	        		this.form.one_time_price = response.data.service_type==1? response.data.price : '';
	        		this.form.recurring_price = response.data.service_type==2? response.data.price : '';
	        		this.form.recurring_duration = response.data.recurring_duration ? response.data.recurring_duration : 1;
	        		this.form.recurring_for = response.data.recurring_for ? response.data.recurring_for : 'month';
	        		this.form.is_active = response.data.is_active;
	        		this.form.isSetDeadline = response.data.deadline ? true : false ;
	        		let  deadline = response.data.deadline ? response.data.deadline.split(" ") : null;
	        		this.form.deadline = deadline ? deadline[0] : '1' ;
	        		this.form.deadline_type = deadline ? deadline[1] : 'days' ;
		        })  

        },

		/*
		*  edit data
		*/
		updateService(){
            this.form.patch(`/api/services/${this.$route.params.slug}`)
            .then(()=>{

              toast.fire({
                type: 'success',
                title: 'Service Updated Successfuly.'
              })
              //this.$router.push('/working-hour')
              
            }).catch(()=>{
              // shoe message if data not saved
            })
		},

	},

    created() {
       this.loadServiceData();
    }

}

</script>


<style type="text/css">

	.table-bordered th, .table-bordered td {
	    border: 1px solid #dee2e647;
	}

	.table thead th {
	    border-bottom: 1px solid #dee2e647;
	    font-size: 12px;
	    padding: 5px 15px;
	    background: #dddddd38;
	}
</style>