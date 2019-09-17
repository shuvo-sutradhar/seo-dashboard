<template>
	<table class="details">
        <tbody>
            <tr v-show="$auth.isClient()">
                <th>Service</th>
                <td>{{ orderDetails.order.order_service.name }} (${{ orderDetails.order.order_service.price }})</td>
            </tr>
	        <tr v-show="!$auth.isClient()">
	            <th style="width: 150px">Client</th>
	            <td>
	                <a href="#">{{orderDetails.order.order_client.name}}</a>
	            </td>
	        </tr>

            <tr>
                <th>Payment</th>
                <td>{{orderDetails.order.payment_staus}}</td>
            </tr>
            <tr>
                <th>Amount</th>
                <td>${{orderDetails.order.order_service.price}}  </td>
            </tr>
            <tr v-show="!$auth.isClient()" v-if="orderDetails.order.invoice!=null">
                <th>Invoice</th>
                <td><a href="/invoice/B39U312Y">{{orderDetails.order.invoice.invoice_number}}</a></td>
            </tr>
            <!-- form origin -->
            <tr v-if="orderDetails.order.origin!=null" v-show="!$auth.isClient()" >
                <th>Origin</th>
                <td>
                  <a href="#">{{orderDetails.order.order_form.formName}}  </a>
                </td>
            </tr>
            <tr v-if="orderDetails.order.payment_staus=='Manual'" v-show="!$auth.isClient()" >
                <th>Origin</th>
                <td>
                    Manual invoice
                </td>
            </tr>
            <!-- /. form origin -->
            <tr>
                <th>Order date</th>
                <td>{{ orderDetails.created_at | dateFormat }}</td>
            </tr>
        
            <tr v-if="orderDetails.order.strated_at!=null">
                <th>Started</th>
                <td>{{ orderDetails.strated_at | dateFormat }}</td>
            </tr>
            <tr v-if="orderDetails.order.completed_at!=null">
                <th>Completed</th>
                <td>{{ orderDetails.completed_at | dateFormat }}</td>
            </tr>
            <tr v-show="!$auth.isClient()">
                <th>Service</th>
                <td><a href="https://alok.spp.io/invoice/B39U312Y">{{ orderDetails.order.order_service.name }}</a></td>
            </tr>
        </tbody>
    </table> 
</template>


<script>


    export default {
        props:['orderDetails']
          
       

    };
</script>
