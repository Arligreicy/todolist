<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title>Dashboard | Tarefas do dia </title>


        <!-- ⚙️ HEAD: Ajustes de versão Bootstrap e CoreUI -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?= base_url(); ?>/assets/coreui/dist/css/coreui.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Icons-->
        <link href="<?php echo base_url(); ?>/assets/coreui/icons/coreui-icons.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>/assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css"rel="stylesheet" />

        <!-- Font Awesome via CDN -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-HY+v0Szf... (continua)" 
        crossorigin="anonymous" referrerpolicy="no-referrer" />

        <style>

            .todo-card {
                border-left: 5px solid #321fdb; 
            }
            .completed { 
                text-decoration: line-through; 
                color: #6c757d; 
            }
            .header-dashboard {
                background-color: #f8f9fa;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                padding: 10px 20px;
              
            }
            .header-dashboard h1 {
                font-size: 24px;
                color: #333;
            }
            .c-sidebar {
                background-color:rgb(0, 0, 0);
            }
            .btn-space{
                margin-right: 10px;
                margin-bottom: 10px;
                margin-top: 10px;
                margin-left: 10px;
            }
            .c-main{
                 padding-top: 70px;
            }
            .c-body{
                padding-top: 70px;
                background-color: #f8f9fa;
            }
            .btn-hover-blue:hover {
                background-color: #321fdb !important; 
                border-color: #321fdb !important;
                color: white !important;
            }
            .placeholder-blue::placeholder {
                color: #321fdb ; 
                opacity: 1; 
            }
            .text-blue {
                color: #321fdb !important; 
            }
        </style>

    </head>

