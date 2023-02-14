<template>
  <div>
    <input type="number" v-model.trim="name">
    <input type="date" v-model.trim="date">
    <button @click="query()">add</button>
  </div>
</template>
<script>
export default {
  name: 'App',
  data(){
    return {
      name:'',
      date:'',
    };
  },
  methods: {
    query() {

      const formData=new FormData();

      formData.append('name', this.name)
      formData.append('date', this.date)
      formData.append('theme', 'sdbfhs')

      this.axios.put('http://api-Cms', {
        name:this.name
      })
          .then(resolve => {
            console.log(resolve.data);
          })
          .catch(error => {
            console.log(error);
          })
    }
  },

  created() {
  }
}
</script>
<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

nav {
  padding: 30px;
}

nav a {
  font-weight: bold;
  color: #2c3e50;
}

nav a.router-link-exact-active {
  color: #42b983;
}
</style>
