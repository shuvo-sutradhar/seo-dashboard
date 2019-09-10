<template>
      <div class="card-body msg_card_body inner" v-if="contact" ref="feed">
        <div v-for="message in messages" :class="`${message.to == contact.id ? 'justify-content-start msg-left' : 'justify-content-end msg-right'}`" :key="message.id" class="d-flex  mb-4">
          <div class="img_cont_msg">
            <img src="https://2.bp.blogspot.com/-8ytYF7cfPkQ/WkPe1-rtrcI/AAAAAAAAGqU/FGfTDVgkcIwmOTtjLka51vineFBExJuSACLcBGAs/s320/31.jpg" class="rounded-circle user_img_msg">
          </div>
          <div class="msg_cotainer">
            {{message.text}}
            <span class="msg_time">{{message.created_at | dateFormat2 }}</span>
          </div>
        </div>
      </div>
</template>


<script>
	export default {

		props: {
			contact:{
				type:Object
			},
			messages: {
				type:Array
			}
		},

		methods: {
			scrollToBottom() {
				setTimeout(()=>{
					this.$refs.feed.scrollTop = this.$refs.feed.scrollHeight - this.$refs.feed.clientHeight;
				},50);
			}
		},

		watch:{
			contact(contact) {
				this.scrollToBottom();
			},
			messages(messages) {
				this.scrollToBottom();
			}
		}
	}
</script>