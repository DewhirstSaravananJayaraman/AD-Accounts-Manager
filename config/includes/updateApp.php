<?php
$availableVersion=file_get_contents('https://raw.githubusercontent.com/jacobsen9026/School-Accounts-Manager/master/version.txt');
/*
if(isset($_POST["updateApp"])){
	if(!$appConfig["debugMode"]){
	$cmd = "git.exe clone https://github.com/jacobsen9026/School-Accounts-Manager ".str_replace("\\", "/",$_SERVER['DOCUMENT_ROOT']);
 
	}
	else{
		$cmd = "git.exe clone --branch dev https://github.com/jacobsen9026/School-Accounts-Manager ".str_replace("\\", "/",$_SERVER['DOCUMENT_ROOT']);
    
	
	}
	debug($cmd);
	   $result = shell_exec($cmd);
	   debug($result);
}
*/

if (floatval($availableVersion)>floatval($appConfig["version"])){
?>
 <div class="shortSettingsContainer">
        <form action="<?php echo $pageURL."#ap_input";?>" method="post">
            <table  class="settingsList">
                <tr>
                    <th>
                        Update the Application
                    </th>

                </tr>
                <tr>

                    <td>
                        Current Version:<?php echo $appConfig["version"];?><br/>
						Available Version:<?php echo $availableVersion;?><br/><br/>
						<a href="https://github.com/jacobsen9026/School-Accounts-Manager/archive/master.zip">Download</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php

                        if(isset($_POST["updateApp"])){
                            echo"<div class='alert'>Application Updated Succefully!</div>";
                        }
                        ?>
                    </td>
                </tr>

            </table>
            <br/>
			<!--
			<input name="updateApp" value="updateApp" hidden/>
            <button id="ap_input" type="submit"  value="Update Admin Password">Update App to Latest <?php if($appConfig["debugMode"]){echo "Dev";}?> Version</button><br/>
-->
        </form>
    </div>
	
<?php
}
?>