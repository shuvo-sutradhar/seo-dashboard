<template>
	<div class="row">
		
		<div class="col-lg-8 col-xl-8 offset-lg-2">

			<div class="card-btn text-right mb-3">

                <router-link :to="`/clients`" class="btn btn-default">
                	<i class="fas fa-backward"></i> View all client
                </router-link>
		         <a class="float-right ml-3">
	                <button type="button" class="btn dropdown-toggle action-btn" data-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
	                <div class="dropdown-menu dropdown-menu-right" role="menu">

	                  <router-link :to="`/clients/${client.email}/edit`" class="dropdown-item text-1" v-if="$auth.isAdmin() || $auth.can('client-edit')">
		                 Edit client
		              </router-link>
                      <a class="dropdown-item text-1" href="#" @click="accessAccount(client.email)" v-if="$auth.isAdmin() || $auth.can('client-login')">
                         Sign in as user
                      </a>
	                  <a class="dropdown-item text-1" href="#"  @click="deleteData(client.id)" v-if="$auth.isAdmin() || $auth.can('client-delete')">Delete</a>
	                </div>
	              </a>
			</div>


			<div class="row">
				<div class="col-lg-4 mb-4 ">

					<div class="card">
						<div class="card-body client-profile">
							<div class="thumb-info mb-3">

								<img :src="getProfilePic(client.client  && client.client.profile_picture ? client.client.profile_picture : 'logged-user.jpg')" :alt="client.name" class="profile-img" style="width: 100%">
								<div class="thumb-info-title">
									<span class="thumb-info-inner">{{ client.name }}</span>
									<span class="thumb-info-type">Client</span>
								</div>
							</div>

							<div class="mb-0">
								<table class="table table-responsive-md mb-0 ">
									
									<tbody>

										<tr>
											<th>Total Order</th>
											<th class="text-right">
												{{ totalOrder ? totalOrder : '0' }}/-
											</th>
										</tr>
										<tr>
											<th>Total Spent</th>
											<th class="text-right">
												{{ totalSpent ? totalSpent : '0.00' }}$
											</th>
										</tr>
									</tbody>
								</table>
							</div>

							


						</div>
					</div>
				</div>

				<div class="col-lg-8">

					<div class="card-body mt-2">

						<table class="table table-responsive-md mb-0 client-profile-table">
								
							<tbody>
								<tr>
									<th>Name</th>
									<th class="text-right">{{ client.name }}</th>
								</tr>

								<tr>
									<th>Email</th>
									<th class="text-right">
										<a :href="client.email"> {{ client.email }}</a>
									</th>
								</tr>

								<tr>
									<th>Phone</th>
									<th class="text-right">
										<a :href="client.client && client.client.phone ? client.client.phone : '--'">{{ client.client && client.client.phone ?  client.client.phone : '--' }}</a>
									</th>
								</tr>

								<tr v-if="client.client && client.client.address">
									<th>Address</th>
									<th class="text-right">{{ client.client.address }}</th>
								</tr>

								<tr v-if="client.client && client.client.city">
									<th>City</th>
									<th class="text-right">{{ client.client.city }}</th>
								</tr>
								
								<tr v-if="client.client && client.client.country">
									<th>Country</th>
									<th class="text-right">{{ client.client.country.countryname }} </th>
								</tr>

								<tr v-if="client.client && client.client.post_code">
									<th>Post code</th>
									<th class="text-right">{{ client.client.post_code }}</th>
								</tr>

								<tr v-if="client.client && client.client.company_name">
									<th>Company name</th>
									<th class="text-right">{{ client.client.company_name }}</th>
								</tr>

								<tr v-if="client.client && client.client.tax_id">
									<th>Tax Id</th>
									<th class="text-right">{{ client.client.tax_id }}</th>
								</tr>
								<tr>
									<th>Created at</th>
									<th class="text-right">
										{{ client.created_at | dateFormat }}
									</th>
								</tr>
							</tbody>
						</table>

					</div>
				</div>
			</div>

			<div class="card mt-4">
				
				<div class="card-body" v-if="orders.data.length > 0">
					<h3>Order(s) {{ orders.data.length }}</h3>

					<table class="table table-responsive-md mb-0">
						<thead>
							<tr>
								<th>#</th>
								<th>ORDER ID</th>
								<th>SERVICE</th>
								<th>ORDER DATE</th>
								<th class="text-right">STATUS</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(order, index) in orders.data">
								<td>{{ ++index }}</td>
								<td>{{ order.order_number }}</td>
								<td>
									{{ order.quantity }} x {{ order.order_service.name }} (${{ order.order_service.price }})
								</td>
								<td>{{ order.created_at | dateFormat }}</td>
								<td class="text-right">
									<button type="button" class="btn btn-success btn-sm">{{ order.order_status }}</button>
								</td>
							</tr>
                          
						</tbody>
					</table>
					
				</div>
			</div>

			<div class="card mt-4">
				
				<div class="card-body" v-if="invoices.data.length > 0">
					<h3>Invoice(s) {{ invoices.data.length }}</h3>

					<table class="table table-responsive-md mb-0">
						<thead>
							<tr>
								<th>#</th>
								<th>INVOICE NUMBER</th>
								<th>DATE</th>
								<th>TOTAL</th>
								<th class="text-right">STATUS</th>
							</tr>
						</thead>
						<tbody>
							
							<tr v-for="(invoice, index) in invoices.data">
								<td>{{ ++index }}</td>
								<td>{{ invoice.invoice_number }}</td>
								
								<td>{{ invoice.created_at | dateFormat }}</td>
								<td>$ {{ invoice.invoice_total }}</td>
								<td class="text-right">
									<button type="button" class="btn btn-success btn-sm">{{ invoice.invoice_status }}</button>
								</td>
							</tr>
							
						</tbody>
					</table>
					
				</div>
			</div>


		</div>

	</div>

