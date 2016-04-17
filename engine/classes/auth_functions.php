<?php
/*
==================================
Файл с пользовательскими функциями
==================================
*/
 
  /**функция вывода ошибок
  * @param array  $data
  */
 function showErrorMessage($data)
 {
	if(is_array($data))
	{
		foreach($data as $val)
			$err .= '<span style="color:red;background-color:white;padding:2px;">'. $val .'</span><br>';
	}
	else
		$err .= '<span style="color:red;background-color:white;padding:2px;">'. $data .'</span><br>';

    return $err;
 }
 
  function showMessage($data)
 {
	if(is_array($data))
	{
		foreach($data as $val)
			$err .= '<span style="background-color:white;padding:2px;">'. $val .'</span><br>';
	}
	else
		$err .= '<span style="background-color:white;padding:2px;">'. $data .'</span><br>';
    return $err;
 }
 
 
 /**Простой генератор соли
 * @param string  $sql
 */
 function salt()
 {
	$salt = substr(md5(uniqid()), -8);
	return $salt;
 }

/** Проверка валидации email
* @param string $email
* return boolian
*/
 function emailValid($email){
  if(function_exists('filter_var')){
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
      return true;
    }else{
      return false;
    }
  }else{
    if(!preg_match("/^[a-z0-9_.-]+@([a-z0-9]+\.)+[a-z]{2,6}$/i", $email)){
      return false;
    }else{
      return true;
    }
  }      
 }
?>
