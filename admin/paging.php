<?php
    echo "<ul class='pagination'>";

    // First page (Button): 
    if($page>1) {
        
        echo "<li><a href='{$page_url}' title='Go to the first page.'>";
            echo "First";
        echo "</a></li>";
    }

    // Calc total pages: 
    $total_pages = ceil($total_rows / $records_per_page);

    // Diplay number of links: 
    $range = 2;
    $initial_num = $page - $range;
    $condition_limit_num = ($page + $range)  + 1;

    for ($x=$initial_num; $x<$condition_limit_num; $x++) {
        
        if (($x > 0) && ($x <= $total_pages)) {

            // Current page: 
            if ($x == $page) {
                
                echo "<li class='active'><a href=\"#\">$x <span class=\"sr-only\">(current)</span></a></li>";
            } 

            else {
                
                echo "<li><a href='{$page_url}page=$x'>$x</a></li>";
            }
        }
    }

    // Last page (button): 
    if($page<$total_pages) {
        
        echo "<li><a href='" .$page_url. "page={$total_pages}' title='Last page is {$total_pages}.'>";
            echo "Last";
        echo "</a></li>";
    }

    echo "</ul>";
?>
