<template>
  <div>
    <input type="number" v-model.trim="name">
    <input type="date" v-model.trim="date">
    <input ref="images" type="file" accept="image/*" @input="fileUpload($event)" placeholder="Image" multiple>
    <button @click="query()">add</button>
    <button @click="login()">login</button>
  </div>
</template>
<script>
export default {
  name: 'App',
  data() {
    return {
      name: '',
      date: '',
      file: '',
    };
  },
  methods: {
    query() {

      const formData = new FormData();

      formData.append('name', this.name)
      formData.append('date', this.date)
      formData.append('theme', 'sdbfhs')
      const files = this.$refs.images.files;


      for (let i = 0; i < files.length; i++) {
        formData.append('file[]', files.item(i));
      }

      this.axios.get('http://api-Cms', {
        headers:{
          'Authorization': 'Bearer db4bf6159a3076b04294722cfd9cf977b27ac1c6097e122888a945e8f144b17284eb197107db4a3f86a11599ae0670fbac2a8b54d1f28dcbae37d29fe1f2f817'
        }
      })
          .then(resolve => {
            console.log(resolve.data);
          })
          .catch(error => {
            console.log(error);
          })
    },

    fileUpload(event) {
      this.file = event.target.files;
    },
    login() {
      this.axios.post('http://api-Cms/login', {
        email:'admin@mail.ru',
        password:'071172'
      })
          .then(resolve => {
            console.log(resolve);
          })
          .catch(error => {
            console.log(error);
          })
    }
  },

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
