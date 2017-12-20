<?php
include "../includes/database.php";
include "includes/employee_header.php";
?>

        <?//PHP to generate pagination links
            //database  link
            global $link;
            //Catalog Globals
            $qry; //current search qry by default will qry all items
            $result;  //result of the above qry (may need to be page_results)
            $rows; //a collection of all the rows to be fetched by the result of the qry
            $maxItemCount = 50; //maximum number of items to be displayed in a page
            $totalPages; //Total number of pages given the current search qry

			//Get current employee role
            $ROLE;
            $temp = mysqli_query($link, "SELECT Role FROM Employees WHERE EmployeeID={$_SESSION['eid']}");
            if (mysqli_num_rows($temp) > 0) {
                $r = mysqli_fetch_assoc($temp);
                $ROLE = $r['Role'];
            }
			
            //Get information from super globals
            $page = (!isset($_GET['page']))? 1 : $_GET['page'];
            $search = (!isset($_GET['search']))? "" : $_GET['search'];

            //Create a offset dependent on the current page
            $offset = (((int) $page) - 1) * $maxItemCount;

            //Query for total number of results
            $qry = "SELECT ProductID, ProductName, Genre, ISBN, Stock FROM Products";

            //check for filters
            $myfilter = $_GET['filter'];
            if ($myfilter == '1') {
                $qry = $qry . " WHERE Genre LIKE '%{$search}%'";
            } else if ($myfilter == '2') {
                 $qry = $qry . " WHERE Author LIKE '%{$search}%'";
            } else if ($myfilter == '3') {
                $qry = $qry . " WHERE Stock={$search}";
            }else {
                //no filters
                $qry = $qry . " WHERE ProductName LIKE '%{$search}%' OR ISBN LIKE '%{$search}%' OR Genre LIKE '%{$search}%' OR ProductID LIKE '%{$search}%'";
            }

            //check order
            $myOrder = $_GET['order'];
            if ($myOrder == 'SLH') {
                if ($myfilter != '3') $qry = $qry . " ORDER BY Stock ASC";
            } else if ($myOrder == 'SHL') {
                 if ($myfilter != '3') $qry = $qry . " ORDER BY Stock DESC";
            } else if ($myOrder == 'GAZ') {
                $qry = $qry . " ORDER BY Genre ASC";
            } else if ($myOrder == 'GZA') {
                $qry = $qry . " ORDER BY Genre DESC";
            } else if ($myOrder == 'IAS') {
                $qry = $qry . " ORDER BY ISBN ASC";
            } else if ($myOrder == 'IDS') {
                $qry = $qry . " ORDER BY ISBN DESC";
            } else if ($myOrder == 'TAS') {
                $qry = $qry . " ORDER BY ProductName ASC";
            } else if ($myOrder == 'TDS') {
                $qry = $qry . " ORDER BY ProductName DESC";
            }

            $total_results = mysqli_query($link, $qry);
            $totalItems = mysqli_num_rows($total_results);
            $totalPages = ceil($totalItems / $maxItemCount);
            $links;  //page links to be generated from searching and pagination
            for ($i = 0; $i < $totalPages; $i++) {
                $links[$i] = 'inventory.php?search=' . $search .'&page=' . ($i + 1);
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
        <form role="form" method="POST" action="inventory_process.php">
            <div class="form-group tight-form-group" role="search">
                <div class="col-md-8">
                    <div class="input-group dropdown" style="padding-bottom:30px">
                        <div class="input-group-addon">
                            <select class="custom-select" name="filters">
                                <?php
                                echo '<option value="">Search Filter</option>';
                                if ($myfilter == '1') {
                                    echo '<option value="1" selected>Genre</option>';
                                } else {
                                    echo '<option value="1">Genre</option>';
                                }
                                if ($myfilter == '2') {
                                    echo '<option value="2" selected>Author</option>';
                                }else {
                                   echo '<option value="2">Author</option>';
                                }
                                if ($myfilter == '3') {
                                     echo '<option value="3" selected>Stock</option>';
                                } else{
                                    echo '<option value="3">Stock</option>';
                                }
                                ?>
                            </select>
                        </div>
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
                <label for="order" class="col-md-2 col-form-label">Search Order</label>
                <div class="col-md-2" style="padding-bottom:30px">
                    <select type="text" class="col-md-2 form-control" name="order">
                        <?php
                         echo '<option value=""></option>';
                         if ($myOrder == 'TAS') {
                            echo '<option value="TAS">Book Title: A-Z</option>';
                         } else {
                             echo '<option value="TAS" selected>Book Title: A-Z</option>';
                         }
                         if ($myOrder == 'TDS') {
                            echo '<option value="TDS" selected>Book Title: Z-A</option>';
                         } else {
                              echo '<option value="TDS">Book Title: Z-A</option>';
                         }
                         if ($myOrder == 'SLH') {
                            echo '<option value="SLH" selected>Stock: Low to High</option>';
                         }else {
                             echo '<option value="SLH">Stock: Low to High</option>';
                         }
                         if ($myOrder =='SHL') {
                            echo '<option value="SHL"selected>Stock: High to Low</option>';
                         } else {
                             echo '<option value="SHL">Stock: High to Low</option>';
                         }
                         if ($myOrder == 'GAZ') {
                            echo '<option value="GAZ"selected>Genre: A - Z</option>';
                         }else{
                            echo '<option value="GAZ">Genre: A - Z</option>';
                         }
                         if ($myOrder == 'GZA') {
                            echo '<option value="GZA" selected>Genre: Z - A</option>';
                         }else {
                            echo '<option value="GZA">Genre: Z - A</option>';
                         }
                         if ($myOrder == 'IAS') {
                            echo '<option value="IAS" selected>ISBN: Ascending</option>';
                         }else {
                            echo '<option value="IAS">ISBN: Ascending</option>';
                         }
                         if ($myOrder == 'IDS') {
                            echo '<option value="IDS" selected>ISBN: Descending</option>';
                         }else {
                            echo '<option value="IDS">ISBN: Descending</option>';
                         }
                         ?>
                    </select>
                </div>
            </div>
        </form>
        </div>
        <div style="text-align:center">
        <div class="row">
            <!--Main inventory view section-->
            <div class="col-md-10">
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
						if (($ROLE == '1') || ($ROLE == '2')) {
							echo "<a href='managebooks.php?product={$row['ProductID']}' class='list-group-item'>";
						} else {
							echo "<div class='list-group-item'>";
						}
    					echo "<div class='row'>
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
							</div>";
    					if (($ROLE == '1') || ($ROLE == '2')) {
							echo "</a>";
						}else {
							echo "</div>";
						}
						$count++;
					}
                ?>
                </div>
            </div>
        </div>

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
        <!--This closes the employee header-->
<?php
include('includes/footer_empty.php');
?>>