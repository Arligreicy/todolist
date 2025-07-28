<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
	<title>Login - Simuladores 3D</title>

	<!-- CoreUI & Font Awesome -->
	<link href="<?= base_url(); ?>/assets/coreui/dist/css/coreui.min.css" rel="stylesheet">
	<link href="<?= base_url(); ?>/assets/coreui/dist/css/style.css" rel="stylesheet">
	<link href="<?= base_url(); ?>/assets/font-awesome/css/font-awesome.min.css" rel="stylesheet">

	<style>
		body, html {
			height: 100%;
			margin: 0;
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
			overflow: hidden;
		}

		.card-body {
			padding: 3rem;
		}

		.login-header {
			font-size: 1.8rem;
			font-weight: bold;
			color: #2c3e50;
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
			animation-name: wave-animation;
			animation-duration: 2.5s;
			animation-iteration-count: infinite;
			transform-origin: 70% 70%;
		}

		/* animação da onda */
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
			background-color: #17a2b8; /* cor info */
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
			<div class="login-header"><span class="wave">👋</span> Bem-vindo de volta!</div>
				<p class="login-subtext">Acesse sua conta para aproveitar os simuladores</p>

				<form id="formLogin" method="post" action="javascript:void(0);">
					<div class="mb-3">
						<label for="txtLogin" class="form-label user">Usuário</label>
						<div class="input-group input-group-lg">
							<span class="input-group-text">
								<i class="fa fa-user"></i>
							</span>
							<input type="text" id="nome" name="nome" class="form-control" placeholder="Digite seu usuário" autocomplete="off" required>
						</div>
					</div>

					<div class="mb-4">
						<label for="txtSenha" class="form-label senha">Senha</label>
						<div class="input-group input-group-lg">
							<span class="input-group-text">
								<i class="fa fa-lock"></i>
							</span>
							<input type="password" id="senha" name="senha" class="form-control" placeholder="Digite sua senha" required>
						</div>
						<p class="mt-3 text-center">
							Não tem cadastro? <a href="<?= base_url('Usuario/cadastrar') ?>">Clique aqui para se cadastrar!</a>
						</p>
					</div>

					<!-- <?php
					echo password_hash('123456', PASSWORD_DEFAULT);
					?> -->
					
					<button type="submit" id="btnEntrar" class="btn btn-primary btn-lg w-100">Entrar</button>

													
					<div class="alert alert-info d-none" id="msg_login"></div>
				</form>
			</div>
		</div>
	</div>

	<!-- Scripts -->
	<script src="<?= base_url(); ?>/assets/js/jquery.min.js"></script>
	<script src="<?= base_url(); ?>/assets/coreui/dist/js/coreui.bundle.min.js"></script>

	  <!-- Intro Js -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/7.2.0/introjs.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intro.js/7.2.0/intro.min.js"></script>

	   <!-- sweetalert 2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<script>

	document.addEventListener("DOMContentLoaded", function() {
	// Ativação automática ao carregar (se quiser manter)
	// setupIntroJS();

	// Botão "Ajuda" aciona o intro manualmente
			document.getElementById("btnAjuda").addEventListener("click", function () {
				introJs().setOptions({
					nextLabel: 'Próximo ➡️',
					prevLabel: '⬅️ Voltar',
					doneLabel: 'Concluir ✅',
					steps: [
						{
							intro: "✨ Seja bem-vindo(a) à tela de login! ✨ <br/><br/> Clique em <strong>Próximo</strong> para explorar as funcionalidades disponíveis. 🚀"
						},
						{
							element: '.user',
							intro: "📂 Digite aqui o seu nome de usuário. 🧭"
						},
						{
							element: '.senha',
							intro: "📘 Aqui a sua senha. 🗓️"
						}
					]
				}).start();
			});
		});

		$(function () {

			$("#nome").focus();

			$('#formLogin').on('submit', function () {

				$('#btnEntrar').attr('disabled', 'disabled').html('<i class="fa fa-spinner fa-spin"></i> Entrando...');

				$.ajax({
					url: '<?= base_url("Usuario/logar"); ?>',
					type: 'POST',
					data: $('#formLogin').serialize(),
					dataType: 'json',

					success: function (retorno) {
						if (retorno.codigo === "ok") {
							Swal.fire({
								icon: 'success',
								title: 'Login realizado!',
								text: retorno.mensagem,
								showConfirmButton: false,
								timer: 1500
							}).then(() => {
								window.location = "<?= base_url("Tarefa/listar"); ?>";
							});
						} else {
							Swal.fire({
								icon: 'error',
								title: 'Erro ao entrar',
								text: retorno.mensagem
							});

							$('#btnEntrar').removeAttr('disabled').text('Entrar');
							$('#senha').select();
						}
					}
				});
			});
		});
	</script>
	
	<!-- Botão Flutuante de Ajuda do intro JS -->
		<button id="btnAjuda" class="btn-ajuda" title="Precisa de ajuda?">
			<i class="fa fa-question"></i>
		</button>
</body>
</html>