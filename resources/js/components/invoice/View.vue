<template>
	<div class="d-flex justify-content-center custome-invoice">
		<section class=" card" ref="formContainer">
			<div class="card-btn text-right mb-3">
		         <a href="#" class="btn btn-default">Download</a>
		         <a href="pages-invoice-print.html" target="_blank" class="btn btn-default ml-3"><i class="fas fa-print"></i> Print</a>
		         <a class="float-right ml-3">
	                <button type="button" class="btn dropdown-toggle action-btn" data-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
	                <div class="dropdown-menu dropdown-menu-right" role="menu">
	                  <a class="dropdown-item text-1" href="#" @click="sendInvoice(invoiceData.id)">Email Invoice</a>
	                  <span v-if="$auth.isAdmin() || $auth.can('invoice-edit')">
	                      <router-link :to="`/invoices/edit/${invoiceData.invoice_number}`" class="dropdown-item text-1">
	                        Edit Invoice
	                      </router-link>
		                  <a class="modal-with-move-anim dropdown-item text-1" href="#modalAnim">Edit Address</a>
	                  </span>
	                  <span v-if="$auth.isAdmin() || $auth.can('invoice-charge')">
		                  <a class="dropdown-item text-1" href="#" v-if="invoiceData.invoice_status=='unpaid'" @click="makeAsPaid(invoiceData.id)">Make as paid</a>
		                  <a class="dropdown-item text-1" href="#" v-if="invoiceData.invoice_status=='unpaid'">Charge Now</a>
		                  <a class="dropdown-item text-1" href="#" v-if="invoiceData.invoice_status=='paid'">Refund</a>
		              </span>
	                  <a class="dropdown-item text-1" href="#"  @click="deleteData(invoiceData.id)" v-if="$auth.isAdmin() || $auth.can('invoice-delete')">Delete</a>
	                </div>
	              </a>
			</div>
		    <div class="card-body">
		      <div class="invoice">
		         <header class="clearfix">
		            <div class="row">
		               <div class="col-sm-6 mt-3">
		                  <h2 class="h2 mt-0 mb-1 text-dark font-weight-bold">INVOICE</h2>
		                  <h4 class="h4 m-0 text-dark font-weight-bold">#{{this.$route.params.invoice_number}}</h4>
		               </div>
		               <div class="col-sm-6 text-right mt-3 mb-3">

		                  <address class="ib mr-5">
		                     {{ generalSetting.length != 0 ? generalSetting[0].value : '' }}
		                     <br>
		                     {{ generalSetting.length != 0 ? generalSetting[5].value : '' }}
		                     <br>
		                     Phone:{{ generalSetting.length != 0 ? generalSetting[4].value : '' }}
		                     <br>
		                     {{ generalSetting.length != 0 ? generalSetting[3].value : '' }}
		                  </address>
		                  <div class="ib">
		                     <img src="http://35.183.250.34/uploads/company_logo/1550777953.png" style="width: 100px" alt="">
		                  </div>
		               </div>
		            </div>
		         </header>
		         <div class="bill-info">
		            <div class="row">
		               <div class="col-md-6">
		                  <div class="bill-to">
		                     <p class="h5 mb-1 text-dark font-weight-semibold">To:</p>
		                     <address>
		                        <p>{{ invoiceData.invoice_bill ? invoiceData.invoice_bill.first_name : ''}}</p>
		                        <p>{{ invoiceData.invoice_bill ? invoiceData.invoice_bill.address : ''}}</p>
		                        <p> {{ invoiceData.invoice_bill && invoiceData.invoice_bill.phone != null ? 'Phone:'+invoiceData.invoice_bill.phone : ''}}</p>
		                        <p>{{ invoiceData.invoice_bill ? invoiceData.invoice_bill.email : ''}}</p>
		                     </address>
		                  </div>
		               </div>
		               <div class="col-md-6">
		                  <div class="bill-data text-right">
		                     <p class="mb-0">
		                        <span class="text-dark">Invoice Status: </span>
		                        <span class="value">{{ invoiceData.invoice_status }}</span>
		                     </p>
		                     <p class="mb-0">
		                        <span class="text-dark">Invoice Date:</span>
		                        <span class="value">{{invoiceData.created_at | dateFormat}}</span>
		                     </p>
		                     <p class="mb-0" v-show="invoiceData.due_date!=null">
		                        <span class="text-dark">Due Date:</span>
		                        <span class="value">{{invoiceData.due_date | dateFormat}}</span>
		                     </p>
		                  </div>
		               </div>
		            </div>
		         </div>
		         <table class="table table-responsive-md invoice-items">
		            <thead>
		               <tr class="text-dark">
		                  <th id="cell-id" class="font-weight-semibold">#</th>
		                  <th id="cell-item" class="font-weight-semibold">Item</th>
		                  <th id="cell-desc" class="font-weight-semibold">Description</th>
		                  <th id="cell-price" class="text-center font-weight-semibold">Price</th>
		                  <th id="cell-qty" class="text-center font-weight-semibold">Quantity</th>
		                  <th id="cell-total" class="text-center font-weight-semibold">Total</th>
		               </tr>
		            </thead>
		            <tbody>
		               <tr v-for="(data, index) in invoiceItems">
		                  <td>{{index+1}}</td>
		                  <td class="font-weight-semibold text-dark">{{data.invoice_service.name}}</td>
		                  <td>{{data.invoice_service.description}}</td>
		                  <td class="text-center">
		                  	<span v-if="data.discount==null">
		                  		${{data.invoice_service.price}}
		                  	</span>
		                  	<span v-else>
		                  		<strike>${{data.invoice_service.price}}</strike><br>
		                  		${{data.invoice_service.price - data.discount}}
		                  	</span>
		                  	
		                  </td>
		                  <td class="text-center">{{data.quantity}}</td>
		                  <td class="text-center">
		                  	<span v-if="data.discount==null">
		                  		${{data.quantity * data.invoice_service.price}}
		                  	</span>
		                  	<span v-else>
		                  		${{(data.invoice_service.price - data.discount) * data.quantity}}
		                  	</span>
		                  	
		                  </td>
		               </tr>
		            </tbody>
		         </table>
		         <div class="invoice-summary">
		            <div class="row justify-content-end">
		               <div class="col-sm-4">
		                  <table class="table h6 text-dark">
		                     <tbody>
		                        <tr class="h4 b-top-0">
		                           <td colspan="2">Grand Total</td>
		                           <td class="text-center">${{invoiceData.invoice_total}}</td>
		                        </tr>
		                     </tbody>
		                  </table>
		               </div>
		            </div>
		         </div>
		      </div>
		    </div>
		</section>
		<Address :addresses="invoiceData.invoice_bill"></Address>
	</div>
