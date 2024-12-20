export default (categories)  => ({
    search:'',
    selectedCategory: null, 
    categories: [], 
    dropdownOpen: false,
    title: '',
    content: '',
    init(){
        this.categories= categories;
    }
})