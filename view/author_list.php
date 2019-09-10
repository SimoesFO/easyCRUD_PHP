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

<!-- CONTENT -->
<section class='content'>

    <div class="container">

        <div class="row justify-content-md-center">

            <div class="col-md-12 div-content">

                <div class="row row-title">
                    <div class="col-12 text-center">
                        <h1>List of Author</h1>
                    </div>
                </div>

                <div class='btn-new-author'>
                    <a  href="AuthorAddControl.php" class="btn btn-primary">New Author</a>
                </div>

                <div class="row justify-content-md-center">

                    <div class="col-12">
                        <table id="tb-list-authors" class="table table-striped table-bordered table-hover">
                            <thead>
                                <th>Cod</th>
                                <th>Name</th>
                                <th>CPF</th>
                                <th>Date of Birthday</th>
                                <th>Phones</th>
                                <th class='td-center'>Actions</th>
                            </thead>

                            <tbody>
                                <?php echo $htmlTable; ?>
                            </tbody>
                        </table>
                    </div>
                    
                </div>

            </div>

        </div>

    </div>
    
</section>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete Author</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Do you really want to delete this author?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-danger" id="btn-delete">Delete</button>
      </div>
    </div>
  </div>
</div>



<!-- IMPORT JS -->
<script type="text/javascript" src="../resources/plugins/jquery.min.js"></script>
<script type="text/javascript" src="../resources/plugins/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../resources/plugins/jQuery-Mask-Plugin/dist/jquery.mask.min.js"></script>
<script type="text/javascript" src="../resources/plugins/DataTables/datatables.min.js"></script>
<script type="text/javascript" src="../resources/js/newsWeek-list.js"></script>

</body>
</html>