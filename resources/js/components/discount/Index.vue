<template>

    <div>
        <div class="card_header" v-if="isDiscountPage()===false">
            <h3 class="font-weight-semibold mt-3 dark">Discount</h3>
            <router-link to="/discount/create" class="mb-1 mt-1 mr-1 btn btn-primary pull-right list-add-button text-light" >
              <i class="fas fa-plus"></i> Add discount
            </router-link>
        </div>

        <div>
            <router-view></router-view>
        </div>
    </div>

</template>


<script>
    
    export default {

        methods: {
            
            isDiscountPage: function() {
              let url = this.$route.path;
              //let urlslice = url.slice(0, url.lastIndexOf('/'));
              if(url==='/discount/create'){
                return true;
              } else {
                return false;
              }
            },

        },


    }


</script>
