<?php
include("header.php");

if(isset($_POST['submit']))
{
	if(isset($_GET['editid']))
	{
		// UPDATE (NO ICON)
		$sql = "UPDATE category SET 
				category_name='$_POST[category_name]',
				description='$_POST[description]',
				status='$_POST[status]' 
				WHERE category_id='$_GET[editid]'";

		$qsql = mysqli_query($con,$sql);

		if(mysqli_affected_rows($con) == 1)
		{
			echo "<script>alert('Category updated successfully..');</script>";
		}
		else
		{
			echo mysqli_error($con);
		}
	}
	else
	{
		// INSERT (NO ICON)
		$sql = "INSERT INTO category(category_name,description,status) 
				VALUES('$_POST[category_name]','$_POST[description]','$_POST[status]')";

		$qsql = mysqli_query($con,$sql);

		if(mysqli_affected_rows($con) == 1)
		{
			echo "<script>alert('Category inserted successfully..');</script>";
			echo "<script>window.location='category.php';</script>";
		}
		else
		{
			echo mysqli_error($con);
		}
	}
}
?>

<?php
if(isset($_GET['editid']))
{
	$sqledit ="SELECT * FROM category WHERE category_id='$_GET[editid]'";
	$qsqledit = mysqli_query($con,$sqledit);
	$rsedit = mysqli_fetch_array($qsqledit);
}
?>

<!-- breadcrumb -->
<div class="breadcrumb-area bg-gray">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<ul class="breadcrumb-list">
					<li class="breadcrumb-item">Home</li>
					<li class="breadcrumb-item active">Category</li>
				</ul>
			</div>
		</div>
	</div>
</div>

<!-- form -->
<div class="content-wraper mt-10">
<div class="container-fluid">

<div class="checkout-area">
<div class="row">
<div class="col-lg-12">

<div class="row">
<div class="col-lg-12 offset-xl-2 col-xl-8 col-sm-12">

<form method="post" onsubmit="return validateform()">

<div class="checkbox-form checkout-review-order">

<h3>Category</h3>

<!-- CATEGORY NAME -->
<div class="col-lg-12">
<p>
<label>Category Name *</label>
<span class="errormsg" id="errcategory_name"></span>
<input type="text" name="category_name" id="category_name"
class="form-control"
value="<?php echo $rsedit['category_name'] ?? ''; ?>">
</p>
</div>

<!-- DESCRIPTION -->
<div class="col-lg-12">
<p>
<label>Description</label>
<textarea name="description" id="description" class="form-control"><?php echo $rsedit['description'] ?? ''; ?></textarea>
</p>
</div>

<!-- STATUS -->
<div class="col-lg-12">
<p>
<label>Status *</label>
<select name="status" id="status" class="form-control">
<option value="">Select Status</option>

<?php
$arr = array("Active","Inactive");
foreach($arr as $val)
{
	$selected = (isset($rsedit['status']) && $rsedit['status']==$val) ? "selected" : "";
	echo "<option value='$val' $selected>$val</option>";
}
?>

</select>
</p>
</div>

<!-- SUBMIT -->
<div class="col-lg-12">
<p><hr>
<center>
<input type="submit" name="submit" class="form-control" style="width:200px;">
</center>
</p>
</div>

</div>
</form>

</div>
</div>

</div>
</div>
</div>

</div>
</div>

<?php include("footer.php"); ?>

<script>
function validateform()
{
	var alpha = /^[a-zA-Z\s]+$/;
	document.getElementById("errcategory_name").innerHTML = "";

	if(document.getElementById("category_name").value == "")
	{
		document.getElementById("errcategory_name").innerHTML = "Required";
		return false;
	}

	if(!document.getElementById("category_name").value.match(alpha))
	{
		document.getElementById("errcategory_name").innerHTML = "Only letters allowed";
		return false;
	}

	return true;
}
</script>