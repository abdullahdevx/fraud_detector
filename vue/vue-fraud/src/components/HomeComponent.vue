<template>
<br>
<h1>REVIEWS</h1>
<br>
<div v-if="!searchData" class="container data">
    <div class="row">
        <div v-for="result in data" :key="result.id" class="col-md-2">
            <div class="border-top border-bottom my-3 pt-2 pb-0 " v-on:click="showEntity(result.id)" @click="showModal = true" >
                <div>
                    <img :src="result.picture" alt="IMAGE" id="img" ><br>
                    <b>{{result.title}}<br></b>
                   <div v-if="result.totalRating >= 1 && result.totalRating < 1.5">
                   <small> Overall Rating: Very Poor</small>
                   </div>
                   <div v-else-if="result.totalRating >= 1.5 && result.totalRating < 2">
                   <small> Overall Rating: Poor</small>
                   </div>
                    <div v-else-if="result.totalRating >= 2.5 && result.totalRating < 3">
                   <small> Overall Rating: Average</small>
                   </div>
                   <div v-else-if="result.totalRating >= 3 && result.totalRating < 4">
                   <small> Overall Rating: Good</small>
                   </div>
                   <div v-else-if="result.totalRating >= 4 ">
                   <small> Overall Rating: Perfect</small>
                   </div>

                    <div class="d-flex justify-content-center pb-1">
                        <star-rating class="content-center" :show-rating="false" :rating="result.totalRating" :max-rating="5" :star-size="18"></star-rating>
                      <div class="pt-1">
                        ({{ result.totalReviews }}) 

                        </div>
                    </div>
                </div>
            </div>
        </div>
      
    </div>
   
</div>

<div v-if="!searchData && isloading">
    <FooterItem/>
</div>

