<template>
	<div>
		<div class="number">
			{{ number }}
		</div>
	</div>
</template>

<script>


export default {
  name: 'NumberPadKey.vue',
  props: ['number'],
}
</script>
