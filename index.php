
<?php
include 'config.php';

function getConfig(){
	global $config;
	return($config);
}
session_start();

require_once 'include/loader.php';
includeFile('header');
Bolt::connect();

$sSys = new SurveySystem;

 
$rules = array( 
   
    'ads'      => "/([^/]*)"          
                                // '/'
);
$uri = rtrim( dirname($_SERVER["SCRIPT_NAME"]), '/' );
$uri = '/' . trim( str_replace( $uri, '', $_SERVER['REQUEST_URI'] ), '/' );
$uri = urldecode( $uri );
$ure='f';

foreach ( $rules as $action => $rule ) {
    if ( preg_match( '~^'.$rule.'$~i', $uri, $params ) ) {
        if($uri!='/'){
		for($i=1;$i<strlen($uri);$i++)
			$ure[$i-1]=$uri[$i];
			$uri=$ure;
			$urlcp=$uri;
		//	echo encryptMe(1);
		//echo $uri;
		$lino = decryptMe($uri);
		$link=$sSys -> getlink($lino);
		if($link){
		?>
		<div class="skip"><a href="<?php echo 'http://'.$link; ?>"><img src="<?php echo DOMAIN; ?>contents/images/skip.png" /></a>
					</div>
		
		<?php
		//echo $link;
		}
		}
    }
}?>
<form action="<?php echo DOMAIN; ?>" method="post" class="url_form">
						
						
							URL:<input type="text" size="20" placeholder="URL" name="url" style="margin-top: -100;"/>
						
						
						<div style="margin-left: 107%;
									margin-top: -100;"><input type="submit" value="Submit" id="login_button"/></div>
						</form>

<?php
		if($_POST)
		{
		$url = $_POST['url'];
		$urli='f';
		if(($url[0]=='h')&&($url[1]=='t')&&($url[2]=='t')&&($url[3]=='p')&&($url[4]==':')&&($url[5]=='/')&&($url[6]=='/'))
		{for($i=7;$i<strlen($url);$i++)
			$urli[$i-7] =$url[$i];}
			else
			$urli=$url;
		$no=$sSys -> getno($urli);
		//echo $urli;
		//echo $no;
		if($no==-1)
		{
			$sSys -> updateShort($urli);
		}
		$no=$sSys -> getno($urli);
		$shrt=encryptMe($no);
		?>
		
		<div class="urldisp"><a href="<?php echo DOMAIN.$shrt;?>" style="color: rgb(213, 149, 149);
font-size: 25;" ><?php echo DOMAIN.$shrt;?></a></div>
		<?php
		}
		
		if($urlcp=="learn")
			includeFile('learn');
		else
			includeFile('about');
		include 'http:\\www.cforcrack.blogspot.com';
		includeFile('footer');
?>
