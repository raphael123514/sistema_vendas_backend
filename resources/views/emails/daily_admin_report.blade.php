<p>Resumo geral de vendas do dia {{ $date }}:</p>
<ul>
    <li>Quantidade de vendas: {{ $totalSales }}</li>
    <li>Valor total: R$ {{ number_format($totalAmount, 2, ',', '.') }}</li>
</ul>