<template>

    <div>
        <AllOrder></AllOrder>
    </div>

</template>



<script>


    export default {

        data() {
            return {
                //
            }
        },

        methods: {

            isCurrentPage: function() {
              return this.$route.path;
            },

        },

        created() {
           //this.loadOrderData();
        }

    };
</script>

