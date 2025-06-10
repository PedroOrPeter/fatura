<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Gerenciamento de Usuários</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #f9f9f9;
    }
    .card-empty {
      text-align: center;
      padding: 40px;
      color: #6c757d;
    }
    .modal-header h5 {
      font-weight: bold;
    }
    .btn-dark {
      background-color: #111;
      border: none;
    }
  </style>
</head>
<body class="p-4">
  <div class="d-flex justify-content-between align-items-start mb-4">
    <div>
      <h2 class="fw-bold">Gerenciamento de Usuários</h2>
      <p class="text-muted">Cadastre e gerencie usuários do sistema</p>
    </div>
    <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#userModal">
      <i class="bi bi-plus"></i> Novo Usuário
    </button>
  </div>

  <div class="card shadow-sm border-0">
    <div class="card-body">
      <h5 class="mb-1 fw-semibold"><i class="bi bi-people me-2"></i> Usuários Cadastrados</h5>
      <small class="text-muted">Total de <span id="userCount">0</span> usuários cadastrados</small>

      <div id="userTableWrapper" class="mt-4">
        <div class="card card-empty" id="emptyState">
          <i class="bi bi-person-x fs-1"></i>
          <p class="mt-3 mb-0">Nenhum usuário cadastrado</p>
          <small class="text-muted">Clique em "Novo Usuário" para começar</small>
        </div>

        <table class="table table-bordered mt-3 d-none" id="usersTable">
          <thead class="table-light">
            <tr>
              <th>ID</th>
              <th>Nome</th>
              <th>CPF/CNPJ</th>
              <th>Email</th>
              <th>Telefone</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="modal fade" id="userModal" tabindex="-1">
    <div class="modal-dialog">
      <form class="modal-content" id="userForm">
        <div class="modal-header">
          <h5 class="modal-title">Novo Usuário</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <small class="text-muted mb-3 d-block">Preencha os dados para cadastrar um novo usuário</small>
          <input type="hidden" name="id" id="userId">
          <div class="mb-3">
            <label class="form-label">Nome</label>
            <input type="text" class="form-control" name="name" placeholder="Digite o nome completo" required>
          </div>
          <div class="mb-3">
            <label class="form-label">CPF/CNPJ</label>
            <input type="text" class="form-control" name="cpfOrcnpj" placeholder="000.000.000-00 ou 00.000.000/0000-00" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" placeholder="usuario@exemplo.com" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Telefone</label>
            <input type="text" class="form-control" name="telefone" placeholder="(00) 00000-0000" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Senha</label>
            <input type="password" class="form-control" name="password" placeholder="Senha" id="passwordInput">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-dark">Editar</button>
        </div>
      </form>
    </div>
  </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>