<!-- SHOWING THIS DIV ONLY WHEN SEARCH ISNT EMPTY -->
<div v-if="searchResult.length > 0 && searchData" class="container data">
    <div class="row">
        <div v-for="result in searchResult" :key="result.id" class="col-md-2">
            <div class="border-top border-bottom my-3 pt-2 pb-1 " v-on:click="showEntity(result.id)" @click="showModal = true">
                <div>
                    <img :src="result.picture" alt="IMAGE" id="img" ><br>
                    {{result.title}}<br>
                      <div v-if="result.totalRating >= 1 && result.totalRating < 1.5">
                   <small> Overall Rating: Very Poor</small>
                   </div>
                   <div v-else-if="result.totalRating >= 1.5 && result.totalRating < 2">
                   <small> Overall Rating: Poor</small>
                   </div>
                    <div v-else-if="result.totalRating >= 2.5 && result.totalRating < 3">
                   <small> Overall Rating: Average</small>
                   </div>
                   <div v-else-if="result.totalRating >= 3 && result.totalRating < 4">
                   <small> Overall Rating: Good</small>
                   </div>
                   <div v-else-if="result.totalRating >= 4 ">
                   <small> Overall Rating: Perfect</small>
                   </div>

                    <div class="d-flex justify-content-center">
                        <star-rating class="content-center" :show-rating="false" :rating="result.totalRating" :max-rating="5" :star-size="18"></star-rating>
                        <div class="pt-1">
                        ({{ result.totalReviews }})
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- IF NO RESULTS ARE FOUND  -->
<div v-if="searchResult.length == 0 && searchData" class="container text-center pt-5">
        <div>
            <br><br>
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
                            <div class="d-flex justify-content-center pt-1">
                                <star-rating class="content-center" :show-rating="false" :rating="modalData.totalRating" :max-rating="5" :star-size="18"></star-rating>
                                ({{ modalData.totalReviews }})
                            </div>
                            <a id="url" :href="modalData.url" target="_blank">{{modalData.url}}</a>
                            <br>
                        </div>
                        <div class="col-sm-6 pt-3">
                            <h5 >Description</h5>
                            <p id="description"> {{modalData.description}} </p><br>
                        </div>
                    </div>
                </div>
                <br>
                <div class="input-group">
                    <input v-model="review" type="text" placeholder="Add a review" class="rounded-pill form-control" />
                    <star-rating v-model:rating="rating" :show-rating="false" :max-rating="5" :star-size="20"></star-rating><br>
                     &nbsp;
                    <button class="btn btn-success rounded-pill" v-on:click="submitReview(modalData.id)"> Post</button>
                </div> <br>
            <div  style="height: 450px;  overflow-y: auto;">
               <div v-if="reviewData1.length == 0 && reviewData2.length == 0" >
                        <p > <br><br><br><br><br><br>No Reviews Found
                        </p>
               </div>
                <!-- <div v-for="review in reviewData1" :key="review.id">     -->
                    <div class="row">             
                 <div class="col-sm-6  ps-3 border-end">
                    <div v-for="review in reviewData1" :key="review.id" class="mt-3">
                    <img id="imgcomment" :src="review.user_belongs_to.user_image" alt="IMAGE" class="img-fluid rounded-circle">
                    <small> {{review.human_readable_created_at}}</small>
                    <star-rating class="ps-2" :rating="review.rating" :show-rating="false" :max-rating="5" :star-size="12"></star-rating> 
                   <div class="text-break"> {{review.comment}}</div>
                   <hr style="width:30%; margin-left:auto; margin-right:auto;">
                </div>
                </div>

                <!-- another sm  -->
                <div class="col-sm-6 ps-3 ">
                    <div v-for="review in reviewData2" :key="review.id" class="mt-3">
                    <img id="imgcomment" :src="review.user_belongs_to.user_image" alt="IMAGE" class="img-fluid rounded-circle">
                    <small> {{review.human_readable_created_at}}</small>
                    <star-rating class="ps-2" :rating="review.rating" :show-rating="false" :max-rating="5" :star-size="12"></star-rating> 
                   <div class="text-break"> {{review.comment}}</div>
                   <hr style="width:30%; margin-left:auto; margin-right:auto;">

                </div>
                </div>

                
            
                </div>
                     
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
import FooterItem from '@/components/FooterItem.vue';


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
            isloading: false,
            modalData: [],
            reviewData: [],
            reviewData1: [],
            reviewData2: [],
        }
    },
    components: {
        StarRating,
        FooterItem,

    },
    methods: {
        successReviewToast() {
            toast.success('Review added', {
                autoClose: 1000,
            });
        },
        verifyEmailToast() {
            toast.error('Please verify your email address!', {
                autoClose: 2000,
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
                        if(error.response.status == 401)
                        {
                            this.verifyEmailToast();
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
            this.reviewData1 = [];
            this.reviewData2 = [];

        },

        async showEntity(id) {
            const entityData = await axios.get(`http://127.0.0.1:8000/api/entitydata/${id}`);
            this.modalData = entityData.data.data;
            this.reviewData = entityData.data.review;
            const midPoint = Math.ceil(this.reviewData.length / 2);

            // Split the reviewData array into two arrays
        this.reviewData1 = this.reviewData.slice(0, midPoint);
        this.reviewData2 = this.reviewData.slice(midPoint);

        }
    },

    async mounted() {
        const result = await axios.get("http://127.0.0.1:8000/api/home");
        this.data = result.data.data;
        this.isloading = true;

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
    width: 170px;
    height: 150px;

}

#description {
    float: left;
}

#img {
    width: 166px;
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

.modal {
    display: block;
    /* Hidden by default */
    position: fixed;
    /* Stay in place */
    z-index: 1;
    /* Sit on top */
    padding-top: 10px;
    /* Location of the box */
    padding-bottom: 80px;
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

/* Modal Content */
.modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 10px;
    border: 1px solid #888;
    width: auto; /* Set to auto to allow content-based width */
    max-width: 80%; /* Maximum width to prevent excessive width */
    height: auto; /* Set to auto for dynamic height */
    overflow-x: hidden; /* Hide horizontal overflow */
}

/* Adjust width and margins of child elements */
#main {
    margin-bottom: 10px; /* Add space between main content and input section */
}

.input-group {
    margin-top: 10px; /* Add space above input section */
    margin-bottom: 20px; /* Add space below input section */
}

.row {
    margin-right: 0; /* Remove right margin to prevent unnecessary space */
    margin-left: 0; /* Remove left margin to prevent unnecessary space */
}

.col-sm-6 {
    padding-right: 10px; /* Add padding between columns */
    padding-left: 10px; /* Add padding between columns */
}



/* Modal Content */

/* The Close Button */
.close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.reviews-section {
    max-height: 70px; /* Adjust height as needed */
    overflow-y: auto;
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
/* This will change the scrollbar for the entire page */
::-webkit-scrollbar {
    width: 6px; /* width of the entire scrollbar */
}

::-webkit-scrollbar-track {
    background: #f1f1f1; /* color of the tracking area */
}

::-webkit-scrollbar-thumb {
    background: #888; /* color of the scroll thumb */
    border-radius: 5px; /* roundness of the scroll thumb */
  
}

::-webkit-scrollbar-thumb:hover {
    background: #4b4949; /* color of the scroll thumb on hover */
    width: 20px;
}
::-webkit-scrollbar-horizontal {
    width: 1px; /* Adjust this value to change the thickness of the horizontal scrollbar */
}

/* This will change the scrollbar for the modal content */
.modal-content::-webkit-scrollbar {
    width: 1px; /* width of the scrollbar */
}

.modal-content::-webkit-scrollbar-track {
    background: #f1f1f1; /* color of the tracking area */
}

.modal-content::-webkit-scrollbar-thumb {
    background: #dddadb; /* color of the scroll thumb */
    border-radius: 1px; /* roundness of the scroll thumb */
}

.modal-content::-webkit-scrollbar-thumb:hover {
    background: #c43030; /* color of the scroll thumb on hover */
}

#content {
    /* Add padding equal to the height of the footer */
    padding-bottom: 100px; /* Adjust this value based on the height of your footer */
}

</style>
