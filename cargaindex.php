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

<body>
<div class="container">
  <div class="row justify-content-md-center">
    <div class="center">
      <h4>EXPEDIENTES ARCHIVADOS | REDOHIS</h4>
      <hr style="margin-top:10px;margin-bottom: 10px;">
      <div align="center">

        <!-- Barra de búsqueda -->
        <div class="input-group">
          <input type="text" id="search" class="form-control" placeholder="Buscar expedientes">
          <hr style="margin-top:30px;margin-bottom: 30px;">
        </div>

        <!-- Botones de navegación -->
        <div align="center">                     
          <a class="btn btn-primary" href="index.php">Volver a Inicio <span class="sr-only">(current)</span></a>
          <a class="btn btn-primary" href="cargardoc.php">Docs Salidos <span class="sr-only">(current)</span></a>
          <a class="btn btn-primary" href="cargardocr.php">Docs Recibidos <span class="sr-only">(current)</span></a>
          <a class="btn btn-primary" href="logout.php">Cerrar Sesión<span class="sr-only">(current)</span></a>
          <hr style="margin-top:10px;margin-bottom: 10px;">
        </div>

        <!-- Formulario para cargar archivo .zip -->
        <div align="center">
          <form action="uploadzip.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label for="zipFile">Subir expediente en formato .zip</label>
              <input type="file" name="zipFile" id="zipFile" class="form-control" accept=".zip">
            </div>
            <button type="submit" class="btn btn-primary">Cargar expediente</button>
          </form>
          <hr style="margin-top:20px;margin-bottom: 20px;">
        </div>

        <!-- Lista de expedientes archivados -->
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
              <tbody id="expedientes">
                <?php
                $REDOHIS = scandir("exp");
                $num = 0;
                $perPage = 5; // Número de registros por página
                $totalFiles = count($REDOHIS) - 2; // Excluyendo "." y ".."
                $totalPages = ceil($totalFiles / $perPage);
                $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $start = ($currentPage - 1) * $perPage + 2;

                for ($i = $start; $i < $start + $perPage && $i < count($REDOHIS); $i++) {
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

        <!-- Paginación -->
        <nav>
          <ul class="pagination">
            <?php if ($currentPage > 1) { ?>
              <li>
                <a href="?page=<?php echo $currentPage - 1; ?>">Anterior</a>
              </li>
            <?php } ?>
            <?php for ($page = 1; $page <= $totalPages; $page++) { ?>
              <li class="<?php echo ($page == $currentPage) ? 'active' : ''; ?>">
                <a href="?page=<?php echo $page; ?>"><?php echo $page; ?></a>
              </li>
            <?php } ?>
            <?php if ($currentPage < $totalPages) { ?>
              <li>
                <a href="?page=<?php echo $currentPage + 1; ?>">Siguiente</a>
              </li>
            <?php } ?>
          </ul>
        </nav>

      </div>
    </div>
  </div>
</div>

<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>

<!-- Filtrar tabla por palabras clave -->
<script>
  document.getElementById('search').addEventListener('keyup', function() {
    var input = document.getElementById('search').value.toLowerCase();
    var rows = document.querySelectorAll('tbody tr');

    rows.forEach(function(row) {
      var expediente = row.querySelector('td:nth-child(2)');
      if (expediente && expediente.innerText.toLowerCase().includes(input)) {
        row.style.display = '';
      } else {
        row.style.display = 'none';
      }
    });
  });
</script>

<footer>
  <div align="center">
    <p>Documentado por: <a href="https://github.com/wafervi" target="_blank">@wafervi</a> - SAGEN - CAGESDO - © 2021</p> 
  </div>
</footer>
</body>
</html>
