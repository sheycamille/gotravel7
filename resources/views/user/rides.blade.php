@extends('layouts.app')

@section('title', 'My rides offered')

@section('active')

@section('sub-menu3', 'active')

@section('content')

@include('parts.small_header_extend')

<style type="text/css">
	span, label{
		font-size:18px;
	}
	table {
		font-family: arial, sans-serif;
		border-collapse: collapse;
		width: 100%;
	}

	td, th {
		border: 1px solid #dddddd;
		text-align: left;
		padding: 8px;
	}

	/*tr:nth-child(even) {
		background-color: #dddddd;
	}*/
</style>

<div class="main ">
	<div class="container">
		<div class="row">

			@include('parts.account_sidebar')

			<div class="col-sm-10">

				<h1>My lifts offered</h1>

				<hr class="hidden-xs">

				<table>
					<thead>
						<tr>
							<th>Ride</th>
							<th>Date\Time</th>
							<th>Vehicle</th>
							<th>Cost</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@forelse($rides as $ride)
						<tr>
							<td>From {{ $ride->departure }} to  {{ $ride->destination }}</td>
							<td>{{ $ride->getFullFormatedDate() }}</td>
							<td>{{ $ride->vehicle }}</td>
							<td>{{ $ride->cost + $ride->charges }}</td>
							<td><a href="{{ route('edit-ride', $ride->id) }}">Edit</a> | <a href="{{ route('details-ride', $ride->id) }}">More</a></td>
						</tr>
						@empty
						Sorry you have not offered any rides on Gokamz, don't forget to list your next journey here, so you don't travel alone.<br><br>
						@endforelse
					</tbody>
				</table>

				{{ $rides->links() }}

			</div>
		</div>
	</div>
</div>

@endsection
