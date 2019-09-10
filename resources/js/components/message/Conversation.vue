<template>
  <div class="col-md-8 col-xl-8 chat">
    <div class="card">
      <div class="card-header msg_head">
        <div class="d-flex bd-highlight">
          <div class="img_cont">
            <img src="https://2.bp.blogspot.com/-8ytYF7cfPkQ/WkPe1-rtrcI/AAAAAAAAGqU/FGfTDVgkcIwmOTtjLka51vineFBExJuSACLcBGAs/s320/31.jpg" class="rounded-circle user_img">
            <span class="online_icon"></span>
          </div>
          <div class="user_info">
            <span>{{ contact ? 'Chat with '+ contact.name : 'Select a contact'}}</span><br>
            <small class="text-light">{{ contact ? contact.email : ''}}</small>
            <p>{{messages.length}} Messages</p>
          </div>
          <!-- <div class="video_cam">
            <span><i class="fas fa-video"></i></span>
            <span><i class="fas fa-phone"></i></span>
          </div> -->
        </div>
        <span id="action_menu_btn"><i class="fas fa-ellipsis-v"></i></span>
        <div class="action_menu">
          <ul>
            <li><i class="fas fa-user-circle"></i> View profile</li>
            <li><i class="fas fa-users"></i> Add to close friends</li>
            <li><i class="fas fa-plus"></i> Add to group</li>
            <li><i class="fas fa-ban"></i> Block</li>
          </ul>
        </div>
      </div>

      <MessagesFeed :contact="contact" :messages="messages"></MessagesFeed>

      <MessageComposer @send="sendMessage"></MessageComposer>

    </div>
  </div>
</template>







<script>

    import MessagesFeed from './MessagesFeed';
    import MessageComposer from './MessageComposer';

    export default {
        props: {
          contact: {
            type:Object,
            default: null
          },
          messages: {
            type:Array,
            default:[]
          }
        },

        methods:{
          sendMessage(text) {
            if(!this.contact) {
              return;
            }
            axios.post('/api/message/send',{
              contact_id: this.contact.id,
              text: text
            }).then((response)=>{
              console.log(response.data.message);
              this.$emit('new', response.data.message)
            })
          }
        },
        components:{MessagesFeed,MessageComposer},

    };
</script>


