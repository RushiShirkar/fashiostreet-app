<template>
    <Page>
        <ActionBar title="Camera Tests FTW!"/>
        <StackLayout>
			<Button text="Choose Picture" @tap="selectPicture" />
			<WrapLayout>
				<Image v-for="(img,index) in images" :src="img.src" :key="index" width="75" height="75" />
			</WrapLayout>
        </StackLayout>
    </Page>
</template>

<script>
//import * as camera from "nativescript-camera";
import * as imagepicker from "nativescript-imagepicker";

import { Image } from "tns-core-modules/ui/image";

export default {
	data() {
		return {
			images:[]
		}
	},
	methods:{
		selectPicture() {

			let context = imagepicker.create({
				mode: 'multiple' 
			});

			context.authorize()
			.then(function() {
				return context.present();
			})
			.then(selection => {
				selection.forEach(selected => {
					
					console.log(JSON.stringify(selected));

					let img = new Image();
					img.src = selected;
                    this.images.push(img);
                    
                });
                alert(this.images);
			}).catch(function (e) {
				console.log('error in selectPicture', e);
			});

		}
	}
}
</script>