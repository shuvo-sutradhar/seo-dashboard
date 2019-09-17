<template>
	<div class="d-flex justify-content-center">
		<div class="col-lg-7 col-md-8">
			<div class="invoice-wrap">

				<div class="card_header mb-4">
	                <h3 class="font-weight-semibold mt-3 dark">Add discount</h3>
	                 <router-link to="/discount" class="mb-1 mt-1 mr-1 btn btn-warning pull-right list-add-button text-light" >
	                  <i class="fas fa-undo-alt"></i> View All Discount
	                </router-link>
	              </div>

				<div class="invoice-body">

					<form @submit.prevent="addDiscount">
						<section class="discountform">
				            <div class="row w-100">
				            	<div class="col-md-12 mb-4">
				            		<div class="form-group">
				            			<label for="cupon_code">Coupon code</label>
				            			<input type="test" v-model="form.cupon_code" class="form-control col-md-5" placeholder="e.g. 25OFF" id="cupon_code" :class="{ 'is-invalid': form.errors.has('cupon_code') }">
						               <span class="small_label">This is what clients will use to get the discount.</span>

						               <has-error :form="form" field="cupon_code"></has-error>
				            		</div>
				            	</div>
				            	<div class="col-md-12 mb-4">
				            		<div class="form-group">
				            		   <label for="description">Description(Optional)</label>
						               <textarea placeholder="Description" class="form-control" v-model="form.description" id="description"  :class="{ 'is-invalid': form.errors.has('description') }"></textarea>
						               <span class="small_label">Not visible to clients, helps you remember what the coupon is for.</span>
						               <has-error :form="form" field="description"></has-error>
				            		</div>
				            	</div>
				            	<div class="col-md-12 mb-4">
				            		<div class="form-group">
				            			<label for="cupon_code">Discount type</label>
										<div class="form-row">
											<div class="scard p-2">
		                                        <div class="custom-control custom-radio">
		                                            <!-- {{ data.selectedService[roll] }} -->
		                                            <input type="radio" v-model="form.discount_type" id="action-0-0" class="custom-control-input" value="1">
		                                            <label for="action-0-0" class="custom-control-label">Fixed amount</label> 
		                                        </div>
		                                    </div>
											<div class="scard p-2">
		                                        <div class="custom-control custom-radio">
		                                            <!-- {{ data.selectedService[roll] }} -->
		                                            <input type="radio" v-model="form.discount_type" id="action-0-1" class="custom-control-input"  value="2"> 
		                                            <label for="action-0-1" class="custom-control-label">Percentage</label> 
		                                        </div>
		                                    </div>
						               		<has-error :form="form" field="discount_type"></has-error>
	                                    </div>
				            		</div>
				            	</div>
				            	<div class="col-md-12 mb-4">
				            		<div class="form-group">
				            			<label for="cupon_code">Discount duration for recurring services</label>
										<div class="form-row">
											<div class="scard p-2">
		                                        <div class="custom-control custom-radio">
		                                            <!-- {{ data.selectedService[roll] }} -->
		                                            <input type="radio" v-model="form.discount_duration" id="action-1-0" class="custom-control-input" value="1">
		                                            <label for="action-1-0" class="custom-control-label">Forever</label> 
		                                        </div>
		                                    </div>
											<div class="scard p-2">
		                                        <div class="custom-control custom-radio">
		                                            <!-- {{ data.selectedService[roll] }} -->
		                                            <input type="radio" v-model="form.discount_duration" id="action-1-1" class="custom-control-input" value="2"> 
		                                            <label for="action-1-1" class="custom-control-label">First payment</label> 
		                                        </div>
		                                    </div>
						               		<has-error :form="form" field="discount_duration"></has-error>
	                                    </div>
				            		</div>
				            	</div>
				            	<div class="col-md-12 mb-4">
					            	<div class="row mb-2 applies_serv" v-for="(item, index) in form.items">
						                <div class="col-md-8 ">
						                    <div class="form-group custom-size">
						                        <label for="user_id">Applies to...</label>
												<vue-single-select 
								                    placeholder="All services" 
								                    you-want-to-select-a-post="id" 
								                    v-model="item.selectedService" 
								                    out-of-all-these-posts="makes sense" 
								                    :options="services" 
								                    you-like-bootstrap="yes" 
								                    a-post-has-an-id="id" 
								                    option-value="id" 
								                    the-post-has-a-title="make sure to show these" 
								                    option-label="name" 
								                    class="vue-single-select" :class="{ 'is-invalid': form.errors.has('selectedService') }">
								                  </vue-single-select>
								                  <has-error :form="form" field="selectedService"></has-error>
						                    </div>
						                </div>
						                <div class="col-md-4">
						                    <div class="form-group">
						                        <label for="date_due">Discount</label>
						                        <input type="text" class="form-control" v-model="item.discount_amount" placeholder="0.0" :class="{ 'is-invalid': form.errors.has('item.discount_amount') }">
								                  <has-error :form="form" field="item.discount_amount"></has-error>
						                    </div>
						                </div>
						                <button v-if="form.items.length>1" type="button" data-delete="" class="btn btn-sm removeServ" @click="deleteItem(index)"><i class="fas fa-trash"></i></button>
						            </div>
						             <div class="text-right mt-2"><a style="cursor: pointer;color: #2ec3a1;" @click="addNewDiscount" >+ Add discount</a></div>
					            </div>
				            	<div class="col-md-12 mb-4">
				            		<div class="form-group">
				            			<label for="cupon_code">Redemption limits</label>
						
										<div class="scard p-2">
	                                        <div class="custom-control custom-checkbox">
	                                            <!-- {{ data.selectedService[roll] }} -->
	                                            <input type="checkbox" v-model="form.limit_1" id="action-2-0" class="custom-control-input"> 
	                                            <label for="action-2-0" class="custom-control-label">Limit to one use per customer</label> 
						                  		<has-error :form="form" field="limit_1"></has-error>
	                                        </div>
	                                    </div>
										<div class="scard p-2">
	                                        <div class="custom-control custom-checkbox">
	                                            <!-- {{ data.selectedService[roll] }} -->
	                                            <input type="checkbox" v-model="form.is_total_limit" id="action-2-1" class="custom-control-input"> 
	                                            <label for="action-2-1" class="custom-control-label">Limit number of uses in total</label>
										        <div id="expiry_date" v-show="form.is_total_limit==true">
										            <input type="number" id="currency" class="form-control col-md-4 mb-1" placeholder="0" v-model="form.total_limit">
										        </div> 
	                                        </div>
	                                    </div>
										<div class="scard p-2">
	                                        <div class="custom-control custom-checkbox">
	                                            <!-- {{ data.selectedService[roll] }} -->
	                                            <input type="checkbox" v-model="form.is_expiry_date" id="action-2-2" class="custom-control-input"> 
	                                            <label for="action-2-2" class="custom-control-label">Set expiry date</label> 
										        <div id="expiry_date" v-show="form.is_expiry_date==true">
										            <input type="date" name="currency" id="currency" class="form-control col-md-4 mb-1" placeholder="USD" v-model="form.expiry_date">
										            <span class="small_label">Coupon will expire on selected date GMT time.</span>
										        </div>
	                                        </div>

	                                    </div>
	                               
				            		</div>
				            	</div>
				                <div class="col-md-12 mb-4">
				                    <div class="form-group">
				                        <label for="date_due">Cupon Status</label>
				                        <toggle-button :value="true" color="#82C7EB" :sync="false" :labels="true" v-model="form.isactive" style="margin-top: 5px;margin-left: 5px;"/>
				                    </div>
				                </div>
				                <div class="col-md-12 mb-4">
								   <div class="text-right">
								      <button type="submit" class="btn btn-primary">
								      	Add invoice
								      </button>
								   </div>
							   	</div>
				            </div>
				        </section>
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

	            formerrors:[],
	            services:[],
	            form: new Form({
	                cupon_code: '',
	                description:'',
	                discount_type:'1',
	                discount_duration:'1',
	                limit_1:'',
	                is_total_limit:'',
	                total_limit:'',
	                is_expiry_date:'',
	                expiry_date:'',
	                isactive:true,
	                items:[{
		                selectedService:null,
		                discount_amount:null,
		            }],
	            }),
			}
		},

		methods:{

			/*
			*  add discount for more service
			*/
			addNewDiscount() {
			 	this.form.items.push({
	                selectedService:null,
	                discount_amount: null,
			 	})

			},
			deleteItem: function(index) {
				this.form.items.splice(index,1);
			},
			/*
			*  Load Invoice Data
			*/
	        loadServices(){
	            axios.get("/api/create-discount").then(({ data }) => (this.services = data.services));

	        },


	        /*
			* Submit Invoice Data
	        */
	        addDiscount() {

	            this.formerrors = [];

				if(this.form.cupon_code == null || this.form.cupon_code == ''){
	    			this.formerrors.push('Cupon code field is required.');
	    		} 



	        	for (var i = 0; i < this.form.items.length; i++) {
	        		
	        		if(this.form.items[i].discount_amount == null){
	        			this.formerrors.push('Discount amount field is required.')
	        		} 

	        		if(1 <= i){
		        		if(this.form.items[i].selectedService == null){
		        			this.formerrors.push('Service field is required.')
		        		} 
		        		if(this.form.items[i].discount_amount == null){
		        			this.formerrors.push('Discount amount field is required.')
		        		} 
	        		} 

	        		// if(this.form.items[i].selectedService != null && this.form.items[i].selectedService.id==0){
	        		// 	if(!this.form.items[i].serviceName){
	        		// 		this.formerrors.push('Item name field is required.')
	        		// 	}
	        		// 	if(!this.form.items[i].servicePrice){
	        		// 		this.formerrors.push('Item price field is required.')
	        		// 	}
	        		// }

	        	}


	            this.$Progress.start();
	            if(this.formerrors.length === 0) {
		            this.form.post('/api/discount')
		            .then((order)=>{

		              $.magnificPopup.close();
		              
		              this.$Progress.finish();
		              toast.fire({
		                type: 'success',
		                title: 'Coupon added successfully.'
		              })

		              //console.log();
		              //window.location.href = "../orders/"+order.data.order.order_number;

		              //this.$router.push('/orders/order/'+order.data.order.order_number);
		            }).catch(()=>{
		                this.$Progress.fail()
		            })
	        	} else {
	                this.$Progress.fail();
	                this.$notify({
	                  group: 'checkErrors',
	                  //title: 'Important message',
	                  text: this.formerrors[0],
	                  closeOnClick: true,
	                  type:"warn"
	                });
	            }

	  
	        }
		},

	    created() {
	       this.loadServices();
	    }

	}

</script>

<style >
	.discountform .help-block.invalid-feedback {
	    color: #dc3545;
	}

	.applies_serv{
		position: relative;
	}
	.removeServ{
		position: absolute;right: -30px;
		top: 30px;
	}
</style>