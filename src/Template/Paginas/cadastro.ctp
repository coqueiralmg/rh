<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <form>
                            <legend>Dados Cadastrais</legend>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group label-control">
                                        <label>Título</label>
                                        <input id="titulo" class="form-control" type="text">
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                     <div class="form-group label-control">
                                        <label>Tipo</label>
                                        <select class="form-control" data-style="select-with-transition" title="Choose City" data-size="7" tabindex="-98">
                                            <option value="2"></option>
                                            <option value="2">A Cidade</option>
                                            <option value="3">Especial</option>
                                        </select>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Texto da Página</label>
                                        <textarea id="descricao" class="form-control"></textarea>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <h4>Imagens do Slide</h4>
                                <div class="col-md-3">
                                    <img src="/img/slide/praca.jpg" class="img-rounded img-responsive img-raised">
                                </div>
                                <div class="col-md-3">
                                    <img src="/img/slide/praca.jpg" class="img-rounded img-responsive img-raised">
                                </div>
                                <div class="col-md-3">
                                    <img src="/img/slide/praca.jpg" class="img-rounded img-responsive img-raised">
                                </div>
                                <div class="col-md-3">
                                    <img src="/img/slide/praca.jpg" class="img-rounded img-responsive img-raised">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label>Adicionar Imagem do Slide (A imagem deve ter o tamanho de 1160 x 490)</label>
                                        <input type="file" class="form-control">
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-default btn-round pull-right">Enviar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <h4>Imagens da Galeria</h4>
                                <div class="col-md-3">
                                    <img src="/img/slide/praca.jpg" class="img-rounded img-responsive img-raised">
                                </div>
                                <div class="col-md-3">
                                    <img src="/img/slide/praca.jpg" class="img-rounded img-responsive img-raised">
                                </div>
                                <div class="col-md-3">
                                    <img src="/img/slide/praca.jpg" class="img-rounded img-responsive img-raised">
                                </div>
                                <div class="col-md-3">
                                    <img src="/img/slide/praca.jpg" class="img-rounded img-responsive img-raised">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label>Adicionar Imagem da Galeria</label>
                                        <input type="file" class="form-control">
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-default btn-round pull-right">Enviar</button>
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