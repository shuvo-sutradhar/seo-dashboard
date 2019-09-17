<template>
	<div class="d-flex justify-content-center">
		<div class="col-lg-7 col-md-8">
			<div class="invoice-wrap">

				<div class="card_header mb-4">
	                <h3 class="font-weight-semibold mt-3 dark">Add new client</h3>
	                 <router-link to="/clients" class="mb-1 mt-1 mr-1 btn btn-warning pull-right list-add-button text-light" >
	                  <i class="fas fa-undo-alt"></i> View All client
	                </router-link>
	              </div>

				<div class="invoice-body">

				<form @submit.prevent="addClient">
					<section>
			            <div class="row w-100">
			                <div class="col-md-12 mb-3">
			                    <div class="form-group custom-size">
			                        <label for="name">Name <span>*</span></label>
									<input type="text" v-model="form.name" class="form-control" id="name" :class="{ 'is-invalid': form.errors.has('name') }">
                  					<has-error :form="form" field="name"></has-error>
			                    </div>
			                </div>
			                <div class="col-md-12 mb-3">
			                    <div class="form-group custom-size">
			                        <label for="email">Email <span>*</span></label>
									<input type="email" v-model="form.email" class="form-control" id="email" :class="{ 'is-invalid': form.errors.has('email') }">
                  					<has-error :form="form" field="email"></has-error>
			                    </div>
			                </div>
			                <div class="col-md-12 mb-3">
			                    <div class="form-group custom-size">
			                        <label for="phone">Phone</label>
									<input type="text" v-model="form.phone" class="form-control" id="phone" :class="{ 'is-invalid': form.errors.has('phone') }">
                    				<has-error :form="form" field="phone"></has-error>
			                    </div>
			                </div>
			                <div class="col-md-12 mb-3">
			                    <div class="form-group custom-size">
			                        <label for="picture">Profile Picture</label>
			                        <input type="file" v-on:change="uploadPhoto" name="profile_picture" class="form-control" :class="{ 'is-invalid': form.errors.has('profile_picture') }">
                    				<has-error :form="form" field="profile_picture"></has-error>
			                    </div>
			                    <div class="profileImg" v-if="form.profile_picture!=''">
			                    	<img :src="getProfilePhoto()" width="100px">
			                    </div>
			                </div>
			          
			            </div>
			        </section>

			        <h3>Billing information</h3>
			        <section>
			        	<div class="row w-100">
			                <div class="col-md-12 mb-3">
			                    <div class="form-group custom-size">
			                        <label for="address">Address </label>
									<input type="text" v-model="form.address" class="form-control" id="address" :class="{ 'is-invalid': form.errors.has('address') }">
                    				<has-error :form="form" field="address"></has-error>
			                    </div>
			                </div>
			                <div class="col-md-6 mb-3">
			                    <div class="form-group custom-size">
			                        <label for="country">Country </label>
									<vue-single-select 
					                    placeholder="Select client" 
					                    you-want-to-select-a-post="id" 
					                    v-model="form.country" 
					                    out-of-all-these-posts="makes sense" 
					                    :options="countries" 
					                    you-like-bootstrap="yes" 
					                    a-post-has-an-id="id" 
					                    option-value="id" 
					                    the-post-has-a-title="make sure to show these" 
					                    option-label="countryname" 
					                    class="vue-single-select" :class="{ 'is-invalid': form.errors.has('client') }">
					                  </vue-single-select>
					                  <has-error :form="form" field="client"></has-error>
			                    </div>
			                </div>
			                <div class="col-md-6 mb-3">
			                    <div class="form-group custom-size">
			                        <label for="state">State </label>
									<input type="text" v-model="form.state" class="form-control" id="state"/>
			                    </div>
			                </div>
			                <div class="col-md-6 mb-3">
			                    <div class="form-group custom-size">
			                        <label for="city">City </label>
									<input type="text" v-model="form.city" class="form-control" id="city"/>
			                    </div>
			                </div>
			                <div class="col-md-6 mb-3">
			                    <div class="form-group custom-size">
			                        <label for="postal_code">Postal / Zip Code </label>
									<input type="text" v-model="form.postal_code" class="form-control" id="postal_code"/>
			                    </div>
			                </div>

                            <div class="col-md-12 mb-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" id="action-2" class="custom-control-input" v-model="form.iscompany"> 
                                    <label for="action-2" class="custom-control-label">I'm purchasing for a company</label>
                                </div>
                            </div>

                            <div class="col-md-12 mb-3" v-if="form.iscompany==true">
                                <div class="row">
                                    <div class="col-md-6">

			                        	<label for="Company">Company</label>
                                        <input type="text" class="form-control" v-model="form.companyName" id="Company" />
                                    </div>
                                    <div class="col-md-6">
			                        	<label for="Tax">Tax ID(Optional)</label>
                                        <input type="text" name="name" id="Tax" class="form-control" v-model="form.taxId" />
                                    </div>
                                </div>
                            </div>

			                <div class="col-md-12 mb-3">
			                    <div class="form-group custom-size">
			                        <label for="password">Password </label>
									<input type="password" v-model="form.password" class="form-control" id="password" autocomplete="new-password"/>
									<small>Default password is: 123456</small>
			                    </div>
			                </div>

                            <div class="col-md-12 mb-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" id="action-3" class="custom-control-input" v-model="form.emailNotification"> 
                                    <label for="action-3" class="custom-control-label">Send welcome email</label>
                                </div>
                            </div>

                            <div class="col-md-12">
								<div class="text-right">
									<button type="submit" class="btn btn-primary">
								      	Add client
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

            countries:[],
            form: new Form({
            	name:'',
            	email:'',
            	phone:'',
            	profile_picture:'',
            	address:'',
            	country:'',
            	state:'',
            	city:'',
            	postal_code:'',
            	iscompany:'',
            	companyName:'',
            	taxId:'',
            	password:'123456',
            	emailNotification:'',
            }),
		}
	},

	methods:{

		/*
		*  getProfilePhoto
		*/
        getProfilePhoto(){

             // let prefix = (this.form.profile_picture.match(/\//) ? '' : '../uploads/profile_pic/');
             let prefix = (this.form.profile_picture.match(/\//) ? '' : '');
             return prefix + this.form.profile_picture;

        },
        uploadPhoto(e){
            let file = e.target.files[0];
            let reader = new FileReader();

            //check file size
            if(file['size'] < 2111775) {
                reader.onloadend = (file) => {
                    //console.log('RESULT', reader.result)
                    this.form.profile_picture = reader.result;
                }
                reader.readAsDataURL(file)
                console.log("ok");
            } else {
                Swal.fire({
                    title: 'Oops...',
                    text: "Something is wrong",
                    type: 'error',
                })
            }
        },
		/*
		*  Load Invoice Data
		*/
        loadAllCountry(){
            axios.get("/api/clients_get_country").then(({ data }) => (this.countries = data));
        },

        /*
		* Submit client info
        */
        addClient() {


            // if there have no error then the form will be submit
            this.$Progress.start();

            this.form.post('/api/clients')
            .then((order)=>{
              
              this.$Progress.finish();
              toast.fire({
                type: 'success',
                title: 'Client created successfully.'
              })
              //console.log();
              //window.location.href = "../orders/"+order.data.order.order_number;

              //this.$router.push('/orders/order/'+order.data.order.order_number);
            }).catch(()=>{
                this.$Progress.fail()
            })


        }


	},

    created() {
       this.loadAllCountry();
    }

}

</script>


<style type="text/css">
	.help-block {
	    margin-top: 3px;
	    color: #dc3545;
	}
</style>