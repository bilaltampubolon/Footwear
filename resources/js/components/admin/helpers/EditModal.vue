<template>

    <div class="fixed inset-0  rounded-lg flex flex-col  justify-center rounded-lg z-20">
        <div class="h-full w-full bg-gray-300 opacity-75" @click="closeModal">
            
        </div>
        <div class="absolute  bg-white left-0 right-0  mx-auto  max-w-3xl shadow-lg rounded p-6 z-30">
            <div class="mb-3 text-right">
                <button @click="closeModal" type="button" class="px-4 py-2 cursor-pointer" data-dismiss="modal" aria-label="Close">
                    <svg class="fill-current text-gray-900" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                      <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                    </svg>
                </button>

            </div>
            <form @submit.prevent="updateProduct" enctype="multipart/form-data">
                    
                <div class="flex flex-row justify-between items-center mb-3">
                    <h1 class="m-0 text-lg font-bold text-gray-900">Edit Product</h1>
                    <button type="submit" class="hover:bg-gray-300 bg-admin-btn hover:bg-admin-btn-hover text-gray-100 font-bold py-3 px-4 rounded focus:outline-none focus:shadow-outline">
                        Save
                    </button>
                </div>
                <div class="flex flex-col lg:flex-row h-90 overflow-y-scroll">
                    <div class="w-full md:w-64  pl-2">
                        <h4 class="text-md font-semibold text-gray-800 my-2">Images</h4>
                        <div class="flex w-full items-center justify-center bg-grey-lighter mb-3">
                            <label class="w-full flex flex-col items-center px-4 py-6 bg-white text-blue rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue ">
                                <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                </svg>
                                <span class="mt-2 text-lg">Choose Product Images</span>
                                <input type='file' id="files" ref="files"  class="hidden" multiple @change="handleFileUpload" />
                            </label>
                        </div>
                        <div v-if="fileErr.length > 0" v-for="n in fileErr">
                            <p class="text-red-600 p-2">{{  n }}</p>
                        </div>
                        <div v-if="files.length > 0" class="">
                            <div v-for="(file) in fileRead" class="w-full flex flex-row flex-wrap justify-between">
                                <div class="relative flex flex-col items-center rounded-lg">
                                    <img :src="`${file}`" class="w-full rounded-lg">
                                    <span class="rounded-lg my-2 text-white font-semibold text-lg  w-full text-center" >
                                        <svg v-on:click="removeFile( file )" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mb-1 md:mb-0 h-6 w-6 md:h-8 md:h-8 text-admin-red cursor-pointer"><path d="M21 4H8l-7 8 7 8h13a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2z"></path><line x1="18" y1="9" x2="12" y2="15"></line><line x1="12" y1="9" x2="18" y2="15"></line></svg>

                                    </span>
                                    <span class="absolute top-0 right-0 bg-admin-red px-2 py-2 rounded-tl-lg rounded-br-lg text-white">New</span>
                                </div>
                                
                            </div>
                        </div>
                        <div v-for="image in images" :key="image.id">
                            <img  :src="`/${image.thumbnail}`" onerror="this.src='/img/placeholder.png'">
                            <svg @click="removeImage(image)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mb-1 md:mb-0 h-6 w-6 md:h-8 md:h-8 text-admin-red cursor-pointer"><path d="M21 4H8l-7 8 7 8h13a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2z"></path><line x1="18" y1="9" x2="12" y2="15"></line><line x1="12" y1="9" x2="18" y2="15"></line></svg>
                        </div>
                    </div> 
                    <div class="flex-1 px-3 md:px-0 md:pl-3">
                        <div class="flex flex-col  rounded-lg mb-3">
                            <label for="name" class=" px-2 py-3 text-gray-800 text-md font-semibold ">Name</label>
                            <input type="text" id="name" v-model="name" class="px-3 py-3 rounded-lg  bg-gray-300 text-gray-900">
                        </div>
                        <div class="px-3 md:px-0 flex flex-row items-center justify-between mb-3">
                            <div class="flex-1 flex flex-col  rounded-lg mr-2">
                                <label for="price" class=" px-2 py-3 text-gray-800 text-md font-semibold ">Price</label>
                                <input type="text" id="price" v-model="price" class="px-3 py-3 rounded-lg  bg-gray-300 text-gray-900  w-full">
                                <div v-if="priceErr.length > 0" v-for="n in priceErr">
                                    <p class="text-red-600 p-2">{{  n }}</p>
                                </div>
                            </div>
                            <div class="flex-1 flex flex-col  rounded-lg ml-2">
                                <label for="qty" class=" px-2 py-3 text-gray-800 text-md font-semibold ">Quantity</label>
                                <input type="text" id="qty" v-model="qty" class="px-3 py-3 rounded-lg  bg-gray-300 text-gray-900  w-full">
                                <div v-if="qtyErr.length > 0" v-for="n in qtyErr">
                                    <p class="text-red-600 p-2">{{  n }}</p>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="flex flex-row items-center justify-between mb-3">
                        
                            <label class="flex-1 block mb-3 mr-2">
                              <span class="text-gray-700 mb-2">Category</span>
                              <select class="form-select mt-1 block w-full" v-model="selectedCat" >
                                <option v-for="category in categoriesArray" :value="category.id">{{category.name}}</option>
                              </select>
                            </label>

                            <label class="block mb-3 flex-1 ml-2" >
                              <span class="text-gray-700 mb-2">SubCategory</span>
                             
                              <select  class="form-select mt-1 block w-full" v-model="selectedSubCat" :disabled='!selectedCat' :class="(selectedCat) ? 'opacity-100' : 'opacity-75 cursor-not-allowed'">
                                <option value="" disabled>Select Sub-category</option>
                                <option v-if="selectedCat" v-for="subcategory in subCategoriesArray" :value="subcategory.id">{{subcategory.name}}</option>
                              </select>
                            </label>
                        </div> 
                        <div v-if="categoryErr.length > 0" v-for="n in categoryErr">
                            <p class="text-red-600 p-2">{{  n }}</p>
                        </div>

                        <div class="flex flex-col  rounded-lg mb-3">
                            <label for="description" class=" px-2 py-3 text-gray-800 text-md font-semibold ">Description</label>
                            <wysiwyg v-model="description" />

                        </div>
                        <div class="flex flex-col  rounded-lg mb-3">
                            <label for="description" class=" px-2 py-3 text-gray-800 text-md font-semibold ">Excerpt</label>
                            <textarea id="description" v-model="excerpt" class="px-3 py-3 rounded-lg  bg-gray-300 text-gray-900 w-full h-16">
                            </textarea>
                        </div>                 

                    </div>
                    
                </div>
            </form>
        </div>

    </div>
  
