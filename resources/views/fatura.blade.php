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
            <p>Nome Cliente</p>
            <p>CNPJ Empresa</p>
            <p>Cidade</p>
            <p>Endereço</p>
            <p>CEP</p>
            <p>Telefone</p>
            <p>E-mail</p>
            @if ($fatura->observacao)
                <p>Observação</p>
            @endif
        </th>
        <th style="text-align: left; font-weight: normal; margin-left: 0px;">
            <p>{{ $fatura->cliente->name }}</p>
            <p>{{ $fatura->cliente->cnpj_cpf }}</p>
            <p>{{ $fatura->cliente->city }} - {{ $fatura->cliente->state }}</p>
            <p>{{ $fatura->cliente->address }}, {{ $fatura->cliente->number }}, {{ $fatura->cliente->area }}</p>
            <p>{{ $fatura->cliente->zip_code }}</p>
            <p>{{ $fatura->cliente->phone }}</p>
            <p>{{ $fatura->cliente->email }}</p>
            @if ($fatura->observacao)
                <p>{{ $fatura->observacao }}</p>
            @endif
        </th>
        <table style="margin-top: 1rem">
            <tr class="bg-blue text-white">
                <th>
                    <p>Vencimento</p>
                </th>
                <th>
                    <p>Total a Pagar</p>
                </th>
            </tr>
            <tr class="bg-bege">
                <td class="p-10 text-center">{{ $fatura->data_vencimento->format('d/m/Y') }}</td>
                <td class="p-10 text-center">R$ {{ $fatura->valor }}</td>
            </tr>
            <tr>
                <th class="pix bg-blue text-white" colspan="2">Chave Pix
                </th>
            </tr>
            <tr>
                <td class="bg-bege p-10 text-center" colspan="2 ">{{ $fatura->chave_pix }}
                </td>
            </tr>
        </table>
    </tr>
</table>
<table class="tabela-servicos">
    <tr>
        <th>Data Laudo</th>
        <th>Paciente</th>
        <th>Análise</th>
        <th>Amostra</th>
        <th>Valor Unit.</th>
    </tr>
    @foreach ($fatura->servicos as $servico)
        <tr class="itens">
            <td>{{ $servico->created_at->format('d/m/Y') }}</td>
            <td>{{ $servico->pet }}</td>
            <td>{{ implode(', ', $servico->analises->pluck('name')->toArray()) }}</td>
            <td>{{ $servico->request_number }}</td>
            <td>R$ {{ $servico->analises->sum('price') }}</td>
        </tr>
    @endforeach

    <tr class="footer">
        <td class="text-center">Total Geral</td>
        <td colspan="3"></td>
        <td class="text-center">R$
            {{ $fatura->valor }}
        </td>
    </tr>
</table>


<style>
    body {
        font-family: "Gill Sans Extrabold", sans-serif;
        font-weight: 10px
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

    .tabela-servicos {
        margin-top: 1rem;
    }

    .tabela-servicos th {
        background-color: #00145b;
        color: white;
        padding: 10px;
    }

    .tabela-servicos td {
        padding: 10px;
    }

    .tabela-servicos .footer {
        background-color: #00145b !important;
        color: white;
        padding: 10px;
    }

    .tabela-servicos .itens {
        background-color: #eeeff1;
        text-align: center;
    }

    .tabela-servicos .itens td {
        border-bottom: 1px solid #b4b4b4;
    }
</style>
