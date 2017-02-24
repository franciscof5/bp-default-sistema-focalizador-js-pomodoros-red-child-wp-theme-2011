//Configurantion vars, will be seted by user in future
var pomodoros_to_big_rest=4;

var pomodoroTime = 1500;
var restTime = 300;
var bigRestTime = 1800;
var intervalMiliseconds = 1000;

//Dynamic clock var
//var is_interrupt_button;
var m1;
var m2;
var m3;
var m4;
var m1_current = 2;
var m2_current = 5;
var s1_current = 0;
var s2_current= 0;

//Pomodoro session control vars
var pomodoro_actual = 1;
var is_pomodoro = true;
var secondsRemaing = pomodoroTime;
var interval_clock=false;

//With that line mootools can use the selector ($) and jQuery use the selector (jQuery), without conflict
//jQuery.noConflict();

//There only one button at the page, all the actions (trigglers) start here
function action_button() {
	//alert("aoshd");
	if(interval_clock) {
		//The user clicked on Interrupt button -> Check if the timmer (countdown_clock()) are running
		interrupt();
	} else {
		//The user clicked on Pomodoro or Rest button
		start_clock();
		//The end of the big rest, the indicators light has to reset
		if(pomodoro_actual==1)
		turn_off_pomodoros_indicators();
	}
}

//Make the code more legible
function start_clock() {
	active_sound.play();
	//Chage button to "interrupt"
	//is_interrupt_button=true;
	change_button(textInterrupt, "#0F0F0F");
	change_status(txt_started_countdown);
	//
	interval_clock = setInterval('countdown_clock()', intervalMiliseconds);
}

//Function called every second when pomodoros are running
function countdown_clock (){
	//Everty second of pomodoros running these functions are called
	secondsRemaing--;
	//Function user to convert number, like 140, into clock time, like 2:20
	convertSeconds(secondsRemaing);
	//Functions to make the effect of flip on countdown_clock
	flip_number();
	//Test the end of the time
	if(secondsRemaing==0)
	complete();
	//Change the title to time
	changeTitle();
}

function getRadioCheckedValue(radio_name){
   /*var oRadio = document.forms["pomopainel"].elements[radio_name];
//alert(oRadio.length);
   for(var i = 0; i < oRadio.length; i++)
   {
      if(oRadio[i].checked)
      {
         return oRadio[i].value;
      }
   }
   return '';
   */
}
//The real life at pomodoros: jQuery calling php function on functions.php
function savepomo () {
	change_status(txt_salving_progress);	
	
	var postcat=getRadioCheckedValue("cat_vl");
	var privornot=getRadioCheckedValue("priv_vl");
	var data = {
		action: 'save_progress',
		post_titulo: title_box.value,
		post_descri: description_box.value,
		post_tags: tags_box.value,
		post_cat: postcat,
		post_priv: privornot
	};
	jQuery.post(ajaxurl, data, function(response) {
		if(response)		
		change_status(txt_save_success);
		else
		change_status(txt_save_error);
		/*Append the fresh completed pomodoro at the end of the list, simulating the data
		var d=new Date();
		data = d.getFullYear()+"-"+(d.getMonth()+1)+"-"+d.getDate()+" "+d.getUTCHours()+":"+d.getUTCMinutes()+":"+d.getUTCSeconds();//new Date(year, month, day, hours, minutes, seconds);
		if(response[0]=="1")
		jQuery("#points_completed").append('<li>'+data+" -> "+description.value+'</li>');*/
	});
}
//Load e Save model function
function save_model () {
	change_status(txt_salving_model);
	var data = {
		action: 'save_modelnow',
		post_titulo: title_box.value,
		post_descri: description_box.value,
		post_tags: tags_box.value
	};
	jQuery.post(ajaxurl, data, function(response) {
		if(response) {
			if(response==0) {
				change_status(txt_salving_model_task_null);
			} else {
				var sessao_atual=response;
				//primeiro salva o post, para depois pegar o id do mesmo
				jQuery("#contem-modelos").append('<ul id="modelo-carregado-'+sessao_atual+'"><li><input type="text" value="'+title_box.value+'" disabled="disabled" id="bxtitle'+sessao_atual+'"><br /><input type="text" value="'+description_box.value+'" disabled="disabled" id="bxcontent'+sessao_atual+'"><br /><input type="text" value="'+tags_box.value+'" disabled="disabled" id="bxtag'+sessao_atual+'"><p><input type="button" value="usar modelo" onclick="load_model('+sessao_atual+')"><input type="button" value="apaga" onclick="delete_model('+sessao_atual+')"></p></li></ul>');
				/*jQuery("#botao-salvar-modelo").val("sessão salvada com sucesso");
				jQuery("#botao-salvar-modelo").attr('disabled', 'disabled');*/
				document.getElementById("bxcontent"+sessao_atual).focus();
				change_status(txt_salving_model_success);
			}
		}
		else
		change_status(txt_save_error);
	});
}
function delete_model(qualmodelo) {
	//PHP deletar post qualmodelo
	change_status(txt_deleting_model);
	var data = {
		action: 'save_modelnow',
		post_para_deletar: qualmodelo
	};
	jQuery.post(ajaxurl, data, function(response) {
		if(response) {
			change_status(txt_deleting_model_sucess);
			jQuery("#modelo-carregado-"+qualmodelo).remove();
		} else {
			change_status(txt_save_error);
		}
	});
}
function load_model(qualmodelo) {
	document.getElementById("title_box").value = document.getElementById("bxtitle"+qualmodelo).value;
	document.getElementById("description_box").value = document.getElementById("bxcontent"+qualmodelo).value;
	
	if(document.getElementById("bxtag"+qualmodelo))
	document.getElementById("tags_box").value = document.getElementById("bxtag"+qualmodelo).value;
	else
	document.getElementById("tags_box").value = "";
	
	document.getElementById("action_button_id").focus();
	change_status(txt_loading_model);
}

