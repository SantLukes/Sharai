🏨 Projeto Hotel Sharai - Sistema de Gestão de Hotelaria

## 1. Apresentação

Este repositório contém o projeto final do curso de capacitacão (POT 2025)

O desafio consistiu em construir um sistema de gestão de hotelaria funcional, implementando uma interface para clientes (Site) e uma interface para gestão (Painel Administrativo), com foco na robustez, segurança e qualidade da experiência do utilizador.

---

## 2. Checklist de Requisitos (Escopo)

O projeto cumpre 100% dos requisitos obrigatórios (MVP)

### ✅ MVP - (Minimum Viable Product)

- [x] **Site (Cliente):** Tela (`sharan.php`) para reserva de quartos.
- [x] **Formulário de Reserva:** Campos de Data, Quarto, Adultos e Crianças.
- [x] **Modal de Hóspede:** Captura de dados (Nome, CPF, E-mail, Telefone).
- [x] **Validações de Frontend (JS):** Validação robusta em tempo real de todos os campos do modal, incluindo máscaras para CPF/Telefone e validação de "só letras" no nome.
- [x] **CRUD de Quartos:** Painel admin para Criar, Ler, Atualizar e Excluir quartos.
- [x] **CRUD de Reservas:** Painel admin para Criar, Ler, Atualizar e Excluir reservas.

### ✅ V1.0 - (Entrega Plus)

- [x] **Login de Admin:** Sistema de login seguro (utilizando `password_hash()` e `password_verify()`) para o painel.
- [x] **CRUD de Usuários:** Painel admin para gestão de outros administradores.
- [x] **Validação de Conflito de Datas:** O sistema possui 3 níveis de validação para garantir a integridade das reservas:
  1.  **(UI):** O calendário (Flatpickr) desativa visualmente os dias já ocupados para o quarto selecionado.
  2.  **(UX):** O JavaScript valida o conflito _antes_ de abrir o modal de dados do hóspede.
  3.  **(Backend):** O PHP (`processa-reserva-cliente.php`) tem uma verificação final de segurança no banco de dados para garantir 100% de integridade contra reservas duplicadas.

---

## 🏆 3. Features "Plus" (Diferenciais)

Para garantir uma entrega de alta qualidade e com visão de produto, foram implementadas as seguintes melhorias que não estavam no escopo original:

1.  **Dashboard Administrativo:** O painel de admin (`index.php`) possui um dashboard que apresenta KPIs (Indicadores-Chave) do negócio, como "Quartos Cadastrados", "Reservas Totais" e "Usuários do Painel".
2.  **UX Avançada no Calendário:** Implementação da biblioteca Flatpickr com um tema CSS personalizado, funcionalidade de 2 meses e um fluxo de utilizador inteligente (selecionar o check-in abre e configura o check-out).
3.  **Feedback Pós-Recarga (UX/Backend):** O sistema não dá apenas um "refresh". O backend (PHP) envia um status (`?reserva=sucesso` ou `?erro=...`) que o frontend (JS) lê e usa para ativar os modais de Sucesso ou Erro, criando um ciclo de feedback completo para o utilizador.
4.  **Histórico de Commits Profissional:** O histórico do Git foi reescrito (`git rebase`) para refletir um fluxo de trabalho profissional, com mensagens de commit claras e semânticas.

---

## 🛠️ 4. Como Preparar o Ambiente (Instalação)

Para executar este projeto, você precisará de um ambiente de servidor local (Apache + MySQL), um editor de código e um gestor de banco de dados.

### 4.1. Instalação do XAMPP (Servidor Local)

O XAMPP é o pacote que instala o Apache (servidor) e o MySQL (banco de dados) de forma simples.

1.  **Baixar:** Acesse [https://www.apachefriends.org/pt_br/index.html].
2.  **Instalar:** Baixe e instale a versão para o seu sistema operacional (Windows, Linux ou Mac). Siga o instalador padrão ("Next" > "Next" > "Finish").

### 4.2. Editor de Código (IDE)

Para visualizar e editar o código, recomendamos um editor moderno.

- **VS Code (Recomendado):** [Baixar aqui](https://code.visualstudio.com/)
- **Sublime Text:** [Baixar aqui](https://www.sublimetext.com/)
- **PhpStorm (Avançado):** [Baixar aqui](https://www.jetbrains.com/phpstorm/)

### 4.3. Gestor de Banco de Dados (SQL)

O XAMPP já inclui o **phpMyAdmin** (que usaremos abaixo), mas um cliente SQL dedicado é recomendado para visualização.

- **HeidiSQL (Windows):** [Baixar aqui](https://www.heidisql.com/download.php)
- **DBeaver (Multiplataforma):** [Baixar aqui](https://dbeaver.io/download/)

---

## 🚀 5. Como Executar o Projeto (Passo a Passo)

Siga estes 5 passos para rodar o projeto localmente.

### 5.1. Inicie o Servidor

1.  Abra o **Painel de Controle do XAMPP**.
2.  Clique em **"Start"** para os módulos **Apache** e **MySQL**.

### 5.2. Clone o Repositório

1.  Navegue até a pasta `htdocs` do seu XAMPP.
    - (Padrão Windows: `C:\xampp\htdocs`)
    - (Padrão Linux: `/opt/lampp/htdocs`)
2.  Abra um terminal (CMD, PowerShell ou Terminal) dentro desta pasta.
3.  Execute o comando `git clone`:

    `   git clone https://github.com/SantLukes/Sharai.git`

4.  Isso criará a pasta `htdocs\Sharai` (ou o nome do seu repositório).

### 5.3. Crie o Banco de Dados

1.  No seu navegador, acesse o phpMyAdmin: `http://localhost/phpmyadmin`
2.  Clique em **"Novo"** (ou "New") no menu à esquerda.
3.  Digite o nome do banco de dados: `Sharan-Hotel`
4.  Clique em **"Criar"**.

### 5.4. Importe o "Dump" do SQL

1.  Depois de criar, selecione o banco `Sharan-Hotel` na lista à esquerda.
2.  Clique na aba **"Importar"** (ou "Import") no menu superior.
3.  Clique em **"Escolher arquivo"** (ou "Browse").
4.  Navegue até a pasta do projeto que você clonou e selecione o ficheiro:
    `htdocs\Sharai\database\Sharan-Hotel.sql`
5.  Role até o final da página e clique em **"Executar"** (ou "Go").

### 5.5. Acesse o Sistema

Se tudo correu bem, o sistema está pronto:

- **Para ver o Site (Cliente):**
  Acesse: `http://localhost/Sharai/sharan.php`

- **Para ver o Painel (Admin):**
  Acesse: `http://localhost/Sharai/admin/`

---

## 🔑 6. Credenciais de Acesso (Admin)

Para testar o painel administrativo:

- **Usuário:** `pot@essentia.com.br`
- **Senha:** `capacitacao2025`

_(Estas credenciais estão no ficheiro `Sharan-Hotel.sql`.)_

---
