<template>
    <section class="mb-4">

		<div class="d-flex justify-content-center">
            <div class="col-md-9">
                <div class="row">
                	<div class="col-md-6">
			            <h3 class="font-weight-semibold mt-3 dark">{{ this.$route.params.slug }} service</h3>
						<p>Drag and drop fields from the right to create a project data form. Orders of this service will have a Pending status until the form is filled out.</p>
                	</div>
                	<div class="col-md-6 text-right">
			            <div>
			                <router-link :to="`/services/edit/${this.$route.params.slug}`" class="mb-1 mt-1 mr-1 btn btn-warning text-light" >
			                  <i class="fas fa-edit"></i> Edit service
			                </router-link>		         
				            <a href="#" class="data-p">
				                <button type="button" class="btn dropdown-toggle action-btn" data-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
				                <div class="dropdown-menu dropdown-menu-right" role="menu">	
					                <!-- <router-link :to="`/services/variants/${this.$route.params.slug}`" class="dropdown-item text-1" >
					                   Variants
					                </router-link>	 -->
					                <router-link :to="`/services/data/${this.$route.params.slug}`" class="dropdown-item text-1" >
					                   Project data
					                </router-link>
					                <router-link to="/services/create" class="dropdown-item text-1" >
					                   Add new service
					                </router-link>
					                <a class="dropdown-item text-1" @click="deleteData(serviceDataId)">Delete Data</a>
				                </div>
				            </a>
			            </div>
                	</div>
				</div>
			</div>
		</div>
	

        <div class="dragabble-form-wrap">
                <form class="p-3" action="" method="post" enctype="multipart/form-data" @submit.prevent="formSubmit">
                    <!-- dragable-form wrap start-->
                    <div class="d-flex justify-content-center">
	                    <div class="col-md-9">
		                    <div class="row">

		                        <div class="col-lg-8">
		                            <div class="card-body-2">
		                                <div class="form-devider">
		                                    Drag and drop fields from the right column onto your form here...
		                                </div>
		                                <draggable v-model="baseForm.form" v-bind="dragOptions" class="dragabble-form" @start="isDragging = true" @end="isDragging = false">
		                                    <div v-for="(data, index) in baseForm.form">
		                        

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
		                                            <button type="button" data-delete="" class="btn btn-sm remove-input" @click.prevent="clearField(data.field, index)"><i class="fas fa-trash"></i></button>
		                                            <div @click="editElementProperties(data)">
		                                                <label for="clientName">{{ data.label }} <small v-show="data.isRequired == false">(optional)</small></label>
		                                                <textarea class="form-control" spellcheck="false" :placeholder="data.placeholder"></textarea>
		                                                <p>{{ data.helpBlock }}</p>
		                                            </div>
		                                        </div>
		                                        <!-- Multiple line of text end -->


		                                        <!-- Checkbox start -->
		                                        <div class="form-group" v-if="data.field === 'checkbox'" :class="{ 'is-active': data === activeForm  }">
		                                            <button type="button" data-delete="" class="btn btn-sm remove-input" @click.prevent="clearField(data.field, index)"><i class="fas fa-trash"></i></button>
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

		                                    </div>
		                                </draggable>
		                                <div class="col-md-12">
		                                	<div class="text-right">
		                                		<button type="submit" class="btn btn-primary mb-3">
											      	Save form
											     </button>
											 </div>
										</div>
		                            </div>
		                        </div><!-- /. dragable-form left -->

		                        <div class="col-lg-4">
		                            <div class="sticky-top">
		                                <div  v-show="elementInput === true">
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
		                                             <p class="help-block data-help-block">Shown inside the field</p>
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
		                                             <p class="help-block data-help-block">Shown next to the field, supports HTML</p>
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
	                    </div>
                    </div>
                    <!-- dragable-form wrap end-->
                </form>
                <!-- notification warning messge modal -->
                <notifications group="checkErrors" position="top center" />
        </div>
    </section>

</template>


 


