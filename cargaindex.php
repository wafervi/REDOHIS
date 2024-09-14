<!DOCTYPE html>
<html>
<head>
<title>Expedientes archivados | REDOHIS</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="/opt/lampp/htdocs/REDOHIS/css/expskin/min2.css">
<script src="/opt/lampp/htdocs/REDOHIS/jquery/exp1.js"></script>
<script src="/opt/lampp/htdocs/REDOHIS/jquery/exp2.js"></script>
<link rel='stylesheet prefetch' href='/opt/lampp/htdocs/REDOHIS/css/expskin/min3.css'>
</head>

<div class="container">
  <div class="row justify-content-md-center">
    <div class="center">
      <h4>EXPEDIENTES ARCHIVADOS | REDOHIS</h4>
      <hr style="margin-top:10px;margin-bottom: 10px;">
      <div align ="center">
        

      <!-- Barra de búsqueda -->
      <div class="input-group">
        <input type="text" id="search" class="form-control" placeholder="Buscar expedientes">
        <hr style="margin-top:30px;margin-bottom: 30px;">
      </div>
      


      <div align ="center">                     
        <a class="btn btn-primary" href="index.php">Volver a inicio <span class="sr-only">(current)</span></a><!--para volver a la pagina principal -->  
        <a class="btn btn-primary" href="cargardoc.php">Docs radicados <span class="sr-only">(current)</span></a>
        <hr style="margin-top:10px;margin-bottom: 10px;">
      </div>
      <div align ="center">



      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">Lista de Expedientes Archivados</h3>
        </div>
        <div class="panel-body">
          <table class="table">
            <thead>
              <tr>
                <th width="7%">#</th>
                <th width="70%">Nombre del Expediente</th>
                <th width="13%">Descargar una copia</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $REDOHIS = scandir("exp");
              $num = 0;
              for ($i = 2; $i < count($REDOHIS); $i++) {
                $num++;
              ?>
              <tr>
                <th scope="row"><?php echo $num; ?></th>
                <td><?php echo $REDOHIS[$i]; ?></td>
                <td>
                  <a title="Descargar Archivo" href="exp/<?php echo $REDOHIS[$i]; ?>" download="<?php echo $REDOHIS[$i]; ?>" style="color: red; font-size:18px;">
                    <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span>
                  </a>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>

<!-- Filtrar tabla por palabras clave -->
<script>
  document.getElementById('search').addEventListener('keyup', function() {
    var input = document.getElementById('search').value.toLowerCase();
    var rows = document.querySelectorAll('table tbody tr');
    
    rows.forEach(function(row) {
      var expediente = row.querySelector('td:nth-child(2)').innerText.toLowerCase();
      if (expediente.includes(input)) {
        row.style.display = '';
      } else {
        row.style.display = 'none';
      }
    });
  });
</script>

</body>
<footer>

                <div align ="center">
                                <p>Documentado por: @wagnerfv1117 - SAGEN - CAGESDO - © 2021</p>
                </div>
  </div>
</footer>
</html>
