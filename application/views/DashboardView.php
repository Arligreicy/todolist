<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

     <title>Dashboard | Tarefas do dia </title>


<!-- ⚙️ HEAD: Ajustes de versão Bootstrap e CoreUI -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="<?= base_url(); ?>/assets/coreui/dist/css/coreui.min.css" rel="stylesheet">
<link href="<?= base_url(); ?>/assets/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<style>
    .todo-card { border-left: 5px solid #321fdb; }
    .completed { text-decoration: line-through; color: #6c757d; }
    .botao-logout-fixo {
        position: fixed;
        top: 10px;
        right: 10px;
        z-index: 9999;
    }
</style>

</head>

<body class="c-app">

    <!-- ✅ SIDEBAR -->
    <div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
        <div class="c-sidebar-brand d-md-down-none text-center py-3">
            <h4>📝 TodoList</h4>
        </div>
        <ul class="c-sidebar-nav">
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link active" href="#">
                    <i class="fas fa-list me-2"></i> Minhas Tarefas
                </a>
            </li>
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="#">
                    <i class="fas fa-user me-2"></i> Meu Perfil
                </a>
            </li>
        </ul>
    </div>

    <!-- ✅ HEADER -->
    <header class="c-header c-header-light c-header-fixed">
        <ul class="c-header-nav ml-auto mr-4">
            <h1></h1>
            <li class="c-header-nav-item">
                <a class="c-header-nav-link btn btn-outline-danger" href="<?= base_url('usuario/logout') ?>">
                    <i class="fas fa-sign-out-alt"></i>  🔓 Sair
                </a>
            </li>
        </ul>
    </header>

    <!-- ✅ CONTEÚDO PRINCIPAL -->
    <div class="c-wrapper">
        <div class="c-body">
            <main class="c-main p-4">
                <div class="container-fluid">

                    <div class="nav nav-tabs" id="nav-tab" role="tablist">

                    <button class="nav-link active" id="tarefas-tab" data-toggle="tab" href="#tarefas" role="tab" aria-controls="tarefas" aria-selected="false">Tarefas</button>   

                    </div>

                    <div class="mb-4">
                        <h2 class="mb-0">Minhas Tarefas</h2>
                        <p><?= $mensagem ?? '' ?></p>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTarefa">
                            <i class="fas fa-plus"></i> Nova Tarefa
                        </button>
                    </div>

                    <div id="tarefas-tab"></div>
        
                </div>
            </main>
        </div>
    </div>

    <div class="tab-content" id="nav-tabContent">

        <div class="tab-pane fade show active" id="tarefas" role="tabpanel" aria-labelledby="tarefas-tab">

            <!-- FORMULÁRIO DE FILTRO -->
            <form id="formFiltro" method="post" action="javascript:void(0);">
                <div class="row gx-3 gy-2 align-items-end mb-3">

                    <!-- Botão Nova Cotação -->
                    <div class="col-auto">
                        <button type="button" class="btn btn-primary" data-toggle="modal"
                            data-target="#modal_novo">
                            <i class="fa fa-plus"></i> Nova Tarefa
                        </button>
                    </div>

                    <!-- Campo Descrição -->
                    <div class="col-md">
                        <input type="text" class="form-control" id="filtro_descricao"
                            name="filtro_descricao" placeholder="Pesquisar por descrição">
                    </div>

                    <!-- Campo Situação -->
                    <div class="col-md-2">
                        <select class="form-control" id="situacao" name="situacao">
                            <option value="" selected>Todos</option>
                            <option value="pendente">Pendente</option>
                            <option value="concluído">Concluído</option>
                            <option value="cancelada">Cancelada</option>
                        </select>
                    </div>

                    <!-- Campo Período -->
                    <div class="col-md-3">
                        <div class="input-group">
                            <input type="date" class="form-control" id="datainicio" name="datainicio"
                                value="<?php echo date('Y-m-d', strtotime('-30 days')); ?>" required>
                            <span class="input-group-text">à</span>
                            <input type="date" class="form-control" id="datafinal" name="datafinal"
                                value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                    </div>

                    <!-- Botões -->
                    <div class="col-auto">
                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-filter"></i> Filtrar
                            </button>
                            <button type="button" id="btnLimpar" class="btn btn-outline-dark">
                                Limpar
                            </button>
                        </div>
                    </div>

                </div>
            </form>

            <!-- TABELA -->
            <div id="tarefas-tab" class="tabulator-custom very compact striped"></div>

        </div>

<!-- ✅ MODAL DE TAREFA -->
<div class="modal fade" id="modalTarefa" tabindex="-1">
    <div class="modal-dialog">
        <form id="formTarefa" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cadastrar/Editar Tarefa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="IDTAREFA" id="IDTAREFA">
                <div class="mb-3">
                    <label class="form-label">Título</label>
                    <input type="text" name="TITULO" id="TITULO" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Descrição</label>
                    <textarea name="DESCRICAO" id="DESCRICAO" class="form-control"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Prioridade</label>
                    <select name="PRIORIDADE" id="PRIORIDADE" class="form-select">
                        <option value="baixa">Baixa</option>
                        <option value="media">Média</option>
                        <option value="alta">Alta</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Prazo</label>
                    <input type="date" name="PRAZO" id="PRAZO" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" type="submit">Salvar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </form>
    </div>
</div>

 <!-- tabulator -->
    <link href="<?php echo base_url(); ?>assets/tabulator/dist/css/tabulator_semanticui.min.css" rel="stylesheet">
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/tabulator/dist/js/tabulator.min.js"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/luxon@2.3.1/build/global/luxon.min.js"></script>
    <!-- dependencia para manipular datas dentro do tabulator -->

<!-- ✅ SCRIPTS -->
<script>

     var listarTarefas = new Tabulator("#tarefas-tab", {
        layout: "fitColumns",
        height: "calc(100vh - 290px)",
        ajaxURL: "<?php echo base_url('Tarefa/listar_ajax'); ?>",

        ajaxResponse: function(url, params, response) {
            atualizarContador("tarefas-tab", response.total || response.data.length);
            return response;
        },
        ajaxConfig: "POST",
        progressiveLoad: "scroll",
        progressiveLoadScrollMargin: 200,
        paginationSize: 20,
        placeholder: "Nenhum registro encontrado",
        sortMode: "remote",
        filterMode: "remote",

        initialFilter: [{
                field: "CONVERT(DATE,TAREFA.DATACRIACAO)",
                type: ">=",
                value: "<?php echo date('Y-m-d', strtotime('-30 days')); ?>"
            },
            {
                field: "CONVERT(DATE,TAREFA.DATACONCLUSAO)",
                type: "<=",
                value: "<?php echo date('Y-m-d'); ?>"
            },
        ],
        dataLoaderLoading: '<i class="fa fa-circle-o-notch fa-spin text-secondary fa-3x fa-fw"></i>',
        columnDefaults: {
            vertAlign: "middle",
        },
        movableColumns: true,
        initialSort: [{
            column: 'IDTAREFA',
            dir: "desc"
        }],
        columns: [
            // Coluna de ações (botões Editar e Excluir)
            {
                title: "Ações",
                field: "acoes",
                width: '110',
                headerSort: false,
                frozen: true,
                hozAlign: "center",
                headerHozAlign: "center",
                formatter: function(cell, formatterParams) {
                    var id = cell.getRow().getData().IDTAREFA;
                    return `
							<button type="button" class="btn btn-primary btn-sm btnEditarTarefa btn-space" data-id="${id}"><i class="fa fa-pencil"></i></button>
							<button type="button" class="btn btn-danger btn-sm btnExcluirTarefa" data-id="${id}"><i class="fa fa-times"></i></button>
						`;
                },
            },
            {
                title: "Nome",
                field: "NOMEUSUARIO",
                width: 150
            },
            {
                title: "Tipo",
                field: "NOMECATEGORIA",
                width: 150
            },

            {
                title: "Cód",
                field: "IDTAREFA",
                width: 60
            },
            {
                title: "Descrição",
                field: "DESCRICAO",

            },
            {
                title: "Prioridade",
                field: "PRIORIDADE",
                width: 120,
                hozAlign: "center",
                formatter: function(cell, formatterParams) {
                    const value = cell.getValue();
                    if (value === "Baixa") {
                        return '<span class="badge bg-green">Baixa</span>';
                    } else if (value === "Média") {
                        return '<span class="badge bg-warning">Média</span>';
                    } else {
                        return '<span class="badge bg-danger">Alta</span>';
                    }
                }
            },
            {
                title: "Data Criação",
                field: "DATACRIACAO",
                width: 200,
                hozAlign: "center",
                headerHozAlign: "center",
                formatter: "datetime",
                formatter: function(cell) {
                    let data = cell.getValue();
                    if (!data) return "";
                    let d = new Date(data);
                    if (isNaN(d.getTime())) return data; // Se não virou data, retorna o texto mesmo

                    let dia = String(d.getDate()).padStart(2, '0');
                    let mes = String(d.getMonth() + 1).padStart(2, '0');
                    let ano = d.getFullYear();
                    let hora = String(d.getHours()).padStart(2, '0');
                    let minuto = String(d.getMinutes()).padStart(2, '0');

                    return `${dia}/${mes}/${ano} ${hora}:${minuto}`;
                }
            },
            {
                title: "Situação",
                field: "STATUS",
                width: 150,
                hozAlign: "center",
                headerHozAlign: "center",
                formatter: function(cell) {
                    const status = cell.getValue();
                    var id = cell.getRow().getData().IDTAREFA;
                    if (status === 'pendente') {
                        return `<button class="btn btn-sm btn-success btnAtualizarStatus" data-id="${id}">Em aberto</button>`;
                    } else if (status === 'concluida') {
                        return `<button class="btn btn-sm btn-primary btnAtualizarStatus" data-id="${id}">Encerrada</button>`;
                    } else {
                        return '<button class="btn btn-sm btn-danger">Cancelada</button>';
                    }
                }
            }
        ],
     });

</script>

</body>
</html>
