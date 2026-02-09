![PHP](https://img.shields.io/badge/PHP-555555?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/BOOTSTRAP-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)

> Um sistema web para gerenciamento de usuários, desenvolvido com PHP e MySQL.

---

## Funcionalidades

Este projeto tem como futuro para além de um CRUD simples, com a perspectiva de implementar recursos modernos:

- **CRUD Completo:** Criação, Leitura, Atualização e Exclusão de usuários.
- **Segurança:**
  - Senhas criptografadas com `password_hash` (Bcrypt).
  - Proteção contra SQL Injection usando `Prepared Statements` e filtros.
  - Validação de dados no Back-end.
- **Interface Responsiva:** Layout construído com **Bootstrap 5**.
- **Feedback Visual:** Sistema de mensagens de sessão (Flash Messages) para alertar sucesso ou erro.

---

## Tecnologias Utilizadas

- **Back-end:** PHP 8.5
- **Banco de Dados:** MySQL 
- **Front-end:** HTML5, CSS3, Bootstrap 5

---

## Estrutura do Projeto

O projeto foi organizado separando responsabilidades para facilitar a manutenção:

```text
/
├── config/             # Configurações do Banco de Dados
├── includes/           # Componentes visuais reutilizáveis (Navbar, Mensagens)
├── views/              # Telas do sistema (Formulários)
├── index.php           # Página principal (Dashboard)
├── acoes.php           # Lógica de processamento (Inserts, Updates, Deletes)


