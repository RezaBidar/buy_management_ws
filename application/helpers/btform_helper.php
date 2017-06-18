<?php
/*
 * bootstrap form helper
 * return form helper in bootstrap format
 */
class btform {
	
	public static function form_open($action = '' , $attribute = '' ,$hidden = array()){
		return form_open($action , $attribute ,$hidden);
	}
	
	public static function form_open_multipart($action = '', $attributes = array(), $hidden = array()){
	    return form_open_multipart($action, $attributes, $hidden) ;
	}
	
	public static function form_input($label = '', $data = '', $value = '', $extra = '' , $help = ''){
		//add form-control class to input
		if(isset($data['class'])) $data['class'] .= ' form-control ' ;	
		else $data['class'] = 'form-control' ;

		$answer  = '<div class="form-group">' ;
		if($label != ''){
			$answer .= form_label($label, $data['name']);
		}
		$answer .= form_input($data, $value, $extra);
		if($help != '')
			$answer .= '<span class="help-block">' . $help . '</span>' ;
		$answer .= '</div>';
		return $answer ;
	}

	public static function form_input_with_button($btn , $label = '', $data = '', $value = '', $extra = '' , $help = ''){
		//add form-control class to input
		if(isset($data['class'])) $data['class'] .= ' form-control ' ;	
		else $data['class'] = 'form-control' ;

		$answer  = '<div class="form-group">' ;
		if($label != ''){
			$answer .= form_label($label, $data['name']);
		}
		$answer .= '<div class="input-group">' ;
		$answer .= form_input($data, $value, $extra) ;
		$answer .= '<span class="input-group-btn">' . $btn . '</span>';
		$answer .= '</div>' ;
		if($help != '')
			$answer .= '<span class="help-block">' . $help . '</span>' ;
		$answer .= '</div>';
		return $answer ;
	}
	
	public static function form_password($label = '', $data = '', $value = '', $extra = '' , $help = ''){
		//add form-control class to input
		if(isset($data['class'])) $data['class'] .= ' form-control ' ;	
		else $data['class'] = 'form-control' ;

		$answer  = '<div class="form-group">' ;
		if($label != ''){
		    $answer .= form_label($label, $data['name']);
		}
		$answer .= form_password($data, $value, $extra);
		if($help != '')
		    $answer .= '<span class="help-block">' . $help . '</span>' ;
		$answer .= '</div>';
		return $answer ;
	}
	
	public static function form_upload($label = '', $data = '', $value = '', $extra = '' , $help = ''){
		$answer  = '<div class="form-group">' ;
		if($label != ''){
			$answer .= form_label($label, $data['name']);
		}
		$answer .= form_upload($data, $value, $extra);
		if($help != '')
			$answer .= '<span class="help-block">' . $help . '</span>' ;
		$answer .= '</div>';
		return $answer ;
		
	}
	
	public static function form_textarea($label = '', $data = '', $value = '', $extra = '', $help = ''){
		//add form-control class to input
		if(isset($data['class'])) $data['class'] .= ' form-control ' ;	
		else $data['class'] = 'form-control' ;

		$answer  = '<div class="form-group">' ;
		if($label != ''){
			$answer .= form_label($label, $data['name']);
		}
		$answer .= form_textarea($data, $value, $extra);
		if($help != '')
			$answer .= '<span class="help-block">' . $help . '</span>' ;
		$answer .= '</div>';
		return $answer ;
	}
	
	public static function form_checkbox($label = '', $data = '', $value='', $checked = FALSE, $extra = '' ){
		
		//$disabled = (is_array($data) && isset($data["disabled"]) && $data["disabled"])? '' : 'disabled' ;
		$answer  = '<div class="checkbox">' ;
		if($label != ''){
			$answer .= '<label>';
			$answer .= $label ;
		}
		$answer .= form_checkbox($data, $value, $checked, $extra);
		if($label != ''){
			
			$answer .= '</label>';
		}
		$answer .= '</div>';
		return $answer ;
	}
	
	public static function form_radio($label = '', $radio_arr = array() , $data = '', $checked = '', $extra = '' ){
		
		//$disabled = (is_array($data) && isset($data["disabled"]) && $data["disabled"])? '' : 'disabled' ;
		$answer  = '<div class="form-group">' ;
		if($label != ''){
			
			$answer .= form_label($label, $data['name']) . "<br>";
		}
		
		foreach ($radio_arr as $r_label => $r_value){
			$answer .= '<label class="radio-inline" >';
			$answer .= $r_label ;
			$selected = ($checked == $r_value) ? TRUE : FALSE ;
			$answer .= form_radio($data, $r_value, $selected, $extra);
			$answer .= '</label><br/>';
		}
		$answer .= '</div>';
		return $answer ;
	}

	public static function form_radio_button($label = '', $radio_arr = array() , $data = '' , $checked = '', $extra = '' ){
		//$disabled = (is_array($data) && isset($data["disabled"]) && $data["disabled"])? '' : 'disabled' ;
		$answer  = '<div class="form-group">' ;
		if($label != ''){
			
			$answer .= form_label($label, $data['name']) . "<br>";
		}
		
		$answer  .= '<div class="radio_button">' ;
		$i = 0 ;
		foreach ($radio_arr as $r_label => $r_value){
			$data['data-button-bootstrap-class'] = 'btn-default' ;
			$data['id'] = $data['name'] . $i++ ;
			$selected = ($checked == $r_value) ? TRUE : FALSE ;
			$answer .= form_radio($data, $r_value, $selected, $extra);
			$answer .= '<label for="'. $data['id'] .'" >';
			$answer .= $r_label ;
			$answer .= '</label>';
			
		}
		$answer .= '</div>';
		$answer .= '</div>';
		return $answer ;
	}
	
