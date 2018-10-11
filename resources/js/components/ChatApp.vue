<template>
    <div class="chat-app">
        <Conversation :contact="selectedContact" :messages="messages" @new="saveNewMessage"/>
        <ContactsList :contacts="contacts" @selected="startConversationWith"/>
    </div>
</template>

<script>
    import Conversation from './Conversation';
    import ContactsList from './ContactsList';

    export default {
        props: {
            user: {
                type: Object,
                required: true
            }
        },
        data() {
            return {
                selectedContact: null,
                messages: [],
                contacts: [],
            }
        },
        mounted() {
            axios.get('/contacts')
                .then((response) => {
                    this.contacts = response.data;
                })
        },
        methods: {
            startConversationWith(contact){
                axios.get(`/conversation/${contact.id}`)
                    .then((response) => {
                        console.log(response.data);
                        this.messages = response.data;
                        this.selectedContact = contact;
                    })
            },

            saveNewMessage(data) {
                this.messages.push(data)
            }
        },
        components: { Conversation, ContactsList }
    }
</script>

<style lang="scss" scoped>
    .chat-app {
        display: flex;
    }
</style>
