<?php
include "includes/database.php";
include "includes/header.php";
?>

        <?//PHP to generate pagination links
            //database  link
            global $link;
            //Catalog Globals
            $qry; //current search qry by default will qry all items
            $result;  //result of the above qry (may need to be page_results)
            $rows; //a collection of all the rows to be fetched by the result of the qry
            $maxItemCount = 4; //maximum number of items to be displayed in a page
            $totalPages; //Total number of pages given the current search qry


            //Get information from super globals
            $page = (!isset($_GET['page']))? 1 : $_GET['page'];
            $search = (!isset($_GET['search']))? "" : $_GET['search'];

            //Create a offset dependent on the current page
            $offset = (((int) $page) - 1) * $maxItemCount;

            //Query for total number of results
            $qry = "SELECT ProductID, ProductName, Genre, ISBN, Stock FROM Products";
            if ($search != "") $qry = $qry . " WHERE ProductName LIKE '%{$search}%' OR ISBN LIKE '%{$search}%' OR Genre LIKE '%{$search}%' OR ProductID LIKE '%{$search}%'";
            $total_results = mysqli_query($link, $qry);
            $totalItems = mysqli_num_rows($total_results);
            $totalPages = ceil($totalItems / $maxItemCount);
            $links;  //page links to be generated from searching and pagination
            for ($i = 0; $i < $totalPages; $i++) {
                $links[$i] = 'Inventory.php?search=' . $search .'&page=' . ($i + 1);
            }
        ?>
         <?php //PHP to generate catalog body
            $curPage_itemCount;
            $qry = $qry . " LIMIT {$maxItemCount} OFFSET {$offset}";
            $result = mysqli_query($link, $qry);
            $rows = mysqli_fetch_all($result, MYSQLI_BOTH);
            $curPage_itemCount = mysqli_num_rows($result);
        ?>
        <div class="row">
        <form role="form" method="POST" action="inventory process.php">
            <div class="form-group" role="search">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="input-group dropdown" style="padding-bottom:30px">
                        <label class="sr-only" for="searchinventory">Search</label>
                        <?php
                        if ($search != "") {
                            echo '<input type="text" class="form-control" name="searchinventory" placeholder="Search..." value="'. $search . '">';
                        }else {
                           echo '<input type="text" class="form-control" name="searchinventory" placeholder="Search...">';
                        }
                        ?>
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                        </span>
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>
        </form>
        </div>
        <div style="text-align:center">
        <?php echo '<div class="row">'; ?>
          <div class="list-group" style="height:700px;overflow-x:hidden;overflow-y:auto">
            <!--Each item in the list will act as a link to the product page-->
            <!--Multiple items here are for example this html will be populated programatically-->
            <div class="list-group-item">
                <div class="row">
                    <div class="col-md-2">
                        <p style="font-weight:bold">Product ID</p>
                    </div>
                    <div class="col-md-2">
                        <p style="font-weight:bold">Product Name</p>
                    </div>
                    <div class="col-md-2">
                        <p style="font-weight:bold">Genre</p>
                    </div>
                    <div class="col-md-2">
                        <p style="font-weight:bold">ISBN</p>
                    </div>
                    <div class="col-md-2">
                        <p style="font-weight:bold">Current Stock</p>
                    </div>
                </div>
            </div>
            <?php
                $count=0;
                while ($count != $maxItemCount) {
                    if ($count == $curPage_itemCount){
                        break;
                    }
                    $row = $rows[$count];
                    echo "<a href='add_edit.php?ProductID={$row['ProductID']}' class='list-group-item'>
                            <div class='row'>
                                <div class='col-md-2'>
                                    <p>{$row['ProductID']}</p>
                                </div>
                                <div class='col-md-2'>
                                    <p>{$row['ProductName']}</p>
                                </div>
                                <div class='col-md-2'>
                                    <p>{$row['Genre']}</p>
                                </div>
                                <div class='col-md-2'>
                                    <p>{$row['ISBN']}</p>
                                </div>
                                <div class='col-md-2'>
                                    <p>x{$row['Stock']}</p>
                                </div>
                            </div>
                        </a>";
                        $count++;
                }
                ?>
        </div>
        <?php echo '</div>'; ?>

        <?php
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


<?php
include_once "includes/footer.php";
?>
