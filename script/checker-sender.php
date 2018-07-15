<?php
//Скрипт CHECKER-SENDER
//Реализую работу формы обратной связи.
//Запускаю сессию
session_start();
//Переменные
$error = false;
//Удаляю предыдущие значения из сессии.
//unset($_SESSION['name']);
//unset($_SESSION['phone']);
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
//Удаляю значения из сессии.
    unset($_SESSION['name']);
    unset($_SESSION['phone']);
//перенаправление на страницу
    header('Refresh: 7; ../index.php');
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
