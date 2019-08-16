<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Author</title>

    <!-- IMPORT CSS -->
    <link rel="stylesheet" type="text/css" href="../resources/plugins/bootstrap/css/bootstrap.min.css">
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
                        <h1>Register New Author</h1>
                    </div>
                </div>

                <div class="row justify-content-md-center" style="padding-top: 10px;">

                    <div class="col-12">
                        <form name="form-author" id="form-author" method="POST" action="AuthorRegisterControl.php">
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-2 col-form-label">Name:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputName" name="inputName" placeholder="Name of Author" value="<?= $name; ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputBirthday" class="col-sm-2 col-form-label">Birthday:</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" id="inputBirthday" name="inputBirthday">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputCPF" class="col-sm-2 col-form-label">CPF:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputCPF" name="inputCPF" data-mask="000.000.000-00" data-mask-reverse="true" placeholder="000.000.000-00">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputPhone" class="col-sm-2 col-form-label">Phone:</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="inputPhone" data-mask="(00) 00000-0000" placeholder="(00) 00000-0000">
                                    <small id="phoneHelp" class="form-text text-muted">Click &lt;Enter&gt;  or '+' to add the new phone number.</small>
                                </div>

                                <div class="col-sm-3">
                                    <select class="form-control" id="select-operator" placeholder="operator...">
                                        <option value=""></option>
                                        <option value="residencial">Residêncial</option>
                                        <option value="claro">Claro</option>
                                        <option value="oi">Oi</option>
                                        <option value="tim">Tim</option>
                                        <option value="vivo">Vivo</option>
                                    </select>

                                    <small id="operatorHelp" class="form-text text-muted">operator</small>
                                </div>


                                <div class="col-sm-1">
                                    <img src="../resources/img/icons/plus.svg" width="20px" id="icon-plus-phone" title='Add New Phone'>
                                </div>

                            </div>

                            <div class="form-group row hide-field" id="div-tb-phones">
                                <div class="col-sm-9 offset-sm-2">
                                    <table class="table table-sm" id="tb-phones">
                                        <thead>
                                            <th>Phones</th>
                                            <th>Operator</th>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 text-right">
                                    <button type="reset" class="btn btn-secondary">Fechar</button>
                                    <button type="submit" class="btn btn-primary" id="btn-salvar">Salvar</button>
                                </div>
                            </div>

                            <input type="hidden" name="hidePhones" id="hidePhones" value="">
                            <input type="hidden" name="hideOperator" id="hideOperator" value="">

                            
                           
                        </form>
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

<script type="text/javascript">
$(function() {

    $("#icon-plus-phone").on('click', function() {

        var phone = $("#inputPhone").val();
        var operator = $("#select-operator option:selected").text();
        var operatorValue = $("#select-operator option:selected").val();

        
        if($.trim(phone) != "" && $.trim(operator) != "" ) {
            
            var hidePhone = $("#hidePhones").val()+(phone+";");
            $("#hidePhones").val(hidePhone);

            var hideOp = $("#hideOperator").val()+operatorValue+";";                
            $("#hideOperator").val(hideOp);

            var tr = "<tr><td>"+ phone +"</td><td>"+ operator +"</td></tr>";
            $("#tb-phones tbody").append(tr);

            $(".hide-field").show();
        }
    });

});
</script>

</body>
</html>