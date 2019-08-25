<template>

    <div>
        <invoiceData></invoiceData>
    </div>

</template>



<script>


    export default {

        data() {
            return {
                //invoiceData : {}
            }
        },

        methods: {

            isInvoceCurrentPage: function() {
              return this.$route.path;
            },
        

        },

        created() {
           //this.loadInvoiceData();
        }

    };
</script>


<style>
    .badge-info {
        color: rgb(23, 162, 184);
        background: rgb(212, 245, 250);
    }
</style>

