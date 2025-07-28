<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <title>Cadastro - Simuladores</title>

  <!-- CoreUI & Font Awesome -->
  <link href="<?= base_url(); ?>/assets/coreui/dist/css/coreui.min.css" rel="stylesheet">
  <link href="<?= base_url(); ?>/assets/font-awesome/css/font-awesome.min.css" rel="stylesheet">

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Intro.js -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/7.2.0/introjs.min.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/intro.js/7.2.0/intro.min.js"></script>

  <style>
    body, html {
      height: 100%;
      background-color: #f8f9fa;
    }

    .login-container {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }

    .login-card {
      width: 100%;
      max-width: 450px;
      box-shadow: 0 0 25px rgba(0, 0, 0, 0.1);
      border-radius: 1rem;
      background-color: #ffffff;
    }

    .card-body {
      padding: 3rem;
    }

    .login-header {
      font-size: 1.8rem;
      font-weight: bold;
      color: #004085;
      text-align: center;
    }

    .login-subtext {
      text-align: center;
      color: #6c757d;
      margin-bottom: 2rem;
    }

    .alert {
      margin-top: 1rem;
      font-size: 0.9rem;
    }

    .wave {
      display: inline-block;
      animation: wave-animation 2.5s infinite;
      transform-origin: 70% 70%;
    }

    @keyframes wave-animation {
      0% { transform: rotate(0deg); }
      10% { transform: rotate(14deg); }
      20% { transform: rotate(-8deg); }
      30% { transform: rotate(14deg); }
      40% { transform: rotate(-4deg); }
      50% { transform: rotate(10deg); }
      60% { transform: rotate(0deg); }
      100% { transform: rotate(0deg); }
    }

    .btn-ajuda {
      position: fixed;
      bottom: 20px;
      right: 20px;
      width: 50px;
      height: 50px;
      border-radius: 50%;
      background-color: #17a2b8;
      color: white;
      border: none;
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
      font-size: 22px;
      cursor: pointer;
      z-index: 9999;
      transition: all 0.3s ease;
    }

    .btn-ajuda:hover {
      background-color: #138496;
      box-shadow: 0 6px 12px rgba(0,0,0,0.3);
    }
  </style>
</head>

<body>
  <div class="login-container">
    <div class="card login-card">
      <div class="card-body">
        <div class="login-header"><span class="wave">📝</span> Crie sua conta</div>
        <p class="login-subtext">Cadastre-se para usar os simuladores</p>

        <form id="formCadastro">
          <div class="mb-3">
            <label for="nome" class="form-label user">Nome de Usuário</label>
            <div class="input-group input-group-lg">
              <span class="input-group-text"><i class="fa fa-user"></i></span>
              <input type="text" class="form-control" name="nome" id="nome" placeholder="Digite seu nome" required autofocus />
            </div>
          </div>

          <div class="mb-4">
            <label for="senha" class="form-label senha">Senha</label>
            <div class="input-group input-group-lg">
              <span class="input-group-text"><i class="fa fa-lock"></i></span>
              <input type="password" class="form-control" name="senha" id="senha" placeholder="Digite uma senha segura" required />
            </div>
            <p class="mt-3 text-center">
              Já tem uma conta? <a href="<?= base_url('Usuario/login') ?>">Clique aqui para entrar</a>
            </p>
          </div>

          <button type="submit" class="btn btn-primary btn-lg w-100">Cadastrar</button>
        </form>
      </div>
    </div>
  </div>

  <!-- jQuery e CoreUI -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="<?= base_url(); ?>/assets/coreui/dist/js/coreui.bundle.min.js"></script>

  <script>
    $(document).ready(function () {

      $('#formCadastro').submit(function (e) {
        e.preventDefault();

        const nome = $('#nome').val().trim();
        const senha = $('#senha').val();

        if (nome === '' || senha === '') {
          Swal.fire({
            icon: 'warning',
            title: 'Atenção',
            text: 'Preencha todos os campos!',
            confirmButtonColor: '#f0ad4e'
          });
          return;
        }

        $.ajax({
          url: "<?= base_url('Usuario/salvar_cadastro') ?>",
          type: 'POST',
          dataType: 'json',
          data: { nome, senha },
          success: function (resposta) {
            if (resposta.status === 'ok') {
              Swal.fire({
                icon: 'success',
                title: 'Cadastro realizado!',
                text: 'Usuário cadastrado com sucesso.',
                confirmButtonColor: '#3085d6'
              }).then(() => {
                window.location.href = "<?= base_url('Usuario/login') ?>";
              });
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Erro ao cadastrar',
                text: resposta.mensagem || 'Tente novamente.',
                confirmButtonColor: '#d33'
              });
            }
          },
          error: function () {
            Swal.fire({
              icon: 'error',
              title: 'Erro de conexão',
              text: 'Não foi possível comunicar com o servidor.',
              confirmButtonColor: '#d33'
            });
          }
        });
      });

      // Ajuda com introJS
      document.getElementById("btnAjuda").addEventListener("click", function () {
        introJs().setOptions({
          nextLabel: 'Próximo ➡️',
          prevLabel: '⬅️ Voltar',
          doneLabel: 'Concluir ✅',
          steps: [
            {
              intro: "👋 Bem-vindo ao cadastro! <br/>Vamos te ajudar a preencher corretamente."
            },
            {
              element: '.user',
              intro: "📂 Digite seu nome de usuário aqui."
            },
            {
              element: '.senha',
              intro: "🔒 Escolha uma senha segura aqui."
            }
          ]
        }).start();
      });

    });
  </script>

  <!-- Botão Flutuante de Ajuda -->
  <button id="btnAjuda" class="btn-ajuda" title="Precisa de ajuda?">
    <i class="fa fa-question"></i>
  </button>
</body>
</html>