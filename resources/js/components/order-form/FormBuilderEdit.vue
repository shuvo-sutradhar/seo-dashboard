<template>
    <section class="mb-4">
        <div class="dragabble-form-wrap">
                <form class="p-3" action="" method="post" enctype="multipart/form-data" @submit.prevent="formSubmit(data.id)">

                    <div class="row">
                        <div class="col-lg-8 col-xl-8">
                            <div class="card-body mb-3">
                                <div class="form-top gradient-bg">
                                    <h4 class="mb-3">{{ data.formName }}</h4>
                                    <a href="#" class="btn btn-default" style="border: inset 2px #000000;color: #000;">View Form</a>
                                </div>
                                <div class="form-group">
                                    <label for="formName">Form name <span class="required">*</span></label>
                                    <input type="text" id="formName" v-model="baseForm.formName" class="form-control" placeholder="John Einarson" >
                                </div>
                                <div class="form-wrap my-4">
                                    <div class="form-group" v-if="isShowing == false">
                                        <div class="d-flex" id="permalink-preview">
                                            <label class="mr-2">Form link:</label>
                                            <a :href="formUrl()+data.formLink" target="_blank">{{formUrl()}}{{ data.formLink }}</a>                                
                                            <button type="button" class="btn btn-default btn-sm ml-auto" @click="isShowing = true">Edit</button>
                                        </div>
                                    </div>
                                    <div class="form-group" v-else>
                                        <div class="" id="permalink-edit">
                                            <label for="#access-key">Form link</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">{{formUrl()}}</span>
                                                </div>
                                                <input type="text" v-model="baseForm.formLink" name="formLink" id="formLink" class="form-control">
                                            </div>
                                            <div class="help-block">Your original form link will still work if you change this to a custom link.</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password">Form information(Optional)</label>
                                    <textarea class="form-control" v-model="baseForm.formInfo"></textarea>
                                </div>

                                <div class="form-group">
                                    <div class="checkbox-custom checkbox-primary">
                                        <input type="checkbox" checked="" id="sendNotification" value="1" v-model="baseForm.cuponCode" >
                                        <label for="sendNotification">Show coupon field</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- dragable-form wrap start-->
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card-body-2">
                                <div class="form-devider">
                                    Drag and drop fields from the right column onto your form here...
                                </div>
                                <draggable v-model="baseForm.form" v-bind="dragOptions" class="dragabble-form" @start="isDragging = true" @end="isDragging = false">
                                   
                                    <div v-for="(data, index) in baseForm.form">

                                        <!--option group (single service) start -->
                                        <div class="form-group"  v-if="data.field === 'opt_single_service'" :class="{ 'is-active': data === activeForm  }">
                                            <button type="button" data-delete="" class="btn btn-sm remove-input" @click.prevent="clearField(data.field, index)"><i class="fas fa-trash"></i></button>
                                            <label for="clientName">{{ data.label }} <small v-if="data.isRequired == false">(optional)</small></label>
                                            <div class="form-row w-100" @click="editElementProperties(data)">
                                                <div class="col-md-6" v-for="(item, roll) in data.hasServices" :key="item.optionValue" :label="roll">
                                                    <div class="scard p-2">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" name="option0" id="action-0-0" class="custom-control-input" checked="checked"> 
                                                            <label for="action-0-0" class="custom-control-label">{{ item[data.selectedService[roll]].name }}</label> 
                                                            <p>{{ item[data.selectedService[roll]].price }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- option group (single service) end -->


                                        <!-- Checkbox group (multiple services) start -->
                                        <div class="form-group" v-if="data.field === 'ckboxMultiServices'" :class="{ 'is-active': data === activeForm  }">
                                            <button type="button" data-delete="" class="btn btn-sm remove-input" @click.prevent="clearField(data.field, index)"><i class="fas fa-trash"></i></button>
                                            <label for="clientName">{{ data.label }} <small v-show="data.isRequired == false">(optional)</small></label>
                                            <div class="form-row w-100" @click="editElementProperties(data)">
                                                <div class="col-md-6" v-for="(item, roll) in data.hasServices" :key="item.optionValue" :label="roll">
                                                    <div class="scard p-2">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" name="option1" :id="index" class="custom-control-input" checked="checked">
                                                            
                                                           <label :for="index" class="custom-control-label">{{ item[data.selectedService[roll]].name }} </label>
                                                            <p>{{ item[data.selectedService[roll]].price }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Checkbox group (multiple services) end -->

                                        <!-- Dropdown menu (single service) start -->
                                        <div class="form-group" v-if="data.field === 'dropDownSingleService'" :class="{ 'is-active': data === activeForm  }">
                                            <button type="button" data-delete="" class="btn btn-sm remove-input" @click.prevent="clearField(data.field, index)"><i class="fas fa-trash"></i></button>
                                            <div @click="editElementProperties(data)">
                                                <label for="clientName">{{ data.label }} <small v-show="data.isRequired == false">(optional)</small></label>
                                                <div class="dropdown">
                                                    <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle w-100 text-left" aria-expanded="false">{{ data.defaultSelected }}
                                                        <span class="bs-caret float-right">
                                                            <span class="caret"></span>
                                                        </span>
                                                    </button> 
                                                    <div class="dropdown-menu w-100" x-placement="bottom-start" style="">
                                                        <a href="#" class="dropdown-item" draggable="false">{{ data.defaultSelected }}</a> 
                                                        <a href="#" click.prevent="1" class="dropdown-item" draggable="false" v-for="(item, roll) in data.hasServices">{{ item[data.selectedService[roll]].name }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Dropdown menu (single service) end -->


                                        <!-- Dropdown menu (multiple services) start -->
                                        <div class="form-group" v-if="data.field === 'dropDownMultipleServices'" :class="{ 'is-active': data === activeForm  }">
                                            <button type="button" data-delete="" class="btn btn-sm remove-input" @click.prevent="clearField(data.field, index)"><i class="fas fa-trash"></i></button>
                                           <div @click="editElementProperties(data)">
                                                <label for="clientName">{{ data.label }} <small v-show="data.isRequired == false">(optional)</small></label>
                                                <div class="dropdown">
                                                    <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle w-100 text-left" aria-expanded="false">{{ data.defaultSelected }}
                                                        <span class="bs-caret float-right">
                                                            <span class="caret"></span>
                                                        </span>
                                                    </button> 
                                                    <div class="dropdown-menu w-100" x-placement="bottom-start" style="">
                                                        <a href="#" class="dropdown-item" draggable="false">{{ data.defaultSelected }}</a> 
                                                        <a href="#" click.prevent="1" class="dropdown-item" draggable="false" v-for="(item, roll) in data.hasServices">{{ item[data.selectedService[roll]].name }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Dropdown menu (multiple services) end -->

                                        <!-- block two start -->
                                        <div class="form-group" v-if="data.field === 'fullName'" :class="{ 'is-active': data === activeForm  }">
                                            <button type="button" data-delete="" class="btn btn-sm remove-input" @click.prevent="clearField(data.field, index)"><i class="fas fa-trash"></i></button>
                                            <label for="clientName"  @click="editElementProperties(data)">{{ data.label }}</label>
                                            <div class="form-row w-100" @click="editElementProperties(data)">
                                                <div class="col-md-12">
                                                    <input type="text" name="name" class="form-control"  />
                                                    <small>Full Name</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" v-if="data.field === 'email'" :class="{ 'is-active': data === activeForm  }">
                                            <button type="button" data-delete="" class="btn btn-sm remove-input" @click.prevent="clearField(data.field, index)"><i class="fas fa-trash"></i></button>
                                            <div @click="editElementProperties(data)">
                                                <label :for="data.field">{{ data.label }}</label>
                                                <input id:="data.field" type="email" name="name" class="form-control" :placeholder="data.placeholder" />
                                            </div>
                                        </div>
                                        <div class="form-group" v-if="data.field === 'password'" :class="{ 'is-active': data === activeForm  }">
                                            <button type="button" data-delete="" class="btn btn-sm remove-input" @click.prevent="clearField(data.field, index)"><i class="fas fa-trash"></i></button>
                                            <div @click="editElementProperties(data)">
                                                <label for="clientName">{{ data.label }}</label>
                                                <input type="password" class="form-control" :placeholder="data.placeholder" />
                                            </div>
                                        </div>
                                        <div class="form-group" v-if="data.field === 'billingAddress'" :class="{ 'is-active': data === activeForm  }">
                                            <button type="button" data-delete="" class="btn btn-sm remove-input" @click.prevent="clearField(data.field, index)"><i class="fas fa-trash"></i></button>
                                            <div @click="editElementProperties(data)">
                                                <label :for="data.field">{{ data.label }}</label>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                            <input type="text" name="name" class="form-control"  />
                                                            <small>Address</small>
                                                    </div>
                                                    <div class="col-md-4">
                                                            <input type="text" name="name" class="form-control"  />
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
                                                        <input type="text" name="name" class="form-control"  />
                                                        <small>State / Province / Region</small>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="text" name="name" class="form-control"  />
                                                        <small>Postal Code</small>
                                                    </div>
                                                    <div class="col-md-12 pt-2">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" id="action-2" class="custom-control-input"> 
                                                            <label for="action-2" class="custom-control-label">I'm purchasing for a company</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" v-if="data.field === 'email_option'" :class="{ 'is-active': data === activeForm  }">
                                            <button type="button" data-delete="" class="btn btn-sm remove-input" @click.prevent="clearField(data.field, index)"><i class="fas fa-trash"></i></button>
                                            <div class="custom-control custom-checkbox" @click="editElementProperties(data)">
                                                <input type="checkbox" id="action-3" class="custom-control-input"> 
                                                <label for="action-3" class="custom-control-label">{{ data.label }}</label> 
                                                <p class="help-block" v-if="data.helpBlock != null">{{ data.helpBlock }}</p>
                                            </div>
                                        </div>
                                        <!-- block two end -->
                                        <!-- block three start -->
                                        <div class="form-group" v-if="data.field === 'paymentMethod'" :class="{ 'is-active': data === activeForm  }">
                                            <button type="button" data-delete="" class="btn btn-sm remove-input" @click.prevent="clearField(data.field, index)"><i class="fas fa-trash"></i></button>
                                            <div @click="editElementProperties(data)">
                                                <label>{{ data.label }}</label>
                                            </div>
                                        </div>
                                        <!-- block three end -->

                                            

                                        <!-- single line of text start -->
                                        <div class="form-group" v-if="data.field === 'singleText'" :class="{ 'is-active': data === activeForm  }">
                                            <button type="button" data-delete="" class="btn btn-sm remove-input" @click.prevent="clearField(data.field, index)"><i class="fas fa-trash"></i></button>
                                            <div class=" w-100" @click="editElementProperties(data)">
                                                <label for="clientName">{{ data.label }} <small v-show="data.isRequired == false">(optional)</small></label>
                                                <input type="text" class="form-control" :placeholder="data.placeholder"  />
                                                <p>{{ data.helpBlock }}</p>
                                            </div>
                                        </div>
                                        <!-- single line of text end -->


                                        <!-- Multiple line of text start -->
                                        <div class="form-group" v-if="data.field === 'multiText'" :class="{ 'is-active': data === activeForm  }">
                                            <button type="button" data-delete="" class="btn btn-sm remove-input" @click.prevent="clearField(field, index)"><i class="fas fa-trash"></i></button>
                                            <div @click="editElementProperties(data)">
                                                <label for="clientName">{{ data.label }} <small v-show="data.isRequired == false">(optional)</small></label>
                                                <textarea class="form-control" spellcheck="false" :placeholder="data.placeholder"></textarea>
                                                <p>{{ data.helpBlock }}</p>
                                            </div>
                                        </div>
                                        <!-- Multiple line of text end -->


                                        <!-- Checkbox start -->
                                        <div class="form-group" v-if="data.field === 'checkbox'" :class="{ 'is-active': data === activeForm  }">
                                            <button type="button" data-delete="" class="btn btn-sm remove-input" @click.prevent="clearField(field, index)"><i class="fas fa-trash"></i></button>
                                            <div class="custom-control custom-checkbox" @click="editElementProperties(data)">
                                                <input type="checkbox" id="action-2" class="custom-control-input"> 
                                                <label for="action-2" class="custom-control-label">{{ data.label }} <small v-show="data.isRequired == false">(optional)</small></label> 
                                                <p>{{ data.helpBlock }}</p>
                                            </div>
                                        </div>
                                        <!-- Checkbox end -->

                                        <!-- dropdown start -->
                                        <div class="form-group" v-if="data.field === 'dropdown'" :class="{ 'is-active': data === activeForm  }">
                                            <button type="button" data-delete="" class="btn btn-sm remove-input" @click.prevent="clearField(data.field, index)"><i class="fas fa-trash"></i></button>
                                            <div @click="editElementProperties(data)">
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
                                        <div class="form-group" v-if="data.field === 'fileUpload'" :class="{ 'is-active': data === activeForm  }">
                                            <button type="button" data-delete="" class="btn btn-sm remove-input" @click.prevent="clearField(data.field, index)"><i class="fas fa-trash"></i></button>
                                            <div @click="editElementProperties(data)">
                                                <label for="clientName">{{ data.label }} <small v-show="data.isRequired == false">(optional)</small></label>
                                                <div class="custom-file">

                                                    <input type="file" class="custom-file-input" id="validatedCustomFile">
                                                    <label class="custom-file-label" for="validatedCustomFile">{{ data.placeholder }}</label>
                                                    <div class="invalid-feedback">Example invalid custom file feedback</div>
                                                    <p v-if="data.helpblock != ''">{{ data.helpBlock }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- file upload end -->

                                        <!-- spread Sheet start -->
                                        <div class="form-group" v-if="data.field === 'spreadSheetInput'" :class="{ 'is-active': data === activeForm  }">
                                            <button type="button" data-delete="" class="btn btn-sm remove-input" @click.prevent="clearField(data.field, index)"><i class="fas fa-trash"></i></button>
                                            <div  @click="editElementProperties(data)">
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
                                        <div class="form-group" v-if="data.field === 'sectionBreak'" :class="{ 'is-active': data === activeForm  }">
                                            <button type="button" data-delete="" class="btn btn-sm remove-input" @click.prevent="clearField(data.field, index)"><i class="fas fa-trash"></i></button>
                                            <p class="mb-0" @click="editElementProperties(data)">{{ data.helpBlock }}</p>
                                        </div>
                                        <!-- section break end -->

                                        <!-- page break start -->
                                        <div class="form-group" v-if="data.field === 'pageBreak'" :class="{ 'is-active': data === activeForm  }">
                                            <button type="button" data-delete="" class="btn btn-sm remove-input" @click.prevent="clearField(data.field, index)"><i class="fas fa-trash"></i></button>
                                            <div @click="editElementProperties(data)">
                                                <button type="button" class="btn btn-success pl-5 pr-5 disabled">Next</button>
                                                <p class="mb-0 mt-2">{{ data.helpBlock }}</p>
                                            </div>
                                        </div>
                                        <!-- page break end -->
                                    </div>
                                    
                                </draggable>
                                <button type="submit" class="mb-4 mt-1 mr-1 btn btn-primary ml-4"><i class="fas fa-plus"></i> Save form</button>
                            </div>
                        </div><!-- /. dragable-form left -->
                        <div class="col-lg-4">
                            <div class="sticky-top">
                                <div  v-show="elementInput === true">
                                   <div class="list-group mb-3 available-fields">

                                        <!-- 1. check box single service -->
                                        <button type="button" class="list-group-item list-group-item-action" @click="ckBoxSingleService" >
                                            <i class="fas fa-dot-circle"></i> 
                                            <span class="ml-2">Option group (single service)</span>
                                        </button>

                                        <!-- 2. check box multiple service -->
                                        <button type="button" class="list-group-item list-group-item-action" @click="ckBoxMultipleService">
                                            <i class="fas fa-check"></i>
                                            <span class="ml-2">Checkbox group (multiple services)</span>
                                        </button>
                                        <!-- 3. dropdown single service -->
                                        <button type="button" class="list-group-item list-group-item-action" @click="dropDownSingle">
                                            <i class="fas fa-sort"></i> 
                                            <span class="ml-2">Dropdown menu (single service)</span>
                                        </button>

                                        <!-- 4. dropdown multiple service -->
                                        <button type="button" class="list-group-item list-group-item-action" @click="dropDownMultiple">
                                            <i class="fas fa-sort"></i> 
                                            <span class="ml-2">Dropdown menu (multiple services)</span>
                                        </button>
                                    </div>
                                    <div class="list-group mb-3 available-fields">

                                        <!-- 5. full name -->
                                        <button type="button" class="list-group-item list-group-item-action" @click="fullName" >
                                            <i class="fas fa-user"></i> 
                                            <span class="ml-2">Full name</span>
                                        </button>

                                        <!-- 6. email -->
                                        <button type="button" class="list-group-item list-group-item-action" @click="email">
                                            <i class="fas fa-envelope-open"></i> 
                                            <span class="ml-2">Email</span>
                                        </button>

                                        <!-- 7. password -->
                                        <button type="button" class="list-group-item list-group-item-action" @click="password">
                                            <i class="fas fa-unlock-alt"></i> 
                                            <span class="ml-2">Password</span>
                                        </button>

                                        <!-- 8. billing address -->
                                        <button type="button" class="list-group-item list-group-item-action" @click="billingAddress">
                                            <i class="fas fa-address-card"></i> 
                                            <span class="ml-2">Billing address</span>
                                        </button>

                                        <!-- 9. email option -->
                                        <button type="button" class="list-group-item list-group-item-action" @click="email_option">
                                            <i class="fas fa-envelope-open"></i> <span class="ml-2">Email Opt-in</span>
                                        </button>
                                    </div>
                                    <div class="list-group mb-3 available-fields">

                                        <!-- 10. payment method -->
                                        <button type="button" class="list-group-item list-group-item-action" @click="paymentMethod">
                                            <i class="fas fa-credit-card"></i> <span class="ml-2">Payment Method</span>
                                        </button>
                                    </div>
                                    <div class="list-group mb-3 available-fields">

                                        <!-- 11. single text -->
                                        <button type="button" class="list-group-item list-group-item-action" @click="singleText(true)">
                                            <i class="fas fa-i-cursor"></i> 
                                            <span class="ml-2">Single line of text</span>
                                        </button>
                                        
                                        <!-- 12. multi text -->
                                        <button type="button" class="list-group-item list-group-item-action" @click="multiText">
                                            <i class="fas fa-align-left"></i> 
                                            <span class="ml-2">Multiple lines of text</span>
                                        </button>

                                        <!-- 13. checkbox -->
                                        <button type="button" class="list-group-item list-group-item-action" @click="checkbox">
                                            <i class="fas fa-check-square"></i> 
                                            <span class="ml-2">Checkbox</span>
                                        </button>

                                        <!-- 14. dropdown -->
                                        <button type="button" class="list-group-item list-group-item-action" @click="dropdown">
                                            <i class="fas fa-sort"></i> 
                                            <span class="ml-2">Dropdown menu</span>
                                        </button>

                                        <!-- 15. file upload -->
                                        <button type="button" class="list-group-item list-group-item-action" @click="fileUpload">
                                            <i class="fas fa-upload"></i>
                                            <span class="ml-2">File upload</span>
                                        </button>

                                        <!-- 16. spread sheet -->
                                        <button type="button" class="list-group-item list-group-item-action" @click="spreadSheetInput">
                                            <i class="fas fa-table"></i> 
                                            <span class="ml-2">Spreadsheet input</span>
                                        </button>
                                    </div>
                                    <div class="list-group mb-3 available-fields">

                                        <!-- 17. section break -->
                                        <button type="button" class="list-group-item list-group-item-action" @click="sectionBreak">
                                            <i class="fas fa-minus"></i> 
                                            <span class="ml-2">Section break</span>
                                        </button>

                                        <!-- 18. page break -->
                                        <button type="button" class="list-group-item list-group-item-action" @click="pageBreak">
                                            <i class="fas fa-clone"></i> 
                                            <span class="ml-2">Page break</span>
                                        </button>
                                    </div>
                                </div>
                                <div v-show="elementInput === false">
                                    <div class="card sticky-top edit-field">
                                        
                                       <div class="card-header">
                                          Edit
                                          <code>{{  activeForm.field }} </code> <a class="close float-right" @click="fieldCardClose">×</a>
                                       </div>
                                       <div class="card-body">

                                          <!-- field name -->
                                          <div class="form-group">
                                            <label>Field name</label> 
                                            <input type="text" v-model="activeForm.label" :placeholder="activeForm.label" class="form-control">
                                          </div>

                                          <!-- default name -->
                                          <div class="form-group" v-show="activeForm.hasOwnProperty('defaultSelected')">
                                            <label>Default</label> 
                                            <input type="text" v-model="activeForm.defaultSelected" :placeholder="activeForm.defaultSelected" class="form-control">
                                          </div>

                                          <!-- placeholder text -->
                                          <div class="form-group" v-show="activeForm.hasOwnProperty('placeholder')">
                                             <label>Placeholder text</label> 
                                             <input type="text" v-model="activeForm.placeholder" class="form-control"> 
                                             <p class="help-block">Shown inside the field</p>
                                          </div>

                                          <!-- services text -->
                                          <div class="form-group" v-if="activeForm.hasOwnProperty('hasServices')">
                                            <label>Services</label>
                                            <div class="d-flex align-items-start justify-content-center service-add" v-if="activeForm['hasOwnProperty'].length">
                                                <div class="form-group w-100" >
                                                    <div class="d-flex itemRemove" v-for="(serviceProject, serviceIndex) in activeForm.hasServices">
                                                        <select class="form-control" v-model="activeForm.selectedService[serviceIndex]">
                                                                <option disabled selected="selected">Please select a service</option>
                                                                <option v-for="(service, sindex) in serviceProject" :key="sindex" :value="sindex">
                                                                    <p>{{ service.name }}</p>
                                                                    <p> (${{ service.price }})</p>
                                                                </option>
                                                        </select>
                                                        <button type="button" class="btn btn-sm remove" v-show="activeForm.hasServices.length > 1">
                                                            <i class="fas fa-trash" @click="deleteOption(activeForm.hasServices, activeForm.selectedService, serviceIndex)"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="service-none" v-else>
                                                All services
                                            </div>
                                            <button type="button" class="btn btn-link p-0" @click="addService(activeForm.hasServices, activeForm.hasServices[0])">+ Add service</button>
                                          </div> 

                                          <!-- Item for spreed sheet -->
                                          <div class="form-group" v-if="activeForm.hasOwnProperty('hasItem')">
                                            <label v-if="activeForm.field === 'spreadSheetInput'">Columns</label>
                                            <label v-else>Items</label>
                                            <div class="form-group">
                                                <div class="d-flex itemRemove" v-for="(item, activeIndex) in activeForm.hasItem" :key="activeIndex" style="margin-bottom:10px">
                                                    <input type="text" v-model="item.option" class="form-control" >
                                                    <button type="button" class="btn btn-sm remove" @click="deleteOption(activeForm.hasItem,activeIndex)" v-show="activeForm.hasItem.length > 1">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-link p-0" @click="addOption(activeForm.hasItem)">
                                                <span v-if="activeForm.field === 'spreadSheetInput'">+ Add column</span>
                                                <span v-else>+ Add item</span>
                                            </button>
                                          </div>

                                          <!-- Help text -->
                                          <div class="form-group" v-show="activeForm.hasOwnProperty('helpBlock')">
                                             <label>Help Text</label> 
                                             <textarea placeholder="Enter your full URL and anchor text" class="form-control" style="resize: none; overflow: hidden; height: 55px;" spellcheck="false" v-model="activeForm.helpBlock" ></textarea>
                                             <p class="help-block">Shown next to the field, supports HTML</p>
                                          </div>

                                          <!-- allow multiple files -->
                                          <div class="form-group" v-show="activeForm.hasOwnProperty('allowMultiple')">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" id="required" value="true" class="custom-control-input" v-model="activeForm.allowMultiple"> 
                                                <label for="required" class="custom-control-label">Allow multiple files</label>
                                            </div>
                                          </div>

                                          <!-- Has Quantaty -->
                                          <div class="form-group" v-show="activeForm.hasOwnProperty('hasQuantaty')">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" id="required12" value="true" class="custom-control-input" v-model="activeForm.hasQuantaty"> 
                                                <label for="required12" class="custom-control-label">Show quantity input</label>
                                            </div>
                                          </div>
                                          <!-- Is Required -->
                                          <div class="form-group" v-show="activeForm.hasOwnProperty('isRequired')">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" id="required1" value="true" class="custom-control-input" v-model="activeForm.isRequired"> 
                                                <label for="required1" class="custom-control-label">This is a required field</label>
                                            </div>
                                          </div>

                                          <!----> <!----> <!----> <!----> 
                                          <div class="text-right"><button type="button" class="btn btn-secondary" @click="fieldCardClose">Close</button></div>
                                       </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /. dragable-form right -->
                    </div>
                    <!-- dragable-form wrap end-->
                </form>
                <!-- notification warning messge modal -->
                <notifications group="checkErrors" position="top center" />
        </div>
    </section>

</template>


 


<script>
    import draggable from "vuedraggable";
    import Notifications from 'vue-notification';
    Vue.use(Notifications)

    export default {
        props: ['data'],
        data () {
    
            return {
                link:window.location.origin,
                isShowing:false,
                errors:[],
                elementInput:true,
                activeForm:[],
                services:[],
                baseForm: new Form({
                    formName: this.data.formName,
                    formLink: this.data.formLink,
                    formInfo: this.data.formInfo,
                    cuponCode: this.data.cuponCode,
                    form:JSON.parse(this.data.orderForm)
                })
            }
        },

        methods: {
            formUrl(){
                return this.link+"/order/";
            },
            sort() {
              this.baseForm.form = this.baseForm.form.sort((a, b) => a.order - b.order);
            },
            // 1. check box single service
            ckBoxSingleService () {
                this.baseForm.form.push({
                    field: 'opt_single_service',
                    order:1,
                    label: 'Option group (single service)',
                    hasQuantaty:false,
                    hasServices: [
                        this.services
                    ],
                    selectedService:[0],
                });
            },
            // 2. check box multiple service
            ckBoxMultipleService () {
                this.baseForm.form.push({
                    field: 'ckboxMultiServices',
                    order:2,
                    label: 'Checkbox group (multiple services)',
                    hasQuantaty:false,
                    isRequired:false,
                    hasServices: [
                        this.services
                    ],
                    selectedService:[0],
                })
            },
            // 3. dropdown single service
            dropDownSingle () {
                this.baseForm.form.push({
                    field: 'dropDownSingleService',
                    order:3,
                    label: 'Dropdown menu (single service)',
                    defaultSelected:"Choose a service",
                    hasQuantaty:false,
                    isRequired:false,
                    hasServices: [
                        this.services
                    ],
                    selectedService:[0],
              
                })
            },
            // 4. dropdown multiple service
            dropDownMultiple () {
                this.baseForm.form.push({
                    field: 'dropDownMultipleServices',
                    order:4,
                    label: 'Dropdown menu (multiple services)',
                    defaultSelected:"Choose a service",
                    hasQuantaty:false,
                    isRequired:false,
                    hasServices: [
                        this.services
                    ],
                    selectedService:[0],
          
                })
            },
            // 5. full name
            fullName() {
                this.baseForm.form.push({
                    field: 'fullName',
                    order:5,
                    label: 'Full Name',
                })
            },
            // 6. email
            email() {
                this.baseForm.form.push({
                    field: 'email',
                    order:6,
                    label: 'Email',
                    placeholder: '',
                })
            },
            // 7. password
            password() {
                this.baseForm.form.push({
                    field: 'password',
                    order:7,
                    label: 'Password',
                    placeholder: '',
                })
            },
            // 8. billing address
            billingAddress() {
                this.baseForm.form.push({
                    field: 'billingAddress',
                    order:8,
                    label: 'Billing Address',
                })
            },
            // 9. email option
            email_option() {
                this.baseForm.form.push({
                    field: 'email_option',
                    order:9,
                    label: 'Email Opt-in',
                    helpBlock:'Check this box if you\'d like to receive occasional emails from us',
                })
            },
            // 10. payment method
            paymentMethod() {
                this.baseForm.form.push({
                    field: 'paymentMethod',
                    order:10,
                    label: 'Payment Method',
                })
            },
            // 11. single text
            singleText() {
                this.baseForm.form.push({
                    field: 'singleText',
                    order:11,
                    label:'Single line of text',
                    helpBlock:'',
                    isRequired:false,
                    placeholder:'',
                })
            },
            // 12. multi text
            multiText() {
                this.baseForm.form.push({
                    field: 'multiText',
                    order:12,
                    label:'Multiple lines of text',
                    helpBlock:'',
                    isRequired:false,
                    placeholder:'',
                })
            },
            // 13. checkbox
            checkbox() {
                this.baseForm.form.push({
                    field: 'checkbox',
                    order:13,
                    label:'Checkbox',
                    helpBlock:'',
                    isRequired:false,
                })
            },
            // 14. dropdown
            dropdown() {
                this.baseForm.form.push({
                    field: 'dropdown',
                    order:14,
                    label:'Dropdown menu',
                    helpBlock:'',
                    isRequired:false,
                    hasItem: [
                        { option: "Item 1"},
                        { option: "Item 2"}
                    ],
                })
            },
            // 15. file upload
            fileUpload() {
                this.baseForm.form.push({
                    field: 'fileUpload',
                    order:15,
                    label:'File Upload',
                    placeholder:'Choose file...',
                    helpBlock:'',
                    isRequired:false,
                    allowMultiple:false,
                })
            },
            // 16. spread sheet
            spreadSheetInput() {
                this.baseForm.form.push({
                    field: 'spreadSheetInput',
                    order:16,
                    label:'Spreadsheet input',
                    isRequired:false,
                    // services: [
                    //     {service:"service 1"},
                    //     {service:"service 1"},
                    //     {service:"service 1"}
                    // ],
                    hasItem: [
                        { option: "Option 1"},
                        { option: "Option 2"}
                    ],
                })
            },
            // 17. section break
            sectionBreak(){
                this.baseForm.form.push({
                    field:'sectionBreak',
                    order:17,
                    label:'Section Break',
                    helpBlock:'Decribe the page below or leve empty'
                })
            },
            // 18. page break
            pageBreak(){
                this.baseForm.form.push({
                    field:'pageBreak',
                    order:18,
                    label:'Page Break',
                    helpBlock:'Decribe the page below or leve empty'
                })
            },
            //clear field
            clearField (field, index) {
                this.baseForm.form.splice(index, 1);
                this.fieldCardClose();
            },
            clearForm () {
                this.baseForm.form = []
            },
            //field close
            fieldCardClose() {
                this.elementInput = true;
            },
            editElementProperties(form){
                this.elementInput = false;
                this.activeForm = form;
            },
            //add and delete new array inside an exixting object
            deleteOption(option, selectedService, index){
                //console.log(index);
                this.$delete(option, index)
                this.$delete(selectedService, index)
            },
            // deleteService(hasServices, index){
            //     console.log(index);
            //     this.$delete(hasServices, index)
            // },
            // add new item/option
            addOption(option){
                let count = option.length + 1;
                option.push({
                    option: "Item " + count,
                })
            },
            // add new item/option
            addService: function(option,service) {
                option.push(this.services);
                this.activeForm.selectedService.push(1);
            },

            loadServices(){
                axios.get("/api/create-form")
                .then((data)=>{

                   //console.log(data);
                   this.services = data.data.services;
                   //this.services.unshift({ selectedService: 1 });

                }).catch(()=>{
                  // shoe message if data not saved
                })
            },

            // form data submit to database
            formSubmit(id) {

                // error validation
                //Check form name field is empty or not
                this.errors = [];
                if (!this.baseForm.formName) {
                    this.errors.push("The form name field is required.");
                }
                //check if email field isn't in form
                if(!this.baseForm.form.find((item) => item.field === 'email')){
                    this.errors.push("Your form needs an email field.");
                } 

                // check if add payment method in form than check for service 
                if(this.baseForm.form.find((item) => item.field === 'paymentMethod')){
                    if(!this.baseForm.form.find((item) => item.field === 'opt_single_service' || item.field === 'ckboxMultiServices' || item.field === 'dropDownSingleService' || item.field === 'dropDownMultipleServices' )){
                        this.errors.push("Your form needs at least one service selection field.")
                    }
                } 
                
                // if there have no error then the form will be submit
                this.$Progress.start();
                if(this.errors.length === 0) {

                    this.baseForm.patch(`/api/order-form/`+id)
                    .then(()=>{

                      toast.fire({
                        type: 'success',
                        title: 'Order Form Has Been Updated Successfully'
                      })

                      //this.$router.push('/working-hour')
                      

                    }).catch(()=>{
                      // shoe message if data not saved
                    })

                    this.$Progress.finish();

                } else {
                    this.$Progress.fail();
                    this.$notify({
                      group: 'checkErrors',
                      //title: 'Important message',
                      text: this.errors[0],
                      closeOnClick: true,
                      type:"warn"
                    });
                }

            }
      
        },
        mounted() {
            this.loadServices();
        },
        computed: {
            dragOptions() {
              return {
                animation: 0,
                group: "description",
                disabled: false,
                ghostClass: "ghost",
              };
            }
        }
    };
</script>

<style scoped>
    .dragabble-form-wrap .vue-notification.warn {
        background: #fff8e2;
        border-left-color: #ffc107;
        border-left: 6px solid #ffc107;
        color: #6c757d;
        font-size: .8rem;
        padding: 1rem 1.25rem;
    }
    .dragabble-form-wrap .vue-notifications{
        margin-top: 0px;
        width: auto !important;
    }
    .dragabble-form-wrap .vue-notification{
        margin:0;
    }

    .dragabble-form-wrap .notification-wrapper{
        margin-bottom: 10px;
        box-shadow: 2px 2px 2px rgba(0,0,0, .5);
    }
</style>
