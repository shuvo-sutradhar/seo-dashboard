<template>

    <div class="card-body">
        <br/>
        <div v-if="orderData!=0">
            <table class="table table-no-more table-bordered table-striped mb-0" id="table">
                <thead>
                    <tr>
                      <th class="text-left">Client</th>
                      <th class="text-center">Status</th>
                      <th class="text-center">Added</th>
                      <th class="text-center">Invoice</th>
                      <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(data, index) in orderData" class="order-wrap" v-show="isCurrentPage()=='/orders' || isCurrentPage()=='/orders/all'">

                        <td>
                            <router-link :to="`/orders/order/${data.order_number}`">
                                {{ data.order_client.name  }} <span class="badge badge-info" v-if="data.team_member_id!= null">{{ data.order_team.name  }}</span>
                                <p>{{ data.order_service.name  }} (${{ data.order_service.price }})</p>
                                <!-- <ul v-if="data.order_assign_tag!=null">
                                    <li v-for="(tag in key) data.order_assign_tag">}</li>
                                </ul> -->
                            </router-link>
                        </td>
                        <td class="text-center">
                            <span v-if="data.order_status == 'Submitted'" class="span-badge submitted">Submitted</span>
                            <span v-if="data.order_status == 'Pending'" class="span-badge pending">Pending</span>
                            <span v-if="data.order_status == 'Working'" class="span-badge working">Working</span>
                            <span v-if="data.order_status == 'Complete'" class="span-badge complete">Complete</span>
                            <span v-if="data.order_status == 'Canceled'" class="span-badge canceled">Canceled</span>
                        </td>
                        <td class="text-center">
                            {{ data.created_at | dateFormat }}
                        </td>
                        <td class="text-center">
                            #{{ data.order_number  }}
                        </td>

                        <td class="text-right">
                            <div class="btn-group flex-wrap">
                                <button type="button" class="mb-1 mt-1 mr-1 btn btn-default dropdown-toggle action-btn role-btn" data-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                                <div class="dropdown-menu" role="menu">
                                    <router-link :to="`/orders/order/${data.order_number}`"  class="dropdown-item text-1">
                                        <i class="far fa-eye"></i> View
                                    </router-link>

                                    <a class="dropdown-item text-1"><i class="far fa-edit"></i> Edit</a>

                                    <a class="dropdown-item text-1" href="#"><i class="far fa-bell-slash"></i> Unfollow</a>

                                    <a class="dropdown-item text-1" href="#" @click="deleteData(data.id)">
                                        <i class="fa fa-trash-alt"></i> Delete
                                    </a>

                                    
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr v-for="(data, index) in orderData" class="order-wrap" v-if="isCurrentPage()=='/orders/'+data.order_status">

                        <td>
                            <router-link :to="`/orders/order/${data.order_number}`">
                                {{ data.order_client.name  }} <span class="badge badge-info" v-if="data.team_member_id!= null">{{ data.order_team.name  }}</span>
                                <p>{{ data.order_service.name  }} (${{ data.order_service.price }})</p>
                            </router-link>
                        </td>
                        <td class="text-center">
                            <span v-if="data.order_status == 'Submitted'" class="span-badge submitted">Submitted</span>
                            <span v-if="data.order_status == 'Pending'" class="span-badge pending">Pending</span>
                            <span v-if="data.order_status == 'Working'" class="span-badge working">Working</span>
                            <span v-if="data.order_status == 'Complete'" class="span-badge complete">Complete</span>
                            <span v-if="data.order_status == 'Canceled'" class="span-badge canceled">Canceled</span>
                        </td>
                        <td class="text-center">
                            {{ data.created_at | dateFormat }}
                        </td>
                        <td class="text-center">
                            #{{ data.order_number  }}
                        </td>

                        <td class="text-right">
                            <div class="btn-group flex-wrap">
                                <button type="button" class="mb-1 mt-1 mr-1 btn btn-default dropdown-toggle action-btn role-btn" data-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                                <div class="dropdown-menu" role="menu">
                                    <router-link :to="`/orders/order/${data.order_number}`"  class="dropdown-item text-1">
                                        <i class="far fa-eye"></i> View
                                    </router-link>

                                    <a class="dropdown-item text-1"><i class="far fa-edit"></i> Edit</a>

                                    <a class="dropdown-item text-1" href="#"><i class="far fa-bell-slash"></i> Unfollow</a>

                                    <a class="dropdown-item text-1" href="#" @click="deleteData(data.id)">
                                        <i class="fa fa-trash-alt"></i> Delete
                                    </a>

                                    
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="pull-right mt-4">
            </div>
        </div>
        
        <div v-else>
            <p class="no-order">
                Orders are added automatically when clients purchase your services.<br>
                Start by setting up your <a :href="serviceLink()">services</a> and creating <a :href="orderFormLink()">an order form</a> where people can buy from you...
            </p>
        </div>
    </div>

</template>



<script>


    export default {

        data() {
            return {
                link:window.location.origin,
                orderData : {}
            }
        },

        methods: {

            isCurrentPage: function() {
              return this.$route.path;
            },

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
                            }).catch(()=> {
                                Swal.fire("Opps!", "Something is wrong.", "warning");
                            });
                     }
                })

            },

            orderFormLink(){
                return this.link+"/order-form/create";
            },
            serviceLink(){
                return this.link+"/services/";
            },

            orderDetails(){
                return this.link+"/orders/";
            },

            loadOrderData(){
                axios.get("/api/orders").then(({ data }) => (this.orderData = data.orders.data));
            },

        },

        created() {
           this.loadOrderData();
           Fire.$on('AfterDelete',() => {
               this.loadOrderData();
           });
        }

    };
</script>


<style>
    .badge-info {
        color: rgb(23, 162, 184);
        background: rgb(212, 245, 250);
    }
</style>

