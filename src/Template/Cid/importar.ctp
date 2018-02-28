<div class="content">
    <div class="container-fluid">
        <div class="row">
        <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <h4 class="card-title">Selecione o método de importação</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-content text-center">
                        <a href="<?=$this->Url->build([
                            'controller' => 'cid',
                            'action' => 'importacao'
                        ])?>">
                            <span>
                                <i class="material-icons" style="font-size: 116px">description</i>
                            </span>
                            <p><b>Padrão</b></p>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-content text-center">
                        <a href="<?=$this->Url->build([
                            'controller' => 'cid',
                            'action' => 'datasus'
                        ])?>">
                            <?=$this->Html->image('datasus.png')?>
                            <p><b>Datasus</b></p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>