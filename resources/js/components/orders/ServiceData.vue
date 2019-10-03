<template>


<div class="modal fade" id="serviceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Service Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div v-for="(data, index) in baseForm.form">

                  

              <!-- single line of text start -->
              <div class="form-group" v-if="data.field === 'singleText'" >
                  <div class=" w-100" >
                      <label for="clientName">{{ data.label }} <small v-show="data.isRequired == false">(optional)</small></label>
                      <input type="text" class="form-control" v-model="data.value" :placeholder="data.placeholder"  />
                      <p>{{ data.helpBlock }}</p>
                  </div>
              </div>
              <!-- single line of text end -->


              <!-- Multiple line of text start -->
              <div class="form-group" v-if="data.field === 'multiText'" >
           
                  <div >
                      <label for="clientName">{{ data.label }} <small v-show="data.isRequired == false">(optional)</small></label>
                      <textarea class="form-control" spellcheck="false" v-model="data.value" :placeholder="data.placeholder"></textarea>
                      <p>{{ data.helpBlock }}</p>
                  </div>
              </div>
              <!-- Multiple line of text end -->


              <!-- Checkbox start -->
              <div class="form-group m-t" v-if="data.field === 'checkbox'" >
                 
                  <div class="custom-control custom-checkbox mt-3" >
                      <input type="checkbox" :id="index" v-model="data.value" class="custom-control-input"> 
                      <label :for="index" class="custom-control-label">{{ data.label }} <small v-show="data.isRequired == false">(optional)</small></label> 
                      <p>{{ data.helpBlock }}</p>
                  </div>
              </div>
              <!-- Checkbox end -->

              <!-- dropdown start -->
              <div class="form-group mt-3" v-if="data.field === 'dropdown'" >
               
                  <div >
                      <label for="clientName">{{ data.label }} <small v-show="data.isRequired == false">(optional)</small></label>
                      <select class="form-control" v-model="data.value">
                        <option v-for="(item, roll) in data.hasItem" :value="item.option">{{ item.option }}</option>
                      </select>
                      <p>{{ data.helpBlock }}</p>
                  </div>
              </div>
              <!-- dropdown end -->

              <!-- file upload start -->
              <div class="form-group" v-if="data.field === 'fileUpload'" >
               
                  <div >
                      <label for="clientName">{{ data.label }} <small v-show="data.isRequired == false">(optional)</small></label>
                      <div class="custom-file">
                          <input type="file" v-on:change="uploadFile(data)" class="custom-file-input" id="validatedCustomFile" required>
                          <label class="custom-file-label" for="validatedCustomFile">{{ data.placeholder }}</label>
                          <div class="invalid-feedback">Example invalid custom file feedback</div>
                          <p v-if="data.helpblock != ''">{{ data.helpBlock }}</p>
                      </div>
                  </div>
              </div>
              <!-- file upload end -->

              <!-- spread Sheet start -->
              <div class="form-group" v-if="data.field === 'spreadSheetInput'" >
     
                  <div  >
                      <label>{{ data.label }}</label>
                      <table class="slick-preview">
                          <tr>
                              <th>&nbsp;</th> 
                              <th v-for="(item, roll) in data.hasItem">{{ item.option  }}</th>
                          </tr> 
                          <tr>
                              <th>1</th> 
                              <td v-for="(item, roll) in data.hasItem"></td>
                          </tr> 
                         
                      </table>
                  </div>
              </div>
              <!-- spread Sheet start -->

          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


</template>


<script>
    import Notifications from 'vue-notification';
    Vue.use(Notifications)
    export default {
        props: ['data'],
        data () {
    
            return {

                //baseform
                baseForm: new Form({
                    form:JSON.parse(this.data.dataForm),
                }),


            }
        },


        methods: {

            uploadFile(e,data){


                let file = e.target.files[0];
                let reader = new FileReader();

                //check file size
                if(file['size'] < 21117750) {
                    reader.onloadend = (file) => {
                        //console.log('RESULT', reader.result)
                        data.value = reader.result;
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

            // form data submit to database
            formSubmit() {


                this.errors = [];
                // error validation
                if (typeof(this.user) != 'undefined') {
                    if (this.user.account_role == 1) {
                        this.errors.push("Please sign out of admin account before placing an order.");
                    }
                }
                // error validation
                //console.log(Object.keys(this.form.opt_single_service).length == 0);
                if (this.form.total === 0) {
                    this.errors.push("No items in your cart yet...");
                }
                

                // if there have no error then the form will be submit
                this.$Progress.start();
                if(this.errors.length === 0) {

                    createToken().then(data =>  {
                      this.form.stripeToken = data.token.id;
                      this.form.post('/api/create-order')

                      .then((orderNumber)=>{
                        //console.log("Test");
                        this.$Progress.finish()
                        //window.location.href = "../thanks/"+orderNumber.data.orderNumber;

                        //redirect and login
                        var csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        var password = this.form.password == '' ? '123456' :  this.form.password;

                        var form = $('<form action="../thanks" method="post">' + 
                          '<input type="hidden" name="_token" value="'+csrf+'">'+
                          '<input type="text" name="email" value="'+this.form.email+'" />' +
                          '<input type="password" name="password" value="'+password+'" />' +
                          '<input type="text" name="order_id" value="'+orderNumber.data.orderNumber+'" />' +
                          '</form>');
                        $('body').append(form);
                        $(form).submit();

                      }).catch(()=>{
                          this.$Progress.fail()
                      })

                    })


                } else {
                    this.$Progress.fail();
                    this.$notify({
                      group: 'checkErrors',
                      //title: 'Important message',
                      text: this.errors[0],
                      type:"warn"
                    });
                }
            },

 

        },

        mounted() {
            //
        },
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