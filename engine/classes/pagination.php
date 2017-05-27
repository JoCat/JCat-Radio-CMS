<?php
/**
* 
*/
class Pagination
{
    public static function getPagination($catalog, $rows, $per_page, $cur_page = 1)
    {
        $num_pages = ceil($rows/$per_page);
        if ($num_pages >= 2){
            $page = 0;
            $link = '';
            while ($page++ < $num_pages)
            {
                if ($page == $cur_page) {
                    $link .= '<span><b>'.$page.'</b></span>';
                }
                else {
                    $link .= '<span><a href="/admin.php?do='.$catalog.'&page='.$page.'/">'.$page.'</a></span>';
                }
            }
            return '<div class="navigation">'.$link.'</div>';
        }
    }
}
?>