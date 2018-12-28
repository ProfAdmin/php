<?php
/**
 * Created by PhpStorm.
 * User: Andrei
 * Date: 24.12.2018
 * Time: 13:34
 */

$email_addresses = []; //массив для заполнения считанных e-mail адресов
$array_bad_email = []; //массив для отсеянных e-mail адресов
$array_mailru = []; //массив для адресов mail.ru
$array_yandex = []; //массив для адресов yandex.ru
$array_gmailcom = []; //массив для адресов gmail.com
$array_office365 = []; //массив для адресов office365
$array_other_email = []; //массив для всех остальный e-mail адресов
//Переменные для функции check_mail()
$mx_port = 25; //Порт подключение к почтовому серверу
$from_domain = "gateway.provds.club"; //домен от имени которого будет выполняться проверка почтового адреса
$from_email = "do_not_replay@{$from_domain}"; //e-mail адрес от которого будет выполняться запрос на проверку

//Открываем файл со списком e-mail адресов
$handle = fopen("check_mail.csv", "r");
if ($handle == false)
{
    printf("could not open file check_mail.csv\n");
    exit(1);
}
//Читаем файл построчно и заносим данные в массив $email_addresses
while ($row = fgetcsv($handle))
{
    $email_addresses[] = $row[0];
}
//закрываем файл
fclose($handle);
//Подсчитываем количество загруженных e-mail адресов
$count_email_addresses = count($email_addresses);

//Проверка e-mail адресов из массива $email_addresses и сортировка по временным массивам
for($i = 0; $i < $count_email_addresses; $i++)
{
    $result = check_mail($email_addresses[$i]);
        if ($result == 0)
        {
            $array_bad_email[] = $email_addresses[$i];
        }
        else if ($result == 1)
        {
            $array_mailru[] = $email_addresses[$i];
        }
        else if ($result == 2)
        {
            $array_yandex[] = $email_addresses[$i];
        }
        else if ($result == 3)
        {
            $array_gmailcom[] = $email_addresses [$i];
        }
        else if ($result == 4)
        {
            $array_office365[] = $email_addresses [$i];
        }
        else
        {
            $array_other_email[] = $email_addresses [$i];
        }
}

//Подсчитываем количество e-mail адресов в массивах
$count_bad_email = count($array_bad_email);
$count_mailru = count($array_mailru);
$count_yandex = count($array_yandex);
$count_gmailcom = count($array_gmailcom);
$count_office365 = count($array_office365);
$count_other_email = count($array_other_email);

//Открываем файл для адресов mail.ru
$fp_mailru = fopen("mail_ru.csv", "wt");
if ($fp_mailru == false)
{
    printf("could not open file mail_ru.csv\n");
    exit(1);
}
//Если в массиве есть e-mail адреса пишем в файл, если нет, закрываем его
if ($count_mailru != 0)
{
    foreach ($array_mailru as $value)
    {
        fputcsv($fp_mailru, array($value));
    }
}
//Закрываем файл mail_ru.csv
fclose($fp_mailru);

//Открываем файл для адресов yandex.ru
$fp_yandex = fopen("yandex_ru.csv", "wt");
if ($fp_yandex == false)
{
    printf("could not open file yandex_ru.csv\n");
    exit(1);
}
//Если в массиве есть e-mail адреса пишем в файл, если нет, закрываем его
if ($count_yandex != 0)
{
    foreach ($array_yandex as $value)
    {
        fputcsv($fp_yandex, array($value));
    }
}
//Закрываем файл yandex_ru.csv
fclose($fp_yandex);

//Открываем файл для адресов gmail.com
$fp_gmailcom = fopen("gmail_com.csv", "wt");
if ($fp_gmailcom == false)
{
    printf("could not open file gmail_com.csv\n");
    exit(1);
}
//Если в массиве есть e-mail адреса пишем в файл, если нет, закрываем его
if ($count_gmailcom != 0)
{
    foreach ($array_gmailcom as $value)
    {
        fputcsv($fp_gmailcom, array($value));
    }
}
//Закрываем файл gmail_com.csv
fclose($fp_gmailcom);

//Открываем файл для адресов office365
$fp_office365 = fopen("office365.csv", "wt");
if ($fp_office365 == false)
{
    printf("could not open file office365.csv\n");
    exit(1);
}
//Если в массиве есть e-mail адреса пишем в файл, если нет, закрываем его
if ($count_office365 != 0)
{
    foreach ($array_office365 as $value)
    {
        fputcsv($fp_office365, array($value));
    }
}
//Закрываем файл office365.csv
fclose($fp_office365);

