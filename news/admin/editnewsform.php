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
  include "../config.php";
  // Так как для исправления мы будет использовать
  // форму добавления новостей, необходимо соответствующим
  // образом настроить управляющие переменные.
  $titlepage = "Редактирование новости";
  $button = "Исправить";
  $action = "editnews.php";

  // Извлекаем из таблицы news запись, соответствующую
  // исправляемой новостной позиции
  $query = "SELECT * FROM news 
            WHERE id_news=".$_GET['id_news'];
  $new = mysql_query($query);
  if(!$new) puterror("Ошибка запроса к таблице новостей...");
  $row = mysql_fetch_array($new);
  // Берём информацию для оставшихся переменных из базы данных
  $name = $row['name'];
  $body = $row['body'];
  $url = $row['url'];
  $url_text = $row['url_text'];
  $url_pict = $row['url_pict'];
  $date_month = substr($row['putdate'],5,2);
  $date_day = substr($row['putdate'],8,2);
  $date_year = substr($row['putdate'],0,4);
  $date_hour = substr($row['putdate'],11,2);
  $date_minute = substr($row['putdate'],14,2);
  $_GET['id_news'] = $row['id_news'];
  // Определяем скрыто поле или нет
  if($row['hide'] == 'show') $showhide = "checked";
  else $showhide = "";

  // Включаем редактирование
  define("EDIT",1);
  // Включаем HTML-форму в полях, которой будут размещены
  // редактируемая информация из таблицы news
  include "addnewsform.php";
?>