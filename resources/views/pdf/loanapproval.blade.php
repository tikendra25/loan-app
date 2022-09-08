<p> Hi, {{$name}} </p>
<p> Your Loan request have been {{$status}} </p>
@if(isset($emis) && count($emis))	
<p> Your Loan Detial are as following: </p>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Loan Start Date</th>
			<th>Loan End date</th>
			<th>Total Emis</th>
			<th>Loan Amount</th>
			<th>Pending Emis</th>
			<th>Outstanding Amount</th>
			<th>Monthly Emi Amount</th>		
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>{{$emis['start_date']}}</td>
			<td>{{$emis['finish_date']}}</td>
			<td>{{$emis['total_emis']}}</td>
			<td>{{$emis['loan_amount']}}</td>
			<td>{{$emis['pending_emis']}}</td>
			<td>{{$emis['outstanding_amount']}}</td>
			<td>{{$emis['monthly_emi_amount']}}</td>		
		</tr>
	</tbody>	
</table>
@endif