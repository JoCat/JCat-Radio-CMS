<?php

class Pagination
{
    public static function get($catalog, $rows, $per_page, $cur_page = 1)
    {
        $num_pages = ceil($rows / $per_page);
        if ($num_pages >= 2) {
            $links = '';
            if ($num_pages <= 10) {
                $page = 0;
                $start = $end = false;
                while ($page++ < $num_pages) {
                    if ($page == $cur_page) {
                        $links .= '<li><span><b>' . $page . '</b></span></li>';
                    } else {
                        $links .= '<li><a href="/admin.php?do=' . $catalog . '&page=' . $page . '">' . $page . '</a></li>';
                    }
                }
            } else {
                if ($cur_page > 4 && $cur_page < ($num_pages - 4)) {
                    $min = $cur_page - 4;
                    $max = $cur_page + 4;
                    $start = $end = true;
                } elseif ($cur_page <= 4) {
                    $min = 1;
                    $max = $cur_page + (9 - $cur_page);
                    $start = false;
                    $end = true;
                } else {
                    $min = $cur_page - (8 - ($num_pages - $cur_page));
                    $max = $num_pages;
                    $start = true;
                    $end = false;
                }
                for ($i = $min; $i <= $max; $i++) {
                    if ($i == $cur_page) {
                        $links .= '<li><span><b>' . $i . '</b></span></li>';
                    } else {
                        $links .= '<li><a href="/admin.php?do=' . $catalog . '&page=' . $i . '">' . $i . '</a></li>';
                    }
                }
            }

            if ($start) {
                $prev = '<li>
                  <a href="/admin.php?do=' . $catalog . '&page=1" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                  </a>
                </li>';
            } else {
                $prev = '<li class="disabled">
                  <span>
                    <span aria-hidden="true">&laquo;</span>
                  </span>
                </li>';
            }

            if ($end) {
                $next = '<li>
                  <a href="/admin.php?do=' . $catalog . '&page=' . $num_pages . '" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                  </a>
                </li>';
            } else {
                $next = '<li class="disabled">
                  <span>
                    <span aria-hidden="true">&raquo;</span>
                  </span>
                </li>';
            }


            return [
                'content' => '<nav aria-label="Page navigation">
                  <ul class="pagination">
                    ' . $prev . '
                    ' . $links . '
                    ' . $next . '
                  </ul>
                </nav>',
                'num_pages' => $num_pages
            ];
        }
    }
}
