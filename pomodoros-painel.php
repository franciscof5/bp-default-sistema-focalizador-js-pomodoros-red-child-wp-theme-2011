<div id="pomodoro-painel">		
		
	<div id="pomodoro-relogio">							
	<form><input type="button" value="FOCAR!" onclick="action_button()" id="action_button_id" /></form>

	<div id="relogio">

		<div id="back">
		 <div id="upperHalfBack">
		 	<img src="<?php bloginfo('stylesheet_directory'); ?>/pomodoro/spacer.png" />
			<img id="minutesUpLeftBack" src="<?php bloginfo('stylesheet_directory'); ?>/pomodoro/Double/Up/Left/0.png" class="asd" /><img id="minutesUpRightBack" src="<?php bloginfo('stylesheet_directory'); ?>/pomodoro/Double/Up/Right/0.png"/>
			<img id="secondsUpLeftBack" src="<?php bloginfo('stylesheet_directory'); ?>/pomodoro/Double/Up/Left/0.png" /><img id="secondsUpRightBack" src="<?php bloginfo('stylesheet_directory'); ?>/pomodoro/Double/Up/Right/0.png"/>
		 </div>
		 <div id="lowerHalfBack">
		 	<img src="<?php bloginfo('stylesheet_directory'); ?>/pomodoro/spacer.png" />
		       <img id="minutesDownLeftBack" src="<?php bloginfo('stylesheet_directory'); ?>/pomodoro/Double/Down/Left/0.png" /><img id="minutesDownRightBack" src="<?php bloginfo('stylesheet_directory'); ?>/pomodoro/Double/Down/Right/0.png" />
		       <img id="secondsDownLeftBack" src="<?php bloginfo('stylesheet_directory'); ?>/pomodoro/Double/Down/Left/0.png" /><img id="secondsDownRightBack" src="<?php bloginfo('stylesheet_directory'); ?>/pomodoro/Double/Down/Right/0.png" />
		 </div>
		</div>
	    
	    
	    <div id="front">
		 <div id="upperHalf">
		 	<img src="<?php bloginfo('stylesheet_directory'); ?>/pomodoro/spacer.png" />
			<img id="minutesUpLeft" src="<?php bloginfo('stylesheet_directory'); ?>/pomodoro/Double/Up/Left/0.png" /><img id="minutesUpRight" src="<?php bloginfo('stylesheet_directory'); ?>/pomodoro/Double/Up/Right/0.png"/>
			<img id="secondsUpLeft" src="<?php bloginfo('stylesheet_directory'); ?>/pomodoro/Double/Up/Left/0.png" /><img id="secondsUpRight" src="<?php bloginfo('stylesheet_directory'); ?>/pomodoro/Double/Up/Right/0.png"/>
		 </div>
		 <div id="lowerHalf">
		 	<img src="<?php bloginfo('stylesheet_directory'); ?>/pomodoro/spacer.png" />
		       <img id="minutesDownLeft" src="<?php bloginfo('stylesheet_directory'); ?>/pomodoro/Double/Down/Left/0.png" /><img id="minutesDownRight" src="<?php bloginfo('stylesheet_directory'); ?>/pomodoro/Double/Down/Right/0.png" />
		       <img id="secondsDownLeft" src="<?php bloginfo('stylesheet_directory'); ?>/pomodoro/Double/Down/Left/0.png" /><img id="secondsDownRight" src="<?php bloginfo('stylesheet_directory'); ?>/pomodoro/Double/Down/Right/0.png" />
		 </div>
		</div>
	</div><!--fecha relogio-->
	<ul id="pomolist">
		<li class="pomoindi" id="pomoindi1">&nbsp;</li>							
		<li class="pomoindi" id="pomoindi2">&nbsp;</li>
		<li class="pomoindi" id="pomoindi3">&nbsp;</li>
		<li class="pomoindi" id="pomoindi4">&nbsp;</li>
	</ul>
	</div><!--fecha pomodoros painel-->
	<br />
	<div id="div_status"><script>document.write(txt_mat_introducing)</script></div>
	<img src="<?php bloginfo('stylesheet_directory'); ?>/mascote_original.jpg" />
	<br />
	<form name="pomopainel">
		<label><script>document.write(txt_write_task_title)</script></label><br />
		<input type="text" size="23" id="title_box" maxlength="70"></input><br />
		<label><script>document.write(txt_write_task_desc)</script></label>
		<textarea rows="4" cols="34" id="description_box"></textarea><br />
		<label><script>document.write(txt_write_task_tags)</script></label>
		<input type="text" size="23" id="tags_box" maxlength="20"></input><br />
		
		<br />
		<!--label><script>document.write(txt_write_task_category)</script></label><br />
		<ul>
			<li><input type="radio" name="cat_vl" value="26">Estudo</li>
			<li><input type="radio" name="cat_vl" value="27">Trabalho</li>
			<li><input type="radio" name="cat_vl" value="28">Pessoal</li>
		</ul>
		<label><script>document.write(txt_write_task_privacy)</script></label><br />
		<ul>
			<li><input type="radio" name="priv_vl" value="publish" CHECKED>Público - todos podem ver.</li>
			<li><input type="radio" name="priv_vl" value="private" >Privado - somente você pode ver. </li>
		</ul-->
		
	</form>
	
	
	
	<input type="button" value="Guardar tarefa modelo" onclick="save_model()" id="botao-salvar-modelo" />
	<h3>Tarefas modelo</h3>
	<p>Agora ficou mais fácil recomeçar uma tarefa, salve a tarefa como um modelo e reutilize quantas vezes quiser. Confira sua lista de modelos:</p>
	
	<div id="contem-modelos">
	<?php
	$args = array(
              'post_type' => 'post',
              'post_status' => 'pending',
              'author'   => get_current_user_id(),
              //'orderby'   => 'title',
              'order'     => 'ASC',
              'posts_per_page' => 14,
            );
	$the_query = new WP_Query( $args );
	
	while ( $the_query->have_posts() ) : $the_query->the_post();
		$counter = $post->ID;
		echo '<ul id="modelo-carregado-'.$counter.'">';
		the_title("<input type='text' value='","' disabled=disabled id=bxtitle$counter /><br />");

		echo "<input type='text' value='".get_the_content()."' disabled=disabled id=bxcontent$counter /><br />";
		//http://stackoverflow.com/questions/2809567/showing-tags-in-wordpress-without-link
		$posttags = get_the_tags();
		  if ($posttags) {
		    foreach($posttags as $tag) {
			echo "<input type='text' value='".$tag->name."' disabled=disabled  id=bxtag$counter />";
		    }
		}
		echo "<p><input type='button' value='usar modelo' onclick='load_model($counter)'><input type='button' value='apaga' onclick='delete_model($counter)'></p>";
		echo '</li>';
		echo '</ul>';
		
	endwhile;
	// Reset Post Data
	wp_reset_postdata();
	?>
	
	
	<?php
	get_currentuserinfo();
	if(current_user_can('administrator')) {
	?>
	<?php } ?>
	</div>
	
	<?php
	/* 
	
	turn_off_pomodoros_indicators ();
	
	/
	echo '<li>';
	the_title("<input type='text' value='","' disabled=disabled />");
	echo "<input type='text' value='".get_the_content()."' disabled=disabled />";
	the_tags("<input type='text' value='", "","' disabled=disabled />");
	echo "<p><input type='button' value='Usar' onclick='load_model(the_title())'><input type='button' value='Del'></p>";
	echo '</li>';
	
	the_title("<input type='text' value='","' disabled=disabled />");
	echo the_tags(' [').']';
	echo the_excerpt();
	echo "<input type='button' value='Usar' onclick='load_model(the_title())'><input type='button' value='Del'>";
	<input type="button" value="Salvar sessão como modelo" />
	
	<h3>Agora você pode visualizar e editar sua produção.</h3>
	<a href="http://pomodoros.com.br/wp-admin/edit.php" alt="Acessar painel">PAINEL DE PRODUÇÃO</a>
	
	STRIKE OU BOLD 
	
	<script type="text/javascript" language="javascript">
		var tmpText = '';
		jQuery(document).ready(function(){
		        tmpText = '';
		        jQuery('#btn_bold').click(function(){bold(tmpText);});
		        jQuery('textarea').bind('mouseup', function(){
		                  tmpText = '';
		                  if(window.getSelection){
		                    tmpText = window.getSelection().toString();
		                  }else if(document.getSelection){
		                    tmpText = document.getSelection().toString();
		                  }else if(document.selection){
		                    tmpText = document.selection.createRange().text;
		                  }
		        });
		});
		
		function bold(str)
		{
		        jQuery('textarea').val($('textarea').val().replace(str,'**'+str+'**'));
		}
		</script>
	<button type="button" id="btn_bold">bold it</button>
	
	/*
	<h3>Agora você pode visualizar e editar toda sua produção.</h3>
	<a href="http://pomodoros.com.br/wp-admin/edit.php" alt="Acessar painel">PAINEL DE PRODUÇÃO</a>
	<input type="button" onclick="javascript:getRadioCheckedValue('cat_vl')" value="ADAS">
	
	<?php
	<h5>Configurar tempos (em breve)</h5>
	<p>Pomodoro: 25 min</p>
	<p>Intervalo: 5 min</p>
	
	<h3><script>document.write(txt_last_pomodoros_heading)</script></h3>
	<!--ul id="points_completed"-->
	
	<?php
	//$arDates = get_user_meta(get_current_user_id(), "point_date", $single = false);
	//$arDescr = get_user_meta(get_current_user_id(), "point_desc", $single = false);
	//$todays_date = date("Y-m-d H:i:s");
	//$today = strtotime($todays_date);
	
	//Get all the pomodoros completed by the user
	//$pomodoros_completed = get_user_meta(get_current_user_id(), "pomodoro_completed", $single = false);
	$pomodoros_completed = $wpdb->get_results('SELECT * FROM  `wp_usermeta` WHERE  `user_id` ='.get_current_user_id().' AND  `meta_key` =  "pomodoro_completed" ORDER BY umeta_id DESC');
	
	date_default_timezone_set("Brazil/East");
	//to group data
	$actual_day = date("d");
	$actual_month = date("m");
	$actual_year = date("Y");
	//These is used to arranje data in the algorithim
	$last_day_used_in_this_function = $actual_day;
	$last_month_used_in_this_function = $actual_month;
	$last_year_used_in_this_function = $actual_year;
	//The array start with 0, that's why $total_pomos_of_day starts with 0 instead of 1
	//$actual_pomodoro=0;
	$actual_pomodoro=count($pomodoros_completed);
	//$actual_pomodoro=0;
	$total_pomos_of_day = 0;
	$total_pomos_of_month = 0;
	$total_pomos_of_year = 0;
	//The first thing that stats show is the pomodoro of the actual day, we must open a div
	echo "<div class='hidden_mouse_over'><strong>Today</strong>";
	//I cant explain that's function on detail, i made it step by step withou planning
	foreach ($pomodoros_completed as $key) {
		//The pomodoro has 2 information, data and description separated by "|"
		list($data, $desc) = explode("|", $key->meta_value);
		//Is necessary to separate the day and the hour manage information
		list($year_month_day, $hour) = explode(" ", $data);
		//echo $data;
		//Group pomodoros by year
		list($year, $month, $day) = explode("-", $year_month_day);
		//At these point we have 5 variables from 1 pomodoros, year, month, day, hour, desc		
		
		//That part of code organize the data in parts
		if($year==$last_year_used_in_this_function) {
			if($year==$actual_year) {
				if($month==$actual_month) {
					if($day!==$last_day_used_in_this_function) {
						echo "Total of day:".$total_pomos_of_day."</div><br /><div class='hidden_mouse_over'><strong>Day: ".$day."</strong>";
						//reset
						$total_pomos_of_day=0;
					}
					echo "<li><strong>".$hour."</strong> - ".$desc."</li>";	
					$last_day_used_in_this_function = $day;
					$podeecho=true;
				} else {
					/*
					if($podeecho){
					//POG
					echo "Total of day:".$total_pomos_of_day."</div><br /><b>Last months</b></br>";
					$podeecho=false;
					}
					
					if($month==$last_month_used_in_this_function) {
						echo $last_month_used_in_this_function.", pomodoros completed: ".$total_pomos_of_month."<br/>";
					}else{
						$total_pomos_of_month= 1;
					}
					$last_month_used_in_this_function = $month;*
				}
			}
		} //else {
			//echo $last_year_used_in_this_function."=".$total_pomos_of_year."<br/>";
			//$total_pomos_of_year = 1;
		//}
		$last_year_used_in_this_function = $year;
		//
		$total_pomos_of_day++;
		$total_pomos_of_month++;
		$total_pomos_of_year++;
		$actual_pomodoro--;
		//$actual_pomodoro++;
		
	}
	//A complete list
	//$pomodoros_completed2 = get_user_meta(get_current_user_id(), "pomodoro_completed");
	//$pomodoros_completed2 = $wpdb->get_results("SELECT * FROM  `wp_usermeta` WHERE  `user_id` ='1' AND  `meta_key` = 'pomodoro_completed' ORDER BY umeta_id");
	$pomodoros_completed2 = $wpdb->get_results('SELECT * FROM  `wp_usermeta` WHERE  `user_id` ='.get_current_user_id().' AND  `meta_key` =  "pomodoro_completed" ORDER BY umeta_id');
	
	$actual_pomodoro2=count($pomodoros_completed2);
	//$actual_pomodoro2=0;
	echo "</div><br/>";
	echo "<div class='hidden_mouse_over'>Complete list<br/><ul>";
	foreach ($pomodoros_completed2 as $key) {
		//list($data, $desc) = explode("|", $pomodoros_completed2[$actual_pomodoro2]);
		//echo "<li>".$data." - ".$desc."</li>";
		//$actual_pomodoro2++;
		//echo $pomodoros_completed2[$actual_pomodoro2];
		echo "<li>".$key->meta_value."</li>";
		$actual_pomodoro2--;
	}
	echo "</ul></div>";
	
	//echo "Total of day:".$total_pomos_of_day;
	?>
	<!--/ul-->	
	*/
	?>
</div>
