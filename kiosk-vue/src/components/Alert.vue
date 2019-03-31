<template>
	<div id="alert" v-if="active">
		<div class="content">
      <h1>⚠️ Upozornenie ⚠️</h1>
      <h2>{{text}}</h2>
			<button type="button" name="button" @click="active=false">Pokračovať</button>
		</div>
	</div>
</template>

<script>


export default {
  name: 'alert',
  data: function () {
    return {
      active: false,
      text:''
    }
  },
  methods:{
    setActive(){
      this.active = true
    }
  }
}
</script>

<style>
#alert{
  position:absolute;
  top:0;
  background-color:#0000009e;
  left:0;
  width:100%;
  height:100%;
  display:flex;
  justify-content:center;
  align-items:center;
}
#alert .content{
  padding: 2em 4em !important;
}
#alert .content button{
	background-color: #5BC0BE;
  outline:none;
  border:none;
	cursor: pointer;
	padding:0.5em 1em;
	color: white;
	font-weight: 800;
	font-size: 2em;
}
</style>
