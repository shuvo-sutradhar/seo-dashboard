<template>

  <div class="row" style="justify-content: space-around;">
    <!-- left side start -->
    <div class="col-md-8">
      <div class="card_header" v-if="isOrderPage()===true">
        <h3 class="font-weight-semibold mt-3 dark" v-show="!$auth.isClient()">{{ orderDetails.order.order_service.name }}</h3>
        <h3 class="font-weight-semibold mt-3 dark" v-show="$auth.isClient()">#{{ orderDetails.order.order_number }}</h3>
      </div>


      <div v-show="$auth.isClient()">
        <div class="orderSummary">
          <OrderSummary :orderDetails="orderDetails"></OrderSummary>
        </div>
        <div class="alert alert-warning mb-4 mt-4">
          We need some information to get started on your order. <a href="#">Click here to submit data</a>.        
        </div>
      </div>
      <!-- service note start -->
      <div v-if="!$auth.isClient()" class="card-body" v-bind:class="orderDetails.order.order_note==null ? '' : 'borderLeft'" >
        <form @submit.prevent="submitOrderNote(orderDetails.order.id)">
          <div class="form-group order-note-field" id="order-note-area">

            <div @click="isHidden=true" v-if="isHidden==false">
              <div v-if="orderDetails.order.order_note==null">
                <p style="margin-bottom: 0px">Add a note for your item...</p>
              </div>
              <div v-else class="order_note_edit">
                <p style="margin-bottom: 0px" v-html="orderDetails.order.order_note"></p>
                <a class="edit-note" id="edit-note" href="#" @click="noteEditor(orderDetails.order.order_note)"><i class="fa fa-edit"></i></a>
              </div>
            </div>

            <div v-else class="order-note-editor">
              <ckeditor :editor="editor" v-model="editorData" ></ckeditor>
              <button type="button" class="mb-1 mt-1 mr-1 btn btn-danger  btn-sm float-right" @click="isHidden=false">Cancle</button>
              <button type="sumit" class="mb-1 mt-1 mr-1 btn btn-primary  btn-sm float-right">Save Change</button>
            </div>

          </div>
        </form>
      </div>
      <!-- service note end -->


      <!-- order conversation start -->
      <Orderconversation :messages="orderMessage" @messageDel="deleteMessage"></Orderconversation>
      <ComposeOrderconversation @send="sendMessage" @new="saveNewMessage"></ComposeOrderconversation>
      <!-- order conversation end -->
    </div>
    <!-- left side end -->

    <!-- right side start -->
    <div class="col-md-3" v-show="!$auth.isClient()">
      <div class="order_right_details">
        <!-- top bar menu -->
        <div class="d-flex justify-content-center">
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
                    <a href="#" class="btn btn-light" @click="isFollowing(orderDetails.order.order_number)" v-if="orderDetails.followOrUnfollow!=null && orderDetails.followOrUnfollow.is_following==0">
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
        <div class="card card-horizontal mt-2">
          <div class="card-body order-body">
            <h3>Order #B39U312Y 
              <span class="float-right ">
                <button type="button" class="btn dropdown-toggle action-btn role-btn" data-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                <div class="dropdown-menu dropdown-menu-right" role="menu">
                  <router-link :to="`/orders/edit/${orderDetails.order.order_number}`" class="dropdown-item text-1">
                    <i class="fa fa-edit"></i> Edit Details
                  </router-link>
                  <a v-on:click="deleteData(orderDetails.order.id)" class="dropdown-item text-1" href="#">
                    <i class="fa fa-trash-alt"></i> Delete Order
                  </a>
                </div>
              </span>
            </h3>

            <OrderSummary :orderDetails="orderDetails"></OrderSummary>
            
          </div>
        </div>
        <!-- details end -->
      </div>
      <div class="order_right_details">
        <div class="card mt-2">
          <div class="card-body order-body">
            <h3>Tags</h3>
            <!-- <form @submit.prevent="addTag">
              <div class="d-flex mb-3" id="tag-edit" >
                  <input type="text" v-model="tag" class="form-control ui-autocomplete-input" id="tag-input" placeholder="New tag" >
                  <button type="submit" class="btn btn-default ml-2" id="tag-save">Add</button>
              </div>
            </form> -->
            <form @submit.prevent="addTag" class="d-flex">
              <vue-tags
                  :active="tags"
                  :all="orderDetails.tags"
                  :element-count-for-start-arrow-scrolling="1"
                  :tab-index="1"
                  :tag-creation-enabled="true"
                  :colors-enabled="false"
                  :tag-color-default="'rgb(46, 195, 161)'"
                  :tag-list-label="'Select an option'"
                  :placeholder="'Select an option'"
                  @on-tag-added="onTagAdded"
                  @on-tag-removed="onTagRemoved"
                  @on-tag-created="onTagCreated"
              />
              <button type="submit" class="btn btn-secondary ml-2" id="tag-save">Add</button>
            </form>
            <div class="tag-wrap mt-3">
              <transition-group name="list" tag="div" class="field is-grouped-multiline" enter-active-class="animated zoomInUp" leave-active-class="animated zoomOutDown">
                <button type="submit" class="btn btn-primary btn-sm mr-2 mb-2 tag" v-for='(tag, id) in orderDetails.order_tag' v-on:click="removeTag(tag)" :key="tag.id">
                  {{tag.order_tag.name}} <span>×</span>
                </button>
              </transition-group>

            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- right side end -->



  </div>

</template>


