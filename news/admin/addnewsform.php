<?php
  ///////////////////////////////////////////////////
  // Блок "Новости"
  // 2003-2006 (C) IT-студия SoftTime (http://www.softtime.ru)
  // Симдянов И.В. (simdyanov@softtime.ru)
  // Голышев С.В. (softtime@softtime.ru)
  ///////////////////////////////////////////////////
  // Выставляем уровень обработки ошибок (http://www.softtime.ru/info/articlephp.php?id_article=23)
  Error_Reporting(E_ALL & ~E_NOTICE); 

  if($titlepage == "") $titlepage = "Добавление новости";
  $helppage='Для добавления новости заполните обязательные поля: "<b>Название</b>" и "<b>Содержание</b>". Нажмите кнопку "Добавить".<br> 
  <i>Необязательные поля</i>:<br> <b>Ссылка:</b> cюда впишите адрес ссылки, например www.yandex.ru<br>
  <b>Текст для ссылки</b>: впишите название ссылки, например "Yandex"<br>
  <b>Изображение</b> - нажав на кнопку "Обзор" и выбрав изображение, находящееся на вашем компьютере, вы можете поместить данное изображение в новости. Будьте осторожны, старайтесь добалять изображения не большого размера.<br>
  <b>Отображать</b> - сняв или установив переключатель вы можете управлять выводом данной новости на сайте. Скрыть ее или отобразить.
  ';
  include "../util/topadmin.php";

  // Если не определена константа EDIT,
  // Устанавливаем параметры HTML-формы
  // на редактирование
  if(!defined("EDIT"))
  {
    $button = "Добавить";
    $action = "addnews.php";
    $showhide = "checked";
    $chk_filename = "";
    $chk_rename   = "";
    $name = "";
    $body = "";
    $url = "";
    $url_text = "";
    $url_pict = "";
    $date_month = date("m");
    $date_day = date("d");
    $date_year = date("Y");
    $date_hour = date("H");
    $date_minute = date("i");
  }
?>
<table><tr><td>
<p class=boxmenu><a class=menu href="index.php">Вернуться в администрирование новоcтей</a></p>
</td></tr></table>
<form name=form enctype='multipart/form-data' action=<?php echo $action; ?> method=post>
<table cellpadding="0" cellspacing="6">
<tr>
  <td><p class=zag2>Название</td>
  <td></td>
  <td><input class=input size=70 type=text name=name value='<?php echo htmlspecialchars($name); ?>'></td>
</tr>
<tr>
  <td><p class=zag2>Содержание</td>
  <td></td>
  <td><textarea class=input name=body rows=10 cols=60><?php echo htmlspecialchars($body); ?></textarea></td>
</tr>
<tr>
  <td><p class=zag2>Ссылка</td>
  <td></td>
  <td><input class=input size=70 type=text name=url value='<?php echo htmlspecialchars($url); ?>'></td>
</tr>
<tr>
  <td><p class=zag2>Текст для ссылки</td>
  <td></td>
  <td><input class=input size=70 type=text name=url_text value='<?php echo htmlspecialchars($url_text); ?>'></td>
</tr>
<tr>
  <td><p class=zag2>Дата новости</td>
  <td></td>
  <td>
   <?php
     // Выпадающий список для дня
     echo "<select title='День' class=input type=text name='date_day'>";
     for($i = 1; $i <= 31; $i++)
     {
       if($date_day == $i) $temp = "selected";
       else $temp = "";
       echo "<option value=$i $temp>".sprintf("%02d", $i);
     }
     echo "</select>";
     // Выпадающий список для месяца
     echo "<select class=input type=text name='date_month'>";
     for($i = 1; $i <= 12; $i++)
     {
       if($date_month == $i) $temp = "selected";
       else $temp = "";
       echo "<option value=$i $temp>".sprintf("%02d", $i);
     }
     echo "</select>";
     // Выпадающий список для года
     echo "<select class=input type=text name='date_year'>";
     for($i = 2004; $i <= 2017; $i++)
     {
       if($date_year == $i) $temp = "selected";
       else $temp = "";
       echo "<option value=$i $temp>$i";
     }
     echo "</select>";
     // Выпадающий список для часа
     echo "&nbsp;&nbsp;<select class=input type=text name='date_hour'>";
     for($i = 0; $i <= 23; $i++)
     {
       if($date_hour == $i) $temp = "selected";
       else $temp = "";
       echo "<option value=$i $temp>".sprintf("%02d",$i);
     }
     echo "</select>";
     // Выпадающий список для минут
     echo "<select class=input type=text name='date_minute'>";
     for($i = 0; $i <= 59; $i++)
     {
       if($date_minute == $i) $temp = "selected";
       else $temp = "";
       echo "<option value=$i $temp>".sprintf("%02d",$i);
     }
     echo "</select>";
   ?>
</tr>
<tr>
  <td><p class=zag2>Изображение</td>
  <td><input type="checkbox" name="chk_filename" onclick="freeze_filename(this.form)" <?php echo htmlspecialchars($chk_filename); ?>></td>
  <td><input class=input size=70 type=file name=filename></td>
</tr>
<tr>
  <td><p class=zag2>Переименовать</td>
  <td><input type="checkbox" name="chk_rename" onclick="freeze_rename(this.form)" <?php echo htmlspecialchars($chk_rename); ?>></td>
  <td><input class=input1 size=70 type=text name=rename ></td>
</tr>
<?php
  if(defined("EDIT") && !empty($url_pict))
  {
  ?>
<tr>
  <td><p class=zag2>Удалить изображение</td>
  <td><input type="checkbox" name="chk_delete"></td>
  <td></td>
  <?php
  }
?>
</tr>
<tr>
  <td><p class=zag2>Отображать</td>
  <td><input type=checkbox name=hide <?php echo htmlspecialchars($showhide); ?>></td>
  <td><p class=help>если флажок не отмечен, новостная позиция не отображается на страницах сайта</p></td>
</tr>
<tr>
  <td></td>
  <td></td>
  <td><input class=button type=submit value=<?php echo htmlspecialchars($button); ?>></td>
</tr>
<input type=hidden name=id_news value=<?php echo htmlspecialchars($_GET['id_news']); ?>>
<input type=hidden name=start value=<?php echo htmlspecialchars($_GET['start']); ?>>
</table>
</form>
<?
  echo $help;
  include "../util/bottomadmin.php";
?>
<script language="JavaScript"> 
<!-- 
  function freeze_filename(form) 
  { 
    form.filename.disabled = !form.chk_filename.checked; 
  } 
  function freeze_rename(form) 
  { 
    form.rename.disabled = !form.chk_rename.checked; 
  } 

  if('<?= $chk_filename; ?>' == 'checked') document.form.filename.disabled = false; 
  else document.form.filename.disabled = true;
  if('<?= $chk_rename; ?>' == 'checked') document.form.rename.disabled = false; 
  else document.form.rename.disabled = true;
//--> 
</script>