<template>
    <div>
        <v-row justify="center">
            <h2 class = "title-steps">Your Appointments</h2>
        </v-row>
        <v-row justify="center">
            <v-col cols="7" offset="2" v-if="!found_rut">
              <v-text-field
                v-model="rut"
                v-validate="'required|rut'"
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
                  <tr v-for="item in appointments" :key="item.date">
                    <td>{{item.date}}</td>
                    <td>{{item.turn}}</td>
                    <td v-if="item.status==1" style = "color:#1E88E5">Pending</td>
                    <td v-else-if="item.status==2" style = "color:#43A047">Finish</td>
                    <td v-else style = "color:#E53935">Cancelled</td>
                    <td v-if="item.status==1">
                      <v-icon small class = "mr-2 iconAction">mdi-pencil</v-icon>
                      <v-icon small class = "mr-2 iconAction">mdi-delete</v-icon>
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
        found_rut: false
      }
    },
    methods:{
      search(){
        this.found_rut=true
      }
    }
  }
</script>

<style>
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

</style>