//Открываем файл для всех остальный e-mail адресов
$fp_other_email = fopen("other_email.csv", "wt");
if ($fp_other_email == false)
{
    printf("could not open file other_email.csv\n");
    exit(1);
}
//Если в массиве есть e-mail адреса пишем в файл, если нет, закрываем его
if ($count_other_email != 0)
{
    foreach ($array_other_email as $value)
    {
        fputcsv($fp_other_email, array($value));
    }
}
//Закрываем файл other_mail.csv
fclose($fp_other_email);

//Открываем файл для не существующих e-mail адресов
$fp_bad_email = fopen("bad_email.csv", "wt");
if ($fp_bad_email == false)
{
    printf("could not open file bad_email.csv\n");
    exit(1);
}
//Если в массиве есть e-mail адреса пишем в файл, если нет, закрываем его
if ($count_bad_email != 0)
{
    foreach ($array_bad_email as $value)
    {
        fputcsv($fp_bad_email, array($value));
    }
}
//Закрываем файл bad_mail.csv
fclose($fp_bad_email);

//Результаты сортировки e-mail адресов
print("e-mail mail.ru: $count_mailru\n");
print("e-mail yandex.ru: $count_yandex\n");
print("e-mail gmail.com: $count_gmailcom\n");
print("e-mail office365: $count_office365\n");
print("e-mail other: $count_other_email\n");
print("e-mail bad: $count_bad_email\n");
print("TOTAL e-mail: $count_email_addresses\n");

