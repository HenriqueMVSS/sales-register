# Sistema de Registro de Vendas

Um sistema completo de gestão de vendas desenvolvido em Laravel com interface moderna usando Tailwind CSS e Bootstrap.

## 🚀 Funcionalidades

### Funcionalidades Principais

-   ✅ **Gestão de Vendas**: Criação, visualização, edição e exclusão de vendas
-   ✅ **Gestão de Clientes**: Cadastro completo de clientes (opcional para vendas)
-   ✅ **Gestão de Produtos**: Controle de estoque e preços
-   ✅ **Métodos de Pagamento**: Suporte a múltiplas formas de pagamento
-   ✅ **Sistema de Parcelas**: Parcelamento automático com controle de vencimentos
-   ✅ **Controle de Estoque**: Redução automática do estoque ao finalizar venda

### Funcionalidades Adicionais

-   ✅ **Sistema de Login**: Autenticação completa com Laravel UI
-   ✅ **Controle de Vendedores**: Cada venda é vinculada ao usuário autenticado
-   ✅ **Filtros Avançados**: Filtros por cliente, vendedor, método de pagamento, data e status
-   ✅ **Geração de PDF**: Relatórios de venda em PDF com layout profissional
-   ✅ **Interface Responsiva**: Design moderno e responsivo
-   ✅ **Validações Completas**: Validação de estoque, parcelas e dados

## 🛠️ Tecnologias Utilizadas

-   **Backend**: Laravel 12.x (PHP 8.2+)
-   **Frontend**: Blade Templates + Bootstrap 5 + JavaScript/jQuery
-   **Banco de Dados**: MySQL 8.0 / SQLite (desenvolvimento)
-   **Geração de PDF**: DomPDF
-   **Autenticação**: Laravel UI
-   **Containerização**: Docker & Docker Compose
-   **Estilização**: CSS customizado com paleta de cores moderna

## 📋 Pré-requisitos

### Opção 1: Desenvolvimento Local

-   PHP 8.2+
-   Composer
-   Node.js & NPM
-   MySQL/SQLite

### Opção 2: Docker (Recomendado)

-   Docker
-   Docker Compose

## 🔧 Instalação

### Usando Docker (Recomendado)

1. **Clone o repositório**

```bash
git clone <url-do-repositorio>
cd registroVendas
```

2. **Configure o ambiente**

```bash
cp .env.example .env
```

3. **Ajuste as variáveis do .env para Docker**

```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=registrovendas
DB_USERNAME=sail
DB_PASSWORD=secret
```

4. **Construa e inicie os containers**

```bash
docker-compose up -d --build
```

5. **Instale as dependências**

```bash
docker-compose exec app composer install
docker-compose exec app npm install
```

6. **Gere a chave da aplicação**

```bash
docker-compose exec app php artisan key:generate
```

7. **Execute as migrações e seeders**

```bash
docker-compose exec app php artisan migrate --seed
```

8. **Compile os assets**

```bash
docker-compose exec app npm run dev
```

### Instalação Local

1. **Clone e configure**

```bash
git clone <url-do-repositorio>
cd registroVendas
cp .env.example .env
```

2. **Instale dependências**

```bash
composer install
npm install
```

3. **Configure banco (SQLite para desenvolvimento)**

```bash
php artisan key:generate
php artisan migrate --seed
```

4. **Compile assets e inicie servidor**

```bash
npm run dev
php artisan serve
```

## 🎯 Como Usar

### Primeiro Acesso

1. **Acesse a aplicação**

    - Docker: http://localhost:8000
    - Local: http://localhost:8000

2. **Faça login com um dos usuários criados**
    - **Admin**: admin@test.com / password
    - **Vendedores**: joao@test.com, maria@test.com, carlos@test.com / password
    - **Gerente**: ana@test.com / password

### Fluxo Básico de Uso

#### 1. Cadastrar Produtos

-   Acesse "Produtos" no menu
-   Clique em "Novo Produto"
-   Preencha nome, descrição, preço e estoque

#### 2. Cadastrar Clientes (Opcional)

-   Acesse "Clientes" no menu
-   Clique em "Novo Cliente"
-   Preencha os dados do cliente

#### 3. Criar uma Venda

-   Acesse "Vendas" no menu
-   Clique em "Nova Venda"
-   Selecione cliente (opcional)
-   Escolha método de pagamento
-   Adicione produtos à venda
-   Defina número de parcelas
-   Salve a venda

#### 4. Gerenciar Vendas

-   **Visualizar**: Clique no ícone de olho para ver detalhes
-   **Editar**: Clique no ícone de lápis para modificar
-   **PDF**: Clique no ícone de PDF para baixar relatório
-   **Excluir**: Clique no ícone de lixeira (cuidado!)

