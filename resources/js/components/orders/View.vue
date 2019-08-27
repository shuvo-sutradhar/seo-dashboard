<template>

  <div class="row" style="justify-content: space-around;">
    <!-- left side start -->
    <div class="col-md-8">
      <div class="card_header" v-if="isOrderPage()===true">
        <h3 class="font-weight-semibold mt-3 dark">{{ orderDetails.order.order_service.name }}</h3>
      </div>

      <div class="card-body" v-bind:class="orderDetails.order.order_note==null ? '' : 'borderLeft'">
        <form @submit.prevent="submitOrderNote(orderDetails.order.id)">
          <div class="form-group order-note-field" id="order-note-area">

            <div @click="isHidden=true" v-if="isHidden==false">
              <div v-if="orderDetails.order.order_note==null">
                <p style="margin-bottom: 0px">Add a note for your item...</p>
              </div>
              <div v-else class="order_note_edit">
                <p style="margin-bottom: 0px">{{orderDetails.order.order_note | striphtml}}</p>
                <a class="edit-note" id="edit-note" href="#" @click="noteEditor(orderDetails.order.order_note)"><i class="fa fa-edit"></i></a>
              </div>
            </div>

            <div v-else>
              <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
              <button type="button" class="mb-1 mt-1 mr-1 btn btn-danger  btn-sm float-right" @click="isHidden=false">Cancle</button>
              <button type="sumit" class="mb-1 mt-1 mr-1 btn btn-primary  btn-sm float-right">Save Change</button>
            </div>

          </div>
        </form>
      </div>

    </div>
    <!-- left side end -->

    <!-- right side start -->
    <div class="col-md-3 ">
      <div class="order_right_details">
        <!-- top bar menu -->
        <div class="row justify-content-center">
            <div class="form-inline">
                 <div class="form-group order-wrap ">
                    <button v-if="orderDetails.order.order_status=='Submitted'" type="button" class="btn submitted dropdown-toggle" data-toggle="dropdown" id="change_status">
                      Submitted <i class="fas fa-angle-down ml-1" aria-hidden="true"></i>
                    </button>
                    <button v-if="orderDetails.order.order_status=='Pending'" type="button" class="btn pending dropdown-toggle" data-toggle="dropdown" id="change_status">
                      Pending <i class="fas fa-angle-down ml-1" aria-hidden="true"></i>
                    </button>
                    <button v-if="orderDetails.order.order_status=='Working'" type="button" class="btn working dropdown-toggle" data-toggle="dropdown" id="change_status">
                      Working <i class="fas fa-angle-down ml-1" aria-hidden="true"></i>
                    </button>
                    <button v-if="orderDetails.order.order_status=='Complete'" type="button" class="btn complete dropdown-toggle" data-toggle="dropdown" id="change_status">
                      Complete <i class="fas fa-angle-down ml-1" aria-hidden="true"></i>
                    </button>
                    <button v-if="orderDetails.order.order_status=='Canceled'" type="button" class="btn canceled dropdown-toggle" data-toggle="dropdown" id="change_status">
                      Canceled <i class="fas fa-angle-down ml-1" aria-hidden="true"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" id="order_status">
                       <div class="dropdown-item disabled small">Changing order status does not trigger an email notification</div>
                       <div class="dropdown-divider"></div>
                       <a href="#" class="dropdown-item " :class="orderDetails.order.order_status=='Pending' ? 'disabled' : ''" @click="changeOrderStatus('Pending',orderDetails.order.id)">
                          Pending                                
                          <div class="text-muted small">Waiting for client to submit project details</div>
                       </a>
                       <a href="#" class="dropdown-item " :class="orderDetails.order.order_status=='Submitted' ? 'disabled' : ''" @click="changeOrderStatus('Submitted',orderDetails.order.id)">
                          Submitted                                
                          <div class="text-muted small">Client has submitted project details</div>
                       </a>
                       <a href="#" class="dropdown-item " :class="orderDetails.order.order_status=='Working' ? 'disabled' : ''" @click="changeOrderStatus('Working',orderDetails.order.id)">
                          Working                                
                          <div class="text-muted small">Order is in progress</div>
                       </a>
                       <a href="#" class="dropdown-item" :class="orderDetails.order.order_status=='Complete' ? 'disabled' : ''" @click="changeOrderStatus('Complete',orderDetails.order.id)">
                          Complete                                
                          <div class="text-muted small">Order has been delivered</div>
                       </a>
                       <a href="#" class="dropdown-item" :class="orderDetails.order.order_status=='Canceled' ? 'disabled' : ''" @click="changeOrderStatus('Canceled',orderDetails.order.id)">
                          Canceled                                
                          <div class="text-muted small">Order stopped due to a refund</div>
                       </a>
                    </div>
                 </div>
                 <div class="form-group ml-2">
                    <button type="button" class="btn badge-info dropdown-toggle" data-toggle="dropdown" id="change_employee" v-if="orderDetails.order.team_member_id==null">
                      Anyone <i class="fas fa-angle-down ml-1" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="btn badge-info dropdown-toggle" data-toggle="dropdown" id="change_employee" v-else>
                      {{ orderDetails.order.order_team.name }} <i class="fas fa-angle-down ml-1" aria-hidden="true"></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-right" id="order_employee">
                       <div class="dropdown-item disabled small">Assigned team member will be notified</div>
                       <div class="dropdown-divider"></div>
                       <a href="#" data-value="0" class="dropdown-item" :class="orderDetails.order.team_member_id==null ? 'disabled' :''" @click="assignTeam(orderDetails.order.order_number,'anyone')" >
                          Anyone <div class="small text-muted">Team members can still follow the order to receive updates</div>
                       </a>
                       <a href="#" class="dropdown-item " v-for="data in orderDetails.teamMembers" @click="assignTeam(orderDetails.order.order_number,data.id)" :class="orderDetails.order.team_member_id!=null && data.id==orderDetails.order.team_member_id ? 'disabled' : ''">
                          {{data.name}}                                
                          <div class="small text-muted" v-if="data.account_role==0">Team Member</div>
                          <div class="small text-muted" v-if="data.account_role==1">Admin</div>
                       </a>
                    </div>
                 </div>
                 <div class="form-group ml-2">
                    <a href="#" class="btn btn-light" @click="isFollowing(orderDetails.order.order_number)" v-if="orderDetails.followOrUnfollow!=null && orderDetails.followOrUnfollow.is_following!=0">
                      <i class="fas fa-bell-slash" aria-hidden="true"></i> Unfollow
                    </a>
                    <a href="#" class="btn btn-light" @click="isFollowing(orderDetails.order.order_number)" v-else>
                      <i class="fas fa-bell" aria-hidden="true"></i> Follow
                    </a>
                 </div>
            </div>
        </div>
        <!-- top bar menu end -->

        <!-- details start -->
        <div class="row">
          <div class="card card-horizontal mt-2">
            <div class="card-body order-body">
              <h3>Order #B39U312Y 
                <span class="float-right ">
                  <button type="button" class="btn dropdown-toggle action-btn role-btn" data-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                  <div class="dropdown-menu dropdown-menu-right" role="menu">
                    <a class="dropdown-item text-1" href="#"><i class="fa fa-edit"></i> Edit Details</a>

                    <a onclick="deleteData(event)" class="dropdown-item text-1" href="#">
                      <i class="fa fa-trash-alt"></i> Delete Order
                    </a>
                  </div>
                </span>
              </h3>
              <table class="details">
                  <tbody>
                    <tr>
                        <th style="width: 150px">Client</th>
                        <td>
                            <a href="#">{{orderDetails.order.order_client.name}}</a>
                        </td>
                    </tr>

                      <tr>
                          <th>Payment</th>
                          <td>{{orderDetails.order.payment_staus}}</td>
                      </tr>
                      <tr>
                          <th>Amount</th>
                          <td>${{orderDetails.order.order_service.price}}  </td>
                      </tr>
                      <tr v-if="orderDetails.order.invoice!=null">
                          <th>Invoice</th>
                          <td><a href="/invoice/B39U312Y">{{orderDetails.order.invoice.invoice_number}}</a></td>
                      </tr>
                      <!-- form origin -->
                      <tr v-if="orderDetails.order.origin!=null">
                          <th>Origin</th>
                          <td>
                            <a href="https://alok.spp.io/invoice/B39U312Y">{{orderDetails.order.order_form.formName}}  </a>
                          </td>
                      </tr>
                      <tr v-if="orderDetails.order.payment_staus=='Manual'">
                          <th>Origin</th>
                          <td>
                              Manual invoice
                          </td>
                      </tr>
                      <!-- /. form origin -->
                      <tr>
                          <th>Order date</th>
                          <td>{{ orderDetails.created_at | dateFormat }}</td>
                      </tr>
                  
                      <tr v-if="orderDetails.order.strated_at!=null">
                          <th>Started</th>
                          <td>{{ orderDetails.strated_at | dateFormat }}</td>
                      </tr>
                      <tr v-if="orderDetails.order.completed_at!=null">
                          <th>Completed</th>
                          <td>{{ orderDetails.completed_at | dateFormat }}</td>
                      </tr>
                      <tr>
                          <th>Service</th>
                          <td><a href="https://alok.spp.io/invoice/B39U312Y">{{ orderDetails.order.order_service.name }}</a></td>
                      </tr>
                  
                  </tbody>
              </table>
            </div>
          </div>
        </div>
        <!-- details end -->

      </div>
    </div>
    <!-- right side end -->



  </div>

