<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <form>
                            <legend>Dados Cadastrais</legend>
                            <div class="row">
                                <h4>Imagem Atual</h4>
                                <center>
                                    <img src="/img/slide/praca.jpg" style="width: 85%" class="img-rounded img-responsive img-raised">
                                </center>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group label-control">
                                        <label>Título</label>
                                        <input id="titulo" class="form-control" type="text">
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group label-control">
                                        <label>Descrição do Banner</label>
                                        <textarea id="descricao" class="form-control"></textarea>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group label-control">
                                        <label>Descrição da Imagem</label>
                                        <textarea id="descricao" class="form-control"></textarea>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group label-control">
                                        <label>Destino</label>
                                        <input id="titulo" class="form-control" type="url">
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group label-control">
                                        <label>Nome da Ação</label>
                                        <input id="titulo" placeholder="Veja mais" class="form-control" type="text">
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group label-control">
                                        <label>Validade</label>
                                        <input id="data" class="form-control" type="text">
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Atualizar Imagem (A imagem deve ter obrigatoriamente o tamanho 1400 x 730)</label>
                                        <input type="file" class="form-control">
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

    });

</script>