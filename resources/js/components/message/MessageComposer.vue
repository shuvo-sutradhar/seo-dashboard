<template>
  <div class="card-footer">
    <div class="input-group">
      <div class="input-group-append">
        <span class="input-group-text attach_btn"><i class="fas fa-paperclip"></i></span>
      </div>
      <textarea v-model="message" class="form-control type_msg" placeholder="Type your message..." @keydown.enter="send"></textarea>
      <div class="input-group-append" @click="send">
        <span class="input-group-text send_btn"><i class="fas fa-location-arrow"></i></span>
      </div>
    </div>
  </div>
</template>


<script>
	export default {
		data() {
			return {
				message:'',
			};
		},

		methods:{
			send(e) {
				e.preventDefault();

				if(this.message == ''){
					return;
				}

				this.$emit('send',this.message);
				this.message='';
			}
		}
	}
</script>