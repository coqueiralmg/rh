<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <h4 class="card-title">Buscar</h4>
                        
                        <form>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group form-group-min">
                                        <label>Assunto</label>
                                        <input class="form-control" type="text">
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group form-group-min">
                                         <label>Tipo</label> <br/>
                                        <select class="form-control" data-style="select-with-transition" title="Choose City" data-size="7" tabindex="-98">
                                            <option value="2">Todos</option>
                                            <option value="3">Leis</option>
                                            <option value="4">Decretos</option>
                                            <option value="3">Leis Complementares</option>
                                            <option value="4">Portarias</option>
                                            <option value="4">Nomeações</option>
                                        </select>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group form-group-min">
                                        <label>Número</label>
                                        <input class="form-control" type="text">
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group form-group-min">
                                         <label>Categoria</label> <br/>
                                        <select class="form-control" data-style="select-with-transition" title="Choose City" data-size="7" tabindex="-98">
                                            <option value="2">Todos</option>
                                            <option value="2">Geral</option>
                                            <option value="3">Tributário</option>
                                            <option value="4">Comercial</option>
                                            <option value="3">Posses</option>
                                        </select>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group form-group-min">
                                        <label>Data Inicial</label>
                                        <input id="data_inicial" class="form-control" type="text">
                                        <span class="material-input"></span></div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group form-group-min">
                                        <label>Data Final</label>
                                        <input id="data_final" class="form-control" type="text">
                                        <span class="material-input"></span></div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group form-group-min">
                                         <label>Mostrar</label> <br/>
                                        <select class="form-control" data-style="select-with-transition" title="Choose City" data-size="7" tabindex="-98">
                                            <option value="2">Todos</option>
                                            <option value="3">Somente Ativos</option>
                                            <option value="4">Somente Inativos</option>
                                        </select>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-button">
                            <button type="submit" class="btn btn-fill btn-success pull-right">Buscar<div class="ripple-container"></div></button>
                                <button type="submit" class="btn btn-fill btn-warning pull-right">Novo<div class="ripple-container"></div></button>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                   
                    <div class="card-content table-responsive">
                        <h4 class="card-title">Legislação</h4>
                        <table class="table">
                            <thead class="text-primary">
                                <tr>
                                    <th>Tipo</th>
                                    <th>Número</th>
                                    <th>Ano</th>
                                    <th>Assunto</th>
                                    <th>Categoria</th>
                                    <th>Data</th>
                                    <th>Destaque</th>
                                    <th>Ativo</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Lei</td>
                                    <td>1021</td>
                                    <td>1988</td>
                                    <td>Lei Orgânica do Município</td>
                                    <td>Lei Orgânica</td>
                                    <td>15/05/1988</td>
                                    <td>Sim</td>
                                    <td>Sim</td>
                                    <td class="td-actions text-right">
                                        <button type="button" rel="tooltip" class="btn btn-primary btn-round" title="">
                                            <i class="material-icons">edit</i>
                                        </button>
                                        <button type="button" rel="tooltip" class="btn btn-danger btn-round" title="">
                                            <i class="material-icons">close</i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Lei</td>
                                    <td>1021</td>
                                    <td>1988</td>
                                    <td>Lei Orgânica do Município</td>
                                    <td>Geral</td>
                                    <td>15/05/1988</td>
                                    <td>Sim</td>
                                    <td>Sim</td>
                                    <td class="td-actions text-right">
                                        <button type="button" rel="tooltip" class="btn btn-primary btn-round" title="">
                                            <i class="material-icons">edit</i>
                                        </button>
                                        <button type="button" rel="tooltip" class="btn btn-danger btn-round" title="">
                                            <i class="material-icons">close</i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Lei</td>
                                    <td>1021</td>
                                    <td>1988</td>
                                    <td>Lei Orgânica do Município</td>
                                    <td>Geral</td>
                                    <td>15/05/1988</td>
                                    <td>Sim</td>
                                    <td>Sim</td>
                                    <td class="td-actions text-right">
                                        <button type="button" rel="tooltip" class="btn btn-primary btn-round" title="">
                                            <i class="material-icons">edit</i>
                                        </button>
                                        <button type="button" rel="tooltip" class="btn btn-danger btn-round" title="">
                                            <i class="material-icons">close</i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Lei</td>
                                    <td>1021</td>
                                    <td>1988</td>
                                    <td>Lei Orgânica do Município</td>
                                    <td>Geral</td>
                                    <td>15/05/1988</td>
                                    <td>Sim</td>
                                    <td>Sim</td>
                                    <td class="td-actions text-right">
                                        <button type="button" rel="tooltip" class="btn btn-primary btn-round" title="">
                                            <i class="material-icons">edit</i>
                                        </button>
                                        <button type="button" rel="tooltip" class="btn btn-danger btn-round" title="">
                                            <i class="material-icons">close</i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Lei</td>
                                    <td>1021</td>
                                    <td>1988</td>
                                    <td>Lei Orgânica do Município</td>
                                    <td>Geral</td>
                                    <td>15/05/1988</td>
                                    <td>Sim</td>
                                    <td>Sim</td>
                                    <td class="td-actions text-right">
                                        <button type="button" rel="tooltip" class="btn btn-primary btn-round" title="">
                                            <i class="material-icons">edit</i>
                                        </button>
                                        <button type="button" rel="tooltip" class="btn btn-danger btn-round" title="">
                                            <i class="material-icons">close</i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Lei</td>
                                    <td>1021</td>
                                    <td>1988</td>
                                    <td>Lei Orgânica do Município</td>
                                    <td>Geral</td>
                                    <td>15/05/1988</td>
                                    <td>Sim</td>
                                    <td>Sim</td>
                                    <td class="td-actions text-right">
                                        <button type="button" rel="tooltip" class="btn btn-primary btn-round" title="">
                                            <i class="material-icons">edit</i>
                                        </button>
                                        <button type="button" rel="tooltip" class="btn btn-danger btn-round" title="">
                                            <i class="material-icons">close</i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Lei</td>
                                    <td>1021</td>
                                    <td>1988</td>
                                    <td>Lei Orgânica do Município</td>
                                    <td>Geral</td>
                                    <td>15/05/1988</td>
                                    <td>Sim</td>
                                    <td>Sim</td>
                                    <td class="td-actions text-right">
                                        <button type="button" rel="tooltip" class="btn btn-primary btn-round" title="">
                                            <i class="material-icons">edit</i>
                                        </button>
                                        <button type="button" rel="tooltip" class="btn btn-danger btn-round" title="">
                                            <i class="material-icons">close</i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Lei</td>
                                    <td>1021</td>
                                    <td>1988</td>
                                    <td>Lei Orgânica do Município</td>
                                    <td>Geral</td>
                                    <td>15/05/1988</td>
                                    <td>Sim</td>
                                    <td>Sim</td>
                                    <td class="td-actions text-right">
                                        <button type="button" rel="tooltip" class="btn btn-primary btn-round" title="">
                                            <i class="material-icons">edit</i>
                                        </button>
                                        <button type="button" rel="tooltip" class="btn btn-danger btn-round" title="">
                                            <i class="material-icons">close</i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Lei</td>
                                    <td>1021</td>
                                    <td>1988</td>
                                    <td>Lei Orgânica do Município</td>
                                    <td>Geral</td>
                                    <td>15/05/1988</td>
                                    <td>Sim</td>
                                    <td>Sim</td>
                                    <td class="td-actions text-right">
                                        <button type="button" rel="tooltip" class="btn btn-primary btn-round" title="">
                                            <i class="material-icons">edit</i>
                                        </button>
                                        <button type="button" rel="tooltip" class="btn btn-danger btn-round" title="">
                                            <i class="material-icons">close</i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Lei</td>
                                    <td>1021</td>
                                    <td>1988</td>
                                    <td>Lei Orgânica do Município</td>
                                    <td>Geral</td>
                                    <td>15/05/1988</td>
                                    <td>Sim</td>
                                    <td>Sim</td>
                                    <td class="td-actions text-right">
                                        <button type="button" rel="tooltip" class="btn btn-primary btn-round" title="">
                                            <i class="material-icons">edit</i>
                                        </button>
                                        <button type="button" rel="tooltip" class="btn btn-danger btn-round" title="">
                                            <i class="material-icons">close</i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Lei</td>
                                    <td>1021</td>
                                    <td>1988</td>
                                    <td>Lei Orgânica do Município</td>
                                    <td>Geral</td>
                                    <td>15/05/1988</td>
                                    <td>Sim</td>
                                    <td>Sim</td>
                                    <td class="td-actions text-right">
                                        <button type="button" rel="tooltip" class="btn btn-primary btn-round" title="">
                                            <i class="material-icons">edit</i>
                                        </button>
                                        <button type="button" rel="tooltip" class="btn btn-danger btn-round" title="">
                                            <i class="material-icons">close</i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Lei</td>
                                    <td>1021</td>
                                    <td>1988</td>
                                    <td>Lei Orgânica do Município</td>
                                    <td>Geral</td>
                                    <td>15/05/1988</td>
                                    <td>Sim</td>
                                    <td>Sim</td>
                                    <td class="td-actions text-right">
                                        <button type="button" rel="tooltip" class="btn btn-primary btn-round" title="">
                                            <i class="material-icons">edit</i>
                                        </button>
                                        <button type="button" rel="tooltip" class="btn btn-danger btn-round" title="">
                                            <i class="material-icons">close</i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Lei</td>
                                    <td>1021</td>
                                    <td>1988</td>
                                    <td>Lei Orgânica do Município</td>
                                    <td>Geral</td>
                                    <td>15/05/1988</td>
                                    <td>Sim</td>
                                    <td>Sim</td>
                                    <td class="td-actions text-right">
                                        <button type="button" rel="tooltip" class="btn btn-primary btn-round" title="">
                                            <i class="material-icons">edit</i>
                                        </button>
                                        <button type="button" rel="tooltip" class="btn btn-danger btn-round" title="">
                                            <i class="material-icons">close</i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Lei</td>
                                    <td>1021</td>
                                    <td>1988</td>
                                    <td>Lei Orgânica do Município</td>
                                    <td>Geral</td>
                                    <td>15/05/1988</td>
                                    <td>Sim</td>
                                    <td>Sim</td>
                                    <td class="td-actions text-right">
                                        <button type="button" rel="tooltip" class="btn btn-primary btn-round" title="">
                                            <i class="material-icons">edit</i>
                                        </button>
                                        <button type="button" rel="tooltip" class="btn btn-danger btn-round" title="">
                                            <i class="material-icons">close</i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        
                    </div>
                     <div class="card-content">
                        <div class="material-datatables">
                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="dataTables_paginate paging_full_numbers" id="datatables_info">70 itens encontrados</div>
                                </div>
                                <div class="col-sm-7 text-right">
                                    <div class="dataTables_paginate paging_full_numbers" id="datatables_paginate">
                                        <ul class="pagination pagination-success" style="margin: 0">
                                            <li class="paginate_button first" id="datatables_first"><a href="#" aria-controls="datatables" data-dt-idx="0" tabindex="0">Primeiro</a></li>
                                            <li class="paginate_button previous" id="datatables_previous"><a href="#" aria-controls="datatables" data-dt-idx="1" tabindex="0">Anterior</a></li>
                                            <li class="paginate_button active"><a href="#" aria-controls="datatables" data-dt-idx="2" tabindex="0">1</a></li><li class="paginate_button "><a href="#" aria-controls="datatables" data-dt-idx="3" tabindex="0">2</a></li>
                                            <li class="paginate_button "><a href="#" aria-controls="datatables" data-dt-idx="4" tabindex="0">3</a></li><li class="paginate_button "><a href="#" aria-controls="datatables" data-dt-idx="5" tabindex="0">4</a></li>
                                            <li class="paginate_button next" id="datatables_next"><a href="#" aria-controls="datatables" data-dt-idx="6" tabindex="0">Próximo</a></li>
                                            <li class="paginate_button last" id="datatables_last"><a href="#" aria-controls="datatables" data-dt-idx="7" tabindex="0">Último</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        $('#data_inicial').datepicker({
            language: 'pt-BR'
        });

         $('#data_final').datepicker({
            language: 'pt-BR'
        });

        $('#data_inicial').mask('00/00/0000');
        $('#data_final').mask('00/00/0000');
    });

</script>