	public static function form_close($extra = ''){
		return form_close($extra);
	}

	public static function form_submit($data='', $value='', $extra=''){
		return form_submit($data,$value,$extra);
	}
	
	public static function form_hidden($name , $value = '' , $recursing = NULL){
		return form_hidden($name,$value,$recursing);
	}
	
	public static function form_button($data,$content = "",$extra = ""){
		return '<div class="form-group">' . form_button($data,$content,$extra) . '</div>';
	}
	
	public static function form_select($label , $name , $options , $selected = '' , $extra = ''){

		$answer  = '<div class="form-group">' ;
		if($label != ''){
			$answer .= form_label($label, $name);
		}
		if($selected == '') {
			//basi ranj bordam dar inja :))))
			//agar select nashode bashad yek option khali be ebtedaye optionha ezafe minomayad
			$regex = "/(<select[^>]*>)\s*((?:<option[^>]*>(?:.*?)<\/option>\s*)*)\s*(<\/select>)/i" ;	
			$drop_down = form_dropdown($name,$options,$selected,$extra) ;
			$answer .= preg_replace($regex, "$1<option selected disabled hidden value=''></option>$2$3", $drop_down) ;
		}else{
			$answer .= form_dropdown($name,$options,$selected,$extra) ;
		}
		$answer .= '</div>';
		return $answer ;
	}
	
	public static function form_inline_checkbox_input($label = '', $data = '', $value = '', $extra = '' , $help = ''){
		$answer = '<div class="form-group">' ;
		if($label != ''){
			$answer .= form_label($label, $data['name']);
		}
		$answer .= '<div class="input-group">' ;
		$answer .= '<span class="input-group-addon">' ;
		$answer .= '<input type="checkbox" class="active_toggle" value="'.$data['name'].'" aria-label="...">' ;
		$answer .= '</span>' ;
		$answer .= form_input($data, $value, $extra);
		$answer .= '</div><!-- /input-group -->' ;
		$answer .= '</div>';
		return $answer ;
	}
	
	/**
	 * show avatar
	 * @param string $pic_address
	 */
	public static function show_pic($pic_address){
	    $pic_address = 'img/avatar/' .$pic_address ;
	    //if($pic_address == NULL || !is_file(site_url($pic_address)) || !file_exists(site_url($pic_address))){
	    if($pic_address == NULL || !is_file($pic_address) || !file_exists($pic_address)){
	       return site_url('img/avatar/default.png') ;
	    }
	    return  site_url($pic_address);
	    
	}
	
	/**
	 * datepicker
	 */
	public static function datepicker($label = 'تاریخ' , $names , $options , $selected = array() , $time = TRUE , $label_id = ''){
	    
	    $now = array(
	        'year' => tr_num(jdate('Y')),
	        'month' => tr_num(jdate('m')),
	        'day' => tr_num(jdate('d')),
	        'hour' => tr_num(jdate('H')),
	        'minute' => tr_num(jdate('i')) - (tr_num(jdate('i')) % 5),
	    );
	    
	    $answer = '<div class="form-group">' ;
	    $answer .= form_label($label ,'' , array("id" => $label_id));
	    $answer .= '<div class="input-group">' ;
	    
	    $answer .= '<span class="input-group-addon">' ;
	    $answer .= form_label('سال', $names['year']);
	    $answer .= '</span>' ;
	    $answer .= form_dropdown($names['year'],$options["year"],(isset($selected["year"]))?$selected["year"]:$now["year"] ,'class="form-control rbt_datepicker_year" ') ;
	    
	    $answer .= '<span class="input-group-addon">' ;
	    $answer .= form_label('ماه', $names['month']);
	    $answer .= '</span>' ;
	    $answer .= form_dropdown($names['month'],$options["month"],(isset($selected["month"]))?$selected["month"]:$now["month"] ,'class="form-control rbt_datepicker_month" ') ;

	    $daylist = dayList((isset($selected["year"])) ? $selected["year"] : $now["year"] , (isset($selected["month"])) ? $selected["month"] : $now["month"]);
	    $answer .= '<span class="input-group-addon">' ;
	    $answer .= form_label('روز', $names['day']);
	    $answer .= '</span>' ;
	    $answer .= form_dropdown($names['day'],$daylist,(isset($selected["day"]))?$selected["day"]:$now["day"] ,'class="form-control rbt_datepicker_day" ') ;
	    
	    if($time):
	    $answer .= '<span class="input-group-addon">' ;
	    $answer .= form_label('ساعت', $names['hour']);
	    $answer .= '</span>' ;
	    $answer .= form_dropdown($names['hour'],$options["hour"],(isset($selected["hour"]))?$selected["hour"]:$now["hour"] ,'class="form-control" ') ;
	     
	    $answer .= '<span class="input-group-addon">' ;
	    $answer .= form_label('دقیقه', $names['minute']);
	    $answer .= '</span>' ;
	    $answer .= form_dropdown($names['minute'],$options["minute"],(isset($selected["minute"]))?$selected["minute"]:$now["minute"] ,'class="form-control" ') ;
	    endif;
	     
	    $answer .= '</div><!-- /input-group -->' ;
	    $answer .= '</div>';
	    return $answer ;
	}
}