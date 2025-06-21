<p>Olá {{ $seller->name }},</p>
<p>Seu resumo de vendas do dia {{ $date }}:</p>
<ul>
    <li>Quantidade de vendas: {{ $totalSales }}</li>
    <li>Valor total: R$ {{ number_format($totalAmount, 2, ',', '.') }}</li>
    <li>Comissão total: R$ {{ number_format($totalCommission, 2, ',', '.') }}</li>
</ul>