<title><?php print $PAGE_TITLE;?></title>

<?php if ($CURRENT_PAGE == "Index") { ?>
	<meta name="description" content="" />
	<meta name="keywords" content="" /> 
<?php } ?>

<link rel="stylesheet" type="text/css" media="screen" href="css/av.css" />
<script src="js/app.js" type="text/javascript"></script>

<!-- <script src="http://192.168.1.7/av-sales/external/"></script> -->
<!-- <link rel="stylesheet" type="text/css" href="http://192.168.1.7/av-sales/external/"> -->

<!-- JQUERY -->
<!-- <script src="http://192.168.1.7/av-sales/external/jquery/jquery-3.5.0.min.js"></script> -->
<!-- JQGRID -->

<link rel="stylesheet" type="text/css" media="screen" href="css/ui.jqgrid.css" />
 
<script src="js/jquery-3.5.0.min.js" type="text/javascript"></script>
<script src="js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="js/jquery.jqGrid.min.js" type="text/javascript"></script>

<!-- JQUERY UI -->
<link rel="stylesheet" type="text/css" href="external/jquery-ui/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="external/jquery-ui/jquery-ui.structure.css">
<link rel="stylesheet" type="text/css" href="external/jquery-ui/jquery-ui.theme.css">
<script src="external/jquery-ui/jquery-ui.js"></script>
<?php include("libs.php");?>

<style>
*{
  font-family: 'Courier New', Courier, monospace !important;
}
.grid-container {
  display: grid;
  grid-template-columns: auto auto auto;
  /* background-color: #2196F3; */
  /* padding: 10px; */
  grid-gap: 10px 10px;
}
.grid-item {
  /* background-color: rgba(255, 255, 255, 0.8); */
  /* border: 1px dashed rgba(0, 0, 0, 0.8); */
  /* padding: 20px; */
  /* font-size: 30px; */
  text-align: center;
  font-size: 0.8em;
  font-family: 'Courier New', Courier, monospace;
}
</style>

<!-- <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"> -->
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
html, body {
    height: 100%;
    width: 100%;

}
input{
  margin: 5px 0px;
  padding:2px 0px;
}
</style>

