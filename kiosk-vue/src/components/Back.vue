<template>
	<div id="back">
		<div class="back">
			<router-link to="/">Vrátiť späť</router-link>
		</div>
	</div>
</template>

<script>


export default {
  name: 'back'
}
</script>

<style>
	.back a{
		margin: 2em auto 0;
	    width: 90%;
	    background-color: white;
	    box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
	    color: #5BC0BE;
	    padding: 1em 0;
	    display: table;
	    font-weight: 600;
	}
</style>
