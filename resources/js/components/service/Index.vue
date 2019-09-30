<template>


    <div>
      <div class="template-wrap">
          
          <section class="card card-horizontal mb-4" >

              <div class="card_header">
                <h3 class="font-weight-semibold mt-3 dark">Services</h3>
                <router-link to="/services/create" class="mb-1 mt-1 mr-1 btn btn-primary pull-right list-add-button text-light" v-if="$auth.isAdmin() || $auth.can('service-create')">
                  <i class="fas fa-plus"></i> Add Service
                </router-link>
              </div>

              <div class="card-body">

                <div v-if="services.length!=0 && services.data.length!=0" ref="formContainer">
                    <table class="table table-no-more table-bordered table-striped mb-0" id="table" >
                        <thead>
                            <tr>
                              <th class="text-left">SL</th>
                              <th class="text-center">THUMBNAIL</th>
                              <th class="text-center">NAME</th>
                              <th class="text-center">PRICE</th>
                              <th class="text-right">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- for all invoice -->
                            <tr v-for="(service, index) in services.data" class="order-wrap" :key="index">
                                <td>
                                   #{{ ++index }}
                                </td>
                                <td class="text-center">
                                  <img :src="getServiceThumbnail(service  && service.thumbnail ? service.thumbnail : 'default-service.png')" :alt="service.name" class="service-img" >
                                </td>
                                <td class="text-center">
                                  {{service.name}}
                                </td>
                                <td class="text-center" v-if="service.service_type==2">
                                 ${{service.price}} / {{ service.recurring_duration  }} {{ service.recurring_for }}(s)
                                </td>
                                <td class="text-center" v-else>
                                  ${{service.price}} 
                                </td>
                                <td class="text-right">
                                    <div class="btn-group flex-wrap">
                                        <button type="button" class="mb-1 mt-1 mr-1 btn btn-default dropdown-toggle action-btn role-btn" data-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                                        <div class="dropdown-menu" role="menu">
                                            
                                            <router-link :to="`/services/edit/${service.slug}`" class="dropdown-item text-1" v-if="$auth.isAdmin() || $auth.can('service-edit')">
                                               Edit
                                            </router-link>
                                            <a class="dropdown-item text-1" href="#" @click="duplocateService(service.id)" v-if="$auth.isAdmin() || $auth.can('service-edit')">
                                                Duplicate
                                            </a>
                                            <a class="dropdown-item text-1" href="#" @click="deleteData(service.id)" v-if="$auth.isAdmin() || $auth.can('service-delete')">
                                                Delete
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>


                        </tbody>
                    </table>

                    <div class="pull-right mt-4">
                      <pagination :data="services" @pagination-change-page="loadServices"></pagination>
                    </div>
                </div>
                <div v-else>
                  No Service
                </div>
              </div>
          </section>

      </div>
    </div>

</template>







<script>


    export default {

        data() {
            return {
                fullPage:false,
                services : {}
            }
        },

        methods: {


      			/*
      			*  Get profile picture
      			*/
  			    getServiceThumbnail(avatar){
  	          return window.location.origin+"/uploads/service_pic/"+avatar;
  	        },


            //duplicate service
            duplocateService(id){
                var url = window.location.origin+'/api/duplicate/'+id;

                this.$Progress.start();
                axios.get(url)
                .then((order)=>{
                  
                  this.$Progress.finish();
                  toast.fire({
                    type: 'success',
                    title: 'Service has been duplicated successfully.'
                  })

                  Fire.$emit('AfterDuplicate');
                }).catch(()=>{
                    this.$Progress.fail()
                })

            },

            //delete data
            deleteData(id){
                
                var url = window.location.origin+'/api/services/'+id;

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
                                Fire.$emit('AfterDelete');
                            }).catch(()=> {
                                Swal.fire("Opps!", "Something is wrong.", "warning");
                            });
                     }
                })

            },

            //load all client
            loadServices(page=1){
               let loader = this.$loading.show({
                  // Optional parameters
                  container: this.fullPage ? null : this.$refs.formContainer,
                  canCancel: true,
                  onCancel: this.onCancel,
                });

                axios.get('/api/services?page='+page).then(({ data }) => (this.services = data));

                // simulate AJAX
                setTimeout(() => {
                  loader.hide()
                },500)
            },

        },

        created() {
           this.loadServices();
           Fire.$on('AfterDelete',() => {
               this.loadServices();
           });
           Fire.$on('AfterDuplicate',() => {
               this.loadServices();
           });
        }

    };
</script>


<style type="text/css">
	.service-img{
    width: 50px;
    border-radius: 100%;
    border: 1px solid #ddd;
    box-shadow: 2px 2px 2px #696969;
    height: 50px;
	}

  .order-wrap td:nth-child(1){
    width: 10%;
  }
  .order-wrap td:nth-child(2){
    width: 15%;
  }
</style>


