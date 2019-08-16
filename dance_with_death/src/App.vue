<template>
  <v-app>   
    <!--content-->
     <router-view></router-view>
     <!--content-->
  </v-app>
</template>


<script>

import Sidebar from './components/sidebar';
import Navbar from './components/navbar';
import Home from './Home'
import Vue from 'vue'
import router from "./router";
export default {
  name: 'App',
  components: {
    Sidebar,
    Navbar,
    Home
  },
  mounted() {
    router.push('/index/home')
  }
}
</script>

<style>

 .myBtn{
   font-weight: 300 !important;
   font-size: 13px !important;
   
 }

.v-stepper__label{
  color: #757575 !important;
  font-weight: 200;
}

.title-steps{
  color:#757575;
  font-weight: 300 !important;
  letter-spacing: 1.04px;
  margin-top:10px;
  margin-left:290px;
  margin-bottom:10px;
}

.btn-container{
  text-align: center;
}

.calendar-container{
  margin-left:310px;
  margin-top:60px;
}

.theme--light.v-btn{
  color:#757575 !important;
  font-weight: 300;
}

.theme--light.v-btn:hover{
  border-bottom: 1px solid yellow !important;
  
}

.v-application--wrap{
  background-color: #151515;
  height:100%;
}

</style>