//Функция проверки e-mail адресов
function check_mail($email)
{
    global $mx_port, $from_domain, $from_email;
    $domain = '127.0.0.1';

    //Выставляем задержку, что бы не забанили
    sleep(2);

    //Выделяем имя домена из e-mail адреса
    $re = '/.*@(.*)/';
    $matchCount = preg_match($re, $email, $match);
    if ($matchCount > 0)
    {
        $domain = $match[1];
    }

    //Находим MX запись для полученого домена $domain
    $mx_records_bool = getmxrr($domain, $mxdomain);
    //Если домен не содержит MX записей, значит e-mail адрес не действителен в большинстве случаев, но есть исключения
    if ($mx_records_bool == false)
    {
        return 0;
    }

    //Для e-mail адресов от Mail.ru нельзя проверить через telnet существование адреса, поэтому применяем только сортировку
    if ($mxdomain[0] == 'mxs.mail.ru')
    {
        return 1;
    }

    //Получаем IP адрес записи MX
    $ip = gethostbyname($mxdomain[0]);
    if ($ip == $mxdomain[0])
    {
        print("Хост не известен");
        return 0;
    }

    //Создаем сокет для обмена информацией с почтовым сервером
    echo "Создаем сокет для обмена информацией с почтовым сервером для e-mail: <$email>...";
    if (($mail_socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false)
    {
        $errorcode = socket_last_error();
        $errormsg = socket_strerror($errorcode);
        echo "Сокет подключения не создан: [$errorcode] $errormsg\n";
        return 0;
    }
    echo "OK\n";

    //Задаем параметр time out для созданного сокета
    if ( !socket_set_option($mail_socket,SOL_SOCKET, SO_RCVTIMEO, array("sec"=>10, "usec"=>0)))
    {
        $errorcode = socket_last_error();
        $errormsg = socket_strerror($errorcode);
        // Закрываем сокет
        echo "Закрываем соединение...";
        socket_close($mail_socket);
        echo "OK\n";
        die("Ошибка установки параметров для сокета: [$errorcode] $errormsg\n");
    }

    //Подключаемся к созданному сокету
    echo "Подключаемся к сокету...";
    if ( !socket_connect($mail_socket, $ip, $mx_port))
    {
        $errorcode = socket_last_error();
        $errormsg = socket_strerror($errorcode);
        // Закрываем сокет
        echo "Закрываем соединение...";
        socket_close($mail_socket);
        echo "OK\n";
        echo "Ошибка подключения к почтовому серверу домена $domain: [$errorcode] $errormsg\n";
        return 0;
    }
    echo "OK\n";

    //Ответ от почтового сервера
    $read = socket_read($mail_socket, 1024);
    echo "Ответ от сервера: $read";

    //Проверяем ответ от сервера, если ответ начинается на "220", то все ок, идем дальше
    if (substr($read, 0, 3) != '220')
    {
        // Закрываем сокет
        echo "Закрываем соединение...";
        socket_close($mail_socket);
        echo "OK\n";
        echo "Ошибка подключения к почтовому серверу домена $domain: [$errorcode] $errormsg\n";
        return 0;
    }

    //Отсылаем сообщение приветствие, HELLO
    $txt = sprintf("HELO %s\r\n", $from_domain);
    echo "Отсылаем запрос: $txt";
    if( ($write = socket_write( $mail_socket, $txt)) === false)
    {
        $errorcode = socket_last_error();
        $errormsg = socket_strerror($errorcode);
        // Закрываем сокет
        echo "Закрываем соединение...";
        socket_close($mail_socket);
        echo "OK\n";
        echo "Ошибка при обмене данными для e-mail $email, домена $domain: [$errorcode] $errormsg";
        return 0;
    }
    echo "OK\n";

    //Ответ от почтового сервера
    $read = socket_read($mail_socket, 1024);
    echo "Ответ от сервера: $read";

    //Проверяем ответ от сервера, если ответ начинается на "250" или "220", то все ок, идем дальше
    if (substr($read, 0, 3) != '250')
    {
        if (substr($read, 0, 3) != '220')
        {
            // Закрываем сокет
            echo "Закрываем соединение...";
            socket_close($mail_socket);
            echo "OK\n";
            echo "Ошибка подключения к почтовому серверу домена $domain: [$errorcode] $errormsg\n";
            return 0;
        }
    }

    //Указываем от какого e-mail будем делать запрос
    $txt = sprintf("MAIL FROM: <%s>\r\n", $from_email);
    echo "Отсылаем запрос: $txt";
    if( ($write = socket_write( $mail_socket, $txt)) === false)
    {
        $errorcode = socket_last_error();
        $errormsg = socket_strerror($errorcode);
        // Закрываем сокет
        echo "Закрываем соединение...";
        socket_close($mail_socket);
        echo "OK\n";
        echo "Ошибка при обмене данными для e-mail $email, домена $domain: [$errorcode] $errormsg";
        return 0;
    }
    echo "OK\n";

    //Ответ от почтового сервера
    $read = socket_read($mail_socket, 1024);
    echo "Ответ от сервера: $read";

    //Проверяем ответ от сервера, если ответ начинается на "250", то все ок, идем дальше
    if (substr($read, 0, 3) != '250')
    {
        // Закрываем сокет
        echo "Закрываем соединение...";
        socket_close($mail_socket);
        echo "OK\n";
        echo "Ошибка подключения к почтовому серверу домена $domain: [$errorcode] $errormsg\n";
        return 0;
    }

    //Указываем e-mail, который проверяем
    $txt =  sprintf("RCPT TO: <%s>\r\n", $email);
    echo "Отсылаем запрос: $txt";
    if( ($write = socket_write( $mail_socket, $txt)) === false)
    {
        $errorcode = socket_last_error();
        $errormsg = socket_strerror($errorcode);
        // Закрываем сокет
        echo "Закрываем соединение...";
        socket_close($mail_socket);
        echo "OK\n";
        echo "Ошибка при обмене данными для e-mail $email, домена $domain: [$errorcode] $errormsg";
        return 0;
    }
    echo "OK\n";

    //Ответ от почтового сервера
    $read = socket_read($mail_socket, 1024);
    echo "Ответ от сервера: $read";

    //Проверяем ответ от сервера, если ответ начинается на "250", то e-mail существует, если нет, то запоминаем статус e-mail
    //Иногда может быть ответ "450"
    $email_status = 1;
    if (substr($read, 0, 3) != '250')
    {
        $email_status = 0;
        if (substr($read, 0, 3) == '450')
        {
            $email_status = 1;
        }
    }

    //Отключаемся от сервера
    $txt = sprintf("quit\r\n");
    echo "Отсылаем запрос: $txt";
    if( ($write = socket_write($mail_socket, $txt)) === false)
    {
        $errorcode = socket_last_error();
        $errormsg = socket_strerror($errorcode);
        // Закрываем сокет
        echo "Закрываем соединение...";
        socket_close($mail_socket);
        echo "OK\n";
        echo "Ошибка при обмене данными для e-mail $email, домена $domain: [$errorcode] $errormsg";
        return 0;
    }
    echo "OK\n";

    //Ответ от почтового сервера
    $read = socket_read($mail_socket, 1024);
    echo "Ответ от сервера: $read";

    //Проверяем ответ от сервера, если ответ начинается на "221", то все ок, идем дальше
    if (substr($read, 0, 3) != '221')
    {
        echo "Что-то пошло не так, сервер ответил: $read\n";
    }

    // Закрываем сокет
    echo "Закрываем соединение...";
    socket_close($mail_socket);
    echo "OK\n";

    //Если e-mail не существует, то возращаем ноль
    if ($email_status == 0)
    {
        return 0;
    }

    //Если e-mail существует, то проверяем к какому почтовому сервису он относится
    if ($mxdomain[0] == 'mx.yandex.ru')
    {
        return 2;
    }
    else if (substr($mxdomain[0], -10) == 'google.com')
    {
        return 3;
    }
    else if (substr($mxdomain[0], -11) == 'outlook.com')
    {
        return 4;
    }
    else
    {
        return 5;
    }
}
?>