</template>



<script>
	

export default{
	data(){
		return{

            client:'',
            orders:'',
            invoices:'',
            totalOrder:'',
            totalSpent:'',

		}
	},

	methods:{

        //acceess client account
        accessAccount(clientEmail) {
          this.$Progress.start();
          axios.post('/accounts-access', {
            email: clientEmail
          })
          .then((data)=>{
              this.$Progress.finish();

              window.location.href = window.location.origin+"/home/";

            }).catch(()=>{
                this.$Progress.fail()
            })
        },

        //delete data
        deleteData(id){
            
            var url = window.location.origin+'/api/clients/'+id;

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                // Send request to the server
                 if (result.value) {
                        axios.delete(url).then(()=>{
                                Swal.fire(
                                'Deleted!',
                                'Your item has been deleted successfully.',
                                'success'
                                )

                            this.$router.push('/clients')
                            Fire.$emit('AfterDelete');
                        }).catch(()=> {
                            Swal.fire("Opps!", "Something is wrong.", "warning");
                        });
                 }
            })

        },

		/*
		*  Get profile picture
		*/
		getProfilePic(avatar){
              return window.location.origin+"/uploads/profile_pic/"+avatar;
        },
		
		/*
		*  Load Data
		*/
        loadData(){
            axios.get(`/api/clients/${this.$route.params.email}`).then(({ data }) => (this.data = data));
            axios.get(`/api/clients/${this.$route.params.email}`)
            .then((data)=>{

               //console.log(data.data.services);
               this.client = data.data.user;
               this.orders = data.data.orders;
               this.invoices = data.data.invoices;
               this.totalOrder = data.data.totalOrder;
               this.totalSpent = data.data.totalSpent;

            }).catch(()=>{
              // shoe message if data not saved
            })
        },

	},

    created() {
       this.loadData();
    }

}

</script>


<style type="text/css">
	.action-btn {
	    top: 0px;
	    background: #fff;
	    border: 1px solid #ddd;
	}
</style>