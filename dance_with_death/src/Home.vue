<template>
    <div>
    <!--form --> 
    <v-snackbar
      v-model="snackbar_result"
      top
      :timeout=2000
      :color="color_post_result"
    >
    {{ post_result }}
    </v-snackbar> 
    <v-row justify="center">
      <h2 class = "title-steps">Follow the steps to concert a dance with Death</h2>
    </v-row>
    <v-row justify="center">
      <v-col offset="3">
      <v-stepper v-model="e2" vertical style = "background:#151515;box-shadow:none;" dark>
        <v-stepper-step :complete="e2 > 1" step="1" color = "orange darken-4">Pick a Day an a hour</v-stepper-step>
        <v-stepper-content step="1">
          <v-row justify="center">
            <v-col cols="6">
              <v-date-picker
               v-model="picker" 
               color="grey darken-4"  
               dark
               :min="min_dd"
               :max="max_dd"
               :allowed-dates="allowedDates"
               landscape></v-date-picker>
            </v-col>
            <v-col cols="6" >
              <v-container grid-list-sm>
                <v-progress-circular v-if="!day_is_selected"
                  
                  :size="70"
                  :width="7"
                  color="orange darken-4"
                  indeterminate
                ></v-progress-circular>
                <v-row v-else>
                  <v-col v-for="n in turns_day_selected.length" :keys="n" sm="4">
                    <v-btn class="myBtn" @click="turn_selected=turns_day_selected[n-1].turn" rounded>{{turns_day_selected[n-1].value}}</v-btn>
                  </v-col>
                </v-row>
              </v-container>
            </v-col>
          </v-row>
          <v-btn class = "mr-2" @click="next" rounded v-if="turn_selected>0">Aceptar</v-btn>
        </v-stepper-content>
        <v-stepper-step :complete="e2 > 2" step="2" color = "orange darken-4">Complete Form</v-stepper-step>
        <v-stepper-content step="2">
          <v-row style = "margin-left:0px;">
            <v-form 
              ref="form"
              v-model="valid"
              lazy-validation>
              <v-text-field
                v-model="name"
                label="Full name"
                data-vv-name="name"
                :rules="[v => !!v || 'Fullname is required']"
                required
                solo
                outlined
                rounded
                color="orange darken-4"
                 >
              </v-text-field>
              <v-text-field
                v-model="rut"
                label="xxxxxxxx-x"
                data-vv-name="rut"
                :rules="[v => !!v || 'Rut is required',v => /.+-.+/.test(v) || 'Rut must be valid']"
                required
                solo
                outlined
                rounded
                color="orange darken-4"
                >
              </v-text-field>
              <v-text-field
                v-model="email"
                :rules="[v => /.+@.+\..+/.test(v) || 'E-mail must be valid']"
                label="E-mail"
                data-vv-name="email"
                required
                solo
                rounded
                outlined
                color="orange darken-4"
                >
              </v-text-field>
              
              <v-text-field
                v-model="phone"
                label="Phone"
                data-vv-name="phone"
                :rules="[v => !!v || 'Phone is required']"
                solo
                required
                outlined
                rounded
                color="orange darken-4"
                
                >
              </v-text-field>
              <div class = "btn-container">
                <v-btn class="mr-4" @click="submit" rounded>Submit</v-btn>
                <v-btn class="mr-2" @click="cancel" rounded>Cancel</v-btn>
              </div>
            </v-form>
          </v-row>
        </v-stepper-content>
      </v-stepper>
      </v-col>
    </v-row>
    <!--form -->
    </div>
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VeeValidate from 'vee-validate'
import { setInterval } from 'timers';
Vue.use(VeeValidate)
export default {
  name: 'Home',
  
   $_veeValidate: {
      validator: 'new',
    },
  data () {
    return {
      e2: 1,
      interval:{},
      value:0,
      valid:true,
      pickerDate: null,
      day_is_selected:false,
      picker: new Date().toISOString().substr(0,10),
      today: new Date(),
      min_dd: String(new Date().getFullYear()) + '-' + String(new Date().getMonth()+1).padStart('2','0') + '-' + String(new Date().getDate()).padStart('2','0'),
      max_dd: String(new Date().getFullYear()) + '-' + String(new Date().getMonth()+(12-new Date().getMonth()+1)).padStart('2','0') + '-' + String(new Date().getDate()).padStart('2','0'),
      name:'',
      email: '',
      rut:'',
      playlist:'',
      phone:'',
      turn_selected:0,
      post_result:'',
      color_post_result:'',
      turns_day_selected:[],
      snackbar_result: false,
      dictionary: {
        attributes: {
          email: 'E-mail Address',
          // custom attributes
        },
        custom: {
          name: {
            required: () => 'Fullname can not be empty',
          },
          rut: {
            required: () => 'Rut can not be empty',
          },
          phone: {
            required: () => 'Phone can not be empty', 
          },

        }
      }
    }
  },
  mounted () {
      this.$validator.localize('en', this.dictionary)
      var date = new Date()
      var date_aux = String(date.getFullYear()) + '-' + String(date.getMonth()+1).padStart('2','0') + '-' + String(date.getDate()).padStart('2','0')
      this.getTurnsPerDay(date_aux)
  },
  watch:{
    picker(current, prev){
      
      this.getTurnsPerDay(current)
    }
  },
   methods: {
     hello(){
       alert("oli")
     },
     allowedDates: val => ![5,6].includes(new Date(val).getDay()),
      getTurnsPerDay(day){
        axios({
          method: 'GET',
          url: 'http://localhost:8100/api/turns/'+day
        })
        .then((response) => {
          if(response.status === 200){
            this.turns_day_selected = response.data
            this.day_is_selected = true
          }
        })
        .catch((error) => {
          this.post_result = "Couldn't connect to server. Try again later"
          this.color_post_result = "red darken-1"
          this.snackbar_result = true
        })
      },
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
        if(this.$refs.form.validate()){
          
          axios({
          method: 'POST',
          url: 'http://localhost:8100/api/appointment',
          data: {
            fullname: this.name,
            email: this.email,
            rut: this.rut,
            phone: this.phone,
            day: this.picker,
            playlist:'a',
            status:0,
            turn: this.turn_selected
          }
          })
          .then((response) => {
            console.log(response)
            if(response.status===201){
              this.color_post_result="green darken-1"
              this.post_result="The appointement was successfully scheduled!! Check your email"
            }
            else if(response.status===200){
              this.color_post_result="blue darken-1"
              this.post_result=response.data
            }
          })
          .catch((error) => 
          {
              this.color_post_result="red darken-1"
              this.post_result="The appointment couldn't be scheduled. Try again later"
          })
          this.snackbar_result = true  
        
        }
        
        
      },
      cancel(){
        this.e2 = 1
        this.turn_selected = 0
      },
      next(){
        if(this.turn_selected === 0){
          this.color_post_result = "red darken-1"
          this.post_result = "You didn't choose an hour"
          this.snackbar_result = true
        }
        else 
          this.e2 = 2
        
      },
      myalert(value){
        alert(value)
      }
    },
    
  
};
</script>

<style>

</style>