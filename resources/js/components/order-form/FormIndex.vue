<template>

    <div class="template-wrap">
        
        <section class="card card-horizontal mb-4">

            <div class="card_header">
              <h3 class="font-weight-semibold mt-3 dark">Order forms</h3>
              <a :href="route" class="mb-1 mt-1 mr-1 btn btn-primary pull-right list-add-button">
                  <i class="fas fa-plus"></i> Add form
              </a>
            </div>

            <div class="card-body" v-if="formData.length > 0">
                <!-- <a :href="route2">{{ route2 }}</a> -->
                
                <br/>
                <table class="table table-no-more table-bordered table-striped mb-0" id="table">
                    <thead>
                        <tr>
                            <th>FORM</th>
                            <th>ID</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(data, index) in formData" :key="index">
                            <td :class="data.status == 1 ? 'activeClass' : ''"><a :href="getEditLink(data.id)"> {{ data.formName }} </a></td>
                            <td>{{ data.formLink }}</td>
                            <td class="actions">
                               <div class="btn-group flex-wrap">
                                  <button type="button" class="mb-1 mt-1 mr-1 btn btn-default dropdown-toggle action-btn role-btn" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                                  <div class="dropdown-menu" role="menu" x-placement="bottom-start">
                                     
                                     <a class="dropdown-item text-1" :href="getOrderForm(data.formLink)">
                                        View
                                     </a>
                                     <a class="dropdown-item text-1" href="#">
                                        Share
                                     </a>
                                     <a class="dropdown-item text-1" href="#" v-if="data.status==1" @click="changeStatus(data.id,0)">
                                        Make Private
                                     </a>
                                     <a class="dropdown-item text-1" href="#" v-else @click="changeStatus(data.id,1)">
                                        Make Public
                                     </a>
                                     <a class="dropdown-item text-1" :href="getEditLink(data.id)">
                                        Edit
                                     </a>
                                     <a class="dropdown-item text-1" href="#" @click="makeDuplicate(data.id)">
                                        Duplicate
                                     </a>
                                     <a class="dropdown-item text-1" @click="deleteForm(data.formLink)" href="#">
                                        Delete
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
            <div class="card-body" v-else>
              No order form.
            </div>
        </section>
    </div>

</template>


<script>


    export default {
        props: ['route'],

        data() {
            return {
                formData : {}
            }
        },

        methods: {
            //duplicate
            makeDuplicate(id){
                this.$Progress.start();
                axios.get('api/order-form-duplocate/'+id)
                .then(()=>{

                  toast.fire({
                    type: 'success',
                    title: 'Form copied.'
                  })
                  Fire.$emit('makeDuplicate');
                }).catch(()=>{
                  // shoe message if data not saved
                })

                this.$Progress.finish(); 
            },

            //delete data
            changeStatus(id,status){
                this.$Progress.start();
                axios.get('api/order-form-status/'+id+'/'+status)
                .then(()=>{

                  toast.fire({
                    type: 'success',
                    title: 'Form status updated.'
                  })
                  Fire.$emit('AfterChangeStatus');
                }).catch(()=>{
                  // shoe message if data not saved
                })

                this.$Progress.finish(); 
            },
            deleteForm(id){               
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
                        axios.delete('api/order-form/'+id).then(()=>{
                                Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                                )
                            Fire.$emit('AfterDelete');
                        }).catch(()=> {
                            Swal.fire("Failed!", "There was something wronge.", "warning");
                        });
                    }
                })
            },
            //Edit data
            getEditLink(id) {
                return "order-form/"+id+"/edit";
            },
            getOrderForm(link) {
                return "order/"+link;
            },
 

            loadFormData(){
                axios.get("/api/order-form").then(({ data }) => (this.formData = data.data));
            },

        },

        created() {
           this.loadFormData();
           Fire.$on('AfterDelete',() => {
               this.loadFormData();
           });
           Fire.$on('AfterChangeStatus',() => {
               this.loadFormData();
           });
           Fire.$on('makeDuplicate',() => {
               this.loadFormData();
           });
        }

    };
</script>

 <style scoped>
     td a {
        color: #5d5d5d;
    }

    td.activeClass a {
        color: #2ec3a1;
    }
 </style>

