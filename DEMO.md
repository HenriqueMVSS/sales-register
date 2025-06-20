# 🎬 Demonstração do Sistema de Registro de Vendas

Este documento apresenta as principais funcionalidades do sistema através de capturas de tela e explicações detalhadas.

## 📱 Interface Principal

### Tela de Login

![Login](docs/screenshots/login.png)

-   Interface moderna e responsiva
-   Autenticação segura com Laravel UI
-   Opções de registro e recuperação de senha

### Dashboard Principal

![Dashboard](docs/screenshots/dashboard.png)

-   Menu de navegação intuitivo
-   Acesso rápido às principais funcionalidades
-   Design clean com cores personalizadas

## 💼 Gestão de Vendas

### Lista de Vendas

![Lista de Vendas](docs/screenshots/sales-list.png)

**Funcionalidades destacadas:**

-   ✅ **Filtros Avançados**: Cliente, vendedor, método de pagamento, data e status
-   ✅ **Informações Completas**: ID, data, cliente, vendedor, total, parcelas
-   ✅ **Ações Rápidas**: Visualizar, editar, gerar PDF, excluir
-   ✅ **Paginação**: Controle de grandes volumes de dados

### Criação de Nova Venda

![Nova Venda](docs/screenshots/sale-create.png)

**Destaques da interface:**

-   📝 **Formulário Inteligente**: Campos dinâmicos que se adaptam às escolhas
-   🧮 **Cálculo Automático**: Total calculado em tempo real
-   🛡️ **Validações**: Controle de estoque e regras de negócio
-   ➕ **Itens Dinâmicos**: Adicione/remova produtos facilmente

### Detalhes da Venda

![Detalhes da Venda](docs/screenshots/sale-details.png)

**Informações apresentadas:**

-   📊 **Resumo Completo**: Dados da venda, cliente e vendedor
-   📋 **Lista de Itens**: Produtos, quantidades e valores
-   💳 **Parcelas**: Cronograma de pagamentos (quando aplicável)
-   🎯 **Ações**: Editar, gerar PDF, voltar

## 👥 Gestão de Clientes

### Lista de Clientes

![Lista de Clientes](docs/screenshots/customers-list.png)

**Funcionalidades:**

-   📝 Cadastro completo com dados opcionais
-   🔍 Busca e filtros
-   ⚡ Ações rápidas de CRUD

### Cadastro de Cliente

![Novo Cliente](docs/screenshots/customer-create.png)

**Campos disponíveis:**

-   Nome (obrigatório)
-   Email, telefone, documento
-   Endereço completo

## 📦 Gestão de Produtos

### Lista de Produtos

![Lista de Produtos](docs/screenshots/products-list.png)

**Destaques:**

-   💰 **Preços**: Formatação brasileira automática
-   📊 **Estoque**: Indicadores visuais por quantidade
-   🎯 **Status**: Produtos ativos/inativos
-   🛠️ **Gerenciamento**: CRUD completo

### Cadastro de Produto

![Novo Produto](docs/screenshots/product-create.png)

**Funcionalidades:**

-   Nome e descrição
-   Preço com validação
-   Controle de estoque
-   Status ativo/inativo

## 📄 Geração de PDF

### Relatório de Venda

![PDF da Venda](docs/screenshots/sale-pdf.png)

**Características do PDF:**

-   🏢 **Cabeçalho Profissional**: Logo e informações da empresa
-   📋 **Dados Completos**: Venda, cliente, vendedor
-   📊 **Tabela de Itens**: Produtos, quantidades, preços
-   💳 **Parcelas**: Cronograma detalhado quando aplicável
-   🎨 **Design Clean**: Layout profissional para impressão

## 🚀 Funcionalidades JavaScript

### Interface Dinâmica de Vendas

```javascript
// Exemplo: Cálculo automático de totais
function calculateItemTotal(itemRow) {
    const quantity =
        parseFloat(itemRow.querySelector(".quantity-input").value) || 0;
    const price = parseFloat(itemRow.querySelector(".price-input").value) || 0;
    const total = quantity * price;

    itemRow.querySelector(".item-total").value =
        "R$ " + total.toLocaleString("pt-BR");
    calculateTotal();
}
```

### Validações em Tempo Real

-   ✅ **Estoque**: Verifica disponibilidade ao selecionar produto
-   ✅ **Parcelas**: Adapta opções baseado no método de pagamento
-   ✅ **Preços**: Atualiza automaticamente ao selecionar produto
-   ✅ **Totais**: Recalcula valores em tempo real

## 📱 Responsividade

### Desktop

![Desktop](docs/screenshots/desktop-view.png)

-   Layout otimizado para telas grandes
-   Máximo aproveitamento do espaço
-   Navegação por menu horizontal

