<template>
<div>
    <div class="card_header">
        <h3 class="font-weight-semibold mt-3 dark">Invoices</h3> 
        
    </div>
    <div class="card-body">
        <br/>
        <div v-if="invoiceData!=0">
            <table class="table table-no-more table-bordered table-striped mb-0" id="table">
                <thead>
                    <tr>
                      <th class="text-left">Invoice</th>
                      <th class="text-center">Date</th>
                      <th class="text-center">Total</th>
                      <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- for all invoice -->
                    <tr v-for="(data, index) in invoiceData" class="order-wrap">
                            <td>
                                <router-link :to="`/dashboard/invoices/${data.invoice_number}`">
                                {{ data.invoice_number }}
                                </router-link>
                            </td>
                            <td class="text-center">
                                {{ data.created_at | dateFormat }}
                            </td>
                            <td class="text-center">
                                ${{ data.invoice_total }}
                            </td>
                            <td class="text-center">
                                <span v-if="data.invoice_status == 'paid'" class="span-badge working">Paid</span>
                                <span v-if="data.invoice_status == 'unpaid'" class="span-badge canceled">Unpaid</span>
                                <span v-if="data.invoice_status == 'refund'" class="span-badge submitted">Refund</span>
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

            loadInvoiceData(){
                axios.get("/api/client-invoice").then(({ data }) => (this.invoiceData = data));
            },

        },

        created() {
           this.loadInvoiceData();

        }

    };
</script>


<style>
    .badge-info {
        color: rgb(23, 162, 184);
        background: rgb(212, 245, 250);
    }
</style>

