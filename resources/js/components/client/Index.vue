<template>


    <div>
      <div class="template-wrap">
          
          <section class="card card-horizontal mb-4" >

              <div class="card_header">
                <h3 class="font-weight-semibold mt-3 dark">Clients</h3>
                <router-link to="/clients/create" class="mb-1 mt-1 mr-1 btn btn-primary pull-right list-add-button text-light"  v-if="$auth.isAdmin() || $auth.can('client-create')">
                  <i class="fas fa-plus"></i> Add clients
                </router-link>
              </div>

              <div class="card-body">

                <div v-if="clients!=0" ref="formContainer">
                    <table class="table table-no-more table-bordered table-striped mb-0" id="table" >
                        <thead>
                            <tr>
                              <th class="text-left">SL</th>
                              <th class="text-center">NAME</th>
                              <th class="text-center">EMAIL</th>
                              <th class="text-center">COMPANY</th>
                              <th class="text-center">ADDED</th>
                              <th class="text-right">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- for all invoice -->
                            <tr v-for="(data, index) in clients" class="order-wrap" >
                                    <td>
                                       #{{index+1}}
                                    </td>
                                    <td class="text-center">
                                      <router-link :to="`/clients/${data.email}`" v-if="$auth.isAdmin() || $auth.can('client-view')">
                                       {{data.name}}
                                      </router-link>
                                      <span v-else>
                                       {{data.name}}
                                      </span>
                                    </td>
                                    <td class="text-center">
                                       {{data.email}}
                                    </td>
  
                                    <td class="text-center">
                                        {{data.client && data.client.company_name ? data.client.company_name : '--'}}
                                    </td>
                                    <td class="text-center">
                                       {{data.created_at | dateFormat}}
                                    </td>
                                    <td class="text-right">
                                        <div class="btn-group flex-wrap">
                                            <button type="button" class="mb-1 mt-1 mr-1 btn btn-default dropdown-toggle action-btn role-btn" data-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                                            <div class="dropdown-menu" role="menu">
                                                
                                                <router-link :to="`/clients/${data.email}`" class="dropdown-item text-1"  v-if="$auth.isAdmin() || $auth.can('client-view')">
                                                  <i class="far fa-eye"></i> View
                                                </router-link>
                                                <router-link :to="`/clients/${data.email}/edit`" class="dropdown-item text-1"  v-if="$auth.isAdmin() || $auth.can('client-edit')">
                                                  <i class="far fa-edit"></i> Edit
                                                </router-link>
                                                <a class="dropdown-item text-1" href="#" @click="accessAccount(data.email)" v-if="$auth.isAdmin() || $auth.can('client-login')">
                                                    <i class="fa fa-user"></i> Sign in as user
                                                </a>
                                                <a class="dropdown-item text-1" href="#" @click="deleteData(data.id)" v-if="$auth.isAdmin() || $auth.can('client-delete')">
                                                    <i class="fa fa-trash-alt"></i> Delete
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                            </tr>


                        </tbody>
                    </table>

                    <div class="pull-right mt-4">
                    </div>
                </div>
                <div v-else>
                  No client
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
                clients : {}
            }
        },

        methods: {
            //acceess client account
            accessAccount(clientEmail) {
              this.$Progress.start();
              axios.post('/accounts-access', {
                email: clientEmail
              })
              .then((data)=>{
                  this.$Progress.finish();

                  window.location.href = "../home/";

                }).catch(()=>{
                    this.$Progress.fail()
                })
            },

            //delete data
            deleteData(id){
                
                var url = window.location.origin+'/api/clients/'+id;

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
            loadClient(){
               let loader = this.$loading.show({
                  // Optional parameters
                  container: this.fullPage ? null : this.$refs.formContainer,
                  canCancel: true,
                  onCancel: this.onCancel,
                });


                axios.get("/api/clients").then(({ data }) => (this.clients = data));



              // simulate AJAX
              setTimeout(() => {
                loader.hide()
              },1000)
            },

        },

        created() {
           this.loadClient();
           Fire.$on('AfterDelete',() => {
               this.loadClient();
           });
        }

    };
</script>