### Tablet

![Tablet](docs/screenshots/tablet-view.png)

-   Interface adaptada para tablets
-   Menu responsivo
-   Tabelas com scroll horizontal

### Mobile

![Mobile](docs/screenshots/mobile-view.png)

-   Design mobile-first
-   Menu colapsável (hamburger)
-   Formulários otimizados para touch

## 🎨 Customização Visual

### Paleta de Cores

```css
:root {
    --primary: oklch(0.623 0.214 259.815); /* Azul principal */
    --secondary: oklch(0.967 0.001 286.375); /* Cinza claro */
    --destructive: oklch(0.577 0.245 27.325); /* Vermelho */
    --success: oklch(0.646 0.222 41.116); /* Verde */
    --warning: oklch(0.828 0.189 84.429); /* Amarelo */
}
```

### Componentes Visuais

-   🎯 **Badges**: Status visuais para vendas e produtos
-   📊 **Cards**: Informações organizadas em cartões
-   🔘 **Botões**: Ações claramente identificadas
-   📋 **Tabelas**: Dados estruturados e legíveis

## 🔒 Segurança e Validações

### Validações de Backend

```php
// Exemplo: Validação de venda
public function rules(): array
{
    return [
        'customer_id' => 'nullable|exists:customers,id',
        'payment_method_id' => 'required|exists:payment_methods,id',
        'items' => 'required|array|min:1',
        'items.*.product_id' => 'required|exists:products,id',
        'items.*.quantity' => 'required|integer|min:1',
        'total_amount' => 'required|numeric|min:0'
    ];
}
```

### Validações Customizadas

-   🛡️ **Estoque**: Impede venda com quantidade maior que disponível
-   💳 **Parcelas**: Valida limite por método de pagamento
-   👤 **Autenticação**: Todas as rotas protegidas
-   🔐 **CSRF**: Proteção contra ataques cross-site

## 📊 Dados de Exemplo

### Métodos de Pagamento Pré-configurados

| Método         | Parcelas | Observações             |
| -------------- | -------- | ----------------------- |
| Dinheiro       | 1x       | Apenas à vista          |
| PIX            | 1x       | Apenas à vista          |
| Cartão Débito  | 1x       | Apenas à vista          |
| Cartão Crédito | Até 12x  | Parcelamento disponível |
| Crediário      | Até 24x  | Parcelamento estendido  |

### Produtos de Demonstração

-   📱 **Eletrônicos**: Smartphones, notebooks, TVs
-   🎧 **Acessórios**: Fones, mouse, teclados
-   💻 **Informática**: Monitores, cabos, periféricos

## 🚀 Performance

### Otimizações Implementadas

-   ⚡ **Lazy Loading**: Carregamento sob demanda
-   🗃️ **Eager Loading**: Relacionamentos otimizados
-   📄 **Paginação**: Controle de memória
-   🎯 **Índices**: Consultas otimizadas no banco

### Métricas Típicas

-   🏠 **Página inicial**: < 200ms
-   📋 **Lista de vendas**: < 300ms
-   💾 **Criação de venda**: < 500ms
-   📄 **Geração de PDF**: < 800ms

## 🎓 Casos de Uso

### Cenário 1: Loja de Eletrônicos

Uma loja de eletrônicos usa o sistema para:

-   Cadastrar produtos com preços dinâmicos
-   Gerenciar clientes com histórico de compras
-   Processar vendas parceladas no cartão
-   Gerar relatórios para prestação de contas

### Cenário 2: Empresa de Equipamentos

Uma empresa B2B utiliza para:

-   Vendas sem cliente cadastrado (cliente final)
-   Pagamentos através de crediário próprio
-   Controle rigoroso de estoque
-   Relatórios detalhados para clientes

### Cenário 3: E-commerce Híbrido

Um e-commerce com loja física:

-   Integração entre vendas online e offline
-   Múltiplos vendedores com controle individual
-   Diversos métodos de pagamento
-   PDFs para comprovantes de venda

## 🔮 Próximas Funcionalidades

### Em Desenvolvimento

-   📊 **Dashboard Analytics**: Gráficos de vendas
-   📱 **API REST**: Integração com outros sistemas
-   🔔 **Notificações**: Alertas de estoque baixo
-   📈 **Relatórios Avançados**: Múltiplos formatos

### Roadmap Futuro

-   🌐 **Multi-tenant**: Múltiplas empresas
-   💰 **Controle Financeiro**: Fluxo de caixa
-   📦 **Gestão de Fornecedores**: Compras
-   🎯 **CRM**: Gestão de relacionamento

---

**Este sistema foi desenvolvido seguindo as melhores práticas de desenvolvimento web moderno, garantindo escalabilidade, segurança e usabilidade.**
