<?php

$htmlTable = "";
for($i = 0; $i < 200; $i++) {

    $htmlTable .= "<tr>
                    <td>$i</td>
                    <td>Felipe Oliveira Simões</td>
                    <td>007.233.351.09</td>
                    <td>26/11/1990</td>
                    <td>(43) 99661-7698 <br/> (43) 8567-4356</td>
                    <td></td>
                </tr>";
}

?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Author</title>

    <!-- IMPORT CSS -->
    <link rel="stylesheet" type="text/css" href="../resources/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../resources/plugins/DataTables/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="../resources/plugins/DataTables/Buttons-1.5.6/buttons.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="../resources/css/style.css">

    <style type="text/css">
        .hide-field {
            display: none;
        }
    </style>
    
</head>

<body>
    
<!-- MENU TOP -->
<section class="menu-top">
    <nav class="navbar navbar-expand-lg  navbar-light bg-light">
        <a class="navbar-brand" href="#">
            <img src="../resources/img/icon-menu-top.png" width="30" height="30" class="align-top">
            NewsWeek
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Authors</a>
                </li>
            </ul>
        </div>
    </nav>
</section>

<section class='content'>

    <div class="container">

        <div class="row justify-content-md-center">

            <div class="col-md-12" style="border: 1px solid #CCC">

                <div class="row">
                    <div class="col-12 text-center">
                        <h1>List of Author</h1>
                    </div>
                </div>

                <div class="row justify-content-md-center" style="padding-top: 10px;">

                    <div class="col-12">
                        <table id="tb-list-authors" class="table table-striped table-bordered table-hover">
                            <thead>
                                <th>Cod</th>
                                <th>Name</th>
                                <th>CPF</th>
                                <th>Date of Birthday</th>
                                <th>Phones</th>
                                <th>Actions</th>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>037</td>
                                    <td>Felipe Oliveira Simões</td>
                                    <td>007.233.351.09</td>
                                    <td>26/11/1990</td>
                                    <td>(43) 99661-7698 <br/> (43) 8567-4356</td>
                                    <td></td>
                                </tr>

                                <?php echo $htmlTable; ?>
                                
                            </tbody>
                        </table>
                    </div>
                    
                </div>

            </div>

        </div>

    </div>
    
</section>


<div class="modal" tabindex="-1" role="dialog" id="modal-alert">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-body">
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal" id="btn-close-alert">Fechar</button>
            </div>
        </div>
    </div>
</div>



<!-- IMPORT JS -->
<script type="text/javascript" src="../resources/plugins/jquery.min.js"></script>
<script type="text/javascript" src="../resources/plugins/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../resources/plugins/jQuery-Mask-Plugin/dist/jquery.mask.min.js"></script>
<script type="text/javascript" src="../resources/plugins/DataTables/datatables.min.js"></script>

<script type="text/javascript">

$(function() {

     $('#tb-list-authors').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    } );

    $(".buttons-html5").removeClass("btn-secondary");
    $(".buttons-html5").addClass("btn-primary");
});

</script>

</body>
</html>