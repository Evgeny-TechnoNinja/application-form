<?php 
//Реализую форму обратной связи.
//Запускаю сессию
session_start();
//Переменные
$error = false;
//Удаляю предыдущие значения из сессии.
unset($_SESSION['name']);
unset($_SESSION['phone']);
//Определяю send не NULL (то-есть нажата была кнопка "Записаться") тогда...
if(isset($_POST['send'])) {
    //Записываю данные из массива в переменные. 
    //Делаю время в нужном формате, для удобства.
    $time_date = date("Y-m-d H:i:s");
    //Записываемые данные проходят через функцию которая убирает пробелы по кроям текста. 
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    //Делаю чтобы данные которые ввели в форму не стерлись после отправки формы.
    $_SESSION['name'] = $name;
    $_SESSION['phone'] = $phone;
} 
    //Обработка ошибок в форме.
    //Идут проверки на недопустимые символы и на короткие имена.
    if($name == "" || preg_match("/[0-9-\.+$^)(><\?\]\[\}\{\*\&\;\:\~\/\=\#\%\@\№\!\"]/u", $name)) {
            $notice = "Укажите имя и фамилию!";
            $error = true;
    }
    elseif(strlen($name) <= 2) {
            $notice = "Короткое имя!";
            $error = true;
    }
    elseif($phone == "" || preg_match("/[^0-9\s-\+ \( \)]/", $phone)) {
            $notice = "Укажите номер телефона!";
            $error = true;
    }
    elseif(strlen($phone) <= 6) {
            $notice = "Короткий номер телефона!";
            $error = true;
    }
    else{
    //Данные которые не содержат ошибок, записываются в файл, а также отправляются на почту.
    //запись в файл...
        file_put_contents('candidate.txt', "$time_date $name $phone\n", FILE_APPEND);
    //данные на почту...
        mail('technoninja@ukr.net', 'Новый кандидат', "$time_date $name $phone");
    }      
 //Если ошибок нет тогда уведомляю что пользователь записан.
if (!$error) {
    $notice = "<span style = color:#19c119;>Вы записаны!</span>";
}
//Если имя  пусто, то уведомления тоже пустое.    
if($name == ""){
    $notice = NULL;
}
//Если имя  пусто, а телефон нет, то...
if($name == "" && $phone != ""){
     $notice = "Укажите имя и фамилию!";
}

?>


<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PHP HomeWork Four</title>
  <link rel="icon" type="image/x-icon" href="favicon.ico">
<link href="https://fonts.googleapis.com/css?family=Oswald&amp;subset=cyrillic" rel="stylesheet">
  <link rel="stylesheet" href="css/normalize.min.css">
  <link rel="stylesheet" href="css/final-style.css">
</head>
<body class="page">

    <div class="container">

        <header class="header container__header">
            <p class="header__txt">Вы видите, как я выполнил своё четвертое&ensp;<a href="doc/php-hw-4.pdf" target="_blank" class="header__link header__link_hover">домашнее задание</a>&ensp;по программе "Марафон по PHP".</p>
        </header>
        
        <div class="application container__application">
            <h1 class="application__heading">Добровольцы для колонизации Марса</h1>
           
            <form class="form application__form" action="index.php" method="POST" name="applicationForm">
                <p class="form__txt">Запись на собеседование</p>
                <input class="form__field form__field_active" placeholder="Ваше имя и фамилия" name="name" maxlength="20" type="text" value="<? echo $_SESSION['name'] ?>"><br>
                <input class="form__field form__field_active" placeholder="Ваш номер телефона" name="phone" maxlength="20" type="tel" value="<? echo $_SESSION['phone'] ?>"><br>
                <button class="form__btn form__btn_hover" name="send" type="submit">Записаться</button>
                <p class="form__txt-notice"><? echo $notice; ?></p> 
            </form>
        
        </div>
        
        <footer class="footer container__footer">
        <p class="footer__txt">Благодарю замечательного художника <a href="https://www.artstation.com/steveburg" target="_blank"  class="footer__link footer__link_hover">Steve Burg</a> за прекрасное изображение.</p>
        <p class="footer__text-author"><a href="https://www.facebook.com/baranovevgene" target="_blank" class="footer__link footer__link_text_bright">&copy;2018*TechnoNinja*</a></p>
        </footer>
    </div>

</body>