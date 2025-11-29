# 🌱 Projeto Plantou!

Central de Monitoramento, Adoção, Reflorestamento e Preservação de Árvores Urbanas

📌 Sobre o Projeto

O Plantou! é uma plataforma digital desenvolvida como projeto acadêmico, criada para centralizar informações sobre árvores urbanas e incentivar a população a participar de ações de preservação e reflorestamento.
A plataforma permite acompanhar cada árvore, adotar, doar, solicitar manutenção e visualizar dados ambientais de forma simples, transparente e acessível.

🎯 Objetivo Principal

Criar um sistema capaz de registrar, monitorar e disponibilizar informações sobre árvores urbanas, promovendo conscientização ambiental e iniciativas de reflorestamento, utilizando tecnologia moderna como QR Code, PWA, IoT e banco de dados integrado.

🧩 Funcionalidades Principais
✔️ Cadastro e Login

Sistema desenvolvido em PHP, com autenticação e validação.

Hash seguro de senhas (password_hash).

Formulários responsivos (HTML, CSS e JavaScript).

✔️ Acompanhamento e Reflorestamento

Cada árvore possui um QR Code único para rastreamento.

Histórico da árvore: espécie, localização, podas, manutenções e saúde.

Adoção de árvores e acompanhamento do impacto ambiental (CO²).

Doações direcionadas para ações de reflorestamento urbano e recuperação de áreas verdes.

✔️ Sistema de Doações e Recompensas

Doações com valor simbólico a partir de R$5, destinadas ao plantio e reflorestamento.

Usuários acumulam moedas virtuais, badges e níveis conforme interações.

✔️ Plataforma como PWA

Acesso offline.

Disponível em qualquer dispositivo com interface responsiva.

✔️ IoT e Blockchain

Sensores para monitoramento de temperatura, umidade e parâmetros ambientais (conceito acadêmico).

Transparência garantida por registros em blockchain.

🛠️ Tecnologias Utilizadas
Frontend

HTML5

CSS3

JavaScript

Interface responsiva

Validação de formulários

Backend

PHP (CRUD de árvores, usuários e doações)

Autenticação com password_hash

Tratamento de erros e validação de dados

Banco de Dados

MySQL

Configuração e testes via XAMPP

Conexão com mysqli ou PDO

Tabelas para árvores, usuários, doações, adoções e histórico

Segurança

password_hash e password_verify

Prepared Statements contra SQL Injection

Controle de sessões e restrição de páginas internas

🗂️ Estrutura Geral do Projeto
/plantou
├── index.php
├── login.php
├── cadastro.php
├── conexao.php
├── dashboard/
├── arvore/
├── doacoes/
├── css/
├── js/
└── assets/

🌳 Reflorestamento no Plantou!

O projeto integra o conceito de reflorestamento urbano, permitindo que doações sejam destinadas ao plantio de novas árvores e recuperação de áreas verdes degradadas.
Através do QR Code, o usuário pode acompanhar:

Crescimento da árvore adotada/plantada

CO² absorvido

Condição ambiental

Localização precisa

Histórico ambiental atualizado

Essa abordagem conecta tecnologia, educação ambiental e impacto real.

🚀 Como Executar o Projeto (XAMPP)

Instalar XAMPP.

Mover a pasta do projeto para:
C:/xampp/htdocs/plantou

Iniciar Apache e MySQL.

Importar o banco de dados no phpMyAdmin.

Acessar no navegador:
http://localhost/plantou.

👥 Equipe do Projeto

Marcelle Martins Dobroski Bastos

Erasmo Carlos De Lima Silva Filho

João Carlos Sara Melo Junior

Thiago Santana Messias

Gustavo Prelado da Silva

Marcos Antônio Pontes dos Santos da Silva

Se quiser, posso gerar este README em PDF, Markdo
