<table class="header font-bold">
    <tr>
        <th>
            <img class="logo" src="{{ public_path('logo.jpg') }}">
        </th>
        <th>
            <div class="font-blue" style="font-size: 12px">
                <h1 style="font-size: 22px">RELATORIO DE ANÁLISES</h1>
                <p> Travessa WE 33, Nº 01, Ed. Pátio Cidade Nova, Salva 11</p>
                <p> Cidade Nova IV, CEP: 67.133-185, Ananindeua-PA</p>
                <p> CNPJ: 27.755.310/0001-72</p>
                <p> Fone: (91) 9266-11-03</p>
                <p> E-mail: contato@pargen.com.br</p>
            </div>
        </th>
        <th>
            <div class="font-blue">
                <h1>FATURA</h1>
                <p class="text-center font-50"> {{ $fatura->id }} </p>
            </div>
        </th>
    </tr>
</table>

<table>
    <tr style="font-size: 13px;">
        <th style="text-align: left">
            <p>Recebemos de:</p>
            <p>Cliente</p>
            <p>CNPJ/CPF</p>
            <p>Cidade</p>
            <p>Endereço</p>
            <p>CEP</p>
            <p>Telefone</p>
            <p>E-mail</p>
        </th>
        <th style="text-align: left; font-weight: normal; margin-left: 0px;">
            <p></p>
            <p>{{ $fatura->cliente->name }}</p>
            <p>{{ $fatura->cliente->cnpj_cpf }}</p>
            <p>{{ $fatura->cliente->city }} - {{ $fatura->cliente->state }}</p>
            <p>{{ $fatura->cliente->address }}, {{ $fatura->cliente->number }}, {{ $fatura->cliente->area }}</p>
            <p>{{ $fatura->cliente->zip_code }}</p>
            <p>{{ $fatura->cliente->phone }}</p>
            <p>{{ $fatura->cliente->email }}</p>
        </th>

    </tr>
</table>
<table class="mt-10">
    <tr>
        <th style="text-align: left">A Importância de: </th>
        <th style="text-align: right">Data de
            recebimento: {{ empty($fatura->data_baixa) ? 'Não recebido' : $fatura->data_baixa->format('d/m/Y') }}</th>
    </tr>
</table>

<table class="mt-10">
    <tr>
        <td>A quantia de R$: {{ $fatura->valor_pago }}</td>
        <td></td>
    </tr>
</table>

<table class="mt-10">
    <tr>
        <td>Referente a: </td>
    </tr>
    <tr>
        <td>Relatório de número : {{ $fatura->id }} </td>
    </tr>
</table>

<table class="mt-10">
    <tr>
        <td></td>
        <td style="text-align: right;">Ananideua, {{ now()->format('d/m/Y') }} </td>
    </tr>
</table>

<table style="margin-top: 50px;">
    <tr>
        <td style="text-align: center;">____________________________________________________</td>
    </tr>
    <tr>
        <td style="text-align: center;">
            <p class="m-0">Elisabete Santos</p>
            <p class="m-0">Diretora Financeira</p>
        </td>
    </tr>
</table>

<style>
    body {
        font-family: "Gill Sans Extrabold", sans-serif;
        font-weight: 10px
    }

    .m-0 {
        margin: 0;
    }

    .p-10 {
        padding: 10px;
    }

    .bg-bege {
        background-color: #ffbc8c;
    }

    .font-blue {
        color: #00145b;
    }

    .font-bold {
        font-weight: bold;
    }

    .bg-blue {
        background-color: #00145b;
    }

    .text-white {
        color: white;
    }

    .header {
        background-color: #eeeff1;
    }

    .logo {
        height: 80px;
        width: 200px;

    }

    .text-center {
        text-align: center;
    }

    .pix {
        text-align: center;
        padding: 10;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    .mt-10 {
        margin-top: 10px;
    }
</style>
