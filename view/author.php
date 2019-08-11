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
        #icon-plus {
            cursor: pointer;
        }

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
                        <h1>Authores Cadastrados</h1>
                    </div>
                </div>

                <div class="row justify-content-md-center">

                    <div class="col-12 text-right">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#modal-author" id='btn-add'>Novo</button>
                    </div>

                </div>

                <div class="row justify-content-md-center" style="padding-top: 10px;">

                    <div class="col-12">
                        <table class="table table-striped table-hover" >
                            <thead>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>CPF</th>
                                <th>Data de Nascimento</th>
                                <th>Telefones</th>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>123</td>
                                    <td>FElipe Oliverra Simẽos</td>
                                    <td>007.233.351-09</td>
                                    <td>26/11/1990</td>
                                    <td>(43)99661-7698</td>
                                </tr>

                                <tr>
                                    <td>123</td>
                                    <td>FElipe Oliverra Simẽos</td>
                                    <td>007.233.351-09</td>
                                    <td>26/11/1990</td>
                                    <td>(43)99661-7698</td>
                                </tr>

                                <tr>
                                    <td>123</td>
                                    <td>FElipe Oliverra Simẽos</td>
                                    <td>007.233.351-09</td>
                                    <td>26/11/1990</td>
                                    <td>(43)99661-7698</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                </div>

            </div>

        </div>

    </div>
    
</section>

<!------ BEGIN MODAL ADD AUTHORS ------->
<div class="modal fade" tabindex="-1" role="dialog" id="modal-author">

    <div class="modal-dialog modal-lg" role="document">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="modal-author-title">Cadastrar Novo Author</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                
                <form name="form-author" id="form-author">
                    <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Name:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputName" name="inputName" placeholder="Name of Author">
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
                            <select class="form-control" id="select-operadora" placeholder="Operadora...">
                                <option value=""></option>
                                <option value="residencial">Residêncial</option>
                                <option value="claro">Claro</option>
                                <option value="oi">Oi</option>
                                <option value="tim">Tim</option>
                                <option value="vivo">Vivo</option>
                            </select>

                            <small id="operadoraHelp" class="form-text text-muted">Operadora</small>
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
                                    <th>Operadora</th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <input type="hidden" name="hidePhones" id="hidePhones" value="">
                    <input type="hidden" name="hideOperadora" id="hideOperadora" value="">
                   
                </form>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" id="btn-salvar">Salvar</button>
            </div>

        </div>
        
    </div>

</div>

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
            var operadora = $("#select-operadora option:selected").text();
            var operadoraValue = $("#select-operadora option:selected").val();

            if($.trim(phone) != "" && $.trim(operadora) != "" ) {
                
                var hidePhone = $("#hidePhones").val()+(phone+";");
                $("#hidePhones").val(hidePhone);

                var hideOp = $("#hideOperadora").val()+operadoraValue+";";                
                $("#hideOperadora").val(hideOp);

                var tr = "<tr><td>"+ phone +"</td><td>"+ operadora +"</td></tr>";
                $("#tb-phones tbody").append(tr);

                $(".hide-field").show();
            }
        });

        $("#btn-salvar").on('click', function() {
            var dataForm = $("#form-author").serialize();

            $.ajax({
                url: "author_ajax.php?"+dataForm,
                method: "GET",
                data: { 
                    method: 'registerUser',
                    debug: 0 // 0 - false | 1 - true
                },
                dataType: "html",
                'success' : function(data) {
                    if(data == 'success') {

                        $('#form-author input, select').each (function(){
                            
                            $(this).val("");
                            $(this).prop('selectedIndex',0);
                            $("#tb-phones").html("");
                            $(".hide-field").hide();
                        });

                        $("#modal-alert").find('.modal-body').html('Operação Realizada com Sucesso!');
                        $("#modal-alert").find('button').removeClass('btn-danger');
                        $("#modal-alert").find('button').addClass('btn-success');
                        $("#modal-author").modal('hide');
                        $("#modal-alert").modal('show');
                    }
                    else {
                        $("#modal-alert").find('.modal-body').html('Error ao executar a operação! Por favor, verifique se todos os campos foram preenchidos de maneira correta, e tente novamente.');
                        $("#modal-alert").find('button').removeClass('btn-success');
                        $("#modal-alert").find('button').addClass('btn-danger');
                        $("#modal-author").modal('hide');
                        $("#modal-alert").modal('show');
                    }
                },
                'done' : function() {
                }
            });
        });

        $("#btn-close-alert").on('click', function () {

            var result = $(this).hasClass('btn-danger');

            if(result) {
                $("#modal-author").modal('show');
            }
        });

    });
</script>

</body>
</html>