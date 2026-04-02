## 🚀 Configuração do Projeto Laravel

### 1. Preparar o PHP (Instalar Extensões)

Antes de baixar os pacotes do Laravel, garanta que o PHP da máquina nova tem todas as ferramentas necessárias para rodar o framework e se conectar ao banco.

```bash
sudo apt update
sudo apt install php8.3-curl php8.3-xml php8.3-mbstring php8.3-mysql

💡 Se a máquina usar outra versão do PHP (ex: 8.2), basta substituir 8.3 no comando.

2. Baixar as Dependências do Projeto

Com o PHP pronto, mande o Composer baixar a famosa pasta vendor.

⚠️ Execute dentro da pasta do projeto:

composer install
3. Configurar o Ambiente (.env)

O arquivo .env não vai para o GitHub por segurança. Você precisa recriá-lo a partir do arquivo de exemplo e gerar uma nova chave de criptografia.

cp .env.example .env
php artisan key:generate
4. Apontar para o Banco de Dados

Abra o arquivo .env e configure as credenciais do banco de dados da nova máquina.

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_do_seu_banco
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
5. Criar as Tabelas (Migrações)

Com o banco configurado e o driver instalado, execute as migrações:

php artisan migrate
6. Ligar o Servidor (Opcional)

Para testar a API no navegador, Postman ou Insomnia:

php artisan serve
