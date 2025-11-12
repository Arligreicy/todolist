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

        <!-- FullCalendar -->
        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">

        <style>

            /* Força o modal do Bootstrap/CoreUI a ficar acima de todos os elementos */
            .modal {
            z-index: 2000 !important;
            }
            .modal-backdrop {
            z-index: 1999 !important;
            }
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
                padding-bottom: 70px;
            }
            .btn-hover-blue:hover {
                background-color:rgb(1, 0, 7) !important; 
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
            .c-footer {
                background-color: #000; /* Preto para combinar com a sidebar */
                color: #fff;
                padding: 15px 0;
                position: fixed;
                bottom: 0;
                left: 0;
                width: 100%;
                box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
                font-size: 14px;
                z-index: 1030;
            }

            .c-footer a {
                color: #321fdb; /* Azul padrão do seu sistema */
                text-decoration: none;
            }

            .c-footer a:hover {
                color: #0d6efd;
                text-decoration: underline;
            }
            .footer-right a {
                margin-left: 10px; /* espaçamento entre os ícones */
                color: #333; /* cor padrão */
                text-decoration: none;
                font-size: 18px;
                transition: color 0.3s ease;
            }

            .footer-right a:hover {
                color: #007bff; /* cor no hover */
            }
            .footer-right a:first-child {
                margin-left: 20px; /* dá espaço entre o nome e o GitHub */
            }
        </style>

    </head>

<body class="c-app">

    <!-- HEADER -->
    <header class="c-header c-header-light c-header-fixed header-dashboard">
        <ul class="c-header-nav ml-auto mr-4">
            <h1>Minhas Tarefas do Dia - <?= date('d/m/Y') ?> - <?= $_SESSION['nome'] ?></h1>
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
                <a class="c-sidebar-nav-link active" href="<?= base_url('tarefa/index') ?>">
                    <i class="fas fa-home me-2"></i> Home
                </a>
            </li>

            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link active" href="<?= base_url('tarefa/listar') ?>">
                    <i class="fas fa-list me-2"></i> Minhas Tarefas
                </a>
            </li>
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="javascript:void(0)" onclick="abrir_modal_perfil()">
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
                    <div class="container-mt-4">
                        <h3 class="mb-3"> 📅 Calendário de Tarefas</h3>
                        <div id="calendar"></div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="c-footer animated-footer">
        <div class="footer-left">
            <span>&copy; <?= date('Y') ?> ToDoList 📝</span>
            <span class="divider">|</span>
            <span>Desenvolvido com <i class="fas fa-heart text-danger"></i> por <strong>Arligreicy</strong></span>
        </div>
    
        <div class="footer-right">
            <a href="https://github.com/Arligreicy" title="GitHub" target="_blank">
                <i class="fab fa-github"></i>
            </a>
            <a href="https://www.linkedin.com/in/arligreicy-castro/" title="LinkedIn" target="_blank">
                <i class="fab fa-linkedin"></i>
            </a>
            <a href="mailto:arligreicy.1@gmail.com" title="E-mail">
                <i class="fas fa-envelope"></i>
            </a>
        </div>
    </footer>

    
    <!-- tabulator -->
    <link href="<?php echo base_url(); ?>assets/tabulator/dist/css/tabulator_semanticui.min.css" rel="stylesheet">
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/tabulator/dist/js/tabulator.min.js"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/luxon@2.3.1/build/global/luxon.min.js"></script>
    <!-- dependencia para manipular datas dentro do tabulator -->

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/min/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/locale/pt-br.min.js"></script>
    
    <!-- FullCalendar JS -->
    
    <script>

    document.addEventListener('DOMContentLoaded', function() {

        // Referência ao elemento onde o calendário será renderizado
        var calendarEl = document.getElementById('calendar');

        // Cria o calendário
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',   // visão inicial (mês)
            themeSystem: 'bootstrap5',     // usa o tema do Bootstrap
            locale: 'pt-br',               // idioma português
            height: 'auto',

            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
            },

            // Carrega eventos via AJAX do seu controller
            events: {
                url: '<?= base_url("Tarefa/listar_eventos"); ?>',
                method: 'GET',
                failure: function() {
                    Swal.fire('Erro!', 'Não foi possível carregar as tarefas!', 'error');
                }
            },

            // Quando clicar em um evento (tarefa)
            eventClick: function(info) {
                var evento = info.event.extendedProps;

                Swal.fire({
                    title: info.event.title,
                    html: `
                        <p><strong>Categoria:</strong> ${evento.categoria || 'Sem categoria'}</p>
                        <p><strong>Status:</strong> ${evento.status}</p>
                        <p><strong>Descrição:</strong><br>${evento.description || 'Sem descrição'}</p>
                        <p><strong>Prazo:</strong> ${moment(info.event.start).format('DD/MM/YYYY')}</p>
                    `,
                    icon: 'info',
                    confirmButtonText: 'Fechar'
                });
            },

            // Permitir arrastar eventos para alterar o prazo
            editable: true,
            eventDrop: function(info) {
                const id = info.event.id;
                const novoPrazo = info.event.start.toISOString().slice(0, 10); // formato YYYY-MM-DD

                $.ajax({
                    url: '<?= base_url("Tarefa/atualizar_prazo"); ?>',
                    type: 'POST',
                    data: { id: id, novo_prazo: novoPrazo },
                    success: function(res) {
                        if (res.sucesso) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Prazo atualizado!',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire('Erro!', res.mensagem || 'Falha ao atualizar prazo!', 'error');
                            info.revert(); // reverte o movimento
                        }
                    },
                    error: function() {
                        Swal.fire('Erro!', 'Erro na comunicação com o servidor.', 'error');
                        info.revert();
                    }
                });
            },

            // Configuração visual dos eventos
            eventDidMount: function(info) {
                var tooltip = new bootstrap.Tooltip(info.el, {
                    title: info.event.title + " - " + (info.event.extendedProps.categoria || ''),
                    placement: 'top',
                    trigger: 'hover',
                    container: 'body'
                });
            },

            // Botão de hoje em destaque
            buttonText: {
                today: 'Hoje',
                month: 'Mês',
                week: 'Semana',
                day: 'Dia',
                list: 'Lista'
            },
        });

        // Renderiza o calendário na tela
        calendar.render();
    });
        

    
    </script>


</body>
</html>


