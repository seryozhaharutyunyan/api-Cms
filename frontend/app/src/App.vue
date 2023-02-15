<template>
  <div>
    <input type="number" v-model.trim="name">
    <input type="date" v-model.trim="date">
    <input ref="images" type="file" accept="image/*" @input="fileUpload($event)" placeholder="Image" multiple>
    <button @click="query()">add</button>
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
      //console.log(files);

      /*for (let i = 0; i < files.length; i++) {
        formData.append('file['+i+']', files.item(i));
      }*/
      //console.log(formData.getAll('file[]'));
      formData.append('file', files[0])

      this.axios.put('http://api-Cms', formData)
          .then(resolve => {
            console.log(resolve.data);
          })
          .catch(error => {
            console.log(error);
          })
    },

    fileUpload(event) {
      this.file = event.target.files;
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
