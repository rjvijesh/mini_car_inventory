<?php
	if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
		$uri = 'https://';
	} else {
		$uri = 'http://';
	}
	$uri .= $_SERVER['HTTP_HOST'].'/';
?>
<head>
	<meta name="csrf-token" content="XYZ123">
	<script src="js/jquery_1_11_1.min.js" type="text/javascript"></script>
	<link rel="stylesheet" href="css/demo.css">
	<script>
	var siteUrl='<?php echo $uri;?>';
	</script>
	<?php  $siteUrl = $uri; ?>
	
	<div class="nav">
      <ul id="header">
        <li><a class="add_manufacturer active" href="<?php echo $siteUrl.'/car_inventory/add_manufacturer.php'?>">Add manufacturer</a></li>
        <li><a class="add_car_model" href="<?php echo $siteUrl.'/car_inventory/add_car_model.php'?>">Add Car Model</a></li>
        <li><a class="view_inventory" href="<?php echo $siteUrl.'/car_inventory/view_inventory.php'?>">View Inventory</a></li>
      </ul>
    </div>
	<style>
  body {
  margin: 0;
  padding: 0;
  background: #ccc;
}
 
.nav ul {
  list-style: none;
  background-color: #444;
  text-align: center;
  padding: 0;
  margin: 0;
}
.nav li {
  font-family: 'Oswald', sans-serif;
  font-size: 1.2em;
  line-height: 40px;
  height: 40px;
  border-bottom: 1px solid #888;
}
 
.nav a {
  text-decoration: none;
  color: #fff;
  display: block;
  transition: .3s background-color;
}
 
.nav a:hover {
  background-color: #005f5f;
}
 
.nav a.active {
  background-color: #fff;
  color: #444;
  cursor: default;
}
 
@media screen and (min-width: 600px) {
  .nav li {
    width: 200px;
    border-bottom: none;
    height: 50px;
    line-height: 50px;
    font-size: 1.1em;
  }
 
  /* Option 1 - Display Inline */
  .nav li {
    display: inline-block;
    margin-right: -4px;
  }
 
  /* Options 2 - Float
  .nav li {
    float: left;
  }
  .nav ul {
    overflow: auto;
    width: 600px;
    margin: 0 auto;
  }
  .nav {
    background-color: #444;
  }
  */
}
VIEW RESOURCES
  </style>
</head>
