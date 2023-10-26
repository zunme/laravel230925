<script>
	import { onMount, onDestroy, beforeUpdate, afterUpdate, tick } from 'svelte'
	import Radiobox from "./front.component.radiobox.svelte"
    export let title;
	export let move_type;
	let move_type2=[
		{key:123},{key:123}
	];
	
	onMount(async() => {
		console.log('App onMount')
	})

	onDestroy(async() => {
		console.log('App onDestroy')
	})

	beforeUpdate(async() => {
	  console.log('the component is about to update');
	  //await tick()
	  //console.log('the component just updated');
	})

	afterUpdate(async() => {
		console.log('App afterUpdate')
	})
</script>
 
<div class="flex flex-col items-center text-center space-y-4">
    <h1 class="block mt-4 font-bold text-4xl">{title}</h1>
	<h2>sadfqqq</h2>
	<div class="tw-grid tw-grid-cols-4 tw-gap-2">
		{#each move_type as m_type}
		  <Radiobox boxitem={m_type} />
		{/each}
	</div>
</div>