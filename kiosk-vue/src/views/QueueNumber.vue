<template>
	<div id="queue">
		<div class="content">
			<div class="title"><h1>Vaše číslo</h1></div>
			<div class="content-inside">
				<p>{{ $route.params.number }}</p>
				<button @click="$router.push({name: 'home'})">Dokončiť</button>
			</div>
		</div>
	</div>
</template>

<script>

export default {
  name: 'queueNumber',
}
</script>

<style>
#queue .content{
	background-color: white;
	padding:2em 0;
	border-radius: 3px;
}

#queue .content-inside{
	display: flex;
    justify-content: center;
    align-items: center;
    flex-flow: column;
}
#queue .content-inside p{
	font-size: 10em;
	margin:0;
}
#queue button{
	background-color: #5BC0BE;
    color: white;
    border-radius: 3px;
    font-size: 2em;
    padding: 0.25em 0.5em;
}

</style>
