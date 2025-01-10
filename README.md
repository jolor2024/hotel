# Hotel
A hotel website built with PHP. It lets customers book rooms, add extra features and check available dates.


Code Review

index.php:92 - Pris saknas på features och rum. 

dbfunctions.php:8-24 - glöm inte att ta bort utkommenterad kod.

booking.php:18-23 - Här ser man att att du använt både kebab-case och camelCase i din namngivning. Kan vara bra att vara konsekvent.

styles.css - Hade rekommenderat att dela upp detta dokument i flera css dokument, tex ett eget för main osv. Även rensa blank spaces som ligger lite här och var. 

admin.php:3 - declare(strict_types=1); ska bara vara med på sidan om det är endast php, denna sida har även html.

booking.php:39-57 - Här hade du kunnat skapa en array och loopat för att göra koden mer DRY.

overall - Vissa av dina kommentarer är på engelska, men de flesta är på svenska. Tror det kan vara bra att vara konsekvent, men framförallt att hålla dem på engelska. Bra och tydligt innehåll i kommentarerna dock. 

overall - Gick inte att se priset när man skulle boka rum, så man fick chansa på hur stor TC man var tvungen att ha. Detta gjorde att jag (som väldigt gärna ville bo på ditt fina hotell) fick sova utomhus. 

Överlag jättefin kod, väldigt lättläst! 

