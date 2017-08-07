<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <form>
                            <legend>Dados Cadastrais</legend>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group label-control">
                                        <label>Nome</label>
                                        <input id="titulo" class="form-control" type="text">
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group label-control">
                                        <label>Responsável</label>
                                        <input id="titulo" class="form-control" type="text">
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group label-control">
                                        <label>Endereço</label>
                                        <input id="titulo" class="form-control" type="text">
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group label-control">
                                        <label>Telefone</label>
                                        <input id="titulo" class="form-control" type="tel">
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group label-control">
                                        <label>E-mail</label>
                                        <input id="titulo" class="form-control" type="email">
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Informações sobre o Responsável pelo Departamento ou Secretaria</label>
                                        <textarea id="resumo" class="form-control"></textarea>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Expediente</label>
                                        <textarea id="resumo" class="form-control"></textarea>
                                        <span class="material-input"></span>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Descrição da Secretaria</label>
                                        <textarea id="descricao" class="form-control"></textarea>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Outras Opções</label> <br/>
                                        <div class="togglebutton">
                                            <label>
                                                <input type="checkbox"> Ativo
                                            </label>
                                        </div>
                                        <span class="material-input"></span>

                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success pull-right">Salvar</button>
                            <button type="reset" class="btn btn-primary pull-right">Limpar</button>
                            <button type="button" class="btn btn-primary pull-right">Voltar</button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $('#data').datepicker({
            language: 'pt-BR'
        });

        $('#data').mask('00/00/0000');
        $('#hora').mask('00:00');


        CKEDITOR.replace('descricao');
    });

</script>