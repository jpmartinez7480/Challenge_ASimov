<template>
    <v-navigation-drawer class = "myNav" dark permanent>
        <v-img :src="require('../assets/death1.png')" aspect-ratio="1" class = "myIcon"></v-img>
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
</template>


<style>

.myNav{
  background-color:#191919 !important;
  width:300px !important;
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

.v-navigation-drawer__border{
  background-color:transparent !important;
}

.v-navigation-drawer {
  position: absolute
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

</style>