//Change the <title> of the document
function changeTitle () {
	var task_name = document.getElementById('title_box');
	document.title = Math.round(m1)+""+Math.round(m2)+":"+s1+""+s2 + " - " + task_name.value;
}

//This is the reason of all the code, the time when user complete a pomodoro, these satisfaction!
function complete() {
	//is_interrupt_button = false;
	stop_clock();	
	if(is_pomodoro) {
		turn_on_pomodoro_indicator("pomoindi"+pomodoro_actual);
		savepomo();
		is_pomodoro = false;
		if(pomodoro_actual==pomodoros_to_big_rest) {
			//big rest
			pomodoro_actual=1;
			change_button(textBigRest, "#0F0");
			change_status(txt_bigrest_countdown);
			secondsRemaing=bigRestTime;
		} else {
			//normal rest
			pomodoro_actual++;
			change_button(textRest, "#990000");
			//change_status(txt_normalrest_countdown);
			secondsRemaing=restTime;
		}
	} else {
		change_button(textPomodoro, "#063");
		change_status(txt_completed_rest);
		is_pomodoro=true;
		secondsRemaing=pomodoroTime;
	}
}


//Just stop de contdown_clock function at certains moments
function stop_clock() {
	window.clearInterval(interval_clock);
	interval_clock=false;
	//is_interrupt_button = false;
	pomodoro_completed_sound.play();
}

//Function to show status warnings at bottom of the clock
function change_status(txt) {
	var status=document.getElementById("div_status");
	status.innerHTML=txt; //status.innerHTML="Status: "+txt;
}

//Function to change button text and color
function change_button (valueset, colorset) {
	var button = $("action_button_id");
	button.value=valueset;
	button.set('morph', {duration: 2000});
	button.morph({/*'border': '2px solid #F00',*/'background-color': colorset});
}


//
function interrupt() {
	//pomodoro_completed_sound.play();
	change_status(txt_interrupted_countdowns);
	stop_clock();
	convertSeconds(0);
	flip_number();
	change_button(textPomodoro, "#063");
	secondsRemaing=0;
	secondsRemaing = pomodoroTime;
	//is_interrupt_button=false;
	//if(!is_pomodoro)is_pomodoro=true;
	if(!is_pomodoro)is_pomodoro=true;
}
//Auxiliar function to contdown_clock() function
function convertSeconds(secs) {
	minutes=secs/60;
	if(minutes>10) {
		someValueString = '' + minutes;
		someValueParts = someValueString.split('');
		m1 = parseFloat(someValueParts[0]);
		m2 = parseFloat(someValueParts[1]);
	} else {
		m1 = parseFloat(0);
		m2 = parseFloat(minutes);
	}
	//seconds%=secs/60;
	if(secs%60!=0) {
		seconds=secs%60;
		otherValueString = '' + seconds;
		otherValueParts = otherValueString.split('');
		if(seconds>10) {
			s1 = parseFloat(otherValueParts[0]);
			s2 = parseFloat(otherValueParts[1]);
		} else {
			s1=0;
			s2=parseFloat(otherValueParts[0]);
		}
	} else {
		s1=0;
		s2=0;
	}
	//alert(m1+""+m2+":"+s1+""+s2);
}

