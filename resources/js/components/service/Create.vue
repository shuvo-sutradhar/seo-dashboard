<template>
	<div class="d-flex justify-content-center">
		<div class="col-lg-7 col-md-8">
			<div class="invoice-wrap">

				<div class="card_header mb-4">
	                <h3 class="font-weight-semibold mt-3 dark">Add service</h3>
	                 <router-link to="/services" class="mb-1 mt-1 mr-1 btn btn-warning pull-right list-add-button text-light" >
	                  <i class="fas fa-undo-alt"></i> View All service
	                </router-link>
	              </div>

				<div class="invoice-body">

				<form @submit.prevent="addService" class="service-form">

					<!-- service top form start -->
					<section>
			            <div class="row w-100 service-form">
			                <div class="col-md-12 mb-3">
			                    <div class="form-group custom-size">
			                        <label for="name">Service name <span>*</span></label>
									<input type="text" v-model="form.name" class="form-control" id="name" :class="{ 'is-invalid': form.errors.has('name') }">
                  					<has-error :form="form" field="name"></has-error>
			                    </div>
			                </div>
			            	<div class="col-md-12 mb-3">
			            		<div class="form-group">
			            		   <label for="description">Description</label>
					               <textarea placeholder="Description" class="form-control" v-model="form.description" id="description"  :class="{ 'is-invalid': form.errors.has('description') }"></textarea>
					               <has-error :form="form" field="description"></has-error>
			            		</div>
			            	</div>	
			                <div class="col-md-12 mb-3">
			                    <div class="form-group custom-size">
			                        <label for="picture">Product Thumbnail</label>
			                        <input type="file" v-on:change="uploadPhoto" name="thumbnail_img" class="form-control" :class="{ 'is-invalid': form.errors.has('thumbnail_img') }">
                    				<has-error :form="form" field="thumbnail_img"></has-error>
			                    </div>
			                    <div class="profileImg" v-if="form.thumbnail_img!=''">
			                    	<img :src="getServieThumbnail()" width="100px">
			                    </div>
			                </div>   
			            </div>
			        </section>
					<!-- service top form end -->


					<!-- service tab area start -->
					<div class="tabs service-tab">
						<ul class="nav nav-tabs">
							<li class="nav-item" :class="form.service_type==1 ? 'active' : ''" @click="form.service_type=1">
								<a class="nav-link" href="#one-time" data-toggle="tab">One-time service</a>
							</li>
							<li class="nav-item" :class="form.service_type==2 ? 'active' : ''">
								<a class="nav-link" href="#recurring-service" data-toggle="tab" @click="form.service_type=2">Recurring service</a>
							</li>
						</ul>
						<div class="tab-content">
							<div id="one-time" class="tab-pane"  :class="form.service_type==1 ? 'active' : ''">
				                <div class="col-md-6 mb-3">
				                    <div class="form-group custom-size">
				                        <label for="one_time_price">Price</label>
										<input type="number" v-model="form.one_time_price" class="form-control" id="one_time_price" :class="{ 'is-invalid': form.errors.has('one_time_price') }" placeholder="0.00">
	                  					<has-error :form="form" field="one_time_price"></has-error>
				                    </div>
				                    <small>You can configure pricing options in the Variants section above.</small>
				                </div>
							</div>

							<div id="recurring-service" class="tab-pane" :class="form.service_type==2 ? 'active' : ''">

					            <div class="col-md-12">
				                    <label for="price">Price</label>
						            <div class="row">
						                <div class="col-md-6 mb-3">
											<div class="input-group mb-3">
												<span class="input-group-prepend">
													<span class="input-group-text">$</span>
												</span>

												<input type="number" v-model="form.recurring_price" class="form-control" id="price2" :class="{ 'is-invalid': form.errors.has('recurring_price') }" placeholder="0.00">
			                  					<has-error :form="form" field="recurring_price"></has-error>
											</div>
										</div>
						                <div class="col-md-6 mb-3">
											<div class="input-group tab-select mb-3">
												<span class="input-group-prepend">
													<span class="input-group-text">Per</span>
												</span>
												<input type="number" class="form-control col-md-8" id="price2"  v-model="form.recurring_duration">
												<select class="form-control" v-model="form.recurring_for">
													<option value="month">Month</option>
													<option value="year">Year</option>
													<option value="week">Week</option>
													<option value="day">Day</option>
												</select>
											</div>
										</div>
									</div>
								</div>

							</div>
						</div>
					</div>
					<!-- service tab area end -->


					<!-- service last section start -->
			        <section class="mt-4">
			        	<div class="row w-100">
			                <div class="col-md-12 mb-3">
								<div class="custom-control custom-checkbox">
									<input type="checkbox" id="action-1" class="custom-control-input" v-model='form.is_active' >
									<label for="action-1" class="custom-control-label">Show in services page</label>
								</div>
			                </div>

                            <div class="col-md-12 mb-1">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" id="action-2" class="custom-control-input" v-model="form.isSetDeadline"> 
                                    <label for="action-2" class="custom-control-label">Set a deadline</label>
                                    <br>
                                	<small>Helps your team see orders that are due soon, not visible to clients.</small>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3 ml-4" v-if="form.isSetDeadline==true">
								<div class="input-group tab-select mb-3">
									<input type="number" class="form-control col-md-8" id="price2" v-model="form.deadline" placeholder="0">
									<select class="form-control" v-model="form.deadline_type">
										<option value="days" selected>Days</option>
										<option value="hours">Hours</option>
									</select>
								</div>
                            </div>

                            <div class="col-md-12">
								<div class="text-right">
									<button type="submit" class="btn btn-primary">
								      	Add Service
								     </button>
								 </div>
							 </div>
			        	</div>
			        </section>
					<!-- service last section end -->

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
            	service_type:1,
            	one_time_price:'',
            	recurring_price:'',
            	recurring_duration:1,
            	recurring_for:'month',
            	is_active:1,
            	isSetDeadline:false,
            	deadline:1,
            	deadline_type:'days',
            }),
		}
	},

	methods:{

		/*
		*  getServieThumbnail
		*/
        getServieThumbnail(){

             let prefix = (this.form.thumbnail_img.match(/\//) ? '' : '');
             return prefix + this.form.thumbnail_img;

        },
        uploadPhoto(e){
            let file = e.target.files[0];
            let reader = new FileReader();

            //check file size
            if(file['size'] < 2111775) {
                reader.onloadend = (file) => {
                    //console.log('RESULT', reader.result)
                    this.form.thumbnail_img = reader.result;
                }
                reader.readAsDataURL(file)
            } else {
                Swal.fire({
                    title: 'Oops...',
                    text: "Something is wrong",
                    type: 'error',
                })
            }
        },


        /*
		* Submit service data
        */
        addService() {


            // if there have no error then the form will be submit
            this.$Progress.start();

            this.form.post('/api/services')
            .then((response)=>{
              
              this.$Progress.finish();
              toast.fire({
                type: 'success',
                title: 'Client created successfully.'
              })

              //window.location.href = "../orders/"+response.data.service.slug;
              this.$router.push('/services/edit/'+response.data.service.slug);
              
            }).catch(()=>{
                this.$Progress.fail()
            })


        }


	},

    created() {
       //this.loadAllCountry();
    }

}

</script>


<style type="text/css">
	.service-form .help-block {
	    margin-top: 3px;
	    color: #dc3545;
	}

	.service-tab .tab-content {
	    padding: 2rem 2rem;
	}

	.tab-select input.form-control {
	    width: 60% !important;
	}
	.tab-select select.form-control {
	    height: auto !important;
	    padding: 4px;
	}
</style>