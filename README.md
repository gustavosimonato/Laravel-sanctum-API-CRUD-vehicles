# CRUD de Gerenciamento de Frota de Veículos

Este projeto é um CRUD (Create, Read, Update, Delete) desenvolvido em Laravel com o Laravel Sanctum para gerenciar uma frota de veículos.

## Instalação e Configuração

Siga as instruções abaixo para configurar e executar o projeto localmente.

### Pré-requisitos

- PHP >= 7.4
- Composer - [Instalação do Composer](https://getcomposer.org/download/)
- MySQL ou outro banco de dados de sua escolha
- Docker Desktop (opcional, mas recomendado) - [Instalação do Docker](https://www.docker.com/products/docker-desktop)
[este passo-a-passo utiliza o Docker Desktop]
### Passos de Instalação

1. Clone o repositório:
```
git clone https://github.com/gustavosimonato/Laravel-sanctum-API-CRUD-vehicles.git
```

2. Acesse o diretório do projeto:
```
cd Laravel-sanctum-API-CRUD-vehicles
```

3. Instale as dependências do Composer:
```
composer install
```

4. Copie o arquivo de ambiente:
```
cp .env.example .env
```

5. Gere a chave de aplicação:
```
php artisan key:generate
```

6. Inicie o ambiente Sail:
```
./vendor/bin/sail up -d
```

7. Execute as migrations:
```
./vendor/bin/sail artisan migrate
```

8. Inicie o server:
```
./vendor/bin/sail artisan serve
```
