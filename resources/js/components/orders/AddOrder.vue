<template>

      <!-- Modal Animation -->
      <div id="modalAnim" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
        <section class="card">
    			<form id="selects-form" @submit.prevent="formSubmit">
    	          <header class="card-header">
    	            <h2 class="card-title">Add order</h2>
    	          </header>
    	          <div class="card-body">
    	          	<div class="alert alert-warning">
    		            Adding an order manually will not trigger any notifications or payments. To add a paid order you can <a :href="'/invoices/create'">create a new invoice</a> and mark it as paid.
    		        </div>
    	            <div class="modal-wrapper">
    						<div class="form-group add-order">
    							<label class="control-label">Client</label>
    							<div>
                      <vue-single-select 
                        placeholder="Select client" 
                        you-want-to-select-a-post="id" 
                        v-model="form.client" 
                        out-of-all-these-posts="makes sense" 
                        :options="orderData.users" 
                        you-like-bootstrap="yes" 
                        a-post-has-an-id="id" 
                        option-value="id" 
                        the-post-has-a-title="make sure to show these" 
                        option-label="name" 
                        class="form-control vue-single-select" :class="{ 'is-invalid': form.errors.has('client') }">
                      </vue-single-select>
                      <has-error :form="form" field="client"></has-error>
    							</div>
    						</div>
    						<div class="form-group add-order">
    							<label class="control-label">Service</label>
                      <div>
                        <vue-single-select 
                          placeholder="Select service" 
                          you-want-to-select-a-post="id" 
                          v-model="form.service" 
                          out-of-all-these-posts="makes sense" 
                          :options="orderData.services" 
                          you-like-bootstrap="yes" 
                          a-post-has-an-id="id" 
                          option-value="id" 
                          the-post-has-a-title="make sure to show these" 
                          option-label="name" 
                          class="form-control vue-single-select" :class="{ 'is-invalid': form.errors.has('service') }">
                        </vue-single-select>
                        <has-error :form="form" field="service"></has-error>
                      </div>
    						</div>
    	            </div>
    	          </div>
    	          <footer class="card-footer">
    	            <div class="row">
    	              <div class="col-md-12 text-right">
    	                <button type="submit" class="btn btn-primary modal-confirm" >Add order</button>
    	                <button class="btn btn-danger" @click="modalDismiss()" type="reset">Cancel</button>
    	              </div>
    	            </div>
    	          </footer>
    			</form>
        </section>
      </div>

</template>


<script>

    export default {
        data() {
            return {
                orderData : {},
                form: new Form({
                    client: '',
                    service: '',
                })
            }
        },

        methods: {
        	/*
			    * Modal dismiss
        	*/
          	modalDismiss(){
          		this.form.client='',
          		this.form.service='',
          		$.magnificPopup.close()
          	},

            // form data submit to database
            formSubmit() {

                this.$Progress.start();
                this.form.post('/api/orders')
                .then((order)=>{

                  $.magnificPopup.close();
                  
                  this.$Progress.finish();
                  toast.fire({
                    type: 'success',
                    title: 'Order created successfully.'
                  })
                  //console.log();
                  window.location.href = "/orders/order/"+order.data.order.order_number;
                  //this.$router.push('/orders/order/'+order.data.order.order_number);

                }).catch(()=>{
                    this.$Progress.fail()
                })

            },


            loadOrderData(){
                axios.get("/api/order-create").then(({ data }) => (this.orderData = data));
            },

        },

        created() {
           this.loadOrderData();
        }

    };

</script>


<style type="text/css" scoped>
    .form-control.vue-single-select {
        padding: 0px;
        border: 0px;
    }
    .invalid-feedback {
      color: #dc3545;
      margin-top: -8px;
  }
</style>