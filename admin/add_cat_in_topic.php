<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml>
<?php

// Report all PHP errors
error_reporting(-1);

//Include db details and credentials
include('../includes/db.php');
        require('header.php');
		
        $id = mysqli_real_escape_string($db, strip_tags($_GET['id']));
		$topic_id=$id;
		
//Results of Sign up button
        if(isset($_POST['add'])){
//Create counter
                $c=0;
//Prevent sql injections, grab entered variable

                $cat_name = mysqli_real_escape_string($db, strip_tags( $_POST['cat_name']));
                $cat_activate = mysqli_real_escape_string($db, strip_tags( $_POST['cat_activate']));
                $cat_sort =  mysqli_real_escape_string($db, strip_tags( $_POST['cat_sort']));

//Check that no category esists with this title
$tresults = mysqli_query($db, "SELECT name FROM tbl_dept WHERE name='$cat_name'");
        $trow = mysqli_fetch_array($tresults);
        $name_test=$trow['name'];
        if(!empty($name_test)){
                $cat_error="An article with this name already exists.";
                $c++;
        }

//Null variables
                $cs_error=" ";

//Check if entered category is not empty

        if(empty($cat_name)){
                $cat_error="You must specify an category name.";
                $c++;
        }elseif(empty($cat_sort) && $an_sort !== '0'){
                $cs_error="Sort order cannot be empty.";
                $c++;
//If valid insert data
        }else{ if($c==0){
//Enter valid data into DB

        mysqli_query($db, "INSERT INTO tbl_dept (name, sort_order, status, topic) VALUES ('$cat_name', '$cat_sort', '$cat_activate', '$topic_id')");
                mysqli_close($db);
                        header('Location: add_page.php?id='.$topic_id);
        }
        }
        }

        if($_POST['exit']){
                        header('Location: index.php');
                        exit();
                }
?>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<body>
<div class="container ">

 <form method="post" action="<?php echo $PHP_SELF;?>">
        <table border="1" class="table1 well-black">
                        <th><h2>Add a New Category</h2></th>
                </tr>
                <tr>
                <td>
                <table>
                                <tr>
                                <td>New Category Name:<input type="text" name="cat_name" value="<?php echo $cat_name ?>" size="85"><span class="red"><?php echo $cat_error ?></span></td>
                                <td>Sort Order:<input class="textarea_short" type="text" name="cat_sort" value="<?php echo $cat_sort ?>" size="2"><span class="red"><?php echo $cs_error ?></span>
								<input type="checkbox" name="cat_activate" value="1">Activate?</td>
                                </tr>
                                <tr>
                                <td colspan="2">
                                <input type="submit" name="add" value="Add" class="button"/>&nbsp;
                                <input type="submit" name="exit" value="Exit" class="button" />&nbsp;
                                </tr>
                </table>
                </td>
                </tr>
        </table>
        </form>

        </div>
  </div>
</body>
<?php
//Import Footer file
require('footer.html');
?>
</html>
