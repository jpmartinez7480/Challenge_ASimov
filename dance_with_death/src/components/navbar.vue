<template>
    <div class = "navbar">
        <v-layout row wrap>
            <v-flex xs12 sm12 lg12 xl12>
                <v-toolbar class = "myToolbar">
                <v-spacer></v-spacer>
                <v-toolbar-items>
                    <v-btn text><router-link :to="'/index/home'">Home</router-link></v-btn>
                <v-btn text><router-link :to="'/index/appointments'">Appointments</router-link></v-btn>
                </v-toolbar-items>
                </v-toolbar>
            </v-flex>
        </v-layout>
    </div>
</template>

<script>


</script>

<style>


.myToolbar{
  background-color:#151515 !important;
  transition: none !important;
  box-shadow: none !important;
}

.navbar{
  padding-left:313px !important;
}

.v-application a{
    color: #757575 !important;
    text-decoration: none !important;
}

</style>