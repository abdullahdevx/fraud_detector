<template>
<br>
<h1>REVIEWS</h1>
<br>
<div v-if="!searchData" class="container data">
    <div class="row">
        <div v-for="result in data" :key="result.id" class="col-md-2">
            <div class="border my-3 pt-2 pb-0 " v-on:click="showEntity(result.id)" @click="showModal = true" >
                <div>
                    <img :src="result.picture" alt="IMAGE" id="img" class="rounded "><br>
                    {{result.title}}<br>

                    <div class="d-flex justify-content-center">
                        <star-rating class="content-center" :show-rating="false" :rating="result.totalRating" :max-rating="5" :star-size="18"></star-rating>
                        <!-- <FooterItem/> -->

                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

<!-- SHOWING THIS DIV ONLY WHEN SEARCH ISNT EMPTY -->
<div v-if="searchResult.length > 0 && searchData" class="container data">
    <div class="row">
        <div v-for="result in searchResult" :key="result.id" class="col-md-2">
            <div class="border my-3 pt-1 pb-1 " v-on:click="showEntity(result.id)" @click="showModal = true"
                >
                <div>
                    <img :src="result.picture" alt="IMAGE" id="img" class="rounded"><br>
                    {{result.title}}<br>
                    <div class="d-flex justify-content-center">
                        <star-rating class="content-center" :show-rating="false" :rating="result.totalRating" :max-rating="5" :star-size="18"></star-rating>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- IF NO RESULTS ARE FOUND  -->
<div v-if="searchResult.length == 0 && searchData" class="container text-center pt-5">
                <div>
                    No results found
                </div>
</div>

<!-- MODAL FOR DISPLAYING ENTITIES -->
<div class="container">
    <div id="myModal" class="modal" v-if="showModal">
        <!-- Modal content FOR ADDING APP-->
        <div class="modal-content">
            <span v-on:click="nullModalData()" class="close" @click="showModal = false">&times;</span>
            <div id="appForm">
                <!--form fields-->
                <h3 class="font-weight-bold">{{modalData.title}}</h3>
                <div id="main" class="review" @click="showModal = true">
                    <div class="row">
                        <div class="col-sm-6">
                            <img id="imgmodal" :src="modalData.picture" alt="IMAGE" class="img-fluid rounded"><br>
                            <div class="d-flex justify-content-center">
                                <star-rating class="content-center" :show-rating="false" :rating="modalData.totalRating" :max-rating="5" :star-size="18"></star-rating>
                            </div>
                            <a id="url" :href="modalData.url" target="_blank">{{modalData.url}}</a>
                            <br>

                        </div>
                        <div class="col-sm-6 pt-5">
                            <p id="description"> {{modalData.description}} </p><br>

                        </div>
                    </div>
                </div>
                <br>
                <div class="input-group">
                    <input v-model="review" type="text" placeholder="Add a review" class="rounded-pill form-control" />
                    <button class="btn btn-success rounded-pill" v-on:click="submitReview(modalData.id)"> Post</button>
                    <br>
                    <star-rating v-model:rating="rating" :show-rating="false" :max-rating="5" :star-size="20"></star-rating>
                </div>

                <div v-for="review in reviewData" :key="review.id">
                    <img id="imgcomment" :src="review.user_belongs_to.user_image" alt="IMAGE" class="img-fluid rounded-circle">
                    <star-rating :rating="review.rating" :show-rating="false" :max-rating="5" :star-size="12"></star-rating> {{review.comment}}
                </div>

            </div>
        </div>
    </div>
</div>

</template>

    
<script>
import axios from 'axios'
import {useMyStore} from '@/store/navbar.js'
import {toast} from 'vue3-toastify'
import 'vue3-toastify/dist/index.css'
import 'bootstrap'
import 'bootstrap/dist/css/bootstrap.min.css'
import StarRating from 'vue-star-rating';
// import FooterItem from './FooterItem.vue'

