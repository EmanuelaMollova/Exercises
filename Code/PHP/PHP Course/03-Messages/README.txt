﻿За потребителско име и парола за базата данни са използвани съотвено user и qwerty.
Можете да ги промените в променливата $connection във файла includes/header.php (ред 7).

Има 3 вида потребители:
-----------------------

 - обикновени потребители (могат да четат и добавят съобщения, да ги филтрират и сортират)
 - администратори:
      - могат да четат, добавят и изтриват съобщения
      - могат да повишават обикновените потребители в администратори и да понижават 
        администраторите в обиновени потребители
      - могат да добавят и редактират категории
 - главен администратор:
      - има всички права на администратор, но не може да бъде понижаван в друг вид потребител
      
Съответно има регистрирани следните потребители:
------------------------------------------------

 - admin (pass: admin) - Главен администратор
 - Johnny (pass: qwerty) - Администратор
 - Sarah (pass: qwerty) - Администратор
 - Benny (pass: qwerty) - Обикновен потребител
 - Katherin (pass: qwerty) - Обикновен потребител

Добавена функционалност:
------------------------

 - вход за регистрирани потребители
 - регистрация на нови потребители
 - добавяне на съобщение
 - филтриране на съобщенията по категория, потребител, дата на добавяне 
 - сортиране на съобщенията възходящо и низходящо по дата на добавяне, заглавие, съобщение, 
   име на потребителя, който е добавил съобщението, категория
 - изтриване на съобщение (само от администратор)
 - преглед на всички регистрирани потребители (само от администратор)
 - даване и отнемане на администраторски права (само от администратор)
 - преглед на всички категории (само от администратор)
 - добавяне на нови категории (само от администратор)
 - редактиране на категории (само от администратор)
 - изход от системата
