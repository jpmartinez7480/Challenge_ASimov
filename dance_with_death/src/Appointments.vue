<template>
    <div>
      <v-snackbar
        v-model="snackbar_result"
        top
        :timeout=2000
        :color="color_post_result"
      >
        {{ post_result }}
      </v-snackbar>
      <v-dialog
        v-model="dialog"
        max-width="290"
        dark
      >
        <v-card>
          <v-card-text>
            Do you want cancel the appointment?
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
              color="orange darken-1"
              text
              @click="dialog = false"
            >
              Cancel
            </v-btn>
            <v-btn
              color="orange darken-1"
              text
              @click="delete_appointment"
            >
              Accept
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
      <v-dialog
        v-model="dialog_update_open"
        dark
        width="500"
      >
        <v-card>
          <v-card-title class="headline">Your data</v-card-title>
          <v-card-text>
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
                style = "height:75px"
                 >
              </v-text-field>
              <v-text-field
                v-model="rut"
                label="Rut"
                data-vv-name="rut"
                :rules="[v => !!v || 'Rut is required',v => /.+-.+/.test(v) || 'Rut must be valid']"
                solo
                outlined
                rounded
                color="orange darken-4"
                style = "height:75px"
                disabled
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
                style = "height:75px"
                >
              </v-text-field>
              <v-text-field
                v-model="phone"
                label="Phone"
                data-vv-name="phone"
                :rules="[v => !!v || 'Phone is required']"
                solo
                outlined
                rounded
                color="orange darken-4"
                style = "height:75px"
              >
              </v-text-field>
            </v-form>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
              color="orange darken-1"
              text
              @click="dialog_update_open = false"
            >
              Cancel
            </v-btn>
            <v-btn
              color="orange darken-1"
              text
              @click="update_data()"
            >
              Accept
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
        <v-row justify="center">
            <h2 class = "title-steps">Your Appointments</h2>
        </v-row>
        <v-row justify="center">
            <v-col cols="7" offset="2" v-if="!found_rut">
              <v-text-field
                v-model="rut"
                label="Rut"
                data-vv-name="rut"
                solo
                outlined
                rounded
                style = "height:75px;"
                >
              </v-text-field>
              <div class = "search-container">
                <v-btn class="mr-4 search-btn" @click="search" dark rounded>Search</v-btn>
              </div>
              <div class = "spinner-container" v-if="is_searching">
                <v-progress-circular
                  :size="70"
                  :width="7"
                  color="orange darken-4"
                  indeterminate
                ></v-progress-circular>
              </div>
            </v-col>
            <v-col cols="7" offset="2" v-else>
              <v-simple-table dark style = "padding:10px">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Turn</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in appointments" :key="item.id">
                    <td>{{item.day}}</td>
                    <td>{{parseTurn(item.turn)}}</td>
                    <td v-if="item.status==0" style = "color:#1E88E5">Pending</td>
                    <td v-else-if="item.status==1" style = "color:#43A047">Finish</td>
                    <td v-if="item.status==0">
                      <v-icon small class = "mr-2 iconAction" @click="dialog_update(item.id)">mdi-pencil</v-icon>
                      <v-icon small class = "mr-2 iconAction" @click="dialog_cancel(item.id)">mdi-delete</v-icon>
                    </td>
                    <td v-else>No available</td>
                  </tr>
                </tbody>
              </v-simple-table>
            </v-col>
        </v-row>
    </div>
    
</template>

<script>

import axios from 'axios'