<body class="c-app">

    <!-- HEADER -->
    <header class="c-header c-header-light c-header-fixed header-dashboard">
        <ul class="c-header-nav ml-auto mr-4">
            <h1>Minhas Tarefas do Dia - <?= date('d/m/Y') ?></h1>
            <li class="c-header-nav-item">
                <a class="c-header-nav-link btn btn-outline-danger btn-space" href="<?= base_url('usuario/logout') ?>">
                     🔓 Sair
                </a>
            </li>
        </ul>
    </header>

        <!--  SIDEBAR -->
    <div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">

        <div class="c-sidebar-brand d-md-down-none text-center py-3">
            <h4 class="text-white m-auto"><strong> ToDoList 📝 </strong></h4>
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

    <!--  CONTEÚDO PRINCIPAL -->
    <div class="c-wrapper">
        <div class="c-body">
            <main class="c-main">
                <div class="container-fluid">

                    <div class="tab-pane fade show active" id="tarefas" role="tabpanel" aria-labelledby="tarefas-tab">

                        <!-- FORMULÁRIO DE FILTRO -->
                        <form id="formFiltro" method="post" action="javascript:void(0);">
                            <div class="row gx-3 gy-2 align-items-end mb-3">

                                <!-- Botão Nova Cotação -->
                                <div class="col-auto">
                                    <button type="button" class="btn btn-dark btn-hover-blue" data-toggle="modal" name="btnnovatarefa" id="btnnovatarefa"
                                        data-target="#modal_novo">
                                        <i class="fa fa-plus"></i> Nova Tarefa
                                    </button>
                                </div>

                                <!-- Campo Descrição -->
                                <div class="col-md">
                                    <input type="text" class="form-control placeholder-blue" id="filtrodescricao"
                                        name="filtrodescricao" placeholder="Pesquisar por descrição">
                                </div>

                                <!-- Campo Situação -->
                                <div class="col-md-2">
                                    <select class="form-control text-blue" id="situacao" name="situacao">
                                        <option value="" selected>Todos</option>
                                        <option value="pendente">Pendente</option>
                                        <option value="concluida">Concluída</option>
                                        <option value="cancelada">Cancelada</option>
                                    </select>
                                </div>

                                <!-- Campo Período -->
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <input type="date" class="form-control text-blue" id="datainicio" name="datainicio"
                                            value="<?php echo date('Y-m-d', strtotime('-30 days')); ?>" required>
                                        <span class="input-group-text">à</span>
                                        <input type="date" class="form-control text-blue" id="datafinal" name="datafinal"
                                            value="<?php echo date('Y-m-d'); ?>" required>
                                    </div>
                                </div>

                                <!-- Botões -->
                                <div class="col-auto">
                                    <div class="btn-group">
                                        <button type="submit" class="btn btn-dark btn-hover-blue" id="btnFiltrar">
                                            <i class="fa fa-filter"></i> Filtrar
                                        </button>
                                        <button type="button" id="btnLimpar" class="btn btn-outline-dark btn-hover-blue text-blue">
                                            Limpar
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </form>

                        <!-- TABELA -->
                        <div id="tarefas-tab" class="tabulator-custom very compact striped"></div>

                    </div>
        
                </div>
            </main>
        </div>
    </div>

    <!-- MODAL DE TAREFA -->
    <div class="modal fade" id="modalTarefa" tabindex="-1" aria-labelledby="modalTarefaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"> 
                <form id="formTarefa" method="post" action="javascript:void(0);">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTarefaLabel">Cadastrar Tarefa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="idtarefa" id="IDTAREFA">

                        <div class="mb-3">
                            <label for="TITULO" class="form-label">Título</label>
                            <input type="text" name="titulo" id="TITULO" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="DESCRICAO" class="form-label">Descrição</label>
                            <textarea name="descricao" id="DESCRICAO" class="form-control"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="PRIORIDADE" class="form-label">Prioridade</label>
                            <select name="prioridade" id="PRIORIDADE" class="form-select">
                                <option value="baixa">Baixa</option>
                                <option value="media">Média</option>
                                <option value="alta">Alta</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="PRAZO" class="form-label">Prazo</label>
                            <input type="date" name="prazo" id="PRAZO" class="form-control">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Salvar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Editar Tarefa -->
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditar" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <form id="formEditar" method="post" action="javascript:void(0);">
                <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalEditar">Editar Tarefa</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                <input type="hidden" id="editaridtarefa" name="idtarefa">
                <div class="mb-3">
                    <label for="editar_titulo" class="form-label">Título</label>
                    <input type="text" class="form-control" id="editartitulo" name="editartitulo" required>
                </div>
                <div class="mb-3">
                    <label for="editar_descricao" class="form-label">Descrição</label>
                    <textarea class="form-control" id="editardescricao" name="editardescricao" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="editar_categoria" class="form-label">Categoria</label>
                    <select class="form-control" id="editarcategoria" name="editarcategoria" required>
                    <option value="1">Trabalho</option>
                    <option value="2">Casa</option>
                    <option value="3">Estudos</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="editar_status" class="form-label">Status</label>
                    <select class="form-control" id="editarstatus" name="editarstatus">
                    <option value="pendente">Pendente</option>
                    <option value="em_andamento">Em Andamento</option>
                    <option value="concluida">Concluída</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="editarprazo" class="form-label">Prazo</label>
                    <input type="date" name="editarprazo" id="editarprazo" class="form-control">
                </div>
                <div class="modal-footer">
                <button type="submit" class="btn btn-success">Salvar Alterações</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <!-- tabulator -->
    <link href="<?php echo base_url(); ?>assets/tabulator/dist/css/tabulator_semanticui.min.css" rel="stylesheet">
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/tabulator/dist/js/tabulator.min.js"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/luxon@2.3.1/build/global/luxon.min.js"></script>
    <!-- dependencia para manipular datas dentro do tabulator -->


    <script>

        var tarefas = new Tabulator("#tarefas-tab", {            
            layout: "fitColumns",
            height: "calc(100vh - 290px)",
            ajaxURL: "<?php echo base_url('Tarefa/listar_ajax'); ?>",
            ajaxConfig: "POST",
            progressiveLoad: "scroll",
            progressiveLoadScrollMargin: 200,
            paginationSize: 20,
            placeholder: "Nenhum registro encontrado",
            sortMode: "remote",
            filterMode: "remote",
            initialFilter: [{
                field: "CONVERT(TAREFA.DATACRIACAO,DATE)",
                type: ">=",
                value: "<?php echo date('Y-m-d', strtotime('-30 days')); ?>"
                },
                {
                    field: "CONVERT(TAREFA.DATACRIACAO,DATE)",
                    type: "<=",
                    value: "<?php echo date('Y-m-d'); ?>"
                },
                 {
                    field: "TAREFA.IDUSUARIO",
                    type: "=",
                    value: "<?php echo $_SESSION['idusuario']; ?>"
                },
            ],
            dataLoaderLoading: '<i class="fa fa-circle-o-notch fa-spin text-secondary fa-3x fa-fw"></i>',
            columnDefaults: {
                vertAlign: "middle",
            },
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
                                <button type="button" class="btn btn-primary btn-sm btnEditar btn-space" data-id="${id}"><i class="fa fa-pencil"></i></button>
                                <button type="button" class="btn btn-danger btn-sm btnExcluir" data-id="${id}"><i class="fa fa-times"></i></button>
                            `;
                    },
                },
                {
                    title: "Nome",
                    field: "NOMEUSUARIO",
                    width: 120
                },
                {
                    title: "Tipo",
                    field: "NOMECATEGORIA",
                    width: 100
                },
                {
                    title: "Título",
                    field: "TITULO",
                    width: 200,
                },
                {
                    title: "Descrição",
                    field: "DESCRICAO",
                    width: 300,
                },
                {
                    title: "Prioridade",
                    field: "PRIORIDADE",
                    width: 100,
                    hozAlign: "center",
                    formatter: function(cell, formatterParams) {
                        const value = cell.getValue();
                        if (value === "baixa") {
                            return '<span class="badge bg-success">Baixa</span>';
                        } else if (value === "alta") {
                            return '<span class="badge bg-danger">Alta</span>';
                        } else {
                            return '<span class="badge bg-warning">Média</span>';
                        }
                    }
                },
                {
                    title: "Justificativa",
                    field: "JUSTIFICATIVA",
                    width: 150,
                },
                 {
                    title: "Data de Criação",
                    field: "DATACRIACAO",
                    width: 150,
                    hozAlign: "center",
                    headerHozAlign: "center",

                    formatter: function(cell) {
                        let data = cell.getValue();
                        if (!data) return "";
                        let d = new Date(data);
                        if (isNaN(d.getTime())) return data;

                        let dia = String(d.getDate()).padStart(2, '0');
                        let mes = String(d.getMonth() + 1).padStart(2, '0');
                        let ano = d.getFullYear();
                        let hora = String(d.getHours()).padStart(2, '0');
                        let minuto = String(d.getMinutes()).padStart(2, '0');

                        return `${dia}/${mes}/${ano} ${hora}:${minuto}`;
                    }
                },
               {
                    title: "Prazo de Conclusão",
                    field: "PRAZO",
                    width: 150,
                    hozAlign: "center",
                    headerHozAlign: "center",

                    formatter: function(cell) {
                        let data = cell.getValue();
                        if (!data) return "";
                        let d = new Date(data);
                        if (isNaN(d.getTime())) return data;

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
                    width: 200,
                    hozAlign: "center",
                    headerHozAlign: "center",
                    formatter: function(cell) {
                        const status = cell.getValue();
                        var id = cell.getRow().getData().IDTAREFA;
                        if (status === 'pendente') {
                            return `<button class="btn btn-sm btn-success btnAtualizarStatus" data-id="${id}">Pendente</button>`;
                        } else if (status === 'concluida') {
                            return `<button class="btn btn-sm btn-primary btnAtualizarStatus" data-id="${id}">Concluído</button>`;
                        } else {
                            return '<button class="btn btn-sm btn-danger">Cancelada</button>';
                        }
                    }
                },
            ],
        });

        $(function() {

            $('#formFiltro').on('submit', function() {
                var datainicio = $('#formFiltro input[name="datainicio"]').val();
                var datafinal = $('#formFiltro input[name="datafinal"]').val();
                var situacao = $('#formFiltro select[name="situacao"]').val();
                var descricao = $('#formFiltro input[name="filtrodescricao"]').val();
                var filtros = [];

                // Se tiver datas, usa as datas do form
                if (datainicio) {
                    filtros.push({
                        field: 'CONVERT(TAREFA.DATACRIACAO,DATE)',
                        type: ">=",
                        value: datainicio
                    });
                }

                if (datafinal) {
                    filtros.push({
                        field: 'CONVERT(TAREFA.DATACRIACAO,DATE)',
                        type: "<=",
                        value: datafinal
                    });
                }

                // Só aplica o filtro de status se foi preenchido
                if (situacao !== "") {
                    filtros.push({
                        field: 'TAREFA.STATUS',
                        type: "=",
                        value: situacao
                    });
                }

                if (descricao != '') {
                    filtros.push({
                        field: 'TAREFA.DESCRICAO',
                        type: "like",
                        value: `%${descricao}%`
                    });
                }

                tarefas.setFilter(filtros);
            });

            $('#btnLimpar').on('click', function() {
                // Limpa os campos do formulário
                $('#formFiltro')[0].reset();

                // Calcula datas padrão: hoje e 30 dias atrás
                var hoje = new Date();
                var dataFim = hoje.toISOString().split('T')[0];

                var dataInicioObj = new Date();
                dataInicioObj.setDate(dataInicioObj.getDate() - 30);
                var dataInicio = dataInicioObj.toISOString().split('T')[0];

                // Aplica os filtros de 30 dias
                tarefas.setFilter([{
                        field: 'CONVERT(TAREFA.DATACRIACAO,DATE)',
                        type: ">=",
                        value: dataInicio
                    },
                    {
                        field: 'CONVERT(TAREFA.DATACRIACAO,DATE)',
                        type: "<=",
                        value: dataFim
                    }
                ]);
            });

            $(document).on('click', '.btnAtualizarStatus', function() {

                var id = $(this).attr('data-id');

                Swal.fire({
                    title: "",
                    text: "Deseja alterar o status desta cotação?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Sim, alterar o status",
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        atualizar_status(id);
                    }
                });

            });

            $(document).on('click', '.btnEditar', function () {
            
                var id = $(this).data('id');

                    $.ajax({
                        url: '<?= base_url("Tarefa/carregartarefa/") ?>' + id,
                        type: 'POST',
                        dataType: 'json',
                        success: function (data) {
                            
                            if (data) {
                                $('#editaridtarefa').val(data.IDTAREFA); 
                                $('#editartitulo').val(data.TITULO);
                                $('#editardescricao').val(data.DESCRICAO);
                                $('#editarcategoria').val(data.IDCATEGORIA);
                                $('#editarstatus').val(data.STATUS); 
                                $('#editarprazo').val(data.PRAZO);
                                $('#modalEditar').modal('show');

                            } else {
                                Swal.fire('Erro', 'Tarefa não encontrada!', 'error');
                            }
                        },
                        error: function () {
                            Swal.fire('Erro', 'Erro ao buscar os dados da tarefa!', 'error');
                        }
                    });
                
            });

            $('#formEditar').on('submit', function() {

                var id = $('#editaridtarefa').val();
                var titulo = $('#editartitulo').val();
                var descricao = $('#editardescricao').val();
                var categoria = $('#editarcategoria').val();
                var status = $('#editarstatus').val();
                var prazo = $('#editarprazo').val();

                $.ajax({
                    url: '<?= base_url("Tarefa/atualizar/") ?>' + id,
                    type: 'POST',
                    data: {
                        titulo: titulo,
                        descricao: descricao,
                        idcategoria: categoria,
                        status: status,
                        prazo: prazo
                    },
                    success: function(response) {

                        if (response.sucesso) {

                            Swal.fire('Sucesso', 'Tarefa atualizada com sucesso!', 'success');
                            tarefas.setData(); 

                            $('#modalEditar').modal('hide');

                        } else {
                            Swal.fire('Erro', response.mensagem || 'Erro ao atualizar tarefa.', 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Erro', 'Erro ao comunicar com o servidor.', 'error');
                    }
                });

            });

        });

        function atualizar_status(idtarefa){ 

            $.post('<?= base_url("Tarefa/alterar_status"); ?>', {
                idtarefa: idtarefa
            }, function(data) {

                if (data.sucesso) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Status alterado!',
                        text: 'O status da tarefa foi atualizado com sucesso.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    tarefas.setData(); 
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro!',
                        text: data.mensagem || 'Erro ao atualizar status.'
                    });
                }
            }).fail(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Falha na conexão!',
                    text: 'Erro na comunicação com o servidor.'
                });
            });
        }

        
    </script>


</body>
</html>


