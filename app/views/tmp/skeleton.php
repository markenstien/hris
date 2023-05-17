<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?php echo $meta['description'] ?? ''?>">
    <meta name="author" content="<?php echo $meta['author'] ?? ''?>">

    <title><?php echo $title?? COMPANY_NAME?></title>

    <!-- Custom fonts for this template-->
    <link href="<?php echo _path_tmp('vendor/fontawesome-free/css/all.min.css')?>" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?php echo _path_tmp('css/sb-admin-2.min.css')?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo _path_public('css/main/global.js')?>">
    <script type="text/javascript" src="<?php echo _path_public('js/core.js')?>"></script>
    <?php produce('headers')?>
    <?php produce('styles')?>
</head>

<body>

    <?php produce('content')?>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap core JavaScript-->
    <script src="<?php echo _path_tmp('vendor/jquery/jquery.min.js')?>"></script>
    <script src="<?php echo _path_tmp('vendor/bootstrap/js/bootstrap.bundle.min.js')?>"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?php echo _path_tmp('vendor/jquery-easing/jquery.easing.min.js')?>"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?php echo _path_tmp('js/sb-admin-2.min.js')?>"></script>
    <script type="text/javascript" src="<?php echo _path_public('js/global.js')?>"></script>
    
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
          $('.dataTable').DataTable();
        });
        </script>
    <?php produce('scripts') ?>

</body>

</html>