<template>

    <div class="card-body">
        <br/>
        <div v-if="orderData!=0">

            <!-- client table data start -->
            <table class="table table-no-more table-bordered table-striped mb-0" id="table" v-if="$auth.isClient()">
                <thead>
                    <tr>
                      <th class="text-left">ORDER</th>
                      <th class="text-center">SERVICE</th>
                      <th class="text-center">ADDED</th>
                      <th class="text-center">COMPLETED</th>
                      <th class="text-right">STATUS</th>
                    </tr>
                </thead>
                <!-- client view -->
                <tbody>
                    <tr v-for="(data, index) in orderData.data" class="order-wrap">

                        <td>
                            <router-link :to="`/orders/order/${data.order_number}`">
                                {{ data.order_number  }} 
                            </router-link>
                        </td>
                        <td class="text-center">
                            {{ data.order_service.name  }}
                        </td>
                        <td class="text-center">
                            {{ data.created_at | dateFormat }}
                        </td>
                        <td class="text-center">
                            <span v-if="data.completed_at">{{ data.completed_at | dateFormat }}</span>
                            <span v-else>--</span>
                        </td>
                        <td class="text-right">
                            <span v-if="data.order_status == 'Submitted'" class="span-badge submitted">Submitted</span>
                            <span v-if="data.order_status == 'Pending'" class="span-badge pending">Pending</span>
                            <span v-if="data.order_status == 'Working'" class="span-badge working">Working</span>
                            <span v-if="data.order_status == 'Complete'" class="span-badge complete">Complete</span>
                            <span v-if="data.order_status == 'Canceled'" class="span-badge canceled">Canceled</span>
                        </td>

                    </tr>
                </tbody>
                <!-- client view -->
            </table>
            <!-- client table data end -->

            <!-- admin table data start -->
            <table class="table table-no-more table-bordered table-striped mb-0" id="table" v-show="!$auth.isClient()">
                <thead>
                    <tr>
                      <th class="text-left">Client</th>
                      <th class="text-center">Status</th>
                      <th class="text-center">Added</th>
                      <th class="text-center">Invoice</th>
                      <th class="text-right">Action</th>
                    </tr>
                </thead>
                <!-- admin view -->
                <tbody>
                    <tr v-for="(data, index) in orderData.data" class="order-wrap" >

                        <td>
                            <router-link :to="`/orders/order/${data.order_number}`" v-if="$auth.isAdmin() || $auth.can('order-view')">
                                {{ data.order_client.name  }} <span class="badge badge-info" v-if="data.team_member_id!= null">{{ data.order_team.name  }}</span>
                                <p>{{ data.order_service.name  }} (${{ data.order_service.price }})</p>
                            </router-link>
                            <span v-else>
                                {{ data.order_client.name  }} <span class="badge badge-info" v-if="data.team_member_id!= null">{{ data.order_team.name  }}</span>
                                <p>{{ data.order_service.name  }} (${{ data.order_service.price }})</p>
                            </span>
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
                                    <router-link :to="`/orders/order/${data.order_number}`"  class="dropdown-item text-1" v-if="$auth.isAdmin() || $auth.can('order-view')">
                                        <i class="far fa-eye"></i> View
                                    </router-link>

                                    <router-link :to="`/orders/edit/${data.order_number}`" class="dropdown-item text-1" v-if="$auth.isAdmin() || $auth.can('order-edit')">
                                        <i class="far fa-edit"></i> Edit
                                    </router-link>

                                    <a class="dropdown-item text-1" href="#" @click="deleteData(data.id)" v-if="$auth.isAdmin() || $auth.can('order-delete')">
                                        <i class="fa fa-trash-alt"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
                <!-- client view -->
            </table>
            <!-- admin table data end -->


            <div class="pull-right mt-4">
                <pagination :data="orderData" @pagination-change-page="loadOrderData"></pagination>
            </div>
        </div>

    </div>

</template>



<script>


    export default {

        data() {
            return {
                //link:window.location.origin,
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


            loadOrderData(page = 1){
                axios.get('/api/orders?page=' + page).then(({ data }) => (this.orderData = data.orders));
            },

        },

        mounted() {
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

    @media only screen and  (max-width: 991px) {
        .table.table-no-more.table-bordered td {
            text-align: center !important;
            width: 100%;
            padding: 10px 0px;
        }
    }
</style>

