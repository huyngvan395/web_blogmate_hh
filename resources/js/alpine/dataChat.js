export default () => ({
    openChatList: true,
    openChatBox: true,
    textareaHeight: 40, 
    maxHeight: 150, 
    minHeight: 40,
    init(){
        this.textareaHeight = this.minHeight;
        if(window.innerWidth <768){
            this.openChatBox=false;
        }
        Livewire.on('openChatBox', () =>  {
            if(window.innerWidth <768){
                this.openChatList=false;
                setTimeout(() => {
                    this.openChatBox = true;
                }, 500);
            }
        })
        window.addEventListener('resize', () => {
            if(window.innerWidth < 768){
                this.openChatBox=false;
            }
        })
        Livewire.on('conversationID', (event) => {
            console.log(event);
            window.Echo.channel(`conversations.${event['conversationID']}`)
                .listen('MessageSent', (e) => {
                    console.log(e);
                    Livewire.dispatch('updateMessage', {event:  e});
                    setTimeout(() => {
                        scrollToBottom();
                    }, 800);
                });
                setTimeout(() => {
                        scrollToBottom();
                    }, 100);
           })
        
           function scrollToBottom() {
               const messageContainer = document.querySelector('.chatbox');
               console.log(messageContainer);
               if (messageContainer) {
                   messageContainer.scrollTop = messageContainer.scrollHeight;
               }
           }
        
           if(window.userID){
            window.Echo.channel(`updateChatList.${window.userID}`)
            .listen('UpdateChatList', (e) => {
                 Livewire.dispatch('updateChatList');
            })
           }
    },
})