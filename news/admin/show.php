<?php
  ///////////////////////////////////////////////////
  // Блок "Новости"
  // 2003-2006 (C) IT-студия SoftTime (http://www.softtime.ru)
  // Симдянов И.В. (simdyanov@softtime.ru)
  // Голышев С.В. (softtime@softtime.ru)
  ///////////////////////////////////////////////////
  // Выставляем уровень обработки ошибок (http://www.softtime.ru/info/articlephp.php?id_article=23)
  Error_Reporting(E_ALL & ~E_NOTICE); 

  // Устанавливаем соединение с базой данных
  require_once("../config.php");

  // Проверяем параметр id_news, предотвращая SQL-инъекцию
  if(!preg_match("|^[\d]+$|",$_GET['id_news'])) puterror("Ошибка при обращении к блоку новостей");
  // Отображаем новость
  $query = "UPDATE news SET hide='show' 
            WHERE id_news=".$_GET['id_news'];
  if(mysql_query($query)) header("Location: index.php?page=".$_GET['page']);
  else puterror("Ошибка при обращении к блоку новостей");
?>