<script scoped>
    import draggable from "vuedraggable";
    import Notifications from 'vue-notification';
    Vue.use(Notifications)

    export default {

        data () {
    
            return {
            	serviceDataId:'',
                errors:[],
                elementInput:true,
                activeForm:[],
                baseForm: new Form({
                    form: []
                })
            }
        },
        methods: {
            sort() {
              this.baseForm.form = this.baseForm.form.sort((a, b) => a.order - b.order);
            },

            // 11. single text
            singleText() {
                this.baseForm.form.push({
                    field: 'singleText',
                    order:1,
                    label:'Single line of text',
                    helpBlock:'',
                    isRequired:false,
                    placeholder:'',
                    value:'',
                })
            },
            // 12. multi text
            multiText() {
                this.baseForm.form.push({
                    field: 'multiText',
                    order:2,
                    label:'Multiple lines of text',
                    helpBlock:'',
                    isRequired:false,
                    placeholder:'',
                    value:'',
                })
            },
            // 13. checkbox
            checkbox() {
                this.baseForm.form.push({
                    field: 'checkbox',
                    order:3,
                    label:'Checkbox',
                    helpBlock:'',
                    isRequired:false,
                    value:'',
                })
            },
            // 14. dropdown
            dropdown() {
                this.baseForm.form.push({
                    field: 'dropdown',
                    order:4,
                    label:'Dropdown menu',
                    helpBlock:'',
                    isRequired:false,
                    hasItem: [
                        { option: "Item 1"},
                        { option: "Item 2"}
                    ],
                    value:'',
                })
            },
            // 15. file upload
            fileUpload() {
                this.baseForm.form.push({
                    field: 'fileUpload',
                    order:5,
                    label:'File Upload',
                    placeholder:'Choose file...',
                    helpBlock:'',
                    isRequired:false,
                    allowMultiple:false,
                    value:'',
                })
            },
            // 16. spread sheet
            spreadSheetInput() {
                this.baseForm.form.push({
                    field: 'spreadSheetInput',
                    order:6,
                    label:'Spreadsheet input',
                    isRequired:false,
                    hasItem: [
                        { option: "Option 1"},
                        { option: "Option 2"}
                    ],
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
            deleteOption(option, index){
                //console.log(index);
                this.$delete(option, index)
            },

            // add new item/option
            addOption(option){
                let count = option.length + 1;
                option.push({
                    option: "Item " + count,
                })
            },


            //load data
            deleteData(id){
                
                var url = window.location.origin+'/api/services/data-field/'+id;
                console.log(url);
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
                     if (result.value) {
                            axios.delete(url).then(()=>{
                                    Swal.fire(
                                    'Deleted!',
                                    'Your item has been deleted successfully.',
                                    'success'
                                    )
                                this.baseForm.form = [];
                                Fire.$emit('AfterDelete');
                            }).catch(()=> {
                                Swal.fire("Opps!", "Something is wrong.", "warning");
                            });
                     }
                })

            },


            //load service data
            loadServiceData(){
            	axios.get(`/api/services/data-field/${this.$route.params.slug}`)
                .then((data)=>{

                   //console.log(data.data.dataForm);
                   this.serviceDataId= data.data.id;
                   this.baseForm.form = JSON.parse(data.data.dataForm);
                   //this.services.unshift({ selectedService: 1 });

                }).catch(()=>{
                  // shoe message if data not saved
                })
            },

            // form data submit to database
            formSubmit() {
            	console.log(this.baseForm.form.length);

                // error validation
                this.errors = [];
                if (this.baseForm.form.length==0) {
                    this.errors.push("Form must need at least one input field.");
                }

                // if there have no error then the form will be submit
                this.$Progress.start();
                if(this.errors.length === 0) {

            		this.baseForm.patch(`/api/services/data-field/${this.$route.params.slug}`)
                    //this.baseForm.post('/api/services/data-field/'+this.$route.params.slug)
                    .then((order)=>{

                      this.$Progress.finish();
		              toast.fire({
		                type: 'success',
		                title: 'Service data form added successfully.'
		              })

                      //window.location.href = "../order-form/"+order.data.order.id+"/edit";

                    }).catch(()=>{
                        this.$Progress.fail()
                    })

                } else {
                    this.$Progress.fail();
                    this.$notify({
                      group: 'checkErrors',
                      text: this.errors[0],
                      closeOnClick: true,
                      type:"warn"
                    });
                }

            }
      
        },
        created() {
            this.loadServiceData();
	        Fire.$on('AfterDelete',() => {
	        	console.log();
	            this.loadServiceData();
	        });
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

    .data-help-block{
    	color: #999;
    }

    .data-p .dropdown-menu.dropdown-menu-right.show {
	    z-index: 9999;
	}
</style>
