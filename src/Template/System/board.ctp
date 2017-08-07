<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="green">
                        <h4 class="title">Licitações Recentes</h4>
                    </div>
                    <div class="card-content table-responsive">
                        <table class="table table-hover">
                            <thead class="text-warning">
                                <th>Título</th>
                                <th>Data</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php foreach ($licitacoes as $licitacao): ?>
                                    <tr>
                                        <td><?=$licitacao->titulo?></td>
                                        <td><?=date_format($licitacao->dataInicio, 'd/m/Y') ?></td>
                                        <td class="td-actions text-right">
                                            <?php if ($this->Membership->handleRole("editar_licitacao")): ?>
                                                <a href="<?= $this->Url->build(['controller' => 'licitacoes', 'action' => 'edit', $licitacao->id]) ?>" class="btn btn-primary btn-round" title="Editar">
                                                    <i class="material-icons">edit</i>
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-right">
                                        <?php if ($this->Membership->handleRole("listar_licitacoes")): ?>
                                            <a href="<?= $this->Url->build(['controller' => 'licitacoes', 'action' => 'index']) ?>" class="btn btn-default btn-info">Ver Todos</a>
                                        <?php endif; ?>
                                        <?php if ($this->Membership->handleRole("adicionar_licitacao")): ?>
                                            <a href="<?= $this->Url->build(['controller' => 'licitacoes', 'action' => 'add']) ?>" class="btn btn-default btn-warning">Nova Licitação</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="green">
                        <h4 class="title">Publicações Recentes</h4>
                    </div>
                    <div class="card-content table-responsive">
                        <table class="table table-hover">
                            <thead class="text-warning">
                                <th>Título</th>
                                <th>Data</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php foreach ($publicacoes as $publicacao): ?>
                                    <tr>
                                        <td><?=$publicacao->titulo?></td>
                                        <td><?=date_format($publicacao->data, 'd/m/Y') ?></td>
                                        <td class="td-actions text-right">
                                            <?php if ($this->Membership->handleRole("editar_publicacao")): ?>
                                                <a href="<?= $this->Url->build(['controller' => 'publicacoes', 'action' => 'edit', $publicacao->id]) ?>" class="btn btn-primary btn-round" title="Editar">
                                                    <i class="material-icons">edit</i>
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-right">
                                        <?php if ($this->Membership->handleRole("listar_publicacoes")): ?>
                                            <a href="<?= $this->Url->build(['controller' => 'publicacoes', 'action' => 'index']) ?>" class="btn btn-default btn-info">Ver Todos</a>
                                        <?php endif; ?>
                                        <?php if ($this->Membership->handleRole("adicionar_publicacao")): ?>
                                            <a href="<?= $this->Url->build(['controller' => 'publicacoes', 'action' => 'add']) ?>" class="btn btn-default btn-warning">Nova Publicação</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="pull-left">
                <h3>Notícias Recentes </h3>
            </div>
            <div class="pull-right">
                <?php if ($this->Membership->handleRole("adicionar_noticia")): ?>
                    <a href="<?= $this->Url->build(['controller' => 'noticias', 'action' => 'add']) ?>" class="btn btn-warning btn-simple">Nova Notícia<div class="ripple-container"></div></a> |
                <?php endif; ?>
                <?php if ($this->Membership->handleRole("listar_noticias")): ?>
                    <a href="<?= $this->Url->build(['controller' => 'noticias', 'action' => 'index']) ?>" class="btn btn-info btn-simple">Ver Todas<div class="ripple-container"></div></a>
                <?php endif; ?>
            </div>
        </div>

        <br/>        

        <div class="row">
            <?php foreach ($noticias as $noticia): ?>
                <div class="col-md-4">
                    <div class="card card-product" data-count="9">
                        <div class="card-image" data-header-animation="true">
                            <a href="#pablo">
                                <img class="img" src="<?= 'http://' . $_SERVER['HTTP_HOST'] . '/' . $noticia->foto?>">
                            </a>
                        </div>
                        <div class="card-content">
                        
                            <h4 class="card-title">
                                <a href="#pablo"><?= $noticia->post->titulo ?></a>
                            </h4>
                            <div class="card-description">
                                <?= $noticia->resumo ?> 
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="stats pull-right">
                                <?php if ($this->Membership->handleRole("editar_noticia")): ?>
                                    <a href="<?= $this->Url->build(['controller' => 'noticias', 'action' => 'edit', $noticia->id]) ?>" class="btn btn-primary btn-simple">Editar<div class="ripple-container"></div></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            
        </div>

    </div>
</div>