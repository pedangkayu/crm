<!doctype html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Not Installed</title>
	<style>
		body {
			background-image: url(https://cdn.dribbble.com/users/40756/screenshots/3994534/artboard_16.png);
			background-origin: content-box;
			background-repeat: no-repeat;
			background-position: top;
			background-size: unset;
			-webkit-background-clip: border-box;
		}
		
		.installDiv {
			width: 100%;
			text-align: center;
			position: absolute;
			bottom: 70px;
		}
		
		h4.intallTitle {
			font-size: 22px;
			color: #5d6ec0;
			font-family: "Haas Grot Text R Web", "Helvetica Neue", Helvetica, Arial, sans-serif;
			-webkit-font-smoothing: antialiased;
			line-height: 0px;
		}
		
		span.installDetail {
			font-family: "Haas Grot Text R Web", "Helvetica Neue", Helvetica, Arial, sans-serif;
			color: #999;
			font-size: 12px;
		}
		
		a.installButton {
			display: inline-block;
			padding: 10px 15px 11px;
			font-family: "Haas Grot Text R Web", "Helvetica Neue", Helvetica, Arial, sans-serif;
			font-size: 13px;
			font-weight: 500;
			line-height: 17px;
			letter-spacing: .02em;
			vertical-align: middle;
			cursor: pointer;
			border: none;
			text-decoration: none;
			background: #ffd47c;
			border-radius: 4px;
			-webkit-appearance: none;
			appearance: none;
			position: relative;
			margin-top: 10px;
		}
	</style>
</head>

<body>
	<div class="installDiv">
		<h4 class="intallTitle">CRM Not Installed</h4>
		<span class="installDetail">To you use the automatic CRM CRM installation tool click the Install button</span><br>
		<a class="installButton" href="<?php echo $install_url ?>">Install Now</a>
	</div>
</body>

</html>