</template>

<script>

	import Address from './Address';

	export default{
		data(){
			return{
				fullPage: false,
				invoiceData:'',
				generalSetting:'',
				invoiceItems:'',
	  
			}
		},

		methods:{

			loadInvoiceData() {

	           let loader = this.$loading.show({
	              // Optional parameters
	              container: this.fullPage ? null : this.$refs.formContainer,
	              canCancel: true,
	              onCancel: this.onCancel,
	            });


			    axios.get('/api/invoices/'+this.$route.params.invoice_number)
			      .then((response)=>{
			        this.invoiceData = response.data.invoice;
			        this.invoiceItems = response.data.invoice_item;
			        this.generalSetting = response.data.generalSetting;
			    });

	            // simulate AJAX
	            setTimeout(() => {
	              loader.hide()
	            },1000)
			},

		    /*
			* Delete Data
		    */
		    deleteData(id){

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
	                this.$Progress.start();
	                 if (result.value) {
	                        axios.delete('/api/invoices/'+id).then(()=>{
	                                Swal.fire(
	                                'Deleted!',
	                                'Your item has been deleted successfully.',
	                                'success'
	                            )

	                  			this.$Progress.finish();
	                        	this.$router.push('/invoices');
	                        }).catch(()=> {
	                            Swal.fire("Opps!", "Something is wrong.", "warning");
	                    		this.$Progress.fail()
	                        });
	                 }
	            })

		    },

		    /*
			* Make as paid
		    */
		    makeAsPaid(id){
		    	// invoice-paid
	            this.$Progress.start();
	            axios.put('/api/invoice-paid/'+id)
	            .then((response)=>{

	              this.$Progress.finish();
	              toast.fire({
	                    type: 'success',
	                    title: 'Invoice has beed paid.'
	                  })

	              Fire.$emit('AfterUpdate');

	            }).catch(()=>{
	                this.$Progress.fail()
	            })
		    },

		    /*
			* Send invoice via email
		    */
		    sendInvoice(id){
		    	console.log(id);
		    	// invoice-paid
	            this.$Progress.start();
	            axios.get('/api/invoice-email/'+id)
	            .then((response)=>{

	              this.$Progress.finish();
	              toast.fire({
	                    type: 'success',
	                    title: 'Invoice has been sent successfully.'
	                  })

	            }).catch(()=>{
	                this.$Progress.fail()
	            })
		    }


	    },

	    mounted() {

	       this.loadInvoiceData();
	        Fire.$on('AfterUpdate',() => {
	           this.loadInvoiceData();
	        });

	    },

		components: {Address}

	}
</script>


<style type="text/css">
	.custome-invoice .invoice .bill-data .value{
	    width: auto;
	}

	.custome-invoice .bill-data p {
	    font-size: 23px;
    	line-height: 35px;
	}

	.custome-invoice .action-btn {
	    top: 0px;
	    background: #fff;
	    border: 1px solid #ddd;
	}

	.invoice address p {
	    margin-bottom: 0px;
	}
</style>