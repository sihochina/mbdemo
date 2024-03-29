<html>
<head>
	<title>Master Builder Demo!</title>
	<link href='//fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
	<style>
	body {
		background-color: white;
		text-align: center;
		padding: 50px;
		font-family: "Open Sans","Helvetica Neue",Helvetica,Arial,sans-serif;
	}

	#logo {
		margin-bottom: 40px;
	}
	</style>
</head>
<body>
  <?php
    $instance_id = @file_get_contents("http://instance-data/latest/meta-data/instance-id");
    $zone = @file_get_contents("http://169.254.169.254/latest/meta-data/placement/availability-zone");
    $private_id = @file_get_contents("http://instance-data/latest/meta-data/local-ipv4");
  ?>
	<img id="logo" src="logo.png" />
	<h1>This is my Master Builder Demo!</h1>
	<h1>Version 3</h1>
	<h2>EC2 Instance ID: <?php echo $instance_id; ?></h2>
	<h2>EC2 Zone: <?php echo $zone; ?></h2>
	<h2>EC2 Private IP: <?php echo $private_id; ?></h2>
	<?php
	$links = [];
	foreach($_ENV as $key => $value) {
		if(preg_match("/^(.*)_PORT_([0-9]*)_(TCP|UDP)$/", $key, $matches)) {
			$links[] = [
				"name" => $matches[1],
				"port" => $matches[2],
				"proto" => $matches[3],
				"value" => $value
			];
		}
	}
	if($links) {
	?>
		<h3>Links found</h3>
		<?php
		foreach($links as $link) {
			?>
			<b><?php echo $link["name"]; ?></b> listening in <?php echo $link["port"]+"/"+$link["proto"]; ?> available at <?php echo $link["value"]; ?><br />
			<?php
		}
		?>
	<?php
	}

	if($_ENV["DOCKERCLOUD_AUTH"]) {
		?>
		<h3>I have Docker Cloud API powers!</h3>
		<?php
	}
	?>
</body>
</html>
