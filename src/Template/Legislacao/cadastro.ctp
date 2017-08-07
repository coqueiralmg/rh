<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <form>
                            <legend>Dados Cadastrais</legend>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group label-control">
                                        <label>Tipo</label>
                                         <select class="form-control" data-style="select-with-transition" title="Choose City" data-size="7" tabindex="-98">
                                            <option value="2"></option>
                                            <option value="3">Lei</option>
                                            <option value="4">Decreto</option>
                                            <option value="3">Lei Complementar</option>
                                            <option value="4">Portaria</option>
                                            <option value="4">Nomeação</option>
                                        </select>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group label-control">
                                        <label>Número</label>
                                        <input id="titulo" class="form-control" type="text">
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group label-control">
                                        <label>Ano</label>
                                        <input id="titulo" class="form-control" type="number">
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group label-control">
                                        <label>Data de Publicação</label>
                                        <input id="titulo" class="form-control" type="text">
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group label-control">
                                        <label>Título</label>
                                        <input id="titulo" class="form-control" type="text">
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group label-control">
                                        <label>Assunto</label>
                                        <input id="titulo" class="form-control" type="text">
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group label-control">
                                        <label>Categoria</label>
                                        <select class="form-control" data-style="select-with-transition" title="Choose City" data-size="7" tabindex="-98">
                                            <option value="2"></option>
                                            <option value="2">Geral</option>
                                            <option value="3">Tributário</option>
                                            <option value="4">Comercial</option>
                                            <option value="3">Posses</option>
                                        </select>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group label-control">
                                        <label>Responsável</label>
                                        <input id="titulo" class="form-control" type="text">
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group label-control">
                                        <label>Co-Responsáveis ou Testemunhas</label>
                                        <input id="titulo" class="form-control" type="text">
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Resumo da Lei</label>
                                        <textarea id="resumo" class="form-control"></textarea>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Texto da Legislação</label>
                                        <textarea id="descricao" class="form-control"></textarea>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Documento em Anexo</label>
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
                                                <input type="checkbox"> Destaque
                                            </label>
                                        </div>
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