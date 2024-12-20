import './bootstrap';
import './attachment';
// import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
// import dataBlog from './alpine/dataBlog';
// import followData from './alpine/followData';
// import dataCreateBlog from './alpine/dataCreateBlog';
// import dataChat from './alpine/dataChat';

// Alpine.data('dataBlog', dataBlog);
// Alpine.data('followData', followData);
// Alpine.data('dataCreateBlog', dataCreateBlog);
// Alpine.data('dataChat', dataChat);
document.addEventListener('alpine:init', ()=>{
    Alpine.data('dataCreateBlog', (categories) => ({
        search:'',
        selectedCategory: null, 
        categories: [], 
        dropdownOpen: false,
        title: '',
        content: '',
        init(){
            this.categories= categories;
        }
    }))
    Alpine.data('dataChat', () => ({
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
                        }, 300);
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
    }))
    Alpine.data('dataBlog', () => ({
        showMoreOptionAction: false,
    }))
    Alpine.data('followData', (initialFollow, userID) => ({
        followed: initialFollow,
        init(){
            console.log(this.followed);
        },
        follow(){
            axios.post('/follow',{
                author_id: userID
            },{
                headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')}
            })
            .then((response)=>{
                console.log(response.data.msg);
                this.followed= response.data.followed;
            })
        }
    }))
})
    




