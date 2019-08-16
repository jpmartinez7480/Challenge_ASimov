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
      >
        <v-card>
          <v-card-text>
            Do you want cancel the appointment?
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
              color="green darken-1"
              text
              @click="dialog = false"
            >
              Cancel
            </v-btn>
            <v-btn
              color="green darken-1"
              text
              @click="delete_appointment"
            >
              Accept
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
      <v-dialog
        v-model="dialog_update"
      >
        <v-card>
          <v-card-title class="headline">Your data</v-card-title>
          <v-card-text>
            <form>
              <v-text-field
                v-model="name"
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
                label="Rut"
                data-vv-name="rut"
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
            </form>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
              color="green darken-1"
              text
              @click="dialog_update = false"
            >
              Cancel
            </v-btn>
            <v-btn
              color="green darken-1"
              text
              @click="update_data"
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
                    <td>{{item.turn}}</td>
                    <td v-if="item.status==0" style = "color:#1E88E5">Pending</td>
                    <td v-else-if="item.status==1" style = "color:#43A047">Finish</td>
                    <td v-if="item.status==0">
                      <v-icon small class = "mr-2 iconAction">mdi-pencil</v-icon>
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
        appointments: [
          {
            date: '12-08-2019',
            turn: '09:00 - 10:00',
            status: 2
          },
          {
            date: '16-08-2019',
            turn: '13:00 - 14:00',
            status: 1
          },
          {
            date: '17-08-2019',
            turn: '09:00 - 10:00',
            status: 1
          },
        ],
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
        dialog_update: false
      }
    },
    methods:{
      update_data(){
        alert('por terminar')
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