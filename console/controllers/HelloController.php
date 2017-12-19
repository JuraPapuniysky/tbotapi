<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace console\controllers;

use common\models\SearchEngine;
use console\models\TestWorker;
use yii\console\Controller;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex($message = 'hello world')
    {
        $content = " Тёмная материя интернета

    Wiki-технология

Иногда я открываю окно торрент-клиента и просто смотрю, как он раздает файлы… Это завораживает даже больше, чем дефрагментация или гейзеры и вулканы в трехлитровой банке с домашним квасом. Ведь я помогаю множеству незнакомых мне людей качать нужные им файлы. Мой домашний компьютер — маленький сервер, ресурсами которого я делюсь со всем интернетом. Наверное, похожие чувства побуждают тысячи добровольцев по всему миру участвовать в проектах вроде folding@home.

Ни один файловый сервер не справился бы с тем объемом раздачи, который обеспечивают миллионы маленьких компьютеров по всему миру, используя лишь небольшую часть своих ресурсов. Вот если бы я мог так же легко поделиться ресурсами с любым понравившимся мне сайтом! Если бы затраты на хостинг при росте аудитории росли не линейно, а логарифмически, за счет «добровольного ботнета» из компьютеров посетителей. Насколько меньше рекламы я бы увидел? Сколько интересных стартапов избавились бы от головной боли по поводу масштабирования? Сколько некоммерческих проектов могли бы перестать зависеть от благосклонности меценатов? И насколько труднее было бы кибергопникам или спецслужбам DDoS-ить такой сайт!

Цена вопроса

Сейчас в мире больше полутора миллиардов компьютеров, подключенных к интернет. Из них около 500 миллионов имеют широкополосное подключение. Если предположить, что средний возраст домашнего компьютера — около двух лет, то можно считать, что у него простенький двухъядерный процессор, 1 -2 гигабайта памяти и винт на 500 гигабайт. Для определенности предположим также, что средняя скорость широкополосного соединения — 10 мегабит/сек.

Много это или мало? Что будет, если нам удастся добраться до этой скрытой массы ресурсов? Прикинем на глазок. Допустим, что если оставлять эти компьютеры включенными круглосуточно, то не меньше трех четвертей их ресурсов будут простаивать (это более, чем осторожная оценка, в Википедии фигурирует средняя нагрузка на сервер в 18%!). Если же загрузить компьютер как следует, то вырастет энергопотребление, скажем на 70 ватт на один компьютер, или на 50 киловатт-часов в месяц. При средней цене электричества в мире около 10 центов за киловатт-час — это $5 в месяц. Плюс возникает вопрос повышенного износа. Вопрос довольно спорный, большинство комплектующих серьезных производителей безнадежно устаревают морально гораздо раньше, чем ломаются, кроме того, есть мнение, что постоянные включения-выключения и связанные с ними нагрев-остывание и другие переходные процессы приводят к выработке ресурса быстрее, чем круглосуточная работа. Тем не менее, включим в расчет лишние 150 долларов на ремонт, размазанные, скажем, на 4 года эксплуатации. Это еще чуть больше 3 долларов в месяц. Итого — 8 долларов в месяц или 100 долларов в год дополнительных расходов. С другой стороны, если три четверти ресурсов, за которые мы уже заплатили в момент покупки компьютера, сейчас простаивает, то при средней цене системника в 500 долларов — 375 мы выбрасываем на свалку. Если учесть, что эти 375 мы потратили сразу, то при распределении этой суммы на 4 года эксплуатации, получаем как раз те же 100 долларов в год. Еще, пожалуй, стоит упомянуть, что компьютер, даже когда использует 10% своей мощности, потребляет электричества вовсе не в 10 раз меньше, а всего раза в два. Но не будем крохоборствовать. Ведь 99% людей, у которых есть дома компьютер и высокоскоростной интернет, принадлежат к «золотому миллиарду», так что плюс-минус несколько долларов в месяц большой роли не играют.

Итак, соберем все вместе. 1 гигабайт памяти, полтора ядра на частоте 1.5 — 2 гигагерца, 350 гигов на винте, канал 7 мегабит/сек умножим на пол-миллиарда:

    + 500 петабайт оперативки
    + 750 миллионов ядер
    + 175 000 петабайт дискового пространства
    + 3.5 петабит/сек полосы пропускания
    — 300 Тераватт-часов электричества (около 0,3% мирового потребления электричества)
    — 100 миллиардов долларов в год, из которых 50 мы уже заплатили в момент покупки компьютера


Критически настроенный читатель (а я надеюсь, таких здесь большинство) может потребовать пруфлинки ко всем цифрам в предыдущем абзаце. Я рискнул их не приводить, так как это были бы несколько десятков ссылок на разрозненные куски статистики разной степени достоверности за последние несколько лет, которые сильно засорили бы текст. Для раскрытия темы статьи важен порядок величин, так что особая точность не нужна. Тем не менее, если у кого-то есть готовая достоверная статистика из той же оперы, и она сильно отличается от моих цифр, буду рад её увидеть.

Итак, большая часть этого океана ресурсов остается неиспользованной. Как до неё добраться? Можно ли сделать так, чтобы доступность сайта при резком всплеске посещаемости росла, а не падала, как это происходит в файлообменных сетях? Можно ли создать систему, которая позволяла бы мне отдать часть свободных ресурсов своего компьютера интересному стартапу, чтобы помочь ему встать на ноги? Первые шаги в этом направлении уже делаются, но, как и всякие первые шаги, особо успешными их пока не назовешь. Любые распределенные системы на порядок сложнее централизованных при сопоставимом функционале. Объяснить, что такое гиперссылка на файл, который хранится где-то на сервере, можно даже ребенку. А вот разобраться, как работает DHT, сможет не каждый взрослый.

Фрагменты мозаики

Самая большая проблема, с которой приходится иметь дело при «размазывании» сайта по неопределенному множеству клиентских компьютеров — динамический контент. Распределенное хранение и раздача статических страниц мало чем отличается от раздачи любых других файлов. Вопрос целостности и подлинности страниц решается с помощью хэшей и цифровых подписей. К сожалению, эпоха статических сайтов на чистом HTML закончилась раньше, чем распределенные сети и протоколы созрели и широко распространились. Единственная ниша, где просто нет других альтернатив — анонимные зашифрованные сети сети вроде FreeNet или GNUnet. В них создать нормальный веб-сервер с постоянным адресом невозможно по определению. «Сайты» в этих сетях как раз состоят из наборов статических страниц или сообщений, объединенных в форумы. Кроме того, чем больше трафик шифруется и анонимизируется, тем быстрее полоса пропускания таких сетей стремится к нулю, а время отклика — к бесконечности. Большинство людей не готово терпеть такие неудобства ради анонимности и приватности. Подобные сети остаются уделом гиков, политических диссидентов и всякой нечисти вроде педофилов. Когда я стал писать о приватности, абзац настолько разросся и так сильно выпирал из окружающего текста, что я оформил его отдельным топиком. Так что вот вам лирическое отступление.

Чуть ближе к нашей теме проект Osiris. Он сосредоточен именно на создании распределенных сайтов — «порталов», а не на анонимном файлообмене и сообщениях. Хотя анонимности там тоже хоть отбавляй. Чтобы безответственные анонимусы не загаживали порталы флудом и спамом, используется система учета репутации, которая может работать в «монархическом» режиме — репутацию присваивает владелец портала, и в «анархическом» — в создании репутации участвуют все посетители. Проект относительно молодой, авторы — итальянцы, большая часть документации пока не переведена даже на английский (не говоря уже о русском), так что статья в Википедии, пожалуй, будет посодержательней, чем официальный сайт.

Гораздо интереснее системы распределенного кэширования и CDN. О Coral CDN слышали многие. Хотя распределенная сеть Coral базируется на серверах PlanetLab, а не на пользовательских компьютерах, её архитектура представляет большой интерес. Одна из главных фишек сети — помощь маленьким сайтам в моменты пиковой нагрузки под слэшдот- или хабраэффектом. Достаточно дописать справа от URL ресурса «волшебные слова» .nyud.net, и весь трафик пойдет через Coral. При обращении по ссылке сеть ищет нужный ресурс по хэшу запроса, используя модифицированный вариант DHT — sloppy DHT. Слово «sloppy» означает, что информация о пирах «размывается» по нескольким узлам с близким значением хэша, снижая нагрузку на самый близкий к хэшу ресурса узел (если вы ничего не поняли в последнем предложении, то вот здесь понятным языком изложены основы архитектуры Distributed Hash Table). Кроме того, Coral разбивает таблицу хэшей на кластеры, в зависимости от пинга между узлами, чтобы уменьшить время отклика — ведь если при скачивании фильма можно и подождать минутку, пока DHT найдет достаточно пиров, то при загрузке страницы лишние несколько секунд сильно раздражают. Вот более подробное описание.
";

        $searchEngine = new SearchEngine();
        $begin_time = microtime(true);
        echo "Indexing started: $begin_time\n";

        // Индексирование //
        $index = $searchEngine->makeIndex($content);

        // Засекаем время конца //
        $finish_time = microtime(true);
        echo "Indexing finished: $finish_time\n";

        // Результаты //
        $total_time = $finish_time - $begin_time;
        echo "Total time: $total_time\n";

        //print_r($index);

        echo $searchEngine->search($searchEngine->makeIndex('Самый маленький слон'), $index);


    }

    public function actionTest()
    {
        $worker = new TestWorker();
        $worker->work();
    }
}
