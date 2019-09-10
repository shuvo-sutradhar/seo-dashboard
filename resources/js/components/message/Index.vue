<template>


    <div class="message-wrap">
      <div class="container-fluid h-100">
        <div class="row justify-content-center h-100">

          <!-- contact list start -->
          <ContactList :contacts="contacts" @selected="startConversationWith"></ContactList>
          <!-- contact list end -->

          <!-- conversation start -->
          <Conversation :contact="selectedContact" :messages="messages" @new="saveNewMessage"></Conversation>
          <!-- conversation end -->

        </div>
      </div>
    </div>

</template>







<script>
    import Conversation from './Conversation';
    import ContactList from './ContactList';

    export default {
        props: {
          user: {
            type:Object,
            required: true
          }
        },
        data() {
            return {
              selectedContact: null,
              messages: [],
              contacts: []
            }
        },

        methods: {
          startConversationWith(contact) {
            //console.log(contact.id);
            this.updateUnreadCount(contact, true);

            axios.get('/api/message/'+contact.id)
                 .then((response)=>{
                    this.messages = response.data.messages;
                    this.selectedContact = contact
                })
          },
          
          saveNewMessage(message){
            this.messages.push(message);
          },

          handleIncoming(message) {
            if(this.selectedContact && message.from == this.selectedContact.id){
              this.saveNewMessage(message);
              return;
            }
            this.updateUnreadCount(message.from_contact, false);
          },

          updateUnreadCount(contact, reset) {
              this.contacts = this.contacts.map((single) => {
                  if (single.id !== contact.id) {
                      return single;
                  }
                  if (reset)
                      single.unread = 0;
                  else
                      single.unread += 1;
                  return single;
              })
          }
        },

        mounted() {
          Echo.private(`messages.${this.user.id}`)
              .listen('NewMessage', (e) => {
                this.handleIncoming(e.message);
              })
          //console.log(this.user);
          axios.get('/api/message')
               .then((response)=>{
                  this.contacts = response.data;
               })
        },
        components: {Conversation,ContactList}

    };
</script>


