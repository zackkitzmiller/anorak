@extends('layouts.page')

@section('content')
<section id="sectionone" class="features-section">
	<div class="container">
		<div class='row'>
			<div class='col-md-12 section-head'>
				<h1>My Account</h1>

				<h2>Your monthly cost</h2>
				<table class='table table-striped'>
					<thead>
						<th>Description</th>
						<th>Base Cost</th>
						<th>Quantity</th>
						<th>Subtotal</th>
					</thead>
					<tbody>
						<?php $totalMonthlyCost = 0; ?>
						@foreach(Auth::user()->subscriptions as $subscription)
						<?php $price = Config::get('subscriptions')[$subscription->price]; ?>
						<tr>
							<td>{{ $subscription->repo->full_github_name }}</td>
							<td>${{ $price }}</td>
							<td></td>
							<td></td>
						</tr>
						<?php $totalMonthlyCost += $price; ?>
						@endforeach
						<tr>
							<td colspan='3'>Total Monthly Cost</td>
							<td colspan='1' class='align-right'>${{ $totalMonthlyCost }}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</section>
@stop
