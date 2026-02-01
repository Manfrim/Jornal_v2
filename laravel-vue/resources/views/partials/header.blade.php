<!-- Topbar -->
<div class="bg-light border-bottom small py-1">
    <div class="container d-flex justify-content-between align-items-center">
        <span class="text-muted">
            {{ date('d/m/Y') }}
        </span>
        <span class="text-muted">
            Jornal pessoal · por Prof. Manfrim
        </span>
    </div>
</div>

<!-- Header principal -->
<nav class="navbar navbar-expand-lg bg-white sticky-top shadow-sm">
    <div class="container">

        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center gap-2" href="#">
            <img src="{{ asset('img/logotipo.png') }}"
                alt="Logo Professor Manfrim"
                class="logo-jornal">
        </a>

        <!-- Botão mobile -->
        <button class="navbar-toggler border-0" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarJornal"
                aria-controls="navbarJornal"
                aria-expanded="false">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Conteúdo -->
        <div class="collapse navbar-collapse" id="navbarJornal">

            <!-- Menu -->
            <ul class="navbar-nav mx-auto mb-3 mb-lg-0 fw-semibold gap-lg-3 text-start text-lg-center">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Artigos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Currículo</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Portfólio</a>
                </li>
            </ul>

            <!-- Busca -->
            <form class="d-flex justify-content-center">
                <input class="form-control form-control-sm rounded-pill me-2"
                       type="search"
                       placeholder="Pesquisar">
                <button class="btn btn-outline-primary btn-sm rounded-pill">
                    Buscar
                </button>
            </form>

        </div>
    </div>
</nav>