//Function to "light" one pomodoro
function turn_on_pomodoro_indicator (pomo) {var pomo = $(pomo);pomo.set('morph', {duration: 2000});pomo.morph({'background-position': '-30px','background-color': '#FFF'});}

//Function to restart the pomodoros
function turn_off_pomodoros_indicators () {
	var pomo1 = $("pomoindi1");var pomo2 = $("pomoindi2");var pomo3 = $("pomoindi3");var pomo4 = $("pomoindi4");
	pomo1.set('morph', {duration: 4000});pomo2.set('morph', {duration: 2000});pomo3.set('morph', {duration: 3000});pomo4.set('morph', {duration: 1200});
	pomo1.morph({'background-position': '0px','background-color': '#EEEEEE'});pomo2.morph({'background-position': '0px','background-color': '#EEEEEE'});pomo3.morph({'background-position': '0px','background-color': '#EEEEEE'});pomo4.morph({'background-position': '0px','background-color': '#EEEEEE'});
}

//Functions to make the effect on the clock
function flip_number() {
	if( m2 != m2_current){
		flip('minutesUpRight', 'minutesDownRight', m2, templateDir+'/pomodoro/Double/Up/Right/', templateDir+'/pomodoro/Double/Down/Right/');
		m2_current = m2;
		
		flip('minutesUpLeft', 'minutesDownLeft', m1, templateDir+'/pomodoro/Double/Up/Left/', templateDir+'/pomodoro/Double/Down/Left/');
		m1_current = m1;
	}
	
	 if (s2 != s2_current){
		flip('secondsUpRight', 'secondsDownRight', s2, templateDir+'/pomodoro/Double/Up/Right/', templateDir+'/pomodoro/Double/Down/Right/');
		s2_current = s2;
		
		flip('secondsUpLeft', 'secondsDownLeft', s1, templateDir+'/pomodoro/Double/Up/Left/', templateDir+'/pomodoro/Double/Down/Left/');
		s1_current = s1;
	 }
	 
	 
}

function flip (upperId, lowerId, changeNumber, pathUpper, pathLower){
	var upperBackId = upperId+"Back";
	$(upperId).src = $(upperBackId).src;
	$(upperId).setStyle("height", "64px");
	$(upperId).setStyle("visibility", "visible");
	$(upperBackId).src = pathUpper+parseInt(changeNumber)+".png";
	
	$(lowerId).src = pathLower+parseInt(changeNumber)+".png";
	$(lowerId).setStyle("height", "0px");
	$(lowerId).setStyle("visibility", "visible");

	var flipUpper = new Fx.Tween(upperId, {duration: 200, transition: Fx.Transitions.Sine.easeInOut});
	flipUpper.addEvents({
		'complete': function(){
			var flipLower = new Fx.Tween(lowerId, {duration: 200, transition: Fx.Transitions.Sine.easeInOut});
				flipLower.addEvents({
					'complete': function(){	
						lowerBackId = lowerId+"Back";
						$(lowerBackId).src = $(lowerId).src;
						$(lowerId).setStyle("visibility", "hidden");
						$(upperId).setStyle("visibility", "hidden");
					}				});					
				flipLower.start('height', 64);
				
		}
	});
	flipUpper.start('height', 0);
}
//Sound configuration
soundManager.url = templateDir+'/pomodoro/soundmanager2.swf';
soundManager.onready(function() {
	// Ready to use; soundManager.createSound() etc. can now be called.
	active_sound = soundManager.createSound({id: 'mySound2',url: templateDir+'/pomodoro/sounds/crank-2.mp3',});
	pomodoro_completed_sound = soundManager.createSound({id:'mySound3',url: templateDir+'/pomodoro/sounds/telephone-ring-1.mp3',});
});
soundManager.onerror = function() {alert(txt_sound_error+"a"+templateDir );}

//Project Management (maybe that snippet deserves a exclusive file)
