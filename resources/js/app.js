import './bootstrap';
import './attachment';
import axios from 'axios';

document.addEventListener('alpine:init', ()=>{
    Alpine.store('url',{
        currentUrl: window.location.href,
        updateCurrentUrl() {
            this.currentUrl = window.location.href;
        }
    })
    Alpine.data('dataNavigation', ()=>({
        open: false,
        openUser: false, 
        showNotifications:false,
        currentUrl: window.location.href,
        notifications: [],
        count_notification: 0,
        count_message: 0,
        query:'',
        searchBlogResults: [],
        searchUserResults: [],
        debounceTimeout: null,
        init(){
            axios.get('/notifications',{
            },{
                headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')}
            })
            .then((response)=>{
                if(response.data.notifications){
                    console.log(response.data);
                    this.notifications.push(...response.data.notifications);
                    console.log(this.notifications);
                }
            })
            console.log(this.currentUrl);
            if(window.userID){
                window.Echo.channel(`notifications.${window.userID}`)
                .listen('NotificationEvent',(e)=>{
                    console.log(e);
                    this.notifications.unshift(e);
                    this.count_notification+=1;
                    console.log(this.count_notification);
                })
            }
        },
        search(){
            if (this.query.length > 0) {
                clearTimeout(this.debounceTimeout);
    
                this.debounceTimeout = setTimeout(() => {
                    console.log(this.query);  
                    axios.post('/search', {
                        query: this.query
                    }, {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then((response) => {
                        this.searchUserResults = response.data.user;
                        this.searchBlogResults = response.data.blog;
                    });
                }, 500);  
            }
        }
        // updateCurrentUrl() {
        //     this.currentUrl=window.location.href;
        // } 
    }))
    Alpine.data('dataBlog', () => ({
        showMoreOptionAction: false,
        currentUrl: window.location.href,
        init(){
            console.log(this.currentUrl);
        }
        // updateCurrentUrl(){
        //     Alpine.store('url').updateCurrentUrl();
        // }
    }))
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
    Alpine.data('dataInfoUser', (followed) => ({
        showMoreOptionAction: false,
        followed: followed ,
        menuMoreOptionRef: null,
        init(){
            console.log(this.followed);
        },
        toggleMenu() {
            this.showMoreOptionAction = !this.showMoreOptionAction;

            if (this.showMoreOptionAction) {
                this.$nextTick(() => {
                    this.menuMoreOptionRef = this.$refs.menuMoreOption;
                    document.addEventListener('click', this.handleClickOutside.bind(this));
                });
            } else {
                document.removeEventListener('click', this.handleClickOutside);
            }
        },
        follow(user_id){
            axios.post('/follow',{
                author_id: user_id
            },{
                headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')}
            })
            .then((response)=>{
                console.log(response.data.msg);
                this.followed= response.data.followed;
            })
        },
        handleClickOutside(event) {
            event.preventDefault();
            event.stopPropagation();
            if (this.menuMoreOptionRef && !this.menuMoreOptionRef.contains(event.target)) {
                console.log("Thành công");
                this.showMoreOptionAction = false;
                document.removeEventListener('click', this.handleClickOutside);
            }
        },
        
    }))
})
    




