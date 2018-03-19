# Sistema de Gerenciamento de Recursos Humanos

O sistema de gerenciamento de recursos humanos, é um sistema voltado para empresas de administração pública, onde é possível gerenciar as informações sobre os funcionário dentro da empresa. Ele ganha pelo destaque de poder ser acessível em qualquer lugar, com telas intuitiva e de fácil aprendizado.

O sistema foi feito na plataforma PHP, rodando sobre o banco de dados MySQL, para permitir que haja a integridade do mesmo. Além disso, o sistema é seguro, permitindo a integridade dos dados e evitando os vazamentos das mesmas informações, bem como as invasões. O sistema foi desenvolvido sobre o framework [CakePHP](http://cakephp.org), onde foi permitido a criação de sistema personalizado e seguro.

## Recursos

Sistema de gerenciamento de recursos humanos, com os seguintes recursos e funcionalidades abaixo:

- **Painel Principal**: Implantação do painel principal do sistema, assim que o usuário acessar o sistema. Nele, o usuário terá acesso a seguintes informações:
    - **Dados Quantitativos**:
        - Quantidade total de funcionários cadastrados
        - Quantidade total de atestados emitidos nos últimos 12 meses
        - Quantidade de atestados que resultaram no afastamento de INSS nos últimos 12 meses
        - Quantidade de médicos cadastrados.
    - **Tabelas Gerais Por Empresa**:
        - Quantidade de Funcionários em uma empresa.
        - Atestados Emitidos por empresa
    - Gráfico mensal evolutivo, mostrando a quantidade mensal de atestados emitidos e o número de afastamentos por INSS, mês a mês.
    - **Dados Classificativos (Rankings)**:
        - Os 10 maiores solicitantes de atestados, ou seja, os funcionários que mais solicitaram atestados, sendo ordenados por quantidade, em ordem decrescente.
        - Os 10 CIDs mais diagnosticados, ou seja, os atestados com os CIDs mais cadastrados no sistema, sendo ordenados por quantidade, em ordem decrescente.
- **Log de Acesso**: Log de acesso, onde o usuário poderá ver todas as suas ações de usuário
- **Cadastro de Usuários**: Sistema de Cadastro de Usuários que irão utilizar o sistema, com operações de inclusão, alteração e exclusão. Além disso haverá recursos de segurança, como obrigar o usuário a trocar de senha e também liberar o usuário que foi suspenso de acessar o sistema, por motivos de segurança.
- **Cadastro de Grupo de Usuário**: Grupos de usuários com papéis, permissões e usos do sistema, com operações de inclusão, alteração e exclusão.
- **Firewall**: Controle de acesso e bloqueio do Firewall, além de controle e verificação de segurança.
- **Funcionários**: Cadastro funcional de funcionários, com operações de inclusão, alteração e exclusão.
- **Segurança**: Controle robusto de acesso ao sistema, com limitação de tentativas de acesso, com bloqueio e suspensão automática de conta em caso de acesso indevido, podendo inclusive bloquear automaticamente o IP do usuário mal intencionado ao sistema. Além disso, o sistema conta com o sistema de auditoria e monitoria de atividades suspeitas do usuário.
- **Funcionários**: Cadastro de funcionários completo, com inclusão, alteração, consulta e exclusão, com a 
possibilidade de impressão das mesmas informações.
- **Atestados**: Cadastro de atestados completo, com inclusão, alteração, consulta e exclusão, com a possibilidade de impressão das mesmas informações, utilizando a interface intuitiva e de fácil aprendizado. Foi implementado um sistema inteligente de busca de CID, além de ser possível fazer busca dentro da tela de cadastro de atestados.
- **Médicos**: Cadastro de médicos completo, com inclusão, alteração, consulta e exclusão, com a possibilidade de impressão das mesmas informações.
- **CID**: Gerenciamento completo de CIDs do sistema, podendo fazer inclusão manual (simples ou massivamente), como também podendo fazer importação. É possível fazer a importação tanto pelo arquivo CSV padrão, como também usando o método do [DataSUS](http://datasus.saude.gov.br/).
- **Relatórios**: Conjunto completo de relatórios imersivos, para a melhor gerenciamenteo e administração das informações relativas aos atestados médicos emitidos. São os seguintes relatórios:
    - *Relatório de Funcionários Por Atestados*: Exibe uma lista de funcionários, juntamente com a quantidade total de atestados médicos emitidos a cada um deles. O relatório se imerge para mostrar todos os atestados de cada funcionário selecionado, podendo ainda ver um atestado simples cadastrado.
    - *Relatório de Empresas Por Atestados*: Exibe uma lista de empresas, juntamente com a quantidade total de atestados médicos emitidos a cada uma das empresas. O relatório se imerge para mostrar todos os funcionários de uma determinada empresa selecionada, ou atestados por cada empresa. Quando o gerenciador estiver visualizando a listagem de funcionários da empresa, ele ainda poderá visualizar os atestados emitidos, podendo ainda ver um atestado simples cadastrado.
    - *Relatório de Atestados Por CID*: Exibe uma lista de CID, juntamente com a quantidade de atestados emitidos para este CID. O relatório se imerge para mostrar todos os atestados relacionados a um CID selecionado, podendo ainda ver um atestado simples cadastrado.
    - *Relatório de Atestados Por Médico*: Exibe uma lista de médicos cadastrados, juntamente com a quantidade de atestados emitidos por ele. O relatório se imerge para mostrar todos os atestados relacionados a um médico selecionado, podendo ainda ver um atestado simples cadastrado.
- **Auditoria**: Sistema de auditoria do sistema, onde os administradores podem consultar e monitorar todas as atividades dentro do sistema.
- **Outros**: O usuário pode editar suas própria informações do usuário, bem como modificar a senha.

## Requisitos do Sistema

- PHP 7 (ou superior)
- MySQL 5.6 (ou superior)
- Extensões de PHP:
    - mbstring
    - intl 
    - simplexml 
- Apache HTTP Server, com *mod_rewrite* habilitado IIS 7 (com *Rewrite Module*) ou nginx.

## Instalação

O sistema deve ser instalado em um provedor PHP e rodado sobre o banco de dados MySQL. O mesmo pode ser baixado [por aqui](https://github.com/coqueiralmg/rh/releases). Além disso, é preciso imputar os dados padrão de acesso a usuário, que pode ser solicitado pela equipe responsável pelo desenvolvimento.