<script>

    import OrderSummary from './OrderSummary';
    import Orderconversation from './Orderconversation';
    import ComposeOrderconversation from './ComposeOrderconversation';
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
    export default {

        data() {
            return {
              isHidden:false,
              //load data from server
              orderDetails:{},
              //load tag 
              tags:[],
              //ck-editor
              editor: ClassicEditor,
              editorData: '',
              //orderMessage
              orderMessage:[],
            }
        },

        methods: {

            //add tag
            addTag(){
                // //save new tag
                this.$Progress.start();
                axios.put('/api/orders/order-tag-status/'+this.orderDetails.order.id,{tag:this.tags})
                .then((response)=>{

                  Fire.$emit('AfterUpdate');
                  this.$Progress.finish();

                  // this.tags.push(newTag);
                  this.tags=[]

                }).catch(()=>{
                    this.$Progress.fail()
                })
            },

            onTagAdded(data){
              //console.log(data.name)
              this.tags.push(data);
            },

            onTagRemoved(data){
              //console.log(data.name)
              this.tags.splice(data,1);
            },

            onTagCreated(data,id = this.orderDetails.order.id){

                // //save new tag
                this.$Progress.start();
                axios.post('/api/orders/order-tag/'+id,{tag:data})
                .then((response)=>{

                  Fire.$emit('AfterUpdate');
                  this.$Progress.finish();

                  //push data into active tag
                  let newTag = {
                    id: response.data.tag.id,
                    name: response.data.tag.name,
                    slug: response.data.tag.slug
                  };

                  this.tags.push(newTag);

                }).catch(()=>{
                    this.$Progress.fail()
                })
            },

            removeTag(data){

                // //save new tag
                this.$Progress.start();
                axios.delete('/api/orders/order-tag/'+data.id)
                .then((response)=>{

                  //remove item from active item
                  if(this.tags.length>0){
                    for(var i = 0; i < this.tags.length; i++) {
                      if(this.tags[i].id==data.order_tag.id){
                        this.tags.splice(data,1);
                      }
                    }
                  }

                  Fire.$emit('AfterUpdate');
                  this.$Progress.finish();

                }).catch(()=>{
                    this.$Progress.fail()
                })
            },

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


            /*
            * load order data
            */
            loadOrderData(){
                axios.get(`/api/show-order/${this.$route.params.order_number}`).then(({ data }) => (this.orderDetails = data));
            },

            /*
            * Sending Message
            */
            saveNewMessage(message,usere){
              Vue.set(message, 'user', usere);
              this.orderMessage.push(message);
            },


            handleIncoming(message, user) {
              //if(this.selectedContact && message.from == this.selectedContact.id){
                this.saveNewMessage(message, user);
                return [message,user];
              },
              //this.updateUnreadCount(message.from_contact, false);
            //},

            sendMessage(text) {

              axios.post('/api/order-message/send',{
                order_id: this.orderDetails.order.id,
                mesasge_body: text[1],
                message_for: text[0],
                message_link: this.orderMessage.length + 1,
              }).then((response)=>{
                console.log(response.data.message);
                this.$emit('new', response.data.message)
              })
            },

            /*
            * Delete Order 
            */
            deleteData(id){
                
                var url = window.location.origin+'/api/orders/'+id;

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
                                Fire.$emit('AfterDelete');
                                this.$router.push('/orders');
                            }).catch(()=> {
                                Swal.fire("Opps!", "Something is wrong.", "warning");
                            });
                     }
                })

            },

            /*
            * Delete Order Message
            */

            deleteMessage(id) {
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
                          axios.delete('/api/order-message/'+id).then(()=>{
                                  Swal.fire(
                                  'Deleted!',
                                  'Your file has been deleted.',
                                  'success'
                                  )
                              Fire.$emit('AfterDeleteOrderMsg');
                          }).catch(()=> {
                              Swal.fire("Failed!", "There was something wronge.", "warning");
                          });
                      }
                  })
            },


            loadOrderMessages() {
              axios.get('/api/order-message/'+this.$route.params.order_number)
                .then((response)=>{
                  this.orderMessage = response.data.orderMessage;
              })
            }

        },

        mounted() {

          Echo.private('orderMessages')
          .listen('NewOrderMessage', (e) => {
              this.handleIncoming(e.orderMessage, e.user);
          });

          this.loadOrderData();
          this.loadOrderMessages();
          Fire.$on('AfterUpdate',() => {
            this.loadOrderData();
          });
          Fire.$on('AfterDeleteOrderMsg',() => {
             this.loadOrderMessages();
          });


        },

        components: {Orderconversation,ComposeOrderconversation,OrderSummary}
    };

</script>


<style type="text/css">
  @import "https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.css";
  .order_note_edit{
        display: flex;
    justify-content: space-between;
    align-items: flex-start;
  }

  .order-note-editor .ck.ck-toolbar {
      border: 1px solid #c4c4c426 !important;
  }
  .order-note-editor .ck.ck-editor__main>.ck-editor__editable:not(.ck-focused) {
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
  .tag-wrap button {
      font-size: 10px !important;
      padding: 3px 5px!important;
      transition: .5s;
  }
  .tag-wrap button span {
      display: none;
      transition: .5s;
  }
  .tag-wrap button:hover span{
      display: inline-block;
      transition: .5s;
  }

  .tags {
    position: relative;
    width: 100% !important;
    height: 40px;
  }

  .tags__search {
      border: none;
  }
  .tags__list-item-tag[data-v-3336f93f] {
      background: transparent !important;
  }
  .tags__list-item-tag span[data-v-3336f93f] {
      color: #8c8c8c !important;
  }
  .orderSummary {
      background: #fff;
      padding: 15px;
      border-radius: 5px;
  }

  .orderSummary .details {
      width: 100%;
  }

  .orderSummary .details tbody tr {
      line-height: 30px;
      display: flex;
      justify-content: space-between;
  }
</style>