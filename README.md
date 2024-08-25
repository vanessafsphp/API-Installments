# Desafio Técnico - API RESTful para Parcelas de Carnê

Este é um projeto de API RESTful que é responsável por gerar e apresentar as parcelas de uma geração de carnê, proposto pelo Desafio Técnico da Tenex, como uma das etapas do seu processo seletivo para vaga de Desenvolvedor Full Stack.

Esta API foi desenvolvida em Laravel 11, e consiste em 2 endpoints, um para geração do carnê e suas parcelas e outro para apresentar (buscar) as parcelas pelo ID do carnê.

## Requisitos

- PHP >= 8.3
- Composer
- Framework Laravel 11
- MySQL ou outro banco de dados compatível

## Instalação

### Passo 1: Clonar o repositório

```bash
git clone https://github.com/seu-usuario/api-installments.git
```
Acesse o diretório raiz do projeto:
```bash
cd api-installments
```

### Passo 2: Instalar as dependências
```bash
composer install
```

### Passo 3: Configurar o ambiente
Copie o arquivo `.env.example` para `.env`:
```bash
cp .env.example .env
```
Edite o arquivo .env e configure com as informações do seu banco de dados.

### Passo 4: Gerar a chave da aplicação
Rode o comando para a geração da chave da aplicação Laravel:
```bash
php artisan key:generate
```

### Passo 5: Executar as migrações
As migrations do projeto já foram criadas e estão na pasta `database/migrations`, rode o comando para executar as migrações e gerar as tabelas no seu banco de dados, já configurado no seu arquivo `.env`:
```bash
php artisan migrate
```

### Passo 6 - Popular o banco de dados com dados fictícios
Este passo é opcional, e poderá ser utilizado para fins de teste da API, caso deseje popular seu banco de dados com dados fictícios, rode o comando de seeder, isso fará com que o Laravel crie dados fictícios aleatórios:
```bash
php artisan db:seed
```

### Passo 6: Iniciar o servidor de desenvolvimento local
Inicia o servidor local do Laravel
```bash
php artisan serve
```
A aplicação estará disponível localmente em http://localhost:8000.

Para testar a API, você pode usar ferramentas como Postman, Insomnia, cURL ou até mesmo bibliotecas de teste integradas ao Laravel, como PHPUnit.

### Rodar teste via PHPUnit
Para executar o teste unitário criado com PHPUnit, basta rodar o seguinte comando:
```bash
php artisan test 
```

## Descrição do Problema

Desenvolver uma API RESTful em PHP que seja responsável por gerar e apresentar as parcelas de
uma geração de carnê. A API deve receber o valor total, a quantidade de parcelas, o primeiro dia de
cobrança, a periodicidade e um possível valor de entrada. A resposta deve conter o total, o valor de
entrada (se houver) e as parcelas. Cada parcela deve incluir a data de vencimento, o valor e o
número da parcela. A soma total das parcelas deve ser sempre igual ao valor total enviado. Quando
houver valor de entrada deve ser considerado como uma parcela independente e não precisa
respeitar a periodicidade, devendo ter uma propriedade entrada=true .

## Acessando os Endpoints

### POST - Criação do Carnê
Rota: `http://localhost:8000/api/carne`