</template>

<script>
import { eventBus } from '../../../app.js';    
import Toast from '../../helpers/Alert';

    export default {
        name : 'EditModal',
        props: {
            product : {
                type     : Object,
                required : true
            }
        },
        components: {
        },
        data(){
            return {
                name              : '',
                price             : '',
                qty               : '',
                selectedCat       : '',
                selectedSubCat    : '',
                description       : '',
                excerpt           : '',
                images            : [],
                categoriesArray   : [],
                subCategoriesArray: [],
                files             : [],
                fileRead          : [],
                fileErr         : [],
                nameErr         : [],
                priceErr        : [],
                qtyErr          : [],
                categoryErr     : []
            }
        },
        mounted() {
            this.productObj();
            this.getCategories();
        },
        watch: {
            selectedCat: function() {
                this.getSubCategories();
            }
        },
        updated() {
        },
        methods: {
            productObj(){
                this.name = this.product.name;
                this.price = this.product.price;
                this.qty = this.product.qty;
                this.selectedCat = this.product.category_id,
                this.selectedSubCat = this.product.subcategory_id,
                this.description = this.product.description;
                this.excerpt = this.product.excerpt;
                this.name = this.product.name;
                
                this.getImages();
            },
            getImages(){
                axios.get(`/admin/productsImage/${this.product.id}`)
                .then((res) => {
                    if(res.status == 200){
                        res.data.images.forEach((image) => {
                            this.images.push(image);        
                        });
                    }
                })
                .catch((err) => {
                    Toast.fire({
                          icon: 'error',
                          title:   `Server error. Please close the modal and try again.`
                    }); 
                });
            },
            getCategories(){
                axios.get(`/admin/getCategories`)
                .then((res) => {
                    if(res.status == 200){
                        res.data.categories.forEach((category) => {
                            this.categoriesArray.push(category);        
                        });
                    }
                })
                .catch((err) => {
                    Toast.fire({
                          icon: 'error',
                          title:   `Server error. Please close the modal and try again.`
                    }); 
                });
            },
            getSubCategories(){
                if(this.selectedCat !== null){
                    axios.get(`/admin/getSubCategories/${this.selectedCat}`)
                    .then(res =>{
                        if(res.status == 200){
                            this.subCategoriesArray = [];
                            res.data.subcategories.forEach((subcategory) => {
                                this.subCategoriesArray.push(subcategory);
                            });
                        }
                    }).catch(err => {
                        Toast.fire({
                          icon: 'error',
                          title: 'Network Error!'
                        });
                    })
                }
            },
            handleFileUpload(){
                // this.files = this.$refs.files.files;
                let uploadedFiles = this.$refs.files.files;
                for( var i = 0; i < uploadedFiles.length; i++ ){
                    this.files.push( uploadedFiles[i] );
                    this.readFileUrl(uploadedFiles[i]);
                }
                // this.coverFile = this.$refs.files.files[0];
                console.log(this.files);

            },
            readFileUrl(file){
                let name = file.name;
                let reader = new FileReader();  
                reader.onload = (e) => {  
                    // get file content  
                    let text = e.target.result; 
                    this.fileRead.push(e.target.result);
                }
                reader.readAsDataURL(file);
            },
            removeFile(file){
                this.files.splice( file, 1 );
                this.fileRead.splice(file, 1);
            },
            removeImage(image){
                axios.delete(`/admin/productsImage/${image.id}`)
                .then((res) => {
                    if(res.status == 204){
                        this.images = this.images.filter((state) => {
                            return state.id !== image.id;
                        });
                        Toast.fire({
                          icon: 'success',
                          title:   `Product Image was successfully deleted.`
                        }); 
                    }
                })
                .catch((err) => {
                    Toast.fire({
                          icon: 'error',
                          title:   `Product Image was not deleted. Please try again.`
                    }); 
                });
            },
            updateProduct(){
                let formData = new FormData();
                if(this.files){
                    for( var i = 0; i < this.files.length; i++ ){
                        let file = this.files[i];

                        formData.append('files[' + i + ']', file);
                    }
                }


                formData.append('name', this.name);
                formData.append('price', this.price);
                formData.append('qty', this.qty);
                formData.append('category', this.selectedCat);
                formData.append('subcategory', this.selectedSubCat);
                formData.append('description', this.description);
                formData.append('excerpt', this.excerpt);
                formData.append('_method', 'PATCH');

                axios.post(`/admin/products/${this.product.id}`,
                    formData,
                    {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then((res) =>{
                    if(res.status == 200){
                        

                        Toast.fire({
                            icon: 'success',
                            title:   `Product was updated successfully!`
                        });

                        this.reset();
                        this.closeModal();
                    } else {
                        Toast.fire({
                          icon: 'error',
                          title: 'There was some network error!'
                        });
                    } 

                })
                .catch((error) => {

                    let errors       = error.response.data.errors;
                    this.fileErr     = [];
                    this.nameErr     = [];
                    this.priceErr    = [];
                    this.qtyErr      = [];
                    this.categoryErr = [];
                    if(error.response.status == 422){
                        this.fileErr = ["File must be jpeg, png or gif"];
                    }

                    if(errors){
                        if(errors.files){
                            this.fileErr = errors.files;
                        }
                        if(errors.name){
                            this.nameErr = errors.name;
                        }

                        if(errors.price){
                            this.priceErr = errors.price;
                        }

                        if(errors.qty){
                            this.qtyErr = errors.qty;
                        }

                        if(errors.category || errors.subcategory){
                            this.categoryErr = errors.category || errors.subcategory;
                        }
                    }
                    Toast.fire({
                      icon: 'error',
                      title: 'There was some network error!'
                    });
                });
            },
            reset(){
                this.name = '';
                this.price = '';
                this.qty = '';
                this.subCategoriesArray = [];
                this.description = '';
                this.excerpt = '';
                this.files   = [];
                this.fileRead = [];
                this.fileErr         = [];
                this.nameErr         = [];
                this.priceErr        = [];
                this.qtyErr          = [];
                this.categoryErr     = [];            
            },
            closeModal(){
                eventBus.$emit('close-modal');
            },
        }
    };
</script>
