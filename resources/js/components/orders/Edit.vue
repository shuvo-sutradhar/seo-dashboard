<template>
	<div class="d-flex justify-content-center">
		<div class="col-lg-7 col-md-8">
			<div class="invoice-wrap">

				<div class="card_header mb-4">
	                <h3 class="font-weight-semibold mt-3 dark">Edit Order</h3>
	                <router-link :to="`/orders/order/${this.$route.params.order_number}`" class="mb-1 mt-1 mr-1 btn btn-warning pull-right list-add-button text-light" >
	                  <i class="fas fa-undo-alt"></i> View this order
	                </router-link>
	              </div>

				<div class="invoice-body">
					<form @submit.prevent="editOrder">
						<section>
				            <div class="row w-100">
				                <div class="col-md-6 mb-4">
				                    <div class="form-group">
				                        <label for="date_due">Date added</label>
				                        <date-pick v-model="form.created_at" :pickTime="true" :format="'YYYY-MM-DD HH:mm'" class="custom-calender"></date-pick>
				                    </div>
				                </div>
				                <div class="col-md-6 mb-4">
				                    <div class="form-group">
				                        <label for="date_due">Date due</label>
				                        <date-pick v-model="form.due_date" :pickTime="true" :format="'YYYY-MM-DD HH:mm'" class="custom-calender"></date-pick>
				                    </div>
				                </div>
				                <div class="col-md-6 mb-4">
				                    <div class="form-group">
				                        <label for="date_due">Date started</label>
				                        <date-pick v-model="form.started_at" :pickTime="true" :format="'YYYY-MM-DD HH:mm'" class="custom-calender"></date-pick>
				                    </div>
				                </div>
				                <div class="col-md-6 mb-4">
				                    <div class="form-group">
				                        <label for="date_due">Date completed</label>
				                        <date-pick v-model="form.completed_at" :pickTime="true" :format="'YYYY-MM-DD HH:mm'" class="custom-calender"></date-pick>
				                    </div>
				                </div>
				                <div class="col-md-12 mb-4">
				                    <div class="form-group custom-size">
				                        <label for="user_id">Service</label>
										<vue-single-select 
						                    placeholder="Select client" 
						                    you-want-to-select-a-post="id" 
						                    v-model="form.service" 
						                    out-of-all-these-posts="makes sense" 
						                    :options="services" 
						                    you-like-bootstrap="yes" 
						                    a-post-has-an-id="id" 
						                    option-value="id" 
						                    the-post-has-a-title="make sure to show these" 
						                    option-label="name" 
						                    class="vue-single-select" :class="{ 'is-invalid': form.errors.has('client') }">
						                  </vue-single-select>
						                  <has-error :form="form" field="client"></has-error>
				                    </div>
				                </div>
				                <div class="col-md-12 mb-4">
				                    <div class="form-group custom-size">
				                        <label for="user_id">Client</label>
										<vue-single-select 
						                    placeholder="Select client" 
						                    you-want-to-select-a-post="id" 
						                    v-model="form.client" 
						                    out-of-all-these-posts="makes sense" 
						                    :options="users" 
						                    you-like-bootstrap="yes" 
						                    a-post-has-an-id="id" 
						                    option-value="id" 
						                    the-post-has-a-title="make sure to show these" 
						                    option-label="name" 
						                    class="vue-single-select" :class="{ 'is-invalid': form.errors.has('client') }">
						                  </vue-single-select>
						                  <has-error :form="form" field="client"></has-error>
				                    </div>
				                </div>
				                <div class="col-md-12 text-right">
				                	<button type="submit" class="btn btn-primary">Edit order</button>
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
	            users:[],
	            services:[],
	            form: new Form({
	                created_at: '',
	                due_date: '',
	                started_at: '',
	                completed_at: '',
	                service:'',
	                client:'',
	            }),
			}

		},

		methods:{

			/*
			*  edit data
			*/
			editOrder(){
                this.form.patch(`/api/update-order/${this.$route.params.order_number}`)
                .then(()=>{

                  toast.fire({
                    type: 'success',
                    title: 'Order Updated Successfuly.'
                  })
                  //this.$router.push('/working-hour')
                  
                }).catch(()=>{
                  // shoe message if data not saved
                })
			},

			
			/*
			*  Load Order Data
			*/
	        loadOrderData(){

		        axios.get(`/api/edit-order/${this.$route.params.order_number}`)
	            .then((data)=>{

	               this.users = data.data.users;
	               this.services = data.data.services;
	               //console.log(data.data.services);
	               this.form.created_at = data.data.order.created_at;
	               this.form.started_at = data.data.order.strated_at;
	               this.form.completed_at = data.data.order.completed_at;
	               this.form.service = data.data.order.order_service;
	               this.form.client = data.data.order.order_client;
	               this.form.due_date =  data.data.order.invoice.due_date ? data.data.order.invoice.due_date : null;

	            }).catch(()=>{
	              // shoe message if data not saved
	            })
	        },

		},

	    created() {
	       this.loadOrderData();
	    }

	}

</script>


<style type="text/css">

	.vdpComponent {
	    width: 100%;
	    display: block;
	}
	.vdpComponent.vdpWithInput>input {
	    width: 100%;
	    display: block;
	    border-radius: 4px;
	    padding: 10px;
	    border: 1px solid #ced4da;
	}
</style>