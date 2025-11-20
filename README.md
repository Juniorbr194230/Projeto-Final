💻 Apresentação do Projeto: Sistema de Cadastro CRUD
Este projeto consiste na criação de um Sistema Web completo de Gerenciamento de Cadastros, focado na integração entre o frontend (HTML/CSS/JavaScript) e o backend (PHP) utilizando o banco de dados PostgreSQL.

Tecnologias Utilizadas
Frontend: HTML5, CSS3 (com Flexbox e Grid para layout e design responsivo) e JavaScript (para manipulação do DOM e comunicação assíncrona).

Backend: PHP (utilizando a biblioteca PDO para comunicação segura com o banco de dados).

Banco de Dados: PostgreSQL (estrutura de dados e persistência).

Funcionalidades Implementadas (CRUD)
O sistema implementa o ciclo completo do CRUD (Create, Read, Update, Delete) em tempo real:

✅ C (Create - Cadastrar): Formulário de cadastro de novos itens (aluno, funcionário, produto) com envio de dados via AJAX/Fetch para o salvar.php.

✅ R (Read - Listar): Visualização dinâmica de todos os registros salvos no PostgreSQL, carregados via listar.php.

✅ U (Update - Editar): Funcionalidade de edição completa através de um Modal (editar.php), permitindo a modificação de qualquer campo do registro.

✅ D (Delete - Deletar): Remoção unitária e imediata de registros da lista e do banco de dados, realizada via deletar.php.

Destaques da Atividade
Conexão Segura: Uso de PDO para preparar e executar consultas SQL, prevenindo ataques de SQL Injection.

Arquitetura: Estrutura modularizada em múltiplas páginas (index.html, cadastrar.html, cadastros.html), garantindo organização e clareza de código.

Resolução de Erros: Identificação e solução do erro SQLSTATE[42P01]: Undefined table e ajustes de escopo em JavaScript para garantir a comunicação fluida entre o cliente e o servidor.