Entrada de dados via JSON (body):
#### Cenário Obrigatório 1:
```bash
{
	"valor_total": 100.00,
    "qtd_parcelas": 12,
    "data_primeiro_vencimento": "2024-08-01",
    "periodicidade": "mensal"
} 
```
Saída esperada:
O somatório das parcelas deve ser igual a 100.00
```bash
{
	"total": 100.00,
	"valor_entrada": 0.00,
    "parcelas": [
		{
			"data_vencimento": "2024-08-01",
			"valor": "8.33",
			"numero": 1,
			"entrada": false
		},
		{
			"data_vencimento": "2024-09-01",
			"valor": "8.33",
			"numero": 2,
			"entrada": false
		},
		{
			"data_vencimento": "2024-10-01",
			"valor": "8.33",
			"numero": 3,
			"entrada": false
		},
		{
			"data_vencimento": "2024-11-01",
			"valor": "8.33",
			"numero": 4,
			"entrada": false
		},
		{
			"data_vencimento": "2024-12-01",
			"valor": "8.33",
			"numero": 5,
			"entrada": false
		},
		{
			"data_vencimento": "2025-01-01",
			"valor": "8.33",
			"numero": 6,
			"entrada": false
		},
		{
			"data_vencimento": "2025-02-01",
			"valor": "8.33",
			"numero": 7,
			"entrada": false
		},
		{
			"data_vencimento": "2025-03-01",
			"valor": "8.33",
			"numero": 8,
			"entrada": false
		},
		{
			"data_vencimento": "2025-04-01",
			"valor": "8.33",
			"numero": 9,
			"entrada": false
		},
		{
			"data_vencimento": "2025-05-01",
			"valor": "8.33",
			"numero": 10,
			"entrada": false
		},
		{
			"data_vencimento": "2025-06-01",
			"valor": "8.33",
			"numero": 11,
			"entrada": false
		},
		{
			"data_vencimento": "2025-07-01",
			"valor": "8.33",
			"numero": 12,
			"entrada": false
		}
	]
} 
```

#### Cenário Obrigatório 2:
Entrada JSON:
```bash
{
	"valor_total": 0.30,
    "qtd_parcelas": 2,
    "data_primeiro_vencimento": "2024-08-01",
    "periodicidade": "semanal",
    "valor_entrada": 0.10
} 
```
Saída esperada:
O somatório das parcelas deve ser igual a 0.30, a entrada deve ser considerada como uma
parcela, a quantidade de parcelas deve ser 2.
```bash
{
	"total": 0.30,
	"valor_entrada": 0.10,
    "parcelas": [
		{
			"data_vencimento": "2024-08-01",
			"valor": "0.10",
			"numero": 1,
			"entrada": true
		},
		{
			"data_vencimento": "2024-08-08",
			"valor": "0.20",
			"numero": 2,
			"entrada": false
		}
	]
} 
```

### GET - Apresentação das Parcelas por ID do Carnê
Rota: `http://localhost:8000/api/carne/{$id}/parcelas`
Parâmetro: `$id` - Identificador do Carnê.

Saída esperada:
```bash
{
	"total": "100.00",
	"valor_entrada": "0.00",
	"parcelas": [
		{
			"data_vencimento": "2024-08-01",
			"valor": "8.33",
			"numero": 1,
			"entrada": false
		},
		{
			"data_vencimento": "2024-09-01",
			"valor": "8.33",
			"numero": 2,
			"entrada": false
		},
		{
			"data_vencimento": "2024-10-01",
			"valor": "8.33",
			"numero": 3,
			"entrada": false
		},
		{
			"data_vencimento": "2024-11-01",
			"valor": "8.33",
			"numero": 4,
			"entrada": false
		},
		{
			"data_vencimento": "2024-12-01",
			"valor": "8.33",
			"numero": 5,
			"entrada": false
		},
		{
			"data_vencimento": "2025-01-01",
			"valor": "8.33",
			"numero": 6,
			"entrada": false
		},
		{
			"data_vencimento": "2025-02-01",
			"valor": "8.33",
			"numero": 7,
			"entrada": false
		},
		{
			"data_vencimento": "2025-03-01",
			"valor": "8.33",
			"numero": 8,
			"entrada": false
		},
		{
			"data_vencimento": "2025-04-01",
			"valor": "8.33",
			"numero": 9,
			"entrada": false
		},
		{
			"data_vencimento": "2025-05-01",
			"valor": "8.33",
			"numero": 10,
			"entrada": false
		},
		{
			"data_vencimento": "2025-06-01",
			"valor": "8.33",
			"numero": 11,
			"entrada": false
		},
		{
			"data_vencimento": "2025-07-01",
			"valor": "8.37",
			"numero": 12,
			"entrada": false
		}
	]
} 
```

## Autor
Desenvolvido por [Vanessa Gomes Bueno](https://github.com/vanessafsphp). Se tiver alguma dúvida ou sugestão, entre em contato através do meu e-mail: [vanessa.webdeveloper@gmail.com](vanessa.webdeveloper@gmail.com) ou [WhatsApp](https://wa.me/5519991654193).