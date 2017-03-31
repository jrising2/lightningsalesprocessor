<?php
include('includes/database.php');
include('includes/header.php');
?>

    <?//PHP to generate pagination links
        //database  link
        global $link;
        //Catalog Globals
        $qry; //current search qry by default will qry all items
        $result;  //result of the above qry (may need to be page_results)
        $rows; //a collection of all the rows to be fetched by the result of the qry
        $maxItemCount = 8; //maximum number of items to be displayed in a page
        $totalPages; //Total number of pages given the current search qry

        //Get information from super globals
        $page = (!isset($_GET['page']))? 1 : $_GET['page'];
        $search = (!isset($_GET['search']))? "" : $_GET['search'];

        //Create a offset dependent on the current page
        $offset = (((int) $page) - 1) * $maxItemCount;

        //Query for total number of results
        $qry = "SELECT ProductID, ProductName, Genre, ISBN, Stock, Price, Description FROM Products";
        if ($search != "") $qry = $qry . " WHERE ProductName LIKE '%{$search}%' OR ISBN LIKE '%{$search}%'";
        $total_results = mysqli_query($link, $qry);
        $totalItems = mysqli_num_rows($total_results);
        $totalPages = ceil($totalItems / $maxItemCount);
        $links;  //page links to be generated from searching and pagination
        for ($i = 0; $i < $totalPages; $i++) {
            $links[$i] = 'catalog.php?search=' . $search .'&page=' . ($i + 1);
        }
    ?>

    <?php //PHP to generate catalog body
    $curPage_itemCount;
    $qry = $qry . " LIMIT {$maxItemCount} OFFSET {$offset}";
    $result = mysqli_query($link, $qry);
    $rows = mysqli_fetch_all($result, MYSQLI_BOTH);
    $curPage_itemCount = mysqli_num_rows($result);
    ?>
	<form role="form" method="POST" action="catalog process.php">
        <div class="form-group" role="search">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="input-group dropdown" style="padding-bottom:30px">
                    <label class="sr-only" for="searchcatalog">Search</label>
                    <?php
                    if ($search != "") {
                        echo '<input type="text" class="form-control" name="searchcatalog" placeholder="Search..." value="'. $search . '">';
                    }else {
                       echo '<input type="text" class="form-control" name="searchcatalog" placeholder="Search...">';
                    }
                    ?>
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                    </span>
                </div>
            </div>
        </div>
    </form>
    <div style="text-align:center">
     <?php
    global $rows;
    global $maxItemCount;
    global $result;
    global $curPage;

    $rowCount=0;
    $colCount=0;
    echo '<div class="row" style="padding-left:125px">';
    while($rowCount != $maxItemCount) {
        //if we run out of search result to display before max item count hits exit the loop
        if ($rowCount == $curPage_itemCount){
            if($rowCount != 4) echo '</div>';
            break;
        }
        $row = $rows[$rowCount];
        if($rowCount% 4 == 0){
            echo '<div class="row">';
            $colCount=1;
        }
        // Change ISBN to Price
        //Just a note image/placeholder.jpg will eventually have a reference which grabs the link to the image
       echo "<div class='col-md-3' style='width:250px'><a href='productpage.php?id={$row['ProductID']}'><img src='image/placeholder.jpg' alt='Insert Image here' width='150' height='150'></a><br><br>".
                        "<strong>Title:</strong> {$row['ProductName']} <br>".
                        "<strong>Genre:</strong> {$row['Genre']} <br>".
                        "<strong>ISBN:</strong> {$row['ISBN']} <br>".
                       	"<strong>Price:</strong> $" . "{$row['Price']} <br><br>".
            "</div>";

        if($colCount==4){
            echo "</div>";
        }
        $rowCount++;
        $colCount++;
    }

    echo '<ul class="pagination pagination-lg">';
    for ($i = 0; $i < $totalPages; $i++) {
        if (($i + 1) == $page) {
             echo '<li class="active"><a href=' . $links[$i] . '>' . ($i + 1) . '</a></li>';
        } else {
            echo '<li><a href=' . $links[$i] . '>' . ($i + 1) . '</a></li>';
        }
    }
    echo '</ul>';
    ?>

<?php include('includes/footer.php'); ?>