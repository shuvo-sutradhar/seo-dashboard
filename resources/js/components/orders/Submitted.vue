<template>

    <div>
        <br/>

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
                <tr v-for="(data, index) in orderData" :key="index" class="order-wrap" v-if="data.order_status == 'Submitted'">

                    <td>
                        <a :href="orderDetails()+data.order_number">
                            {{ data.order_clinet.name  }} <span class="badge badge-info" v-if="data.team_member_id!= null">{{ data.order_team.name  }}</span>
                            <p>{{ data.order_service.name  }} (${{ data.order_service.price }})</p>
                        </a>
                    </td>
                    <td class="text-center">
                        <span class="span-badge submitted">Submitted</span>
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
                                <a class="dropdown-item text-1"  :href="orderDetails()+data.order_number"><i class="far fa-eye"></i> View</a>

                                <a class="dropdown-item text-1"><i class="far fa-edit"></i> Edit</a>

                                <a class="dropdown-item text-1" href="#"><i class="far fa-bell-slash"></i> Unfollow</a>

                                <a class="dropdown-item text-1" href="#">
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

            orderDetails(){
                return this.link+"/orders/";
            },

            loadOrderData(){
                axios.get("/api/orders").then(({ data }) => (this.orderData = data.orders.data));
            },

        },

        created() {
           this.loadOrderData();
        }

    };
</script>


<style>
    .badge-info {
        color: rgb(23, 162, 184);
        background: rgb(212, 245, 250);
    }
</style>

