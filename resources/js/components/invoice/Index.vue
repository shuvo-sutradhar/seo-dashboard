<template>


    <div>
      <div class="template-wrap" v-if="$auth.isClient() || $auth.isAdmin() || $auth.can('invoices')">
          
          <section class="card card-horizontal mb-4" >

              <div class="card_header" v-if="isInvoiceSinglePage()===false">
                <h3 class="font-weight-semibold mt-3 dark">Invoices</h3>
                <router-link to="/invoices/create" class="mb-1 mt-1 mr-1 btn btn-primary pull-right list-add-button text-light"  v-if="$auth.isAdmin() || $auth.can('invoice-create')">
                  <i class="fas fa-plus"></i> Add invoice
                </router-link>
              </div>


              <div class="card_nav" v-if="isInvoiceSinglePage()===false">
                <ul>
                  <li v-if="invoiceData.total!=0">
                    <router-link to="/invoices/all" class="nav-link order-all">
                      <span>{{invoiceData.total}}</span> All
                    </router-link>
                  </li>
                  <li v-if="invoiceData.paid_total!=0">
                    <router-link to="/invoices/paid" class="nav-link order-working">
                      <span>{{invoiceData.paid_total}}</span> Paid
                    </router-link>
                  </li>
                  <li v-if="invoiceData.unpaid_total!=0">
                    <router-link to="/invoices/unpaid" class="nav-link order-cancle">
                      <span>{{invoiceData.unpaid_total}}</span> Unpaid
                    </router-link>
                  </li>
                  <li v-if="invoiceData.refund_total!=0">
                    <router-link to="/invoices/refund" class="nav-link order-submit">
                      <span>{{invoiceData.refund_total}}</span> Refunded
                    </router-link>
                  </li>
                </ul>
              </div>
             
              <div>
                <router-view :invoiceData="invoiceData.invoices"></router-view>
              </div>
          </section>

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
            isInvoceCratePage: function() {
              return this.$route.path === '/invoices/create';
            },

            isInvoiceSinglePage: function() {

              let url = this.$route.path;
              let urlslice = url.slice(0, url.lastIndexOf('/'));

              if(url==='/invoices/create'){
                return true;
              } else if (urlslice==='/invoices/view') {
                return true;
              } else if (urlslice==='/invoices/edit') {
                return true;
              }else {
                return false;
              }
            },

            loadInvoiceData(){
                axios.get("/api/invoices").then(({ data }) => (this.invoiceData = data));
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



<style type="text/css">
  .card_nav ul {
      margin: 0;
      padding: 0;
      list-style: none;
  }

  .card_nav ul li {
      display: inline-block;
      background: #fff;
      border-bottom: 1px solid #e6e6e6;
      margin-bottom: 2px;
  }
  .card_nav ul li .nav-link{
      padding: 10px 20px;
      display: block;
      cursor: pointer;
  }

  .card_nav ul li .nav-link span {
      width: 20px;
      height: 20px;
      background: #2ec3a1;
      display: inline-block;
      text-align: center;
      border-radius: 100%;
      margin-right: 5px;
      font-size: 9px;
      color: #fff;
      box-shadow: 1px 2px 2px #bfbfbf;
      transition: .5s;
  }

  .card_nav ul li .nav-link:hover,
  .card_nav ul li .nav-link.router-link-active{
    background-color: #2ec3a1;
    color: #fff !important;
  }
  .card_nav ul li .nav-link:hover span,
  .card_nav ul li .nav-link.router-link-active span{
    background: #fff;
    color: #2ec3a1;
  }

  /*pending order*/
  .card_nav ul li .nav-link.order-pending {
      color: #79ce71;
  }
  .card_nav ul li .nav-link.order-pending span {
      background: #79ce71;
  }
  .card_nav ul li .nav-link.order-pending:hover,
  .card_nav ul li .nav-link.order-pending.router-link-active{
          background: rgba(121, 206, 113, .6);
  }
  .card_nav ul li .nav-link.order-pending:hover span ,
  .card_nav ul li .nav-link.order-pending.router-link-active span {
      background: #fff;
  }

  /*submitted order*/
  .card_nav ul li .nav-link.order-submit {
      color: #fcb000;
  }
  .card_nav ul li .nav-link.order-submit span {
      background: #fcb000;
  }
  .card_nav ul li .nav-link.order-submit:hover,
  .card_nav ul li .nav-link.order-submit.router-link-active{
      background: rgb(255, 244, 211);
      color: #fcb000 !important;

  }
  .card_nav ul li .nav-link.order-submit:hover span ,
  .card_nav ul li .nav-link.order-submit.router-link-active span {
      background: #fff;
      color: #fcb000;
  }


    
  /*working order*/
  .card_nav ul li .nav-link.order-working {
     color: rgb(0, 123, 255);
  }
  .card_nav ul li .nav-link.order-working span {
      background: rgb(0, 123, 255);
  }
  .card_nav ul li .nav-link.order-working:hover,
  .card_nav ul li .nav-link.order-working.router-link-active{
      background: rgb(204, 229, 255);
      color: rgb(0, 123, 255) !important;

  }
  .card_nav ul li .nav-link.order-working:hover span ,
  .card_nav ul li .nav-link.order-working.router-link-active span {
      background: #fff;
      color: rgb(0, 123, 255);
  }
    

  /*complete order*/
  .card_nav ul li .nav-link.order-complete {
     color: rgb(40, 167, 69);
  }
  .card_nav ul li .nav-link.order-complete span {
      background: rgb(40, 167, 69);
  }
  .card_nav ul li .nav-link.order-complete:hover,
  .card_nav ul li .nav-link.order-complete.router-link-active{
       background: rgb(216, 246, 223);
      color: rgb(40, 167, 69) !important;

  }
  .card_nav ul li .nav-link.order-complete:hover span ,
  .card_nav ul li .nav-link.order-complete.router-link-active span {
      background: #fff;
      color: rgb(40, 167, 69);
  }
    
    
  /*cancle order*/
  .card_nav ul li .nav-link.order-cancle {
    color: rgb(228, 96, 109);
  }
  .card_nav ul li .nav-link.order-cancle span {
      background: rgb(228, 96, 109);
  }
  .card_nav ul li .nav-link.order-cancle:hover,
  .card_nav ul li .nav-link.order-cancle.router-link-active{
       background: rgb(250, 227, 229);
      color: rgb(228, 96, 109) !important;

  }
  .card_nav ul li .nav-link.order-cancle:hover span ,
  .card_nav ul li .nav-link.order-cancle.router-link-active span {
      background: #fff;
      color: rgb(228, 96, 109);
  }

   

  .order-wrap .span-badge{
    padding: 5px 10px;
    border-radius: 10px;
    color: #fff;
  }
  .order-wrap .submitted{
    color: rgb(252, 176, 0);
    background: rgb(255, 244, 211);
  }
  .order-wrap .pending{
    background: rgba(121, 206, 113, .6);
  }
  .order-wrap .working{    
    background: rgb(204, 229, 255);
    color: rgb(0, 123, 255) !important;
  }
  .order-wrap .complete{    
    background: rgb(216, 246, 223);
    color: rgb(40, 167, 69);
  }
  .order-wrap .canceled{    
        background: rgb(250, 227, 229);
    color: rgb(228, 96, 109);
  }
  .order-wrap td p {
      margin-bottom: 0px;
      font-size: 12px;
      color: #999;
  }

  .order-wrap td a {
      text-decoration: none;
  }


</style>