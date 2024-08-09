# CRM Laravel 📊

**CRM Laravel** é um sistema de gerenciamento de relacionamento com o cliente (CRM) desenvolvido em Laravel. O projeto inclui funcionalidades de autenticação, recuperação de senha e envio de emails para autenticação.

## Funcionalidades
- Autenticação de usuários com login e registro.
- Recuperação de senha com envio de emails.
- Envio de emails para autenticação e recuperação de senha.
- Gerenciamento de clientes e interações.

## Requisitos
Para rodar o projeto na sua máquina, você precisará de:
- PHP 8.0 ou superior
- Composer
- MySQL 5.7 ou superior
- Laravel 8.x
- Um servidor de email (como SMTP) para envio de emails
- Um navegador moderno

## Configuração do Ambiente

1. **Banco de Dados**:
   - Crie um banco de dados no MySQL.
   - Importe o arquivo SQL disponível no projeto para configurar as tabelas e dados iniciais.

2. **Configuração do Projeto**:
   - Copie o arquivo `.env.example` para `.env` e configure as variáveis de ambiente:
     ```bash
     cp .env.example .env
     ```
   - Configure as credenciais do banco de dados no arquivo `.env`:
     ```
     DB_DATABASE=nome_do_banco
     DB_USERNAME=seu_usuario
     DB_PASSWORD=sua_senha
     ```
   - Configure as opções de envio de email no arquivo `.env`:
     ```
     MAIL_MAILER=smtp
     MAIL_HOST=smtp.exemplo.com
     MAIL_PORT=587
     MAIL_USERNAME=seu_usuario
     MAIL_PASSWORD=sua_senha
     MAIL_ENCRYPTION=tls
     MAIL_FROM_ADDRESS=seu_email@exemplo.com
     MAIL_FROM_NAME="${APP_NAME}"
     ```

3. **Instalar Dependências**:
   - Instale as dependências do projeto utilizando o Composer:
     ```bash
     composer install
     ```
   - Gere a chave da aplicação:
     ```bash
     php artisan key:generate
     ```

4. **Executar as Migrações**:
   - Execute as migrações para configurar as tabelas no banco de dados:
     ```bash
     php artisan migrate
     ```

5. **Configurar o Envio de Emails**:
   - Certifique-se de que o servidor de email está configurado corretamente para envio de emails. Teste a configuração enviando um email de teste.

6. **Iniciar o Servidor**:
   - Inicie o servidor localmente com o comando:
     ```bash
     php artisan serve
     ```
   - Acesse a aplicação no navegador em `http://localhost:8000`.

## Licença
Este projeto está licenciado sob a [MIT License](LICENSE).
