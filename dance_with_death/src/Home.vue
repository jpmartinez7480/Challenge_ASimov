<template>
    <div>
    <!--form -->  
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
               :picker-date.sync="pickerDate"
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
      </v-col>
    </v-row>
    <!--form -->
    </div>
</template>

<script>
import Vue from 'vue'
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
      pickerDate: null,
      day_is_selected:false,
      picker: new Date().toISOString().substr(0,10),
      //dateFormatted: formatDate(new Date().toISOString().substr(0, 10)),
      //min_dd: String(new Date().getFullYear()) + '-' + String(new Date().getMonth()+1).padStart('2','0') + '-' + String(new Date().getDate()).padStart('2','0'),
      //max_dd: String(today.getFullYear()) + String(today.getMonth()+1).padStart('2','0') + String(today.getDate()).padStart('2','0'),
      min_dd: "2019-08-15",
      max_dd: "2019-08-31",
      name:'',
      email: '',
      rut:'',
      playlist:'',
      phone:'',
      turn_selected:0,
      turns_day_selected:[
        {
          turn:1,
          value:'09:00 - 10:00'
        },
        {
          turn:2,
          value:'10:00 - 11:00'
        },
        {
          turn:3,
          value:'11:00 - 12:00'
        },
        {
          turn:4,
          value:'12:00 - 13:00'
        },
        {
          turn:5,
          value:'13:00 - 14:00'
        },
        {
          turn:6,
          value:'14:00 - 15:00'
        },
        {
          turn:7,
          value:'15:00 - 16:00'
        },
        {
          turn:8,
          value:'16:00 - 17:00'
        },
        {
          turn:9,
          value:'17:00 - 18:00'
        }
      ],
      snackbar_result: false,
      result_post: 'The appointment was succefully saved. Check your email',
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
      this.interval= setInterval(() => {
        if(this.value == 5){
          this.day_is_selected=true
        }
        this.value+=1
      },1000)
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
        /*axios.post(ruta,{
          fullname: this.fullname,
          email: this.email,
          rut: this.rut,
          phone: this.phone,
          day: this.picker,
          turn: this.turn
        })
        .then((response) => {
          
        })*/
        this.snackbar_result = true
      },
      cancel(){
        this.e2 = 1
      },
      next(){
        this.e2 = 2
        
      },
      myalert(value){
        alert(value)
      }
    },
    watch:{
      pickerDate(val){
        
      }
    }
    
  
};
</script>

<style>

</style>