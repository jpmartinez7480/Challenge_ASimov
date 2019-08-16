<template>
    <div>
        <Sidebar/>
        <Navbar />
        <router-view></router-view>
    </div>
    
</template>

<script>
import Vue from 'vue'
import Sidebar from './components/sidebar';
import Navbar from './components/navbar';
export default {
  name: 'Layout',
  components: {
    Sidebar,
    Navbar,
  }
}
</script>