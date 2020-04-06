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
  // Формируем заголовок страницы и подсказку
  $titlepage="Управление блоком\n \"Новости\" $version";
  $helppage='Если у вас не работает это Web-приложение, вы всегда можете найти помощь по его установке и настройке на нашем форуме <a href=http://www.softtime.ru/forum/>http://www.softtime.ru/forum/</a> Возможно вам также потребуется дополнительная функциональность, в этом случае Вы также можете посетить наш форум и выссказать свои предложения. Если Ваше предложение действительно актуально и интересно, мы доработаем приложение с учетом Ваших пожеланий.';
  // Выводим шапку страницы
  include "../util/topadmin.php";  


  // Проверяем параметр page, предотвращая SQL-инъекцию
  if(!preg_match("|^[\d]*$|",$_POST['page'])) puterror("Ошибка при обращении к блоку новостей");
  // Проверяем переменную $page, равную порядковому номеру первой новости на странице
  $page = $_GET['page'];
  if(empty($page)) $page = 1;
  $begin = ($page - 1)*$all_number_news;

  // Воспроизводим новости, таким образом, как они выглядят на 
  // главной странице, но отображаем так же невидимые новости
  $query = "SELECT id_news,
                   name,
                   body,
                   DATE_FORMAT(putdate,'%d.%m.%Y') as putdate_format,
                   url,
                   url_text,
                   url_pict,
                   hide
            FROM news
            ORDER BY putdate DESC 
            LIMIT $begin, $all_number_news";
  $new = mysql_query($query);
  if ($new)
  {
    // Выводим ссылки управления новостями, добавление, удаление и редактирование
    ?>
<table cellpadding="0" cellspacing="0" border="0" >
        <tr>
        <?php
    echo "<td class=boxmenu><a class=menu href=addnewsform.php?start=$start title='Добавить новую новость на сайт' >Добавить новость</a></td>";
    ?>
    </tr>
    </table><br>
    <table width=100% class=bodytable border=1 align=center cellpadding=5 cellspacing=0 bordercolorlight=gray bordercolordark=white>
      <tr class=tableheadercat align="center">
        <td width=120><p class=zagtable>Дата</p></td>
        <td width=60%><p class=zagtable>Новость</p></td>
        <td width=40><p class=zagtable><nobr>Избр-е</nobr></p></td>
        <td colspan=3><p class=zagtable>Действия</p></td>
      </tr>
    <?php
    while($news = mysql_fetch_array($new))
    {
    
      // Если новость отмечена как невидимая (hide='hide'), выводим
      // ссылку "отобразить", если как видимия (hide='show') - "скрыть"
      $colorrow = "";
      if($news['hide']=='show') $showhide = "<p><a href=hide.php?id_news=".$news['id_news']."&start=$start title='Скрыть новость в блоке новостей'>Скрыть</a>";
      else  {
        $showhide = "<p><a href=show.php?id_news=".$news['id_news']."&start=$start title='Отобразить новость в блоке новостей'>Отобразить</a>";
        $colorrow = "class='hiddenrow'";
      }
      // Проверяем наличие изображения
      if ($news['url_pict'] != '' && $news['url_pict'] != '-') $url_pict="<b><a href=../".$news['url_pict'].">есть</a></b>";
      else $url_pict="нет";
      
      if (($news['url']!='-') and ($news['url']!='')) $news_url="<br><b>Ссылка:</b> <a href='".$news['url']."'>".$news['url_text']."</a>";
      else $news_url="";
      // Выводим новость
      echo "<tr $colorrow >
              <td><p class=help align=center>".$news['putdate_format']."</p></td>
              <td><p><a title='Редактировать текст новости' href=editnewsform.php?id_news=".$news['id_news']."&start=$start>".$news['name']."</a><br>".nl2br($news['body'])." ". $news_url." </td>
              <td><p>".$url_pict."</p></td>
              <td align=center>".$showhide."</td>
              <td align=center><p><a href=delnews.php?start=$start&id_news=".$news['id_news']." title='Удалить новость'>Удалить</a></td>
              <td align=center><p><a href=editnewsform.php?start=$start&id_news=".$news['id_news']." title='Редактировать текст новости'>Исправить</a></td>
            </tr>";
    }
    echo "</table>";
  }
  else puterror("Ошибка при обращении к блоку новостей");

  // Постраничная навигация
  $page_link = 4;
  $query = "SELECT COUNT(*) FROM news";
  $tot = mysql_query($query);

  $total = mysql_result($tot,0);
  $number = (int)($total/$all_number_news);
  if((float)($total/$all_number_news) - $number != 0) $number++;
  echo "<br><table><tr><td><p>";
  // Проверяем есть ли ссылки слева
  if($page - $page_link > 1)
  {
    echo "<a href=$_SERVER[PHP_SELF]?page=1>[1-$all_number_news]</a>&nbsp;&nbsp;...&nbsp;";
    // Есть
    for($i = $page - $page_link; $i<$page; $i++)
    {
        echo "&nbsp;<a href=$_SERVER[PHP_SELF]?page=".$i.">[".(($i - 1)*$all_number_news + 1)."-".$i*$all_number_news."]</a>&nbsp;";
    }
  }
  else
  {
    // Нет
    for($i = 1; $i<$page; $i++)
    {
        echo "&nbsp;<a href=$_SERVER[PHP_SELF]?page=".$i.">[".(($i - 1)*$all_number_news + 1)."-".$i*$all_number_news."]</a>&nbsp;";
    }
  }
  // Проверяем есть ли ссылки справа
  if($page + $page_link < $number)
  {
    // Есть
    for($i = $page; $i<=$page + $page_link; $i++)
    {
      if($page == $i)
        echo "&nbsp;[".(($i - 1)*$all_number_news + 1)."-".$i*$all_number_news."]&nbsp;";
      else
        echo "&nbsp;<a href=$_SERVER[PHP_SELF]?page=".$i.">[".(($i - 1)*$all_number_news + 1)."-".$i*$all_number_news."]</a>&nbsp;";
    }
    echo "&nbsp;...&nbsp;<a href=$_SERVER[PHP_SELF]?page=$number>[".(($number - 1)*$all_number_news + 1)."-$total]</a>&nbsp;";
  }
  else
  {
    // Нет
    for($i = $page; $i<=$number; $i++)
    {
      if($number == $i)
      {
        if($page == $i)
          echo "&nbsp;[".(($i - 1)*$all_number_news + 1)."-$total]&nbsp;";
        else
          echo "&nbsp;<a href=$_SERVER[PHP_SELF]?page=".$i.">[".(($i - 1)*$all_number_news + 1)."-$total]</a>&nbsp;";
      }
      else
      {
        if($page == $i)
          echo "&nbsp;[".(($i - 1)*$all_number_news + 1)."-".$i*$all_number_news."]&nbsp;";
        else
          echo "&nbsp;<a href=$_SERVER[PHP_SELF]?page=".$i.">[".(($i - 1)*$all_number_news + 1)."-".$i*$all_number_news."]</a>&nbsp;";
      }
    }
  }
  echo "</td></tr></table>";
  // Выводим завершение страницы
  include "../util/bottomadmin.php";
?>