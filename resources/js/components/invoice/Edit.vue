<template>
	<div class="d-flex justify-content-center">
		<div class="col-lg-7 col-md-8">
			<div class="invoice-wrap">

				<div class="card_header mb-4">
	                <h3 class="font-weight-semibold mt-3 dark">Edit invoices</h3>
	                 <router-link to="/invoices" class="mb-1 mt-1 mr-1 btn btn-warning pull-right list-add-button text-light" >
	                  <i class="fas fa-undo-alt"></i> View All Invoice
	                </router-link>
	              </div>

				<div class="invoice-body">

				<form @submit.prevent="addInvoice">
					<section>
			            <div class="row w-100">
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
			                        <!-- <input type="date" class="form-control" v-model="form.due_date"> -->			                        <date-pick v-model="form.due_date" :pickTime="true" :format="'YYYY-MM-DD HH:mm'" class="custom-calender"></date-pick>
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
					            <th style="width: 100px;">Discount(%)</th>
					            <th style="width: 130px;">Qty</th>
					         </tr>
					      </thead>
					      <tbody class="pb-3 pb-3 clearfix">
					         <tr v-for="(item, index) in form.items">
					            <td>
					                <div class="form-group custom-size">
					                    <vue-single-select 
					                    placeholder="Select service" 
					                    you-want-to-select-a-post="id" 
					                    v-model="item.invoice_service" 
					                    out-of-all-these-posts="makes sense" 
					                    :options="services" 
					                    you-like-bootstrap="yes" 
					                    a-post-has-an-id="id" 
					                    option-value="id" 
					                    the-post-has-a-title="make sure to show these" 
					                    option-label="name" 
					                    class="vue-single-select">
					                  </vue-single-select>
					                   
					                </div>
					               <div class="form-group" v-if="item.invoice_service != null">
					               		<input type="text" placeholder="Item name" class="form-control" v-model="item.invoice_service.name" v-if="item.invoice_service.id==0">
					               </div>
					               <div class="form-group"><textarea placeholder="Description" class="form-control" v-model="item.description"></textarea></div>
					            </td>
					            <td>
					            	<input v-if="item.invoice_service != null && item.invoice_service.id==0" placeholder="0.00" type="text" class="form-control" v-model="item.servicePrice">
					            	<input v-if="item.invoice_service != null && item.invoice_service.id!=0" type="text" class="form-control" :value="item.invoice_service.price">
					            	<input v-if="item.invoice_service== null" type="text" class="form-control" placeholder="0.00">
					            </td>
					            <td><input placeholder="0.00" type="text" class="form-control"  v-model="item.serviceDiscount"></td>
					            <td class="d-flex">
					               <input type="number" class="form-control d-flex-grow-1" v-model="item.quantity"> 
					               <button v-if="form.items.length>1" type="button" data-delete="" class="btn btn-sm removeServ" @click="deleteItem(index)"><i class="fas fa-trash"></i></button>
					            </td>
					         </tr>
					      </tbody>
					   </table>
					   <div class="text-right mt-2"><a style="cursor: pointer;color: #2ec3a1;" @click="addNewItem" >+ Add item</a></div>
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
					      	Add invoice
					      </button>
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

            // a: location.href,
            //invoiceData:{},
            invoice:'',
            errors:[],
            users:[],
            services:[],
            form: new Form({
                client: '',
                due_date:'',
                invoice_note:'',
                items:[],
                send_email:'',
                custom_currency:'',
            }),
		}
	},

	methods:{


		/*
		*  addNewItem
		*/
		addNewItem: function () {
		 	this.form.items.push({
                selectedService:null,
                serviceName: '',
                servicePrice:0 ,
                serviceDiscount:0,
                serviceQty:1,
                description:''
		 	})
		},

		/*
		*  Load Invoice Data
		*/
        loadInvoiceData(){
            axios.get("/api/invoices/edit/"+this.$route.params.invoice_number)
            .then((data)=>{

               //console.log(data.data.services);
               this.invoice = data.data.invoice;
               this.users = data.data.users;
               this.services = data.data.services;
               this.services.unshift({"id":0,"name":"Custom","price":0.00});
               //push invoice data
               this.form.client = data.data.invoice.invoice_client;
               this.form.due_date = data.data.invoice.due_date;
               this.form.invoice_note = data.data.invoice.invoice_note;
               this.form.send_email = data.data.invoice.send_email;
               this.form.custom_currency = data.data.invoice.custom_currency;
			   this.form.items = data.data.invoice_item;
            }).catch(()=>{
              // shoe message if data not saved
            })
        },


        /*
		* Submit Invoice Data
        */
        addInvoice() {

            this.errors = [];

        	for (var i = 0; i < this.form.items.length; i++) {
        		if(this.form.items[i].selectedService == null){
        			this.errors.push('Select service field is required.')
        		} 

        		if(this.form.items[i].selectedService != null && this.form.items[i].selectedService.id==0){
        			if(!this.form.items[i].serviceName){
        				this.errors.push('Item name field is required.')
        			}
        			if(!this.form.items[i].servicePrice){
        				this.errors.push('Item price field is required.')
        			}
        		}

        	}

            // if there have no error then the form will be submit
            this.$Progress.start();
            if(this.errors.length === 0) {

	            this.form.post('/api/invoices')
	            .then((order)=>{

	              $.magnificPopup.close();
	              
	              this.$Progress.finish();
	              toast.fire({
	                type: 'success',
	                title: 'Order created successfully.'
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
                  text: this.errors[0],
                  closeOnClick: true,
                  type:"warn"
                });
            }
        }
	},

    created() {
       this.loadInvoiceData();
      
    }

}

</script>

<style >
	.removeServ {
	    margin-left: 14px;
	}
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