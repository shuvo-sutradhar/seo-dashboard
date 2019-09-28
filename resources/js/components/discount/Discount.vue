<template>

    <div class="card-body">

        <div v-if="discounts!=0">
            <table class="table table-no-more table-bordered table-striped mb-0" id="table">
                <thead>
                    <tr>
                      <th class="text-left">SL</th>
                      <th class="text-center">CODE</th>
                      <th class="text-center">TYPE</th>
                      <th class="text-center">EXPIRES</th>
                      <th class="text-center">USAGE LIMIT</th>
                      <th class="text-center">TIMES USED</th>
                      <th class="text-right">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- for all invoice -->
                    <tr v-for="(data, index) in discounts" class="order-wrap" >
                        <td>
                           #{{index+1}}
                        </td>
                        <td class="text-center">
                           {{data.cupon_code}}
                        </td>
                        <td class="text-center">
                          <span v-if="data.discount_type==1" class="badge badge-info">$</span>
                          <span v-else class="badge badge-success">%</span>
                        </td>
                        <td class="text-center">
                            <span v-if="data.expiry_date">{{ data.expiry_date | dateFormat }}</span>
                            <span v-else>--</span>
                        </td>
                        <td class="text-center">
                            <span v-if="data.total_limit">{{ data.total_limit }}</span>
                            <span v-else>--</span>
                        </td>
                        <td class="text-center">
                            sddf
                        </td>
                        <td class="text-right">
                            <div class="btn-group flex-wrap">
                                <button type="button" class="mb-1 mt-1 mr-1 btn btn-default dropdown-toggle action-btn role-btn" data-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                                <div class="dropdown-menu" role="menu">
                                    
                                    <router-link :to="`/discount`" class="dropdown-item text-1" v-if="$auth.isAdmin() || $auth.can('discount-edit')">
                                      <i class="far fa-edit"></i> Edit
                                    </router-link>
                                    <a class="dropdown-item text-1" href="#" @click="deleteData(data.id)" v-if="$auth.isAdmin() || $auth.can('discount-delete')">
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
               Invoices are created automatically for new orders...
            </p>
        </div>
    </div>

</template>



<script>


    export default {

        data() {
            return {
                discounts : {}
            }
        },

        methods: {

            loadData() {
              axios.get("/api/discount").then(({ data }) => (this.discounts = data));
            },


            //delete data
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
                            axios.delete('/api/discount/'+id).then(()=>{
                                    Swal.fire(
                                    'Deleted!',
                                    'Your item has been deleted successfully.',
                                    'success'
                                )

                                this.$Progress.finish();
                                Fire.$emit('AfterDelete');
                            }).catch(()=> {
                                Swal.fire("Opps!", "Something is wrong.", "warning");
                                this.$Progress.fail()
                            });
                     }
                })

            },

            

        },

        created() {
           this.loadData();
           Fire.$on('AfterDelete',() => {
               this.loadData();
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

