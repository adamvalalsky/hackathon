
const state = {
  numbers:null,
}

const actions = {
  load(){
    axios.get(this._vm.$apiURL+"numbers")
      .then(response => {
        state.numbers = response.data.numbers;

    
    }).catch(error => {
      console.log(error);
     
    });
  },
}


export default {
  namespaced: true,
  state,
  actions
}
