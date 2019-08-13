<template>
  <v-app>

    <v-navigation-drawer class = "myNav" dark permanent>
        <v-img :src="require('./assets/death1.png')" aspect-ratio="1" class = "myIcon"></v-img>
        <v-container>
          <v-row>
            <v-col cols="12" md = "11" style = "padding-left:30px">
              <p class = "presentation-text">
                Hi!, I’m Death. For one hour at day we can dance the songs that you want. 
                Just pick the day and hour.</p><p class = "presentation-text2">I’ll be wating for you :)</p> 
            </v-col>
          </v-row>
          <v-container class = "footer-info">
            <p><v-icon color = "#757575" small>mdi-email</v-icon><span>   dwd_contact@gmail.com</span></p>
            <p><v-icon color = "#757575" small>mdi-phone</v-icon><span>   (22) 6666 000</span></p>
          </v-container>
        </v-container>
      </v-navigation-drawer>
    
    <div class = "navbar">
      <v-layout row wrap>
        <v-flex xs12 sm12 lg12 xl12>
          <v-toolbar class = "myToolbar">
            <v-spacer></v-spacer>
            <v-toolbar-items>
            <v-btn text>Appointments</v-btn>
            <v-btn text>Rules</v-btn>
          </v-toolbar-items>
          </v-toolbar>
        </v-flex>
      </v-layout>
    </div>
    
  </v-app>
</template>

<style>

.theme--light.v-btn{
  color:#757575 !important;
  font-weight: 300;
}


.theme--light.v-btn:hover{
  border-bottom: 1px solid yellow !important;
  
}

.v-navigation-drawer {
  position: absolute
}

.myToolbar{
  background-color:#151515 !important;
  transition: none !important;
  box-shadow: none !important;
}

.presentation-text{
  color:#757575;
  font-size: 14px;
}


.presentation-text2{
  color:#757575;
  text-align: center;
  font-size: 14px;
}

.v-application--wrap{
  background-color: #151515;
  height:100%;
}

.myNav{
  background-color:#191919 !important;
  width:300px !important;
}

.v-navigation-drawer__border{
  background-color:transparent !important;
}

.myIcon{
  width: 85%;
  margin-top:55px;
  margin-left:20px;
  height:47%;
}

.footer-info{
  color:#757575;
  font-size: 14px;
}

.navbar{
  padding-left:313px !important;
}

</style>


<script>
import HelloWorld from './components/HelloWorld';

export default {
  name: 'App',
  components: {
    HelloWorld,
  },
  data: () => ({
    //
  }),
};
</script>
