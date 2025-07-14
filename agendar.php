<?php
require_once 'conexao.php';
if (!$conn) {
    die("Erro na conexão: " . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Agenda Corte X</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="Free Website Template" name="keywords">
        <meta content="Free Website Template" name="description">

        <!-- Favicon -->
        <link href="img/favicon.ico" rel="icon">

        <!-- Google Font -->
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">

        <!-- CSS Libraries -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
        <link href="lib/animate/animate.min.css" rel="stylesheet">
        <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
        <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="css/style.css" rel="stylesheet">
        <style>
            .profissionais {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
            }
            .prof-card {
                cursor: pointer;
                text-align: center;
                padding: 10px;
                border: 1px solid #ddd;
                border-radius: 5px;
            }
            .prof-card.active {
                background-color: #f0f0f0;
            }
        </style>
    </head>

    <body>
        <!-- Top Bar Start -->
        <div class="top-bar d-none d-md-block">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="top-bar-left">
                            <div class="text">
                                <h2>8:00 - 20:00</h2>
                                <p>Horários Seg - Sab</p>
                            </div>
                            <div class="text">
                                <h2> (11) 987654321</h2>
                                <p>Ligue para agendar uma consulta</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="top-bar-right">
                            <div class="social">
                                <a href=""><i class="fab fa-twitter"></i></a>
                                <a href=""><i class="fab fa-facebook-f"></i></a>
                                <a href=""><i class="fab fa-linkedin-in"></i></a>
                                <a href=""><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Top Bar End -->

        <!-- Nav Bar Start -->
        <div class="navbar navbar-expand-lg bg-dark navbar-dark">
            <div class="container-fluid">
                <a href="index.html" class="navbar-brand">Corte <span>X</span></a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav ml-auto">
                        <a href="index.html" class="nav-item nav-link">Ínicio</a>
                        <a href="about.html" class="nav-item nav-link">Sobre</a>
                        <a href="service.html" class="nav-item nav-link">Serviços</a>
                        <a href="price.html" class="nav-item nav-link">Loja</a>
                        <a href="team.html" class="nav-item nav-link">Barbeiros</a>
                        <a href="portfolio.html" class="nav-item nav-link">Galeria</a>
                        <a href="agendar.php" class="nav-item nav-link active">Agendamentos</a>
                        <a href="login.php" class="nav-item nav-link">Cadastre-se</a>
                        <a href="contact.html" class="nav-item nav-link">Contatos</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Nav Bar End -->

        <!-- Page Header Start -->
        <div class="page-header">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2>Reserve seu corte agora mesmo</h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page Header End -->

        <div class="container mt-4">
            <!-- Seleção de Profissionais -->
            <h5 class="mt-4">Selecione o Profissional:</h5>
            <div class="profissionais">
            <?php
            $res = mysqli_query($conn, "SELECT * FROM profissionais");
            if (!$res) {
                echo "<p>Erro na consulta: " . mysqli_error($conn) . "</p>";
            } elseif (mysqli_num_rows($res) == 0) {
                echo "<p>Nenhum profissional encontrado.</p>";
            } else {
                    while ($row = mysqli_fetch_assoc($res)) {
        $foto_url = 'img/profissionais/default.jpg'; // imagem padrão

        if (!empty($row['foto_url']) && file_exists($row['foto_url'])) {
            $foto_url = $row['foto_url']; // usa a imagem do banco se existir e o arquivo estiver presente
        }
        $foto_url = 'img/profissionais/carloseduardo.jpg';
        echo "<div class='prof-card' data-id='{$row['id']}'>
            <img src='{$foto_url}' width='80' height='80' style='border-radius:50%' 
                onerror=\"this.onerror=null; this.src='img/profissionais/default.jpg';\"><br>
            <strong>{$row['nome']}</strong>
        </div>";
}

            }
            ?>
            </div>

            <!-- Seleção de Serviço -->
            <div class="mb-3 mt-4">
                <label class="form-label">Serviço:</label>
                <select name="id_servico" id="servico" class="form-select" required>
                    <option value="">Selecione um profissional primeiro...</option>
                </select>
            </div>

            <!-- Formulário -->
            <form method="POST" action="salvar_agendamento.php" id="formAgendamento">
            <input type="hidden" name="id_profissional" id="id_profissional" required>

            <div class="mb-3">
                <label class="form-label">Data:</label>
                <input type="date" name="data" id="data" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Hora:</label>
                <select name="hora" id="hora_selecionada" class="form-control" required>
                    <option value="">Selecione uma hora</option>
                    <?php
                    for ($h = 8; $h <= 20; $h++) {
                        $hora = sprintf("%02d:00", $h);
                        echo "<option value='$hora'>$hora</option>";
                        $hora = sprintf("%02d:30", $h);
                        echo "<option value='$hora'>$hora</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="calendar" id="calendario">
                <!-- Calendário gerado dinamicamente -->
            </div>

            <input type="hidden" name="id_usuario" value="<?php echo $_SESSION['usuario']['id']; ?>">

            <button type="submit" class="btn btn-primary mt-3"><i class="bi bi-check-circle"></i> Confirmar Agendamento</button>
            </form>
        </div>

        <script>
        const profissionais = document.querySelectorAll('.prof-card');
        const id_prof_input = document.getElementById('id_profissional');
        const servicoSelect = document.getElementById('servico');
        const calendario = document.getElementById('calendario');
        const dataInput = document.getElementById('data');
        const horaInput = document.getElementById('hora_selecionada');

        // Seleção do profissional
        profissionais.forEach(prof => {
            prof.addEventListener('click', () => {
                console.log("Clicou no profissional ID: " + prof.dataset.id); // Debug
                if (!prof.dataset.id) {
                    console.log("Erro: data-id não encontrado");
                    return;
                }
                profissionais.forEach(p => p.classList.remove('active'));
                prof.classList.add('active');
                id_prof_input.value = prof.dataset.id;
                carregarServicos(prof.dataset.id);
                calendario.innerHTML = "";
            });
        });

        // Carregar serviços do profissional
        function carregarServicos(id_prof) {
            fetch(`buscar_servicos.php?id_prof=${id_prof}`)
                .then(res => {
                    if (!res.ok) throw new Error('Erro na requisição');
                    return res.json();
                })
                .then(data => {
                    servicoSelect.innerHTML = '<option value="">Selecione um serviço</option>';
                    if (data.length > 0) {
                        data.forEach(item => {
                            servicoSelect.innerHTML += `<option value="${item.id}" data-tempo="${item.tempo}">${item.nome} (${item.tempo} min)</option>`;
                        });
                    } else {
                        servicoSelect.innerHTML = '<option value="">Nenhum serviço disponível</option>';
                    }
                })
                .catch(error => console.error('Erro ao carregar serviços:', error));
        }

        // Atualizar calendário ao escolher data
        dataInput.addEventListener('change', atualizarCalendario);
        servicoSelect.addEventListener('change', atualizarCalendario);

        function atualizarCalendario() {
            const data = dataInput.value;
            const id_prof = id_prof_input.value;
            if (!data || !id_prof) return;

            fetch(`buscar_agendamentos.php?id_prof=${id_prof}&data=${data}`)
                .then(res => {
                    if (!res.ok) throw new Error('Erro na requisição');
                    return res.json();
                })
                .then(agendados => {
                    calendario.innerHTML = "";
                    const horas = gerarHoras();
                    const card = document.createElement('div');
                    card.className = 'day-card';
                    card.innerHTML = `<h5>${data}</h5>`;
                    horas.forEach(h => {
                        const ocupado = agendados.find(a => h >= a.hora_inicio && h < a.hora_fim);
                        const btn = document.createElement('div');
                        btn.className = ocupado ? 'occupied' : 'available';
                        btn.innerHTML = ocupado ? `<i class="bi bi-person-fill"></i> ${h} - Ocupado` : `<i class="bi bi-check-circle"></i> ${h} - Disponível`;

                        if (!ocupado) {
                            btn.addEventListener('click', () => {
                                document.querySelectorAll('.available').forEach(b => b.style.fontWeight = 'normal');
                                btn.style.fontWeight = 'bold';
                                horaInput.value = h;
                            });
                        }
                        card.appendChild(btn);
                    });
                    calendario.appendChild(card);
                })
                .catch(error => console.error('Erro ao carregar agendamentos:', error));
        }

        // Gerar horários
        function gerarHoras() {
            let horas = [];
            for (let h = 8; h <= 22; h++) {
                horas.push((h < 10 ? '0' : '') + h + ':00');
                horas.push((h < 10 ? '0' : '') + h + ':30');
            }
            return horas;
        }
        </script>

        <!-- Footer Start -->
        <div class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="footer-contact">
                                    <h2>Endereço e contatos</h2>
                                    <p><i class="fa fa-map-marker-alt"></i>Av.Paulista 1000</p>
                                    <p><i class="fa fa-phone-alt"></i>(11) 987654321</p>
                                    <p><i class="fa fa-envelope"></i>cortex@barbershop.com</p>
                                    <div class="footer-social">
                                        <a href=""><i class="fab fa-twitter"></i></a>
                                        <a href=""><i class="fab fa-facebook-f"></i></a>
                                        <a href=""><i class="fab fa-youtube"></i></a>
                                        <a href=""><i class="fab fa-instagram"></i></a>
                                        <a href=""><i class="fab fa-linkedin-in"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="footer-link">
                                    <h2>Recursos</h2>
                                    <a href="">Termos de uso</a>
                                    <a href="">Política de privacidade</a>
                                    <a href="">Cookies</a>
                                    <a href="">Ajuda</a>
                                    <a href="">Perguntas frequentes</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="footer-newsletter">
                            <h2>Novidades</h2>
                            <p>
                                Cadastre seu e-mail e receba as últimas novidades, promoções exclusivas e dicas diretamente no seu inbox. Fique sempre por dentro do que acontece no Corte X!
                            </p>
                            <div class="form">
                                <input class="form-control" placeholder="Seu Email aqui">
                                <button class="btn">Enviar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container copyright">
                <div class="row">
                    <div class="col-md-6">
                        <p>© <a href="#">Corte X</a>, Todos os direitos reservados.</p>
                    </div>
                    <div class="col-md-6">
                        <p>Desenvolvido por <a href="https://htmlcodex.com">Alvaro Diniz</a></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->

        <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
        <script src="lib/easing/easing.min.js"></script>
        <script src="lib/owlcarousel/owl.carousel.min.js"></script>
        <script src="lib/isotope/isotope.pkgd.min.js"></script>
        <script src="lib/lightbox/js/lightbox.min.js"></script>

        <!-- Contact Javascript File -->
        <script src="mail/jqBootstrapValidation.min.js"></script>
        <script src="mail/contact.js"></script>

        <!-- Template Javascript -->
        <script src="js/main.js"></script>
    </body>
</html>