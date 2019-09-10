<template>

      <div id="modalAnim" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
        <section class="card">
          <header class="card-header">
            <h2 class="card-title">Edit billing details</h2>
          </header>
          <form @submit.prevent="formSubmit">
            <div class="card-body">

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="First">First name</label>
                    <input type="text" class="form-control" id="First" placeholder="Jhon" v-model="form.first_name" :class="{ 'is-invalid': form.errors.has('first_name') }">
                    <has-error :form="form" field="form.first_name"></has-error>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="Last">Last name</label>
                    <input type="text" class="form-control" id="Last" placeholder="doe" v-model="form.last_name" :class="{ 'is-invalid': form.errors.has('last_name') }">
                    <has-error :form="form" field="form.last_name"></has-error>
                  </div>
                </div>
                <div class="form-row">

                  <div class="form-group col-md-12 mb-0" >
                  <label for="inputEmail04">Billing address</label>
                  </div>
                  <div class="form-group col-md-8">
                    <input type="text" class="form-control" id="Address" placeholder="1234 Main St" v-model="form.address" :class="{ 'is-invalid': form.errors.has('address') }">
                    <label for="Address" class="address-small">Address</label>
                    <has-error :form="form" field="form.address"></has-error>
                  </div>
                  <div class="form-group col-md-4">
                    <input type="text" class="form-control" id="Country" v-model="form.country">
                    <label for="Country" class="address-small">Country</label>
                  </div>
                  <div class="form-group col-md-4">
                    <input type="text" class="form-control" id="City" v-model="form.city">
                    <label for="City" class="address-small">City</label>
                  </div>
                  <div class="form-group col-md-4">
                    <input type="text" class="form-control" id="State" v-model="form.state">
                    <label for="State" class="address-small">State / Province / Region</label>
                  </div>
                  <div class="form-group col-md-4">
                    <input type="text" class="form-control" id="Postal" v-model="form.post_code">
                    <label for="Postal" class="address-small">Postal / Zip Code</label>
                  </div>

                  <div class="row">
                      <div class="col-md-12 pt-2">
                          <div class="custom-control custom-checkbox">
                              <input type="checkbox" id="action-2" class="custom-control-input" v-model="form.isCompany"> 
                              <label for="action-2" class="custom-control-label">I'm purchasing for a company</label>
                          </div>
                      </div>

                      <div class="col-md-12 mt-2" v-if="form.isCompany==true">
                          <div class="row">
                              <div class="col-md-6">
                                  <input type="text" class="form-control" v-model="form.company_name"  />
                                  <small>Company</small>
                              </div>
                              <div class="col-md-6">
                                  <input type="text" name="name" class="form-control" v-model="form.tax_id" />
                                  <small>Tax ID(Optional)</small>
                              </div>
                          </div>
                      </div>
                  </div>
                </div>

            </div>
            <footer class="card-footer">
              <div class="row">
                <div class="col-md-12 text-right">
                  <button type="submit" class="btn btn-primary modal-confirm">Submit</button>
                  <button type="button" class="btn btn-default modal-dismiss" @click="modalDismiss()">Cancel</button>
                </div>
              </div>
            </footer>
          </form>
        </section>
      </div>



</template>


<script>

    export default {

        props: ["addresses"],

        data() {
            return {
                form: new Form({
                    first_name: '',
                    last_name: '',
                    address: '',
                    country: '',
                    city: '',
                    state: '',
                    post_code: '',
                    isCompany:'',
                    company_name: '',
                    tax_id: '',
                })
            }
        },

        methods: {
        	/*
			    * Modal dismiss
        	*/
          	modalDismiss(){
          		$.magnificPopup.close()
          	},
            // form data submit to database
            formSubmit() {

                this.$Progress.start();
                this.form.put('/api/invoices/address/'+this.addresses.id)
                .then((order)=>{

                  $.magnificPopup.close();
                  
                  this.$Progress.finish();
                  toast.fire({
                    type: 'success',
                    title: 'Address updated successfully.'
                  })
                  //console.log();
                }).catch(()=>{
                    this.$Progress.fail()
                })

            },   
        },

        
        watch:{
          addresses(addresses) {
            this.form.fill(this.addresses);
            if(this.addresses.company_name){
              this.form.isCompany = true;
            }
          },
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
  form .address-small{
    font-size: 12px;
    margin-top: 4px;
    opacity: .7;
  }
</style>