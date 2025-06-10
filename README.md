# Sistema de Gerenciamento de Clientes (PHP, MySQL, MVC)

Projeto simples para cadastro, edição e exclusão de clientes utilizando PHP, MySQL, jQuery, JavaScript e Bootstrap. A aplicação segue a arquitetura MVC e usa modais para os formulários.

---

## Funcionalidades

- Adicionar cliente com nome, CPF/CNPJ, email e telefone
- Editar cliente usando modal
- Excluir cliente
- Listar todos os clientes
- Validação de CPF/CNPJ, email e telefone
- Interface responsiva com Bootstrap e jQuery

---

## Tecnologias Utilizadas

- PHP
- MySQL
- jQuery
- Bootstrap 4/5
- Arquitetura MVC

---
## Acesse a URL com banco de dados integrado
1. http://www.faturarteste.infy.uk/


---
## Como rodar localmente

1. Clone este repositório:

   ```bash
   Salve o arquivo dentro da pasta htdocs do xampp
   git clone https://github.com/PedroOrPeter/fatura.git
   cd NomeDoProjeto
   
2. Digite no terminal
  ```bash
    Acesse o config.php e edite as credenciais de acordo com o seu banco local
    Execute o XAMPP e ligue o MYSQL
    Crie a tabela Fatura
    Importe o arquivo .sql no phpmyadmin
    Rode a aplicação com o comando php -S localhost:8000
