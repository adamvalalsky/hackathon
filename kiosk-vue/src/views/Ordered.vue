<template>
	<div id="ordered">
		<div class="content">
			<div class="title"><h1>Objednaný pacient</h1></div>
			<div class="content-inside">
				<div class="code">
					<h1>Kód</h1>
					<h1>{{ formattedCode }}</h1>
				</div>
				<div class="numbers">
					<div class="numberpad">
						<NumberPadKey @click.native="addNumber(1)" number="1"/>
						<NumberPadKey @click.native="addNumber(2)" :number="2"/>
						<NumberPadKey @click.native="addNumber(3)" :number="3"/>

						<NumberPadKey @click.native="addNumber(4)" :number="4"/>
						<NumberPadKey @click.native="addNumber(5)" :number="5"/>
						<NumberPadKey @click.native="addNumber(6)" :number="6"/>

						<NumberPadKey @click.native="addNumber(7)" :number="7"/>
						<NumberPadKey @click.native="addNumber(8)" :number="8"/>
						<NumberPadKey @click.native="addNumber(9)" :number="9"/>

						<NumberPadKey @click.native="addNumber(0)" :number="0"/>
						<div @click="removeNumber()" class="delete">Vymazať</div>
						<div @click="submitCode()" class="submit">Potvrdiť</div>
					</div>
				</div>

			</div>
			<Back/>
			<Alert/>

		</div>
	</div>
</template>

<script>

import NumberPadKey from "../components/NumberPadKey"
import Back from "../components/Back"
import Alert from "../components/Alert"
export default {
  name: 'ordered',
  data: function () {
    return {
      code: ''
    }
  },
  computed: {
    formattedCode: function () {
    	if (this.code.length>4) {

    		return (this.code.substring(0, 4) + "-" + this.code.substring(4));
    	}else{
    		return this.code;
    	}
    }
  },
  components: {
    NumberPadKey,
    Back,
		Alert
  },
  methods:{
  	addNumber(number){
  		if (this.code.length<8) {
  			this.code +=number;
  		}
  	},
  	removeNumber(){
  		if (this.code.length>0) {
  			this.code = this.code.slice(0,-1);
  		}
  	},
  	submitCode(){
  		if(this.code.length==8){
  			axios.get(this.$apiURL+'patient/ordered/'+this.code)
		        .then(response => {
		        	var number = response.data.number;
		          this.$router.push({ name: 'queue', params: {  number  } })

		      }).catch(error => {
						this.$children[this.$children.length-1].text="Neplatný alebo použitý kód!";
		  			this.$children[this.$children.length-1].setActive();

		      });

  		}else{
				this.$children[this.$children.length-1].text="Nezadali ste správny počet znakov";
  			this.$children[this.$children.length-1].setActive();
  		}

  	}
  }
}
</script>

<style>
#ordered .content{
	background-color: white;
	padding:2em 1em;
	border-radius: 3px;
}
#ordered .content-inside{
	margin-top: 2em;
	display: flex;
	justify-content: center;
	align-items: center;

}
#ordered .numbers, .code{
	width: 40%;
	float:left;
	display: flex;
	justify-content: center;
	align-items: center;
	flex-flow: column;
}
#ordered .numbers{
	width: 60%;
}
#ordered .numberpad{
	display: flex;
	justify-content: center;
	align-items: space-between;
	width: 100%;
	flex-wrap: wrap;
}
#ordered .num{
	cursor: pointer;
}
#ordered .numberpad> div{
	background-color: #5BC0BE;
	width: calc(100%/3);
	cursor: pointer;
	padding:1em;
	color: white;
	font-weight: 800;
	font-size: 2em;
}
#ordered .numberpad .delete{
	background-color: #3A506B;
}
#ordered .numberpad .submit{
	background-color: #1C2541;
}
#ordered .numberpad> div {
  background-position: center;
  transition: background 0.8s;
}
#ordered .numberpad> div:hover {
  background: #5dd0cd radial-gradient(circle, transparent 1%, #5dd0cd 1%) center/15000%;
}
#ordered .numberpad> div:active {
  background-color: #6FFFE9;
  background-size: 100%;
  transition: background 0s;
}
#ordered .numberpad> div.delete:hover {
  background: #506e94 radial-gradient(circle, transparent 1%, #506e94 1%) center/15000%;
}
#ordered .numberpad> div.delete:active {
  background-color: #72a0da;
  background-size: 100%;
  transition: background 0s;
}

#ordered .numberpad> div.submit:hover {
  background: #303f6d radial-gradient(circle, transparent 1%, #303f6d 1%) center/15000%;
}
#ordered .numberpad> div.submit:active {
  background-color: #4b64b1;
  background-size: 100%;
  transition: background 0s;
}
</style>
