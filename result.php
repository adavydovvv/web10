<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@300&display=swap" rel="stylesheet">
    <title>Давыдов Артём Сергеевич 221-362 - Лабораторная работа №10</title>   
</head>

<body>
    <header>
        <img src="mospolytech_logo_white.png" alt="Логотип">
    </header>
    <main>
    <?php
    if (isset($_POST['data']) && $_POST['data']) {
        echo '<div class="src_text">' . htmlspecialchars($_POST['data']) . '</div>';
        analyze_text($_POST['data']);
    } else {
        echo '<div class="src_error">Нет текста для анализа</div>';
    }

    function analyze_text($text)
    {
        // Количество символов в тексте
        $chars_count = mb_strlen($text);

        // Количество букв
        $letters_count = preg_match_all('/\p{L}/u', $text, $matches);

        // Количество строчных и заглавных букв
        preg_match_all('/\p{Ll}/u', $text, $lowercase_matches);
        preg_match_all('/\p{Lu}/u', $text, $uppercase_matches);
        $lowercase_letters = count($lowercase_matches[0]);
        $uppercase_letters = count($uppercase_matches[0]);

        // Количество знаков препинания
        $punctuation_count = preg_match_all('/[\p{P}\p{S}]/u', $text, $matches);

        // Количество цифр
        $digits_count = preg_match_all('/\p{N}/u', $text, $matches);

        // Количество слов
        $words = preg_split('/\s+/u', $text, -1, PREG_SPLIT_NO_EMPTY);
        $words_count = count($words);

        // Подсчет вхождений каждого символа текста (без различия верхнего и нижнего регистров)
        $text_lower = mb_strtolower($text, 'UTF-8');
        $chars_count_case_insensitive = array_count_values(preg_split('//u', $text_lower, -1, PREG_SPLIT_NO_EMPTY));
        ksort($chars_count_case_insensitive);

        // Вывод списка всех слов и их количество вхождений, отсортированный по алфавиту
        $word_counts = array_count_values($words);
        ksort($word_counts);

        echo '<table border="1">';
        echo '<tr><td>Количество символов:</td><td>' . $chars_count . '</td></tr>';
        echo '<tr><td>Количество букв:</td><td>' . $letters_count . '</td></tr>';
        echo '<tr><td>Количество строчных букв:</td><td>' . $lowercase_letters . '</td></tr>';
        echo '<tr><td>Количество заглавных букв:</td><td>' . $uppercase_letters . '</td></tr>';
        echo '<tr><td>Количество знаков препинания:</td><td>' . $punctuation_count . '</td></tr>';
        echo '<tr><td>Количество цифр:</td><td>' . $digits_count . '</td></tr>';
        echo '<tr><td>Количество слов:</td><td>' . $words_count . '</td></tr>';

        // Вывод количества вхождений каждого символа текста без учета регистра
        echo '<tr><td colspan="2">Количество вхождений каждого символа текста (без различия регистра):</td></tr>';
        foreach ($chars_count_case_insensitive as $char => $count) {
            echo '<tr><td>' . htmlspecialchars($char) . '</td><td>' . $count . '</td></tr>';
        }

        // Вывод списка всех слов и их количество вхождений, отсортированный по алфавиту
        echo '<tr><td colspan="2">Список слов и их количество вхождений (отсортировано по алфавиту):</td></tr>';
        foreach ($word_counts as $word => $count) {
            echo '<tr><td>' . htmlspecialchars($word) . '</td><td>' . $count . '</td></tr>';
        }

        echo '</table>';
    }
    ?>
    <a href="index.html">Другой анализ</a>
</main>



<footer></footer>
</body>
</html>
