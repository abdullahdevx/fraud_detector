<template>
<div id="footer">
<footer
        class="text-center text-lg-start text-white"
        style="background-color: darkcyan"
        >
  <!-- Section: Social media -->
  <section
           class="d-flex justify-content-between "
           style="background-color : white"
           >
  
    
    <!-- Right     .-->
  </section>
  <!-- Section: Social media -->

  <!-- Section: Links  -->
  <section class="">
    <div class="container text-center text-md-start mt-5">
      <!-- Grid row -->
      <div class="row mt-3">
        <!-- Grid column -->
        <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
          <!-- Content -->
          <h6 class="text-uppercase fw-bold">Company name</h6>
          <hr
              class="mb-4 mt-0 d-inline-block mx-auto"
              style="width: 60px; background-color: #7c4dff; height: 2px"
              />
          <p>
            FRAUD DETECTOR
          </p>
        </div>
     

        <!-- Grid column -->
        <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
          <!-- Links -->
          <h6 class="text-uppercase fw-bold">links</h6>
          <hr
              class="mb-4 mt-0 d-inline-block mx-auto"
              style="width: 60px; background-color: #7c4dff; height: 2px"
              />
          <p>
            <router-link to="/account" class="text-white">Your Account</router-link>
          </p>
          <p>
            <router-link to="/about" class="text-white">About Us</router-link>
          </p>
        
         
        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
          <!-- Links -->
          <h6 class="text-uppercase fw-bold">Contact</h6>
          <hr
              class="mb-4 mt-0 d-inline-block mx-auto"
              style="width: 60px; background-color: #7c4dff; height: 2px"
              />
          <p><i class="fas fa-home mr-3"></i> Address</p>
          <p><i class="fas fa-envelope mr-3"></i> frauddetectorofficial@gmail.com</p>
          <p><i class="fas fa-phone mr-3"></i> + 01 234 567 88</p> 
          <p><i class="fas fa-print mr-3"></i> + 01 234 567 89</p>
        </div>
        <!-- Grid column -->
      </div>
      <!-- Grid row -->
    </div>
  </section>
  <!-- Section: Links  -->

  <!-- Copyright -->
  <div
       class="text-center p-3"
       style="background-color: rgba(0, 0, 0, 0.2)"
       >
    © 2024 Copyright:
    <a class="text-white" href=""
       >Fraud Detector</a
      >
  </div>
  <!-- Copyright -->
</footer>
</div>

   </template>
   
   <script>
   export default {
     name: 'FooterItem',
    
   }
   </script>
   
   <!-- Add "scoped" attribute to limit CSS to this component only -->
   <style scoped>
   
#footer {
    position: relative;
    padding-top: 225px;
    width: 100%;
    /* other styles as needed */
}


   </style>
   