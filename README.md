<p align="center"><img src="./public/img/Logo.png" width="400" alt="Logo do car control"></p>

## Sobre projeto

Este projeto representa meu trabalho pessoal em um sistema de controle de veículos, que permite registrar informações detalhadas sobre clientes e revisões. Desenvolvi uma aplicação robusta que vai além do simples controle de veículos, proporcionando acesso a informações valiosas. Meu sistema organiza e apresenta de forma eficiente os dados e informações obtidas.

> O objetivo principal do meu projeto é fornecer um controle abrangente sobre os veículos, oferecendo funcionalidades para cadastrar clientes, veículos e revisões. Além disso, implementei um dashboard intuitivo que proporciona aos usuários uma visão geral dos dados cadastrados, permitindo uma análise rápida e eficaz.

> Meu sistema é projetado para facilitar a gestão de veículos, fornecendo uma plataforma centralizada para armazenar e acessar informações relevantes. Estou comprometido em fornecer uma solução que atenda às necessidades dos usuários, proporcionando uma experiência simplificada e eficiente na gestão de frota.


## Recursos utilizados

- Laravel
- PHP
- Bootstrap
- VueJS
- PostgreSQL
- Jquery

## Libs(Adicionais)

- Select2
- SweetAlert
- ChartJS
- Moment
- InputMask
- ExcelJS
- JSPDF

## Hospedagem

- Em breve

## Instalação

> Pacotes VueJS:

```sh
npm install
```

> Pacotes Laravel:

```sh
composer install
```

## Ativar servidor

> Servidor VueJS:

```sh
npm run dev
```

> Servidor Laravel:

```sh
php artisan server
```

## Configurando Dusk

> Execute o seguinte comando:
```sh
php artisan dusk:install
```

```sh
php artisan dusk:chrome-driver
```

> No arquivo .env, em APP_URL, Modifique para: APP_URL=http://127.0.0.1:8000

> Em caso de erro na execução do comando, na pasta "bin" na raiz deste projeto, se encontra um certificado, no qual deve-se ser inserido em: C:\caminho\php\php_versão\extras\ssl (Modifique o caminho, inserindo o local onde se encontra o pasta extras\ssl correta do PHP)

> Após colar o certificado, localize o arquivo php.ini no seu computador, abra com algum editor de texto e no final do arquivo insira a seguinte linha:
```sh
curl.cainfo = "C:\caminho\php\php_versão\extras\sslcacert.pem"
```
> (Lembrando de colocar o caminho correto onde se encontra pasta extras\ssl do PHP)

## Imagens do projeto

<p align="center"><img src="./public/project/Page_one.png" alt="Página login"></p>
<p align="center"><img src="./public/project/Page_two.png" alt="Dashboard"></p>
<p align="center"><img src="./public/project/Page_three.png" alt="Página da tabela"></p>
<p align="center"><img src="./public/project/Page_four.png" alt="Página de celular"></p>

## Atualizações

* 1.1.2 - 🧪 New API test 
    * Refactoring the vehicle_data controller for the test

* 1.1.1 - 📝 Update the title on the excel page
    * Update the row style in the title

* 1.1.0 - ✨ Tests coverage and new column
    * New Plate column
    * Dusk finished
    * Updated Ids on pages

* 1.0.4 - 📝 Create account page
    * Add: delete account
    * Add: update password
    * Add: edit informations

* 1.0.3 - 📝 Update tests and styles
    * Update comments
    * Update icons
    * Update How to configure the dusk lib in ReadMe.md

* 1.0.2 - 📝 Initial tests
    * Creating tests
    * Add bin file
    * How to configure the dusk lib in ReadMe.md

* 1.0.1 - 📝 Update ReadMe.md
    * Update src

* 1.0.0 - ✨ First version
    * Releasing first version
    * Update ReadME.md
    * Update comments

* 0.5.0 - 📝 PDF and Excel page finished
    * Initial pages(PDF and Excel)
    * First style
    * Security / PDF and Excel model.

* 0.4.0 - 📝 Review page finished
    * Initial page(Reviews)
    * First style
    * Security.

* 0.3.1 - 📝 Vehicles page finished.
    * Select input.

* 0.3.0 - 📝 Add vehicles page
    * Initial page(Vehicles)
    * First style
    * Security.

* 0.2.0 - 📝 Add dashboard and customers page
    * Initial pages(Dashboard and customers)
    * Charts
    * First style
    * Security and Alert.

* 0.1.0 - 📝 Add: Login, register and home page.
    * Initial pages(Login, register and home)
    * First style
    * Authenticate and security.

* 0.0.1 - 🎉 First commit
    * Initial project.


## Informações adicionais

Euzebio Batista [@Linkedin](https://www.linkedin.com/in/euzebio-batista) - euzebio.batista2@gmail.com

Criado por **Euzebio Batista**.
**Todos os direitos reservados.**