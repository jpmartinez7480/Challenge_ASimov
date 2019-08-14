<template>
  <v-app>
    <!--sidebar-->
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
    <!--sidebar-->
    <!--navbar-->
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
    <!--navbar-->

    <!--form -->  
    <v-row justify="center">
      <h2 class = "title-steps">Follow the steps to concert a dance with Death</h2>
    </v-row>
    <v-row justify="center">
      <v-stepper v-model="e2" vertical style = "background:#151515;box-shadow:none;" dark>
        <v-stepper-step :complete="e2 > 1" step="1" color = "orange darken-4">Pick a Day an a hour</v-stepper-step>
        <v-stepper-content step="1">
          <v-row justify="center">
            <v-date-picker v-model="picker" color="grey darken-4" dark landscape width="450"></v-date-picker>
          </v-row>
        </v-stepper-content>
        <v-stepper-step :complete="e2 > 2" step="2" color = "orange darken-4">Complete Form</v-stepper-step>
        <v-stepper-content step="2">
          <v-row style = "margin-left:0px;">
            <form>
              <v-text-field
                v-model="name"
                :error-messages="errors.collect('name')"
                label="Full name"
                data-vv-name="name"
                required
                solo
                outlined
                rounded
                color="orange darken-4"
                style = "height:75px"
                 >
              </v-text-field>
              <v-text-field
                v-model="rut"
                v-validate="'required|rut'"
                label="Rut"
                data-vv-name="rut"
                solo
                outlined
                rounded
                color="orange darken-4"
                style = "height:75px"
                >
              </v-text-field>
              <v-text-field
                v-model="email"
                v-validate="'required|email'"
                :error-messages="errors.collect('email')"
                label="E-mail"
                data-vv-name="email"
                required
                solo
                rounded
                outlined
                color="orange darken-4"
                style = "height:75px"
                >
              </v-text-field>
              
              <v-text-field
                v-model="phone"
                label="Phone"
                data-vv-name="phone"
                solo
                outlined
                rounded
                color="orange darken-4"
                style = "height:75px"
                >
              </v-text-field>
              <div class = "btn-container">
                <v-btn class="mr-4" @click="submit" rounded>Submit</v-btn>
                <v-btn class="mr-2" @click="cancel" rounded>Cancel</v-btn>
              </div>
            </form>
          </v-row>
        </v-stepper-content>
      </v-stepper>
    </v-row>
    <!--form --> 
  </v-app>
</template>


<script>
import HelloWorld from './components/HelloWorld';
import Vue from 'vue'
import VeeValidate from 'vee-validate'
Vue.use(VeeValidate)
export default {
  name: 'App',
  components: {
    HelloWorld,
  },
   $_veeValidate: {
      validator: 'new',
    },
  data () {
    return {
      e2: 1,
      picker: new Date().toISOString().substr(0,10),
      name:'',
      email: '',
      rut:'',
      playlist:'',
      phone:'',
      dictionary: {
        attributes: {
          email: 'E-mail Address',
          // custom attributes
        },
        custom: {
          name: {
            required: () => 'Name can not be empty',
            max: 'The name field may not be greater than 10 characters',
            // custom messages
          },
        }
      }
    }
  },
  mounted () {
      this.$validator.localize('en', this.dictionary)
  },
   methods: {
      validate () {
        if (this.$refs.form.validate()) {
          this.snackbar = true
        }
      },
      reset () {
        this.$refs.form.reset()
      },
      resetValidation () {
        this.$refs.form.resetValidation()
      },
      submit(){
        alert('guardando')
      },
      cancel(){
        this.e2 = 1
      },
    },
  
};
</script>



<style>

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

