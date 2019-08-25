<template>
	<div class="d-flex justify-content-center">
		<div class="col-lg-7 col-md-8">
			<div class="invoice-wrap">

				<div class="card_header mb-4">
	                <h3 class="font-weight-semibold mt-3 dark">Create invoices</h3>
	                 <router-link to="/invoices" class="mb-1 mt-1 mr-1 btn btn-warning pull-right list-add-button text-light" >
	                  <i class="fas fa-undo-alt"></i> View All Invoice
	                </router-link>
	              </div>

				<div class="invoice-body">
					<section>
			            <div class="row">
			                <div class="col-md-8">
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
			                <div class="col-md-4">
			                    <div class="form-group">
			                        <label for="date_due">Date due</label>
			                        <input type="date" class="form-control" v-model="form.due_date">
			                    </div>
			                </div>
			            </div>
			        </section>

			        <!-- service order -->
					<div class=" mt-3 mb-3 serviceOrder">
					   <table class="table section">
					      <thead>
					         <tr>
					            <th>Item</th>
					            <th style="width: 100px;">Price</th>
					            <th style="width: 100px;">Discount</th>
					            <th style="width: 130px;">Qty</th>
					         </tr>
					      </thead>
					      <tbody class="pb-3 pb-3 clearfix">
					         <tr>
					            <td>
					                <div class="form-group custom-size">
					                    <vue-single-select 
					                    placeholder="Select service" 
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
					                   
					                </div>
					               <div class="form-group" v-if="form.service != null">
					               	<input type="text" placeholder="Item name" class="form-control" v-if="form.service.id==0">
					               </div>
					               <div class="form-group"><textarea placeholder="Description" class="form-control"></textarea></div>
					            </td>
					            <td><input placeholder="0.00" type="tel" class="form-control"></td>
					            <td><input placeholder="0.00" type="tel" class="form-control"></td>
					            <td class="d-flex">
					               <input type="number" class="form-control d-flex-grow-1" value="1"> <!---->
					            </td>
					         </tr>
					      </tbody>
					   </table>
					   <div class="text-right mt-2"><a href="#">+ Add item</a></div>
					   <input type="hidden" name="invoice_items" value="[{&quot;service_id&quot;:0,&quot;quantity&quot;:1,&quot;amount&quot;:0,&quot;discount&quot;:0}]">
					</div>
			        <!-- service order end -->

					<section>
					   <div class="form-group mt-3 mb-5">
					      <label>Note to client</label>
					      <textarea class="form-control" rows="3" v-model="form.invoice_note"></textarea>
					   </div>
					   <div class="form-group">
					      <div class="custom-control custom-checkbox">
					         <input type="checkbox" v-model="form.send_email" value="1" id="send-email" class="custom-control-input">
					         <label class="custom-control-label" for="send-email">Send email notification</label>
					         <p class="help-block">If you don't notify the client they will still see the invoice in their account.</p>
					      </div>
					   </div>
					   <div class="form-group">
					      <div class="custom-control custom-checkbox">
					         <input type="checkbox" v-model="form.custom_currency" id="is-currency" value="1" class="custom-control-input" >
					         <label class="custom-control-label mb-3" for="is-currency">Custom currency</label>
					         <div class="form-inline " id="custom-currency" v-show="form.custom_currency==true">
					            <input type="text" name="currency" id="currency" class="form-control" placeholder="USD" value="">
					         </div>
					      </div>
					   </div>
					   <div class="text-right">
					      <button type="submit" class="btn btn-primary">
					      Add  invoice
					      </button>
					   </div>
					</section>


				</div><!-- /. invoice-hader -->

			</div>
		</div>
	</div>
</template>

<script>
	

export default{
	data(){
		return{
            // a: location.href,
            //invoiceData:{},
            users:[],
            services:[],
            form: new Form({
                client: '',
                due_date:'',
                service:[],
                invoice_note:'',
                send_email:'',
                custom_currency:'',
            }),
		}
	},

	methods:{
		isInvoceCratePage: function() {
		  return this.$route.path === '/invoices/create';
		},

		// goBack(){
		// 	this.$router.go(-1) //go back 1 step
		// },

        loadInvoiceData(){
            axios.get("/api/create-invoice").then(({ data }) => (this.users = data.users));
            axios.get("/api/create-invoice")
            .then((data)=>{

               //console.log(data.data.services);
               this.services = data.data.services;
               this.services.unshift({"id":0,"name":"Custom","price":0.00});

            }).catch(()=>{
              // shoe message if data not saved
            })
        },

	},

    created() {
       this.loadInvoiceData();
    }

}

</script>

<style >
	.invoice-body section {
	    background: #fff;
	    border-radius: .25rem;
	    padding: 2rem 2rem;
	    margin-bottom: 30px;
	}

	.custom-size .search-input {
	    padding: 10px 10px !important;
	}

	.serviceOrder table.table.section {
	    background: #fff;
	    padding-bottom: 3px;
	    /* display: flex; */
	    /* flex-direction: column; */
	    border-bottom: 1px solid #ddd;
	}
	.serviceOrder table.table.section thead {
	    background: #F8F9FA;
	}
	.vue-single-select {
	    width: 100%;
	}
</style>