### Funcionalidades Avançadas

#### Filtros de Venda

-   **Por Cliente**: Filtre vendas de um cliente específico
-   **Por Vendedor**: Veja vendas de cada vendedor
-   **Por Método de Pagamento**: Filtre por forma de pagamento
-   **Por Data**: Defina período específico
-   **Por Status**: Pendente, Concluída ou Cancelada

#### Sistema de Parcelas

-   Parcelas são criadas automaticamente
-   Cada método de pagamento tem suas regras:
    -   Dinheiro/PIX: Apenas à vista
    -   Cartão de Crédito: Até 12x
    -   Crediário: Até 24x

#### Controle de Estoque

-   Estoque é reduzido automaticamente na venda
-   Validação impede venda com estoque insuficiente
-   Indicadores visuais de estoque baixo

## 🏗️ Arquitetura do Sistema

### Estrutura MVC

```
app/
├── Http/
│   ├── Controllers/     # Controllers (SaleController, CustomerController, etc.)
│   └── Requests/        # Form Requests (validações)
├── Models/              # Models Eloquent
└── Services/            # Services (regras de negócio)

resources/
├── views/
│   ├── layouts/         # Layout principal
│   ├── sales/           # Views de vendas
│   ├── customers/       # Views de clientes
│   └── products/        # Views de produtos
└── css/                 # Estilos customizados

database/
├── migrations/          # Estrutura do banco
└── seeders/            # Dados iniciais
```

### Modelos e Relacionamentos

-   **User**: Vendedores do sistema
-   **Customer**: Clientes (opcional nas vendas)
-   **Product**: Produtos com controle de estoque
-   **PaymentMethod**: Métodos de pagamento com regras
-   **Sale**: Vendas principais
-   **SaleItem**: Itens de cada venda
-   **Installment**: Parcelas das vendas

## 🎨 Personalização

### Cores do Sistema

O sistema usa uma paleta de cores moderna definida em CSS Variables:

```css
:root {
    --primary: oklch(0.623 0.214 259.815); /* Azul principal */
    --secondary: oklch(0.967 0.001 286.375); /* Cinza claro */
    --destructive: oklch(0.577 0.245 27.325); /* Vermelho */
    --background: oklch(1 0 0); /* Branco */
    --foreground: oklch(0.141 0.005 285.823); /* Preto */
}
```

### Modificar Layout

-   **Layout Principal**: `resources/views/layouts/app.blade.php`
-   **Estilos**: Inline no layout principal
-   **Logo/Nome**: Altere `config/app.php`

## 📊 Dados de Exemplo

O sistema vem com dados pré-cadastrados:

### Usuários do Sistema

-   **Admin Sistema** (admin@test.com)
-   **João Vendedor** (joao@test.com)
-   **Maria Silva** (maria@test.com)
-   **Carlos Santos** (carlos@test.com)
-   **Ana Gerente** (ana@test.com)
-   **Senha padrão**: password

### Clientes de Exemplo

-   10 clientes variados (pessoas físicas e jurídicas)
-   Dados completos: nome, email, telefone, documento, endereço
-   Mistura de CPF e CNPJ para demonstração

### Métodos de Pagamento

-   Dinheiro (à vista)
-   PIX (à vista)
-   Cartão de Débito (à vista)
-   Cartão de Crédito (até 12x)
-   Crediário (até 24x)

### Produtos de Exemplo

-   Smartphones, Notebooks, TVs
-   Fones de ouvido, Periféricos
-   Preços variados e estoque controlado

## 🔒 Segurança

-   ✅ Autenticação obrigatória
-   ✅ Proteção CSRF
-   ✅ Validação de dados server-side
-   ✅ Sanitização de inputs
-   ✅ Controle de acesso por rotas

## 🚀 Deploy

### Produção com Docker

1. Configure variáveis de ambiente de produção
2. Use volumes persistentes para dados
3. Configure SSL/HTTPS
4. Ajuste configurações do nginx

### Otimizações de Produção

```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build
```

## 🤝 Contribuição

1. Fork o projeto
2. Crie uma branch para sua feature
3. Commit suas mudanças
4. Push para a branch
5. Abra um Pull Request

## 📝 Licença

Este projeto está sob a licença MIT. Veja o arquivo LICENSE para mais detalhes.

## 🐛 Problemas Conhecidos

-   PDF pode ter problemas com caracteres especiais em algumas configurações
-   Filtros mantêm estado durante navegação (feature, não bug)

## 📞 Suporte

Para dúvidas ou problemas:

1. Verifique a documentação
2. Confira os logs em `storage/logs/`
3. Abra uma issue no repositório

---

**Desenvolvido com ❤️ usando Laravel + Bootstrap + Tailwind CSS**