export default {
  name: 'Appointments',
    data () {
      return {
        headers: [
          { text: 'Date', value: 'date' },
          { text: 'Turn', value: 'turn' },
          { text: 'Status', value: 'status' },
          { text: 'Actions', value: 'action'}
        ],
        appointments: [],
        rut:'',
        found_rut: false,
        color_post_result: '',
        post_result:'',
        snackbar_result:false,
        is_searching:false,
        dialog: false,
        id_delete:-1,
        name:'',
        rut:'',
        phone:'',
        email:'',
        dialog_update_open: false,
        valid:true,
        id_update:0
      }
    },
    methods:{
      parseTurn(value){
        switch(value){
          case 1:
            return '09:00 - 10:00'
          case 2:
            return '10:00 - 11:00'
          case 3:
            return '11:00 - 12:00'
          case 4:
            return '12:00 - 13:00'
          case 5:
            return '13:00 - 14:00'
          case 6:
            return '14:00 - 15:00'
          case 7:
            return '15:00 - 16:00'
          case 8:
            return '16:00 - 17:00'
          case 9:
            return '17:00 - 18:00'
        }
      },
      dialog_update(id){
        this.id_update = id
        axios({
          method: 'GET',
          url: 'http://localhost:8100/api/appointment_turn/'+id
        })
        .then((response) => {
          if(response.status === 200){
            this.name = response.data.fullname,
            this.rut = response.data.rut,
            this.phone = response.data.phone,
            this.email = response.data.email
          }
          else{
            this.color_post_result = "red darken-1"
            this.post_result = "Error to get data. Try again later"
          }
        })
        .catch((error) => {
            this.color_post_result = "red darken-1"
            this.post_result = "Error to get data. Try again later"
        })
        this.dialog_update_open=true      
      },
      update_data(){
        axios({
          method: 'PUT',
          url: 'http://localhost:8100/api/appointment/'+this.id_update,
          data: {
            fullname: this.name,
            email: this.email,
            rut: this.rut,
            phone: this.phone
          }
        })
        .then((response) => {
          if(response.status === 200){
            this.color_post_result = "green darken-1"
            this.post_result = "Your data was update"
            this.snackbar_result = true
            this.dialog_update_open = false
          }
          else{
            this.color_post_result = "red darken-1"
            this.post_result = "Your data wasn't update"
            this.snackbar_result = true
            this.dialog_update_open = false
          }
        })
        .catch((error) => {
            this.color_post_result = "red darken-1"
            this.post_result = "Your data wasn't update"
            this.snackbar_result = true
            this.dialog_update_open = false
        })
      },
      dialog_cancel(id){
        this.dialog= true
        this.id_delete = id
      },
      search(){
        axios({
          method: 'GET',
          url: 'http://localhost:8100/api/appointment/'+this.rut
        })
        .then((response) => {
          this.is_searching = true
          if(response.status===200){
            if(response.data.length === 0){
              this.snackbar_result = true
              this.color_post_result = "blue darken-1"
              this.post_result = "This rut doesn't have appointments. Try again"   
              this.is_searching = false
            }
            else if(response.data.length > 0){
              this.appointments = response.data
              this.found_rut = true
              this.is_searching = false
            }
          }
        })
      },
      delete_element(){
        for(var i = 0; i < this.appointments.length; i++){
          if(this.appointments[i].id === this.id_delete){
            this.appointments.splice(i,1)
            i = this.appointments.length
          }
        }
      },
      delete_appointment(){
        axios({
          method: 'DELETE',
          url: 'http://localhost:8100/api/appointment/'+this.id_delete
        })
        .then((response) => {
          if(response.status === 200){
            this.snackbar_result = true
            this.color_post_result = "green darken-1"
            this.post_result = "The appointment was cancelled"
            this.dialog = false
            this.delete_element()
          }
          else{
            this.snackbar_result = true
            this.color_post_result = "red darken-1"
            this.post_result = "Error. The appointment wasn't cancelled"
            this.dialog = false
          }
        })
      }
    }
  }
</script>

<style>

.spinner-container{
  text-align: center;
  margin-top:50px;
}

.theme--dark.v-data-table{
  background-color: #212121 !important;
  color: #757575  !important;
}

.theme--dark.v-data-table thead tr th{
  color: #757575 !important;
  font-weight: 500 !important;
}

.iconAction:hover{
  cursor:pointer;
  color:#E65100;
}

.search-container{
  text-align: center
}

.search-btn{
  font-weight: 300 !important;
}

.theme--light.v-text-field--outlined fieldset{
  border-color:#757575 !important;
}

.theme--light.v-input:not(.v-input--is-disabled) input{
  color: #757575 !important;
}

</style>