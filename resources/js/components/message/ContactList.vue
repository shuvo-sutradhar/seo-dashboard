<template>

  <div class="col-md-4 col-xl-4 chat">
    <div class="card mb-sm-3 mb-md-0 contacts_card">
      <div class="card-header">
        <div class="input-group">
          <input type="text" placeholder="Search..." name="" class="form-control search">
          <div class="input-group-prepend">
            <span class="input-group-text search_btn"><i class="fas fa-search"></i></span>
          </div>
        </div>
      </div>
      <div class="card-body contacts_body">
        <ul class="contacts">
          <li v-for="contact in sortedContacts" :key="contact.id" @click="selectedContact(contact)" :class="{ 'active' : contact == selected}">
            <div class="d-flex bd-highlight">
              <div class="img_cont">
                <img src="https://via.placeholder.com/150/fff" class="rounded-circle user_img">
                <span class="online_icon"></span>
              </div>
              <div class="user_info">
                <span>{{contact.name}} </span>
                <p>Maryam is online</p>
                <small class="badge badge-danger" v-if="contact.account_role==2">client</small>
                <small class="badge badge-warning" v-if="contact.account_role==0">Team Member</small>
                <small class="badge badge-primary" v-if="contact.account_role==1">Admin</small>
                <div class="unread" v-if="contact.unread">{{contact.unread}}</div>
              </div>
            </div>
          </li>

        </ul>
      </div>
      <div class="card-footer"></div>
    </div>
  </div>

</template>







<script>


    export default {
        props: {
          contacts: {
            type:Array,
            default: []
          }
        },

        data(){
          return {
            selected: this.contacts.length ? this.contacts[0] : null
          }
        },

        methods: {
          selectedContact(contact) {
            this.selected = contact;
            this.$emit('selected',contact);
          },
        },

        computed: {
          sortedContacts() {
            return _.sortBy(this.contacts, [(contact)=>{
              if(contact == this.selected){
                return Infinity;
              }
              return contact.unread;

            }]).reverse();
          }
        }
    };
</script>


