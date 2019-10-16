<?php
// variables
$xfwd     = mm_strip($_SERVER["HTTP_X_FORWARDED_FOR"]);
$address  = mm_strip($_SERVER["REMOTE_ADDR"]);
$port     = mm_strip($_SERVER["REMOTE_PORT"]);
$method   = mm_strip($_SERVER["REQUEST_METHOD"]);
$protocol = mm_strip($_SERVER["SERVER_PROTOCOL"]);
$agent    = mm_strip($_SERVER["HTTP_USER_AGENT"]);
if ($xfwd !== '') {
	$IP = $xfwd;
	$proxy = $address;
	$host = @gethostbyaddr($xfwd);
} else {
	$IP = $address;
	$host = @gethostbyaddr($address);
}
// sanitizes
function mm_strip($string) {
	$string = trim($string);
	$string = strip_tags($string);
	$string = htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
	$string = str_replace("\n", "", $string);
	$string = trim($string);
	return $string;
}
?>
<!DOCTYPE html>
<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="author" content="Jason Mcgwier">
	<title>What's my IP?</title>
	<style type="text/css">
		* { margin:0; padding:0; }
		body { background:#ededed; color:#777; margin-top:50px; }
		.tools { margin:25px auto; width:960px auto; }
		.tools p {
			margin-left:20px; color:#DB4437; font-family: Trebuchet MS;
			}
		#ip-lookup {
			border:1px solid #ededed;
			background: #fff;
			}
		#tools p { font-size:60px; }
		#more p  { font-size:24px; }
		#more-info p { font-size:18px; }
		#more-info ul { margin:20px 0 35px 50px; font-size:18px; color:#626567;list-style-type: none;}
		#more-info li { margin:10px 0; line-height:25px; font-family:Helvetica, Arial; }
		h1 {
			font: 100px/1 Helvetica, Arial; text-align:center; margin:50px 0; color:#4285F4;
			}
		h1 a:link { color:#efefef; }
		a:link,a:visited {
			color:#F4B400; text-decoration:none; outline:0 none;
			}
		a:hover,a:active { color:#999; text-decoration:underline; outline:0 none; }
		li span {
			font:16px/1 Monaco,"Panic Sans","Lucida Console","Courier New",Courier,monospace,sans-serif; color:#545454;
			}
	</style>
	<body>
		<div id="tools" class="tools">
			<p>Your IP:</p>
		</div>
		<div id="ip-lookup" class="tools">
			<h1><?php echo $IP; ?></h1>
		</div>
		<div id="more" class="tools">
			<p><a id="more-link" title="More information" href="javascript:toggle();">More info</a></p>
		</div>
		<div id="more-info" class="tools">
			<ul>
			<?php
				echo '<li><strong>Remote Port:</strong> <span>'.$port.'</span></li>';
				echo '<li><strong>Request Method:</strong> <span>'.$method.'</span></li>';
				echo '<li><strong>Server Protocol:</strong> <span>'.$protocol.'</span></li>';
				echo '<li><strong>Server Host:</strong> <span>'.$host.'</span></li>';
				echo '<li><strong>User Agent:</strong> <span>'.$agent.'</span></li>';
				if ($proxy) echo '<li><strong>Proxy: <span>'.($proxy) ? $proxy : ''.'</span></li>';
				$time_start = microtime(true);
				usleep(100);
				$time_end = microtime(true);
				$time = $time_end - $time_start;
			?>
			</ul>
			<p><small>It took <?php echo $time; ?> seconds to share this info.</small></p>
		</div>
		<script type="text/javascript">
			function hideStuff(){
				if (document.getElementById){
					var x = document.getElementById('more-info');
					x.style.display="none";
				}
			}
			function toggle(){
				if (document.getElementById){
					var x = document.getElementById('more-info');
					var y = document.getElementById('more-link');
					if (x.style.display == "none"){
						x.style.display = "";
						y.innerHTML = "Less info";
					} else {
						x.style.display = "none";
						y.innerHTML = "More info";
					}
				}
			}
			window.onload = hideStuff;
		</script>
	</body>
</html>
