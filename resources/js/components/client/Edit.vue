<template>
	<div class="d-flex justify-content-center">
		<div class="col-lg-7 col-md-8">
			<div class="invoice-wrap">

				<div class="card_header mb-4">
	                <h3 class="font-weight-semibold mt-3 dark">Edit client information</h3>
	                 <router-link to="/clients" class="mb-1 mt-1 mr-1 btn btn-warning pull-right list-add-button text-light" >
	                  <i class="fas fa-undo-alt"></i> View All client
	                </router-link>
	              </div>

				<div class="invoice-body">

				<form @submit.prevent="updateClient" class="client-form">
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
									<input type="email" v-model="form.email" class="form-control" id="email" disabled :class="{ 'is-invalid': form.errors.has('email') }">
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
			                    <div class="profileImg" v-if="form.profile_picture">
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
					                    placeholder="Select country" 
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
			                        <label for="postCode">Postal / Zip Code </label>
									<input type="text" v-model="form.postCode" class="form-control" id="postCode"/>
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
                                        <input type="text" id="Tax" class="form-control" v-model="form.taxId" />
                                    </div>
                                </div>
                            </div>

			                <div class="col-md-12 mb-3">
			                    <div class="form-group custom-size">
			                        <label for="password">Reset Password </label>
									<input type="password" v-model="form.password" class="form-control" id="password" autocomplete="new-password"/>
			                    </div>
			                </div>

                            <div class="col-md-12 mb-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" id="action-3" class="custom-control-input" v-model="form.emailNotification"> 
                                    <label for="action-3" class="custom-control-label">Reset password and send welcome email</label>
                                </div>
                            </div>

                            <div class="col-md-12">
								<div class="text-right">
									<button type="submit" class="btn btn-primary">
								      	Edit client
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
            	postCode:'',
            	iscompany:'',
            	companyName:'',
            	taxId:'',
            	password:'',
            	emailNotification:'',
            }),
		}
	},

	methods:{

		/*
		*  edit data
		*/
		updateClient(){
			//update client
            this.$Progress.start();

            this.form.patch(`/api/clients/${this.$route.params.email}`)
            .then(()=>{

              this.$Progress.finish();
              toast.fire({
                type: 'success',
                title: 'Client Updated Successfuly.'
              })
              //this.$router.push('/working-hour')
              
            }).catch(()=>{
              // shoe message if data not saved
                this.$Progress.fail()
            })
		},

		/*
		*  getProfilePhoto
		*/
        getProfilePhoto(){

             let prefix = (this.form.profile_picture.match(/\//) ? '' : '../../uploads/profile_pic/');
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
        loadData(){

           axios.get("/api/clients_get_country").then(({ data }) => (this.countries = data));
	       axios.get(`/api/clients-edit/${this.$route.params.email}`)
	        .then((response)=>{
        		//console.log(response.data.id);
	            //this.form.fill(response.data)
        		this.form.name = response.data.name;
        		this.form.email = response.data.email;

            	this.form.phone = response.data.client ? response.data.client.phone : '';
            	this.form.profile_picture = response.data.client ? response.data.client.profile_picture : '';
            	this.form.address = response.data.client ? response.data.client.address : '';
            	this.form.country = response.data.client ? response.data.client.country : '';
            	this.form.state = response.data.client ? response.data.client.state : '';
            	this.form.city = response.data.client ? response.data.client.city : '';
            	this.form.postCode = response.data.client ? response.data.client.post_code : '';
            	this.form.iscompany = response.data.client && response.data.client.company_name ? true : false;
            	this.form.companyName = response.data.client ? response.data.client.company_name : '';
            	this.form.taxId = response.data.client ? response.data.client.tax_id : '';
	        })     

		}


	},

    created() {
       this.loadData();

    }

}

</script>


<style type="text/css">
	.client-form .help-block {
	    margin-top: 3px;
	    color: #dc3545;
	}
</style>