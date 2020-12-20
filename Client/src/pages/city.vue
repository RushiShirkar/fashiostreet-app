<template>
	<f7-page>
		<f7-block>
			<div style="margin-top:100px;">
				<f7-input fill type="text" style="background-color:#37474f" :value="city" @input="city = $event.target.value" placeholder="Your city name" clear-button>				
			</div>
		</f7-block>
	</f7-page>
</template>
<script>
	export default {
		name:'city',
		data:function(){
			return{
				city:null
			}
		}
	}
</script>