export default {
    name: 'HomeComponent',

    computed: {
        searchResult() {
            const userStore = useMyStore();
            return userStore.searchResult;
        },
        searchData() {
            const userStore = useMyStore();
            return userStore.searchData;
        },
     
    },

    data() {
        return {
            rating: 0,
            review: '',
            data: null,
            showModal: false,
            modalData: [],
            reviewData: [],
        }
    },
    components: {
        StarRating,
        //  FooterItem,

    },
    methods: {
        successReviewToast() {
            toast.success('Review added', {
                autoClose: 1000,
            });
        },
        onlyOneReviewToast() {
            toast.error('Only one review per app is allowed', {
                autoClose: 2000,
            });
        },

        loginToast() {
            toast.error('Please Login to continue', {
                autoClose: 2000,
            });

        },
        emptyToast() {
            toast.error('Review cannot be empty!', {
                autoClose: 2000,
            });

        },

        async submitReview(id) {
            if (!this.review) {
                this.emptyToast();
            } else {
                const userStore = useMyStore();
                if (userStore.loginState == true) {
                    let entityID = id;
                    let userToken = localStorage.getItem('user-token');
                    userToken = userToken.replace(/^"(.*)"$/, '$1');
                    try {
                        let result = await axios.post("http://127.0.0.1:8000/api/addreview", {
                            rating: this.rating,
                            review: this.review,
                            entity_id: entityID,
                        }, {
                            headers: {
                                'Authorization': `Bearer ${userToken}`
                            }
                        });
                        if (result.status == 201) {
                            this.showEntity(entityID);
                            this.review = '';
                            this.successReviewToast();
                        }
                    } catch (error) {
                        if (error.response.status == 409) {
                            this.onlyOneReviewToast();
                        }

                    }
                } else {
                    this.loginToast();
                }
            }
        },
        //TO MAKE THE modalData PROPERTY NULL TO DISPLAY FRESH CONTENT WITHOUT SHOWING PREVIOUS LOADED CONTENT THAT APPEARS FOR A MINI SECOND
        nullModalData() {
            this.modalData = [];
            this.reviewData = [];
        },

        async showEntity(id) {
            const entityData = await axios.get(`http://127.0.0.1:8000/api/entitydata/${id}`);
            this.modalData = entityData.data.data;
            this.reviewData = entityData.data.review;
            console.log(this.modalData);
        }
    },

    async mounted() {
        const result = await axios.get("http://127.0.0.1:8000/api/home");
        this.data = result.data.data;
        try{
        let userToken = localStorage.getItem('user-token');
        userToken = userToken.replace(/^"(.*)"$/, '$1');
         let result = await axios.get("http://127.0.0.1:8000/api/checkrole", {
          headers:{
            'Authorization': `Bearer ${userToken}`
          }
        }); 
        if(result.status == 200)
        {
                const userStore = useMyStore();
                userStore.isAdmin = true;
            
        }
        }
        catch(error)
        {
            const userStore = useMyStore();
                userStore.isAdmin = false;

        }
 },
}
</script>
    
<style scoped>
#imgmodal {
    width: 140px;
    height: 130px;

}

#description {
    float: left;
}

#img {
    width: 150px;
    height: 150px;
}

#imgcomment {
    width: 40px;
    height: 40px;

}
 .enlarged {
        transform: scale(1.1); /* Increase the size by 10% */
        transition: transform 0.2s ease; /* Add a smooth transition effect */
    }
    footer {
  margin-top: auto;
}

.modal {
    display: block;
    /* Hidden by default */
    position: fixed;
    /* Stay in place */
    z-index: 1;
    /* Sit on top */
    padding-top: 70px;
    /* Location of the box */
    padding-bottom: 60px;
    /* Location of the box */
    left: 0;
    top: 0;
    width: 100%;
    /* Full width */
    height: 100%;
    /* Full height */
    overflow: auto;
    /* Enable scroll if needed */
    background-color: rgb(0, 0, 0);
    /* Fallback color */
    background-color: rgba(0, 0, 0, 0.4);
    /* Black w/ opacity */
}
#footer {
    position: fixed;
    bottom: 0;
    width: 100%;
    /* other styles as needed */
}

/* Modal Content */
.modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}

/* The Close Button */
.close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}
.data{
    cursor: pointer; 
}
</style>
