<template>

    <div class="card-body">
        <br/>
        <div v-if="invoiceData.data!=0">
            <table class="table table-no-more table-bordered table-striped mb-0" id="table">
                <thead>
                    <tr>
                      <th class="text-left">Invoice</th>
                      <th class="text-center">Client</th>
                      <th class="text-center">Status</th>
                      <th class="text-center">Added</th>
                      <th class="text-center">Number</th>
                      <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- for all invoice -->
                    <tr v-for="(data, index) in invoiceData.data" class="order-wrap" >
                            <td>
                                <router-link :to="`/invoices/view/${data.invoice_number}`" v-if="$auth.isAdmin() || $auth.can('invoice-view')">
                                {{ data.invoice_number }}
                                </router-link>
                                <span v-else>
                                {{ data.invoice_number }}
                                </span>
                            </td>
                            <td class="text-center">
                                {{ data.invoice_client.name }}
                            </td>
                            <td class="text-center">
                                <span v-if="data.invoice_status == 'paid'" class="span-badge working">Paid</span>
                                <span v-if="data.invoice_status == 'unpaid'" class="span-badge canceled">Unpaid</span>
                                <span v-if="data.invoice_status == 'refund'" class="span-badge submitted">Refund</span>
                            </td>
                            <td class="text-center">
                                {{ data.created_at | dateFormat }}
                            </td>
                            <td class="text-center">
                               Pending
                            </td>
                            <td class="text-right">
                                <div class="btn-group flex-wrap">
                                    <button type="button" class="mb-1 mt-1 mr-1 btn btn-default dropdown-toggle action-btn role-btn" data-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                                    <div class="dropdown-menu" role="menu">
                                        
                                        <router-link :to="`/invoices/view/${data.invoice_number}`" class="dropdown-item text-1" v-if="$auth.isAdmin() || $auth.can('invoice-view')">
                                          <i class="far fa-eye"></i> View
                                        </router-link>
                                        <router-link :to="`/invoices/edit/${data.invoice_number}`" class="dropdown-item text-1" v-if="$auth.isAdmin() || $auth.can('invoice-edit')">
                                          <i class="far fa-edit"></i> Edit
                                        </router-link>
                                        <a class="dropdown-item text-1" href="#" @click="deleteData(data.id)" v-if="$auth.isAdmin() || $auth.can('invoice-delete')">
                                            <i class="fa fa-trash-alt"></i> Delete
                                        </a>
                                    </div>
                                </div>
                            </td>
                    </tr>
                </tbody>
            </table>

            <div class="pull-right mt-4">
                <pagination :data="invoiceData" @pagination-change-page="loadInvoiceData"></pagination>
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
                invoiceData : {}
            }
        },

        methods: {

            isInvoceCurrentPage: function() {
              return this.$route.path;
            },

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
                                Fire.$emit('AfterDelete');
                            }).catch(()=> {
                                Swal.fire("Opps!", "Something is wrong.", "warning");
                                this.$Progress.fail()
                            });
                     }
                })

            },

            loadInvoiceData(page=1){
                axios.get('/api/invoices?page=' + page).then(({ data }) => (this.invoiceData = data.invoices));
            },
        },

        created() {
           this.loadInvoiceData();
           Fire.$on('AfterDelete',() => {
               this.loadInvoiceData();
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

