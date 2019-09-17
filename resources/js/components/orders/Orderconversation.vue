<template>

  <div class="mt-3 order-chat" v-if="messages.length!=0">
    <div class="card">
      <div class="card-header">
        <h2 class="card-title">Messages</h2>
      </div><!-- /. card-header -->

      <div class="messages order-messages" ref="feed">
      	<!-- {{message.sender_id != $auth.auth().id && message.message_for=='Client'}} if true add class 'staff-message' or staff-note -->
		<div class="message" v-for="(message,index) in messages" :key="message.id" :id="'#message-'+index"  :class="[(message.sender_id == $auth.auth().id && message.message_for=='Team' ? 'staff-note' : ''), (message.sender_id == $auth.auth().id && message.message_for=='Client' ? 'staff-message' : '')]">
		   <div class="message-flex" >
		      <div class="message-avatar">
		         <div class="avatar css-avatar" v-if="message.message_sender">{{message.message_sender.name[0]}}</div>
		         
		         <div class="avatar css-avatar" v-else>{{message.user[0]}}</div> 
		      </div>
		      <div class="flex-fill">
		         <div class="order-message-options">
		            <a href="#" class="option-vertical" data-toggle="dropdown" >
		            	<i class="fas fa-ellipsis-v" aria-hidden="true" data-toggle="tooltip" title="#1"></i>
		            </a>
		            <div class="dropdown-menu dropdown-menu-right">
		               <a :href="'#message-'+index" class="dropdown-item">Link</a>
		               <a href="#" @click="deleteMessage(message.id)" class="dropdown-item" data-toggle="modal" data-target="#spp-modal">Delete</a>                                                                            
		            </div>
		         </div>
		         <div class="name" v-if="message.message_sender">
		            {{ message.message_sender.name }}<span></span>
		         </div>
		         <div class="name" v-else>
		            {{message.user}}<span></span>
		         </div>
		         <div class="date">
		            <!-- Aug 28th at 08:00 am -->
		            {{ message.created_at | dateFormat1 }}   at  {{ message.created_at | timeFormat }}                                            
		         </div>
		         <div class="user-content mt-2">
		            <div v-html="message.message_body"></div>
		         </div>
		      </div>
		   </div>
		</div><!-- /. order message-->
		
		<!-- staff-message
		staff-note -->
		
      </div><!-- /. messages -->

    </div>
  </div>
</template>



<script>


    export default {
        props: {
          messages: {
            type:Array,
            default:[]
          }
        },

        data() {
            return {
                //
            }
        },

        methods: {

			scrollToBottom() {
				setTimeout(()=>{
					this.$refs.feed.scrollTop = this.$refs.feed.scrollHeight - this.$refs.feed.clientHeight;
				},50);
			},
			deleteMessage(id) {
			  //e.preventDefault();
              this.$emit('messageDel',id);
            }
        	
        },

        watch: {
			messages(messages) {
				this.scrollToBottom();
			}
        }

    };
</script>


<style type="text/css">
	html {
	  scroll-behavior: smooth;
	}
	.order-chat .card-header {
	      background: #fff;
	  }
	.order-chat .message {
	    padding: .75rem 1.25rem;
	    background: #fff;
	    position: relative;
	}

	.order-chat .message .message-flex {
	    display: flex;
	}
	.order-chat .message .message-avatar {
	    padding-right: .9rem;
	}
	.order-chat .flex-fill {
	    flex: 1 1 auto!important;
	}

	.order-chat .css-avatar {
	    text-align: center;
	    color: #fff;
	    background: #adb5bd;
	    font-size: 28px;
	    line-height: 54px;
	}

	.order-chat .avatar {
	    width: 50px;
	    height: 50px;
	    border-radius: 50%!important;
	    background-position: 50%;
	    background-size: cover;
	}

	.message .order-message-options {
	    float: right;
	}
	.user-content {
	    color: #000000c7;

	}

	.order-chat .name {
	    font-size: 18px;
	    color: #111;
	    font-weight: 600;
	    margin-top: 3px;
	    margin-bottom: 2px;
	}
	.order-chat .date {
	    font-size: 11px;
	}

	.dropdown-menu.dropdown-menu-right.show {
	    border: 0 solid rgba(0,0,0,.15);
	    border-radius: .25rem;
	    box-shadow: 0 0.5rem 2.5rem rgba(0,0,0,.15);
	}
	.order-chat .order-message-options a i {
	    color: #111;
	}
	.order-messages .message {
	    border-bottom: 1px solid #dddddd9e;
	    padding-top: 20px;
	}
	.message.staff-note {
	    border-left: 3px solid #ffc107;
	}
	.message.staff-message {
	    border-left: 3px solid #adb5bd;
	}

	
	.messages.order-messages {
	    max-height: 60vh;
	    overflow-y: auto;
	}

	.user-content p {
	    margin-bottom: 0px;
	}
</style>