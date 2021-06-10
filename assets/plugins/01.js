var url="./?action=vue";
const app = new Vue({
  el: '#app',
  data: {
    procesos:[]
  },
  methods:{

    listar: function(){
      axios.post(url).then(response=>{
        this.procesos =response.data;
        console.log(this.procesos);
      });

    }
  },
  created: function(){
    this.listar();

  }
  
})