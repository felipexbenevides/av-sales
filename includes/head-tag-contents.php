<title><?php print $PAGE_TITLE;?></title>

<?php if ($CURRENT_PAGE == "Index") { ?>
	<meta name="description" content="" />
	<meta name="keywords" content="" /> 
<?php } ?>

<?php include("libs.php");?>

<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<style>
	#main-content {
		margin-top:20px;
	}
	.footer {
		font-size: 14px;
		text-align: center;
	}
</style>
<style>
.av-nav ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: #333;
}

.av-nav li {
  float: left;
}

.av-nav li a {
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}
.av-nav .disabled{
  color: #666666;
}


/* Change the link color to #111 (black) on hover */
.av-nav li a:hover {
  color: white;
  background-color: #111;
}

</style>

