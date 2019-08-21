<template>

    <div>
        <div class="order-page-header">
            <div class="container">
                <div class="row navbar navbar-public">
                   <a href="#" class="navbar-brand">
                   Seodashboard
                   </a>
                </div>
             </div>
        </div>
        <!-- /. page-header -->

        <div class="main-content">
            <form method="post" @submit.prevent="formSubmit()" class="order-form">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="main-content-left cardarea">
                                <div class="intro">
                                    {{this.data.formInfo}}
                                </div>
                                
                                <div class="form-wrap">
                                    <div v-for="(data, index) in baseForm.form">

                                        <!--option group (single service) start -->
                                        <div class="form-group"  v-if="data.field === 'opt_single_service'" >
                                            
                                            <label :for="data.field">{{ data.label }} <small v-if="data.isRequired == false">(optional)</small></label>
                                            <div class="form-row w-100" >
                                                <div class="col-md-6" v-for="(item, roll) in data.hasServices" :key="item.optionValue" :label="roll">
                                                    <div class="scard p-2">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" v-model="form.opt_single_service" :value="item[data.selectedService[roll]]" :id="'opt_single_service'+roll" class="custom-control-input" @change="updateCart()" > 

                                                            <label :for="'opt_single_service'+roll" class="custom-control-label">{{ item[data.selectedService[roll]].name }}</label> 
                                                            <p style="margin-bottom:0">{{ item[data.selectedService[roll]].price }}</p>

                                                            <small>This is a sample one-time service. Feel free to delete it by going back to the services list.</small>
                                                            <div class="item-quantity" v-show="data.hasQuantaty == true">
                                                               <span>Qty: </span>
                                                               <input type="hidden" name="quantity_3" class="form-control form-control-sm custom-quantity" data-quantity="">
                                                               <select name="quantity_3" class="custom-select" v-model="item[data.selectedService[roll]].quantity" @change="updateCart()">
                                                                  <option selected value="1">1</option>
                                                                  <option value="2">2</option>
                                                                  <option value="3">3</option>
                                                                  <option value="4">4</option>
                                                                  <option value="5">5</option>
                                                                  <option value="6">6</option>
                                                                  <option value="7">7</option>
                                                                  <option value="8">8</option>
                                                                  <option value="9">9</option>
                                                                  <option value="10">10+</option>
                                                               </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- option group (single service) end -->


                                        <!-- Checkbox group (multiple services) start -->
                                        <div class="form-group" v-if="data.field === 'ckboxMultiServices'" >
                                          
                                            <label for="clientName">{{ data.label }} <small v-show="data.isRequired == false">(optional)</small></label>
                                            <div class="form-row w-100" >
                                                <div class="col-md-6" v-for="(item, roll) in data.hasServices" :key="item.optionValue" :label="roll">
                                                    <div class="scard p-2">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" v-model="form.ckboxMultiServices" :value="item[data.selectedService[roll]]" :id="'ckboxMultiServices'+roll" class="custom-control-input" @change="updateCart()"> 
                                                           <label :for="'ckboxMultiServices'+roll" class="custom-control-label">{{ item[data.selectedService[roll]].name }} </label>
                                                            <p>{{ item[data.selectedService[roll]].price }}</p>

                                                            <div class="item-quantity" v-show="data.hasQuantaty == true">
                                                               <span>Qty: </span>
                                                               <input type="hidden" name="quantity_3" class="form-control form-control-sm custom-quantity" data-quantity="">
                                                               <select name="quantity_3" class="custom-select" v-model="item[data.selectedService[roll]].quantity" @change="updateCart()">
                                                                  <option selected value="1">1</option>
                                                                  <option value="2">2</option>
                                                                  <option value="3">3</option>
                                                                  <option value="4">4</option>
                                                                  <option value="5">5</option>
                                                                  <option value="6">6</option>
                                                                  <option value="7">7</option>
                                                                  <option value="8">8</option>
                                                                  <option value="9">9</option>
                                                                  <option value="10">10+</option>
                                                               </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Checkbox group (multiple services) end -->

                                        <!-- Dropdown menu (single service) start -->
                                        <div class="form-group" v-if="data.field === 'dropDownSingleService'" >
                                            
                                            <div >
                                                <label for="clientName">{{ data.label }} <small v-show="data.isRequired == false">(optional)</small></label>
                                             
                                                <select v-model="form.dropDownSingleService" class="form-control" @change="updateCart()">
                                                    <option disabled>{{ data.defaultSelected }}</option>
                                                    <option v-for="(item, roll) in data.hasServices" :value="item[data.selectedService[roll]]">{{ item[data.selectedService[roll]].name }}</option>
                                                </select>
                                                <div class="item-quantity" v-show="data.hasQuantaty == true" style="justify-content: end;">
                                                   <span>Qty : </span>
                                                   <select name="quantity_3" class="custom-select" v-model="form.dropSingleQty"  @change="updateCart()">
                                                      <option selected value="1">1</option>
                                                      <option value="2">2</option>
                                                      <option value="3">3</option>
                                                      <option value="4">4</option>
                                                      <option value="5">5</option>
                                                      <option value="6">6</option>
                                                      <option value="7">7</option>
                                                      <option value="8">8</option>
                                                      <option value="9">9</option>
                                                      <option value="10">10+</option>
                                                   </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Dropdown menu (single service) end -->


                                        <!-- Dropdown menu (multiple services) start -->
                                        <div class="form-group" v-if="data.field === 'dropDownMultipleServices'" >
                                          
                                            <label for="clientName">{{ data.label }} <small v-show="data.isRequired == false">(optional)</small></label>
                                             
                                            <div v-for="multiDrop in multiDropdown" class="mb-4">
                                                <select v-model="form.dropDownMultipleServices[multiDrop-1]" class="form-control" @change="updateCart()">
                                                    <option disabled value="">{{ data.defaultSelected }}</option>
                                                    <option v-for="(item, roll) in data.hasServices" :value="item[data.selectedService[roll]]" >
                                                        {{ item[data.selectedService[roll]].name }}
                                                    </option>
                                                </select>
                                                <div class="item-quantity" style="justify-content: space-between;">
                                                     <div v-show="data.hasQuantaty == true">
                                                       <span>Qty :</span>
                                                       <input type="hidden" name="quantity_3" class="form-control form-control-sm custom-quantity">
                                                       <select name="quantity_3" class="custom-select" v-model="form.dropMultiQty[multiDrop-1]" @change="updateCart()">
                                                          <option value="1">1</option>
                                                          <option value="2">2</option>
                                                          <option value="3">3</option>
                                                          <option value="4">4</option>
                                                          <option value="5">5</option>
                                                          <option value="6">6</option>
                                                          <option value="7">7</option>
                                                          <option value="8">8</option>
                                                          <option value="9">9</option>
                                                          <option value="10">10+</option>
                                                       </select>
                                                    </div>
                                                    <div>
                                                       <a href="#" @click="addMultiDropdown">+ Add service</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Dropdown menu (multiple services) end -->

                                        <!-- block two start (name) -->
                                        <div class="form-group" v-if="data.field === 'fullName'" >
                                            <label for="clientName"  >{{ data.label }}</label>
                                            <div class="form-row w-100" >
                                                <div class="col-md-12">
                                                    <input type="text" name="name" class="form-control" v-model="form.name" disabled="disabled" v-if="user" />
                                                    <input type="text" name="name" class="form-control" v-model="form.name" v-else/>
                                                    <small>Full Name</small>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- email -->
                                        <div class="form-group" v-if="data.field === 'email'" >
                                            
                                            <label :for="data.field">{{ data.label }}</label>
                                            <div v-if="user">
                                                <input id:="data.field" type="email" name="name" class="form-control" v-model="form.email" disabled="disabled" />
                                                <div class="help-block">
                                                    To change your email go to <a :href="profileLink(user.email)">your profile</a>.  
                                                    <!-- {{ route('client.show', $user->email) }} -->      
                                                </div>
                                            </div>
                                            <div v-else>
                                                <input :id="data.field" type="email" v-model="form.email" class="form-control" :placeholder="data.placeholder" :class="{ 'is-invalid': form.errors.has('email') }" />
                                                <has-error :form="form" field="email"></has-error>
                                                <div class="help-block">
                                                   
                                                   Already have an account ?<a href=""> Sign in here.</a> 
                                                    <!-- {{ route('client.show', $user->email) }} -->      
                                                </div>
                                            </div>
                                        </div>
                                        <!-- PASSWORD -->
                                        <div class="form-group" v-if="data.field === 'password'" >
                                           
                                            <div >
                                                <label for="clientName">{{ data.label }}</label>
                                                <input type="password" class="form-control" :placeholder="data.placeholder" v-model="form.password" />
                                            </div>
                                        </div>
                                        <!-- BILLING ADDRESS -->
                                        <div class="form-group" v-if="data.field === 'billingAddress'" >
                                          
                                            <div v-if="clientinfo">
                                                <label :for="data.field">{{ data.label }}</label>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <input type="text" name="name" class="form-control" v-model="form.address" disabled="disabled" />
                                                        <small>Address</small>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="text" name="name" class="form-control" v-model="form.city" disabled="disabled" />
                                                        <small>City</small>
                                                        
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="dropdown">
                                                            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle w-100 text-left" aria-expanded="false">
                                                                    United States
                                                                <span class="bs-caret float-right"><span class="caret"></span></span>
                                                            </button> 
                                                            <div class="dropdown-menu w-100" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 35px, 0px);"><a href="#" class="dropdown-item" draggable="false">United States</a>
                                                            </div>
                                                            <small>Country</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="text" name="name" class="form-control" v-model="form.state" disabled="disabled" />
                                                        <small>State / Province / Region</small>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="text" name="name" class="form-control" v-model="form.postalCode" disabled="disabled" />
                                                        <small>Postal Code</small>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div v-else>
                                                <label :for="data.field">{{ data.label }}</label>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <input type="text" name="name" class="form-control" v-model="form.address" />
                                                        <small>Address</small>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="text" name="name" class="form-control" v-model="form.city" />
                                                        <small>City</small>
                                                        
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="dropdown">
                                                            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle w-100 text-left" aria-expanded="false">
                                                                    United States
                                                                <span class="bs-caret float-right"><span class="caret"></span></span>
                                                            </button> 
                                                            <div class="dropdown-menu w-100" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 35px, 0px);"><a href="#" class="dropdown-item" draggable="false">United States</a>
                                                            </div>
                                                            <small>Country</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="text" name="name" class="form-control" v-model="form.state" />
                                                        <small>State / Province / Region</small>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="text" name="name" class="form-control" v-model="form.postalCode"  />
                                                        <small>Postal Code</small>
                                                    </div>
                                                   
                                                    
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 pt-2">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" id="action-2" class="custom-control-input" v-model="form.iscompany"> 
                                                        <label for="action-2" class="custom-control-label">I'm purchasing for a company</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mt-2" v-if="form.iscompany==true">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" v-model="form.companyName"  />
                                                            <small>Company</small>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" name="name" class="form-control" v-model="form.taxId" />
                                                            <small>Tax ID(Optional)</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Email option -->
                                        <div class="form-group" v-if="data.field === 'email_option'" >
                                            
                                            <div class="custom-control custom-checkbox" >
                                                <input type="checkbox" id="action-3" class="custom-control-input" v-model="form.emailOption"> 
                                                <label for="action-3" class="custom-control-label">{{ data.label }}</label> 
                                                <p class="help-block" v-if="data.helpBlock != null">{{ data.helpBlock }}</p>
                                            </div>

                                        </div>
                                        <!-- block two end -->
                                        <!-- block three start -->
                                        <div class="form-group" v-if="data.field === 'paymentMethod'" >
                                            <div >
                                                <label>{{ data.label }}</label>
                                            </div>
                                        </div>
                                        <!-- block three end -->

                                            

                                        <!-- single line of text start -->
                                        <div class="form-group" v-if="data.field === 'singleText'" >
                                            <div class=" w-100" >
                                                <label for="clientName">{{ data.label }} <small v-show="data.isRequired == false">(optional)</small></label>
                                                <input type="text" class="form-control" :placeholder="data.placeholder"  />
                                                <p>{{ data.helpBlock }}</p>
                                            </div>
                                        </div>
                                        <!-- single line of text end -->


                                        <!-- Multiple line of text start -->
                                        <div class="form-group" v-if="data.field === 'multiText'" >
                                     
                                            <div >
                                                <label for="clientName">{{ data.label }} <small v-show="data.isRequired == false">(optional)</small></label>
                                                <textarea class="form-control" spellcheck="false" :placeholder="data.placeholder"></textarea>
                                                <p>{{ data.helpBlock }}</p>
                                            </div>
                                        </div>
                                        <!-- Multiple line of text end -->


                                        <!-- Checkbox start -->
                                        <div class="form-group" v-if="data.field === 'checkbox'" >
                                           
                                            <div class="custom-control custom-checkbox" >
                                                <input type="checkbox" id="action-2" class="custom-control-input"> 
                                                <label for="action-2" class="custom-control-label">{{ data.label }} <small v-show="data.isRequired == false">(optional)</small></label> 
                                                <p>{{ data.helpBlock }}</p>
                                            </div>
                                        </div>
                                        <!-- Checkbox end -->

                                        <!-- dropdown start -->
                                        <div class="form-group" v-if="data.field === 'dropdown'" >
                                         
                                            <div >
                                                <label for="clientName">{{ data.label }} <small v-show="data.isRequired == false">(optional)</small></label>
                                                <div class="dropdown">
                                                    <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle w-100 text-left" aria-expanded="false">{{ data.hasItem[0].option }}
                                                        <span class="bs-caret float-right">
                                                            <span class="caret"></span>
                                                        </span>
                                                    </button> 
                                                    <div class="dropdown-menu w-100" x-placement="bottom-start" style="">
                                                        <a href="#" class="dropdown-item" draggable="false" v-for="(item, roll) in data.hasItem" :key="item.optionValue" :label="roll">{{ item.option }}</a> 
                                                       
                                                    </div>
                                                </div>
                                                <p>{{ data.helpBlock }}</p>
                                            </div>
                                        </div>
                                        <!-- dropdown end -->

                                        <!-- file upload start -->
                                        <div class="form-group" v-if="data.field === 'fileUpload'" >
                                         
                                            <div >
                                                <label for="clientName">{{ data.label }} <small v-show="data.isRequired == false">(optional)</small></label>
                                                <div class="custom-file">

                                                    <input type="file" class="custom-file-input" id="validatedCustomFile" required>
                                                    <label class="custom-file-label" for="validatedCustomFile">{{ data.placeholder }}</label>
                                                    <div class="invalid-feedback">Example invalid custom file feedback</div>
                                                    <p v-if="data.helpblock != ''">{{ data.helpBlock }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- file upload end -->

                                        <!-- spread Sheet start -->
                                        <div class="form-group" v-if="data.field === 'spreadSheetInput'" >
                               
                                            <div  >
                                                <label>{{ data.label }}</label>
                                                <table class="slick-preview">
                                                    <tr>
                                                        <th>&nbsp;</th> 
                                                        <th v-for="(item, roll) in data.hasItem">{{ item.option  }}</th>
                                                    </tr> 
                                                    <tr>
                                                        <th>1</th> 
                                                        <td v-for="(item, roll) in data.hasItem"></td>
                                                    </tr> 
                                                   
                                                </table>
                                            </div>
                                        </div>
                                        <!-- spread Sheet start -->

                                        <!-- section break start -->
                                        <div class="form-group" v-if="data.field === 'sectionBreak'" >
                                    
                                            <p class="mb-0" >{{ data.helpBlock }}</p>
                                        </div>
                                        <!-- section break end -->

                                        <!-- page break start -->
                                        <div class="form-group" v-if="data.field === 'pageBreak'">
                                    
                                            <div >
                                                <button type="button" class="btn btn-success pl-5 pr-5 disabled">Next</button>
                                                <p class="mb-0 mt-2">{{ data.helpBlock }}</p>
                                            </div>
                                        </div>
                                        <!-- page break end -->
                                    </div>
                                    <div class="stripe-card-wrap">
                                      <card class='stripe-card'
                                        :class='{ complete }'
                                        stripe='pk_test_5xpRbUpAyqZ5pDE3cVEqyGUu00LWZqwxd1'
                                        :options='stripeOptions'
                                        @change='change($event)'
                                      />
                                      <div id="card-errors" role="alert" v-text="stripeErrorMessage"></div>
                                    </div>
                                    <!-- <button class='pay-with-stripe' @click='pay' :disabled='!complete'>Pay with credit card</button> -->


                                    <button type="submit" class="btn btn-primary btn-block btn-lg" data-continue="Continue to Payment" data-continue-paypal="Continue to PayPal" >Continue to Payment</button>
                                </div><!-- email -->
                            </div>



                        </div><!-- /. main-content-left -->
                        <div class="col-md-4">
                            <div class="content-right">
                                <div class="main-content-right">
                                    <table class="table last-right">
                                        <thead>
                                            <tr>
                                                <th colspan="3">Order summary</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- single service -->
                                            <tr v-if="form.opt_single_service.length != 0">
                                                <td class="quantity">{{ form.opt_single_service.quantity }}×</td>
                                                <td>{{ form.opt_single_service.name }}</td>
                                                <td>${{ form.opt_single_service.price }}</td>
                                            </tr>
                                            <!-- multiple service -->
                                            <tr v-if="form.ckboxMultiServices.length != 0" v-for="service in form.ckboxMultiServices">
                                                <td class="quantity">{{ service.quantity }}×</td>
                                                <td>{{ service.name }}</td>
                                                <td>${{ service.price }}</td>
                                            </tr>
                                            <!-- dropdown single service -->
                                            <tr v-if="form.dropDownSingleService.length != 0" >
                                                <td class="quantity" v-if="form.dropSingleQty.length != 0">{{ form.dropSingleQty }}×</td>
                                                <td class="quantity" v-else>1×</td>
                                                <td>{{ form.dropDownSingleService.name}}</td>
                                                <td>${{ form.dropDownSingleService.price }}</td>
                                            </tr>
                                            <!-- dropdown multiple service -->
                                            <tr v-if="form.dropDownMultipleServices.length != 0" v-for="(service, index) in form.dropDownMultipleServices">
                                                <td class="quantity" v-if="form.dropMultiQty[index] >= 2">{{ form.dropMultiQty[index] }}×</td>
                                                <td class="quantity" v-else>1×</td>
                                                <td>{{ service.name}}</td>
                                                <td>${{ service.price }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="table last-right totals mb-4">
                                        <tbody>
                                            <tr class="strong">
                                                <td>Total</td>
                                                <!-- <td>USD ${{ updateCart() }}</td> -->
                                                <td>USD ${{ form.total }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="d-flex align-items-center justify-content-between coupon-row mt-2">
                                        <a href="#" id="coupon-link" class="mr-2">Have a coupon?</a>
                                        <button type="submit" class="btn btn-outline-primary ml-auto">Continue to Payment</button>
                                    </div>
                                </div>
                                <div class="text-center">
                                   <img src="https://seodashboard.spp.io/img/badge-secure.png" title="Secure order form" width="100" alt="Secure checkout badge">
                                   <img src="https://seodashboard.spp.io/img/badge-privacy.png" title="Your privacy is guaranteed" width="100" alt="Privacy guarantee badge">
                                </div>
                                <div class="helptext">
                                    Questions? We're here to help.<br>
                                    <a href="">Contact us</a>
                                </div>
                            </div>
                        </div><!-- /. main-content-left -->
                    </div>
                </div>
                <notifications group="checkErrors" position="top center" />
            </form>
        </div>
        <!-- /. main-content -->
    </div>

</template>


 


<script>
    import { Card, createToken } from 'vue-stripe-elements-plus'
    import Notifications from 'vue-notification';
    Vue.use(Notifications)
    export default {
        props: ['data','user','clientinfo'],
        data () {
    
            return {
                stripeErrorMessage: '',
                complete: false,
                stripeOptions: {
                    // see https://stripe.com/docs/stripe.js#element-options for details
                    style: {
                      base: {
                        color: '#32325d',
                        lineHeight: '18px',
                        fontFamily: '"Raleway", Helvetica, sans-serif',
                        fontSmoothing: 'antialiased',
                        fontSize: '16px',
                        '::placeholder': {
                          color: '#aab7c4'
                        }
                      },
                      invalid: {
                        color: '#fa755a',
                        iconColor: '#fa755a'
                      }
                    },
                    hidePostalCode: true
                },
                errors:[],
                baseForm: new Form({
                    formName: this.data.formName,
                    formInfo: this.data.formInfo,
                    cuponCode: this.data.cuponCode,
                    form:JSON.parse(this.data.orderForm)
                }),

                form: new Form({
                    formLink: this.data.formLink,
                    opt_single_service:[],
                    radioSingleQty:[],
                    ckboxMultiServices:[],
                    ckbxMultiQty:[],
                    dropDownSingleService:[],
                    dropSingleQty:1,
                    dropDownMultipleServices:[],
                    dropMultiQty:[],
                    email: typeof(this.user) !== 'undefined' ? this.user.email : "",
                    name: typeof(this.user) !== 'undefined' ? this.user.name : "",
                    password:'',
                    address: typeof(this.clientinfo) !== 'undefined' ? this.clientinfo.address : "",
                    city: typeof(this.clientinfo) !== 'undefined' ? this.clientinfo.city : "",
                    country: typeof(this.clientinfo) !== 'undefined' ? this.clientinfo.country : "",
                    state: typeof(this.clientinfo) !== 'undefined' ? this.clientinfo.state : "",
                    postalCode: typeof(this.clientinfo) !== 'undefined' ? this.clientinfo.post_code : "",
                    isCompany:'',
                    companyName:'',
                    taxId:'',
                    emailOption:'',
                    stripeToken:'',
                    total:0
                }),
                multiDropdown: 1,
                
            }
        },

        components: { Card },

        methods: {
            // pay () {
            //   // createToken returns a Promise which resolves in a result object with
            //   // either a token or an error key.
            //   // See https://stripe.com/docs/api#tokens for the token object.
            //   // See https://stripe.com/docs/api#errors for the error object.
            //   // More general https://stripe.com/docs/stripe.js#stripe-create-token.
            //   createToken().then(data => console.log(data.token))
            // },
            change(event) {
                // if (event.error) {
                //   this.errorMessage = event.error.message;
                // } else {
                //   this.errorMessage = ''
                // }
                this.stripeErrorMessage = event.error ? event.error.message : ''
            },
            // for single service radio button
            rdBtnSingleAddQut() {

                var valObj = this.baseForm.form.filter(function(elem){
                    if(elem.field == "opt_single_service") {
                        var count1 = elem.hasServices.length;
                        var count2 = elem.hasServices[0].length;
                        //console.log(count2)
                        for (var i = 0; i < count1; i++) {
                            for (var j = 0; j < count2; j++) {
                                elem.hasServices[i][j] = Object.assign({}, elem.hasServices[i][j], {quantity: 1})
                            }
                        }
                    }
                   
                });
            },

            // for multiple service checkbox
            ckBoxServiceAddQut() {

                var valObj = this.baseForm.form.filter(function(elem){
                    if(elem.field == "ckboxMultiServices") {
                        var count1 = elem.hasServices.length;
                        var count2 = elem.hasServices[0].length;
                        //console.log(count2)
                        for (var i = 0; i < count1; i++) {
                            for (var j = 0; j < count2; j++) {
                                elem.hasServices[i][j] = Object.assign({}, elem.hasServices[i][j], {quantity: 1})
                            }
                        }
                    }
                   
                }); 
            },

            profileLink(email){
                return '../profile';
            },
            addMultiDropdown() {
                this.multiDropdown++ ;
                //console.log(this.multiDropdown);
            },
            //add cart item
            updateCart() {
                //total
                //let total = 0;
                let radioBtnTotal = 0;
                let ckBoxTotal = 0;
                let dropdownSingleTotal = 0;
                let dropServiceTotal = 0;

                //radio button single service
                if(this.form.opt_single_service && this.form.opt_single_service.length !== 0){
                    radioBtnTotal = Number(this.form.opt_single_service.price) * Number(this.form.opt_single_service.quantity);
                }
                //checkbox multiple service
                if(this.form.ckboxMultiServices) {
                    for (var i = 0; i < this.form.ckboxMultiServices.length; i++) {
                        ckBoxTotal += this.form.ckboxMultiServices[i].price * this.form.ckboxMultiServices[i].quantity;
                    }
                }

                //dropdown single service
                if(this.form.dropDownSingleService && this.form.dropDownSingleService.length !== 0){
                    dropdownSingleTotal = this.form.dropDownSingleService.price * this.form.dropSingleQty;
                }

                //dropdown multiple service 
                if(this.form.dropDownMultipleServices) {
                    for (var i = 0; i < this.form.dropDownMultipleServices.length; i++) {
                        var qty = this.form.dropMultiQty[i] ? this.form.dropMultiQty[i] : 1;
                        dropServiceTotal += this.form.dropDownMultipleServices[i].price * qty;
                    } 
                }
                //console.log(radioBtnTotal+ckBoxTotal+dropdownSingleTotal+dropServiceTotal);
                return this.form.total =  radioBtnTotal+ckBoxTotal+dropdownSingleTotal+dropServiceTotal;
            },

            // form data submit to database
            formSubmit() {


                this.errors = [];
                // error validation
                if (typeof(this.user) != 'undefined') {
                    if (this.user.account_role == 1) {
                        this.errors.push("Please sign out of admin account before placing an order.");
                    }
                }
                // error validation
                //console.log(Object.keys(this.form.opt_single_service).length == 0);
                if (this.form.total === 0) {
                    this.errors.push("No items in your cart yet...");
                }
                

                // if there have no error then the form will be submit
                this.$Progress.start();
                if(this.errors.length === 0) {

                    createToken().then(data =>  {
                      this.form.stripeToken = data.token.id;
                      this.form.post('/api/create-order')
                    })
                    .then((order)=>{

                      //console.log("Test");
                      this.$Progress.finish()
                      //axios.get('order-form');\
                      //console.log(order.data.order.id);
                      //window.location.href = "../order-form/"+order.data.order.id+"/edit";

                    }).catch(()=>{
                        this.$Progress.fail()
                    })

                } else {
                    this.$Progress.fail();
                    this.$notify({
                      group: 'checkErrors',
                      //title: 'Important message',
                      text: this.errors[0],
                      type:"warn"
                    });
                }
            },

        },

        mounted() {
            this.rdBtnSingleAddQut();
            this.ckBoxServiceAddQut();
        },
    };
</script>

<style scoped>
    .form-wrap{
        margin-top: 30px;
    }

    .form-wrap .form-group{
        margin-bottom: 30px;
    }
    .form-wrap .form-group label{
        font-weight: bold;
    }

    .main-content-right{
        padding: 15px;
        background:#fff;
        border-radius: .25rem;
        margin-bottom: 2rem;
    }
    .main-content-right .table th{
        border-top: none;
    }
    .strong {
        font-weight: 700;
    }
    .table.last-right tr td:last-child{
        text-align: right;
    }
    .table td{
        border:0px;
    }

    .table.last-right.totals {
        border-top: 1px solid #ddd;
    }

    .content-right .helptext {
        text-align: center;
        padding-top: 20px;
        padding-bottom: 20px;
        color: #6c757d;
    }
    .scard.p-2 {
        background: #f0f7ff;
        border: 1px solid #dbedff;
            margin-bottom: 10px;
    }

    .item-quantity {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        margin-top: 15px;
    }

    .item-quantity select {
        width: 45px;
        margin-left: 5px;
        padding: 0px;
        height: 25px;
        padding-left: 5px;
    }

    /*--- error maessage  -----*/

    .order-form .vue-notifications{
        margin-top: 0px;
        width: auto !important;
    }
    .order-form .vue-notification{
        margin:0;
    }

    .order-form .notification-wrapper{
        margin-bottom: 10px;
        box-shadow: 2px 2px 2px rgba(0,0,0, .5);
    }
    .vue-notification.warn{
        background: #FFF8E2 !important;
        border-left: 6px solid #ffc107;
        color: #6c757d;
        font-size: .8rem;
        padding: 1rem 1.25rem;
    }

    .help-block.invalid-feedback {
        color: #fa755a;
    }
    .form-control.is-invalid{
      border-color: #fa755a;
    }
    .stripe-card-wrap{

        margin-bottom: 30px;
    }
    .stripe-card {
        width: 100%;
        border: 1px solid #ced4da;
        padding: 10px;
        border-radius: 5px;
    }
    .stripe-card.complete {
      border-color: green;
    }

    div#card-errors {
        color: #fa755a;
    }

</style>

