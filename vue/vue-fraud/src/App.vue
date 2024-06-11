<template>
  <router-view/>
  <NavbarItem/>
  <!-- <FooterItem/> -->
<SignUp/>
</template>

<script>
import NavbarItem from './components/NavbarItem.vue'

export default {
  name: 'App',
  components: {
    NavbarItem,
   
  },
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}


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
</style>