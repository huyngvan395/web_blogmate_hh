export default (initialFollow, userID) => ({
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
})