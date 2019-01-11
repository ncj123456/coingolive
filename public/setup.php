<?php
if(isset($_POST['install'])){
        //copy file config
        if(!file_exists(__DIR__.'/../define.php')){
            $rs1 =  copy(__DIR__.'/../define.local', __DIR__.'/../define.php');
            if(!$rs1){
                echo 'Erro ao copiar o arquivo de configuracao';
            }
        }

        //script create tables
        $rs2 = exec('php /var/www/console/execute.php setup');


        $rs3 = exec('php /var/www/console/execute.php moeda');
        $rs4 = exec('php /var/www/console/execute.php coin-change');

        if($rs2==='OK'){
            echo '<h1>installation complete</h1>';
            unlink(__FILE__);
        }else{
          echo $rs2;  
        }
}else{
?>
<body style="background-color: #d9d3da;padding: 40px 20px;font-family: Arial">
<div style="text-align: center;">
    <h3>Click on the install button to create the tables and download the data, wait a few minutes to complete</h3>
    <form action="setup.php" method="POST">
        <input  onclick="this.style.display = 'none';document.getElementById('msg').style.display = 'block'" name="install" type="submit" value="Install" style="border:none;border-radius: 20px;padding: 20px 40px;font-size: 18px;cursor:pointer;color: white;background-color: #9c27b0">
        <h2 id="msg" style="color:#9c27b0;display: none">installing... wait a few minutes to complete</h2>
    </form>
    <script>
        
    </script>
</div>
</body>
<?php
}
?>