</template>


<script>

    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
    export default {
        data() {
            return {
              isHidden:false,
              //load data from server
              orderDetails:{},
              //ck-editor
              editor: ClassicEditor,
              editorData: '',
              editorConfig: {
                  // The configuration of the rich-text editor.
              },
            }
        },

        methods: {

            //submit order note data
            submitOrderNote(id){
                //
                this.$Progress.start();
                axios.put('/api/orders/order-note/'+id,{data:this.editorData})
                .then((order)=>{

                  this.$Progress.finish();
                  toast.fire({
                    type: 'success',
                    title: 'Order note update successfully.'
                  })
                  //this.$router.push('/route_name')
                  Fire.$emit('AfterUpdate');
                  this.isHidden=false;

                }).catch(()=>{
                    this.$Progress.fail()
                })
            },


            //change order status
            changeOrderStatus(attr,id){
                this.$Progress.start();
                axios.put('/api/orders/order-status/'+id,{data:attr})
                .then((order)=>{

                  this.$Progress.finish();
                  toast.fire({
                    type: 'success',
                    title: 'Order status changed successfully.'
                  })
                  //this.$router.push('/route_name')
                  Fire.$emit('AfterUpdate');
                  this.isHidden=false;

                }).catch(()=>{
                    this.$Progress.fail()
                })
            },


            //change isFollowing status
            assignTeam(number,id){
                this.$Progress.start();
                axios.put('/api/orders/order-assign/'+number,{data:id})
                .then((order)=>{
                  this.$Progress.finish();
                  toast.fire({
                    type: 'success',
                    title: 'Order has been assign.'
                  })
                  //this.$router.push('/route_name')
                  Fire.$emit('AfterUpdate');
                  this.isHidden=false;

                }).catch(()=>{
                    this.$Progress.fail();
                })
            },

            //change isFollowing status
            isFollowing(number){
                this.$Progress.start();
                axios.put('/api/orders/order-following/'+number)
                .then((order)=>{
                  this.$Progress.finish();
                  toast.fire({
                    type: 'success',
                    title: order.data[0]
                  })
                  //this.$router.push('/route_name')
                  Fire.$emit('AfterUpdate');
                  this.isHidden=false;

                }).catch(()=>{
                    this.$Progress.fail()
                })
            },


            //onclick chang text to texteditor
            noteEditor(attr = this.orderDetails.order.order_note){
              if(attr===null || attr===undefined){
                this.editorData='Write your order note';
              } else {
                this.editorData=attr;
              }
              return false;
            },


            isOrderPage: function() {
              let url = this.$route.path;
              url = url.slice(0, url.lastIndexOf('/'));
              return url === '/orders/order';
            },


            //load order data
            loadOrderData(){
                axios.get(`/api/show-order/${this.$route.params.order_number}`).then(({ data }) => (this.orderDetails = data));
            },


        },

        mounted() {
          this.loadOrderData();
          Fire.$on('AfterUpdate',() => {
            this.loadOrderData();
          });

        }
    };

</script>


<style type="text/css">
  .order_note_edit{
        display: flex;
    justify-content: space-between;
    align-items: flex-start;
  }

  .ck.ck-toolbar {
      border: 1px solid #c4c4c426 !important;
  }
  .ck.ck-editor__main>.ck-editor__editable:not(.ck-focused) {
      border:none;
      box-shadow: 0px 0px 3px #00000014 !important;
  }
  .order-body h3 {
    margin: 0;
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 25px;
  }
  .order-body .role-btn{
    background: transparent;
    border: none;
  }

  .order-body  .dropdown-menu.dropdown-menu-right.show {
      border: 0 solid rgba(0,0,0,.15);
      border-radius: .25rem;
      box-shadow: 0 0.5rem 2.5rem rgba(0,0,0,.15);
  }

  .details tbody tr {
      line-height: 30px;
  }
  .card-body.borderLeft {
      border-left: 3px solid #FFC107;
  }

  .order_right_details .dropdown-toggle::after{
    display: none;
  }

  #order_employee,
  #order_status {
    border: 0 solid rgba(0,0,0,.15);
    border-radius: .25rem;
    box-shadow: 0 0.5rem 2.5rem rgba(0,0,0,.15);
}
</style>