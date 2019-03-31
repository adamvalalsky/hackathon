<template>
	<div id="non-ordered">
		<div class="content">
			<div class="title"><h1>Neobjednaný pacient</h1></div>
			<div class="content-inside">
				<div class="code">
					<h1>Rodné číslo</h1>
					<h1>{{ formattedIdNumber }}</h1>
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
  name: 'non-ordered',
  data: function () {
    return {
      idNumber: ''
    }
  },
  computed: {
    formattedIdNumber: function () {
    	if (this.idNumber.length>6) {

    		return (this.idNumber.substring(0, 6) + "/" + this.idNumber.substring(6));
    	}else{
    		return this.idNumber;
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
  		if (this.idNumber.length<10) {
  			this.idNumber +=number;
  		}
  	},
  	removeNumber(){
  		if (this.idNumber.length>0) {
  			this.idNumber = this.idNumber.slice(0,-1);
  		}
  	},
  	submitCode(){
  		if(this.idNumber.length==10){
  			axios.post(this.$apiURL+'patient/nonordered',{
  				number: this.idNumber
  			})
		        .then(response => {
		        	var number = response.data.number;
		          this.$router.push({ name: 'queue', params: {  number  } })

		      }).catch(error => {
						this.$children[this.$children.length-1].text="Neplatné alebo použité rodné číslo!";
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
#non-ordered .content{
	background-color: white;
	padding:1em;
	border-radius: 3px;
}
#non-ordered .content-inside{
	margin-top: 2em;
	display: flex;
	justify-content: center;
	align-items: center;

}
#non-ordered .numbers, .code{
	width: 40%;
	float:left;
	display: flex;
	justify-content: center;
	align-items: center;
	flex-flow: column;
}
#non-ordered .numbers{
	width: 60%;
}
#non-ordered .numberpad{
	display: flex;
	justify-content: center;
	align-items: space-between;
	width: 100%;
	flex-wrap: wrap;
}
#non-ordered .num{
	cursor: pointer;
}
#non-ordered .numberpad> div{
	background-color: #5BC0BE;
	width: calc(100%/3);
	cursor: pointer;
	padding:1em;
	color: white;
	font-weight: 800;
	font-size: 2em;
}
#non-ordered .numberpad .delete{
	background-color: #3A506B;
	background-size: 100%;
  transition: background 0s;
}
#non-ordered .numberpad .submit{
	background-color: #1C2541;
	background-size: 100%;
  transition: background 0s;
}
#non-ordered .numberpad> div {
  background-position: center;
  transition: background 0.8s;
}
#non-ordered .numberpad> div:hover {
  background: #5dd0cd radial-gradient(circle, transparent 1%, #5dd0cd 1%) center/15000%;
}
#non-ordered .numberpad> div:active {
  background-color: #6FFFE9;
  background-size: 100%;
  transition: background 0s;
}

#non-ordered .numberpad> div.delete:hover {
  background: #506e94 radial-gradient(circle, transparent 1%, #506e94 1%) center/15000%;
}
#non-ordered .numberpad> div.delete:active {
  background-color: #72a0da;
  background-size: 100%;
  transition: background 0s;
}

#non-ordered .numberpad> div.submit:hover {
  background: #303f6d radial-gradient(circle, transparent 1%, #303f6d 1%) center/15000%;
}
#non-ordered .numberpad> div.submit:active {
  background-color: #4b64b1;
  background-size: 100%;
  transition: background 0s;
}

</style>
