<?php
  ///////////////////////////////////////////////////
  // Блок "Новости"
  // 2003-2006 (C) IT-студия SoftTime (http://www.softtime.ru)
  // Симдянов И.В. (simdyanov@softtime.ru)
  // Голышев С.В. (softtime@softtime.ru)
  ///////////////////////////////////////////////////
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>Новости</title>
<link rel="StyleSheet" type="text/css" href="news.css">
</head>
<?php
  // Выставляем уровень обработки ошибок (http://www.softtime.ru/info/articlephp.php?id_article=23)
  Error_Reporting(E_ALL & ~E_NOTICE); 

  // Этот файл выводит первые $pnumber новостей
  // Устанавлинваем соединение с базой данных
  require_once("config.php");
?>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<p class="zagblock">НОВОСТИ</p>
<?php
  // Выясняем общее количество новостей в базе данных, для того чтобы
  // правильно отображать ссылки на последующие новости.
  $tot = mysql_query("SELECT count(*) FROM news WHERE hide='show' AND putdate <= NOW()");
  if ($tot)
  {
    $total = mysql_result($tot,0);
    // Если в базе новостей меньше чем $pnumber
    // выводим их без вывода ссылки "Все новости".
    if($pnumber < $total) echo "<p class='linkblock'><a href=news.php class='linkblock'>Все новости</a>";
  }
  else puterror("Ошибка при обращении к блоку новостей");
  // Запрашиваем все видимые новости, т.е. те, у которых в базе данных hide='show',
  // если это поле будет равно 'hide', новость не будет отображаться на странице
  $query = "SELECT * FROM news 
            WHERE hide='show' AND putdate <= NOW()
            ORDER BY putdate DESC
            LIMIT $pnumber";
  $new = mysql_query($query);
  if(!$new) puterror("Ошибка при обращении к блоку новостей");
  if(mysql_num_rows($new) > 0)
  {
    while($news = mysql_fetch_array($new))
    {
      // Выводим заголовок новости
      echo "<p class=newsblockzag><b>".$news['name']."</b></p>";
      // Формируем анонс
      // Переменная $numchar содержит примерное
      // количество символов в анонсе
      $pos = strpos(substr($news['body'],$numchar), " ");
      // Если новость длинная, то выводим троеточие...
      if(strlen($news['body'])>$numchar) $srttmpend = "...";
      else $strtmpend = "";
      // Выводим анонс
      echo "<p class=newsblock>".substr($news['body'], 0, $numchar+$pos).$srttmpend;
      echo "<br><a class=anewsblock href=news.php?id_news=".$news['id_news'].">подробнее</a></p>";
    }
  }
?>
<br><br>