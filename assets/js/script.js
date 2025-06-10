function carregarUsuarios() {
    $.get('?action=list', function(data) {
        let rows = '';
        data.forEach(u => {
            rows += `<tr>
                <td>${u.id}</td><td>${u.name}</td><td>${u.documento}</td><td>${u.email}</td><td>${u.telefone}</td>
                <td>
                    <button class="btn btn-sm btn-primary editar-btn" data-usuario='${JSON.stringify(u)}'>Editar</button>
                    <button class="btn btn-sm btn-danger" onclick="excluirUsuario(${u.id})">Excluir</button>
                </td></tr>`;
        });
        $('#usersTable tbody').html(rows);

        if (data.length > 0) {
            $('#usersTable').removeClass('d-none');
            $('#emptyState').addClass('d-none');
            $('#userCount').text(data.length);
        } else {
            $('#usersTable').addClass('d-none');
            $('#emptyState').removeClass('d-none');
            $('#userCount').text(0);
        }
    }, 'json');
}

$(document).on('click', '.editar-btn', function() {
    const usuario = JSON.parse($(this).attr('data-usuario'));
    editarUsuario(usuario);
});

function editarUsuario(usuario) {
    $('#userId').val(usuario.id);
    $('[name="name"]').val(usuario.name);
    $('[name="cpfOrcnpj"]').val(usuario.documento);
    $('[name="email"]').val(usuario.email);
    $('[name="telefone"]').val(usuario.telefone);
    $('[name="password"]').val('');

    $('#userModal .modal-title').text('Editar Usuário');
    $('#userForm button[type="submit"]').text('Salvar Alterações');

    const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('userModal'));
    modal.show();
}

$('[data-bs-target="#userModal"]').on('click', function () {
    $('#userForm')[0].reset();
    $('#userId').val('');
    $('#userModal .modal-title').text('Novo Usuário');
    $('#userForm button[type="submit"]').text('Cadastrar');
});



function excluirUsuario(id) {
    if (confirm("Deseja excluir este usuário?")) {
        $.post('?action=delete', { id }, function() {
            carregarUsuarios();
        });
    }
}

$('#userForm').submit(function(e) {
    e.preventDefault();
    const formData = $(this).serialize();
    $.post('?action=' + ($('#userId').val() ? 'edit' : 'create'), formData, function(resp) {
    const modalEl = document.getElementById('userModal');

    modalEl.addEventListener('hidden.bs.modal', function () {
        const backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) backdrop.remove();
        document.body.classList.remove('modal-open');
    });
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.hide();
        carregarUsuarios();
    });
});
carregarUsuarios();
