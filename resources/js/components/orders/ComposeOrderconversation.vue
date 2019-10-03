<template>
	<div class="card mt-3 message-compose">
      <div class="card-header">
        <h2 class="card-title" v-if="$auth.isAdmin()">Message {{ selectedUser }}</h2>
        <h2 class="card-title" v-if="$auth.isClient()">Send a message</h2>
        <div v-if="$auth.isAdmin()">
            <a href="#" class="option-vertical" data-toggle="dropdown" >
            	Send to {{ selectedUser }} <i class="fas fa-angle-down" aria-hidden="true" ></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
               <a href="#message-8" class="dropdown-item" @click="selectUser('Client')">Send to client</a>                              
               <a href="#message-8" class="dropdown-item" @click="selectUser('Team')">Send to team</a>
            </div>
		    </div>
      </div><!-- /. card-header -->
      <div class="card-body">
      	<ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
      </div>
      <div class="card-footer compose-footer">
	      <div class="d-flex">
	      	<div class="help-block" v-show="$auth.isAdmin()">Team members who are @mentioned, or following this order will be notified.</div>
	      	<button v-if="$auth.isAdmin()" type="submit" class="btn btn-primary" @click="send">Send to {{ selectedUser }}</button>
          <button v-show="!$auth.isAdmin()" type="submit" class="btn btn-primary" @click="send">Send message</button>
	      </div>
      </div>
	</div>
</template>



<script>

    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
    export default {
        data() {
            return {
              editor: ClassicEditor,
              editorConfig: {
                    // The configuration of the editor.
                  //toolbar: [ 'bold', 'italic', '|', 'link','image' ]
              },
              selectedUser: 'Client',
              editorData: '',
            }
        },

        methods: {
            selectUser($data) {
              this.selectedUser = $data;
            },

            send(e) {
              e.preventDefault();

              if(this.editorData == ''){
                return;
              }

              this.$emit('send',[this.selectedUser,this.editorData]);
              this.editorData='';
              this.selectedUser='Client';
            }
        }
    }

</script>

<style type="text/css">
	.message-compose .card-header {
	    background: #fff;
	    display: flex;
	    justify-content: space-between;
	}

	.message-compose .card-header a{
		text-decoration: none;
	}

	.compose-footer{
		    border-top: 0px;
	}
	.compose-footer>div{
		justify-content: space-between;
	}
</style>