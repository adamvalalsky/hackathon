<template>

	<div id="home">
		<div class="buttons">
			<router-link to="/non-ordered"><div class="btn non-ordered-btn">Neobjednaný pacient</div></router-link>
      		<router-link to="/ordered"><div class="btn ordered-btn">Objednaný pacient</div></router-link>
		</div>
		<div class="order-numbers clearfix">
			<h1>Poradovník ⏩</h1>
			<div class="numbers">
				<div v-for="number in numbers" class="order-number" v-bind:class="{ ordered: number.ordered }">{{ number.queue }}</div>
			</div>
			
		</div>
	</div>
</template>

<script>

import { mapState } from 'vuex'
export default {
  name: 'home',
  data: function () {
    return {
      interval: null
    }
  },
  computed: {
    // mix the getters into computed with object spread operator
    ...mapState('patients',[
      "numbers",
    ])
  },
  mounted: function () {
    this.$store.dispatch('patients/load');
  	this.interval = setInterval(function () {
      this.$store.dispatch('patients/load');
    }.bind(this), 15000); 
  },
   beforeDestroy: function(){
	clearInterval(this.interval);
	}
}
</script>

<style>
#home .buttons {
  	justify-content: space-evenly;
	display: flex;
 	width: 100%;
}
#home .buttons a{
	width: 47.5%;
}

#home .btn{
	text-decoration: none;
	height: 60vh;
	background-color: #ffffffe6;
	display: flex;
	justify-content: center;
	align-items: center;
	padding: 1em 3em;
	font-weight: 500;
    font-size: 3.5em;
    border-radius: 3px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
}
#home .order-numbers {
 	width: 95%;
 	margin: 2em auto 0;
 	background-color: #ffffffe6;
 	padding:1em;
 	border-radius: 3px;
 	box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
}
#home .order-number{
	transition: 300ms all ease-in-out;
	color: white;
	background-color: #5BC0BE;
	border-radius: 5px;
	padding: 0.25em 0.5em;
	font-weight: bolder;
	font-size: 1.5em;
	box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
	float: left;
	margin-right: 5px;
}
#home .order-number.ordered{
	background-color: #3A506B;
}
</style>
