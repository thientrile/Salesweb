<?php
class pagination
{
    function PagingLink($pageNumber)
    {


        // Get the current page number if it's been set in the URL


        // Get the current URL
        $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        // Parse the URL
        $parsedUrl = parse_url($url);

        // Extract the query string
        $query = isset($parsedUrl['query']) ? $parsedUrl['query'] : '';

        // Parse the query string into an array
        parse_str($query, $queryArray);

        // Update the value of the page parameter
        $queryArray['page'] = $pageNumber;

        // Rebuild the query string
        $newQuery = http_build_query($queryArray);
        $parsedUrl['host'] = "localhost:7000";

        $newUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'] . $parsedUrl['path'] . '?' . $newQuery;
        echo $newUrl;
    }
   
    function renderPaging($currentPage, $totalPages, $pagesToShow)
    {
        $start = max(1, $currentPage - floor($pagesToShow / 2));
        $end = min($totalPages, $start + $pagesToShow - 1);
        $start = max(1, $end - $pagesToShow + 1);
?>
        <ul class="pagination justify-content-center my-1">
            <?php if ($currentPage > 1) { ?>
                <li class="page-item"><a class="page-link" href="<?php $this->PagingLink($currentPage - 1) ?>">Previous</a></li><?php }
                                                                                                                            for ($i = $start; $i <= $end; $i++) {
                                                                                                                                ?>

                <li class="page-item <?php echo $i == $currentPage ? 'active' : ''; ?>"><a class="page-link" href="<?php $this->PagingLink($i) ?>"><?php echo $i ?></a></li>

            <?php }
                                                                                                                            if ($currentPage < $totalPages) { ?>
                <li class="page-item"><a class="page-link" href="<?php $this->PagingLink($currentPage + 1) ?>">Next</a></li><?php } ?>
        </ul>

<?php
    }
} ?>