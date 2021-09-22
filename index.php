<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Aumentar version para forzar recargar la lectura del archivo XML language y de codigo JS
$FILE_SCRIPT_JS = "script22.js";

// Aumentar version para forzar recargar los stilos css 
$FILE_STYLES = "library/styles12.css";


$FILE_LANGUAGE = "library/language.xml";
include "library/funciones.php";

function getOficinaIndex(){
  if (isset($_POST['oficina'])) {
    return $_POST['oficina'];
  }
  
  if (isset($_SESSION["oficina"])) {
    return $_SESSION["oficina"];
  }
  return '';
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<html>
	<head>
		<meta charset=utf-8 />
    <!--<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />-->
    <!--<meta http-equiv="Content-Type" content="text/html;" />-->
        <title><?php include "library/title.php"; ?></title>
		<?php $xajax->printJavascript(); ?>
		<LINK REL="SHORTCUT ICON" HREF="images/favicon.ico">
		<link media="screen" rel="stylesheet" href="colorbox.css" />
		<link rel=stylesheet type="text/css" href="<?php echo $FILE_STYLES ?>">
		<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script> -->
		<script src="colorbox/jquery.min.js"></script>
		<script src="colorbox/jquery.colorbox.js"></script>		
		<script> 
      <?php echo "var language = '{$FILE_LANGUAGE}'; "; ?>
		</script>
		<script type="text/javascript" src="<?php echo $FILE_SCRIPT_JS ?>"></script>
		<script type='text/JavaScript' src='scw.js?v=<?php echo rand(100, 999); ?>'></script>
		
    </head>
    <body bottommargin="0px" leftmargin="0px" marginheight="0px" marginwidth="0px" rightmargin="0px" topmargin="0px" bgcolor="#EAEAEA">
        <center>
            <table border="0" style="border: 2px solid #565656; border-top: 0px" cellpadding="0px" cellspacing="0px" bgcolor="#FFFFFF" height="100%" width="1400px">
                <tr>
                    <td>
                        <img src="images/header<?php echo getOficinaIndex(); ?>.jpg" border="0" width="1396px" height="117px" alt="">
                    </td>
                </tr>
                <tr>
<!--                    <td background="images/menu_back.gif">-->
                    <td>
                        <?php
                            include "library/menu.php";
                        ?>
                    </td>
                </tr>
                

                <tr>
                    <td height="100%" valign="top">
                        <table border="0" width="100%" cellpadding="0px" cellspacing="0px">
                            <tr>
                                <td width="1%" valign="center" align ="left">&nbsp;
                                    
                                </td>
                                <td width="98%" align ="left">
                                    <?php
                                        include "library/header.php";
                                    ?>
                                    <?php
                                        include "library/window.php";
                                    ?>
                                </td>
                                <td width="1%">&nbsp;
                                    
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>


				<?php
					if($reserva == true)
						include "library/botonesReserva.php";
				?>
										
                <tr>
                    <td background="images/footer.gif" height="38px">
                        <?php
                            include "library/footer.php";
                        ?>
                    </td>
                </tr>
            </table>
            <br>
        </center>

        <?php
            include "library/footer_end.php";
        ?>     
    </body>
</html>