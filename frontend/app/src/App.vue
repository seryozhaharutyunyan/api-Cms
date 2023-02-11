<template>
  <div>111</div>
</template>
<script>
export default {
  name: 'App',
  methods: {
    query() {

      this.axios.delete('http://api-Cms/aaa')
          .then(resolve => {
            console.log(resolve);
          })
          .catch(error => {
            console.log(error);
          })
    }
  },

  created() {
    this.query();
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
