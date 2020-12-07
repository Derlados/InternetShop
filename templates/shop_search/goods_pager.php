<div class="goods_pager">
    <a <?php echo $backPageHref?>>
        <img class="pager_arrow" src="/Images/Site/pager_arrow_back.png">
    </a>
    <div class="pages_numbers">
        <?php
            $pagerValues = getPagesArray($currentPage, $maxPages); // Получение массива значений для pager-а

            for ($i = 0; $i < count($pagerValues); ++$i) {
                // Если элемент это "..." ссылка не создается
                if ($pagerValues[$i] != "...")
                    $href = str_replace('{page}', $pagerValues[$i], $hrefTemplate);
                else
                    $href = '';   
                
                // Если страница в pager-е соответствует текущей - она принимает стиль активной
                $styleA = '';
                if ($pagerValues[$i] == strval($currentPage))
                    $styleA = "active";

                echo '<a '.$href.' class="'.$styleA.'">
                        <span><b>'.$pagerValues[$i].'</b></span>
                      </a>';
            }

            /** Создание массива єлементов для pager-а внизу списка товаров
             * @param currentPage - текущая страница
             * @param maxPages - максимальное количество страниц
             * @return pagerArray - массив элементов для pager-а
             */
            function getPagesArray($currentPage, $maxPages) {

                $pagesArray = array();
                    
                // Если страниц меньше десяти в pager вносится просто последовательность от 1 до 9
                if ($maxPages < 10) {
                    for ($i = 0; $i < $maxPages; ++$i)
                        $pagesArray[$i] = strval($i + 1);
                    return $pagesArray;
                }
                    
                // Определение левой части pager-а (до последних двух єлементов)
                if ($currentPage < 6) 
                    for ($i = 0; $i <= 6; ++$i)
                        $pagesArray[$i] = strval($i + 1);
                else {
                    $pagesArray[0] = "1";
                    $pagesArray[1] = "...";

                    $iter = 2;
                    for ($i = 2; $i >= -2; --$i) {
                        $pagesArray[$iter] = strval($currentPage - $i);
                        ++$iter;
                    }
                }

                $pagesArray[7] = ($maxPages - $currentPage > 4) ? "..." : $maxPages - 1;
                $pagesArray[8] = strval($maxPages);
                return $pagesArray;
            }
        ?>
    </div>
    <a <?php echo $nextPageHref?>>
        <img class="pager_arrow" src="/Images/Site/pager_arrow_next.png">
    </a>
</div>