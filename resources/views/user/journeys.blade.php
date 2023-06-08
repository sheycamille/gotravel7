@extends('layouts.app')

@section('title', 'My Journeys taken')

@section( 'active')

@section('sub-menu2', 'active')

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

                <h1>My Journeys taken</h1>

                <hr class="hidden-xs">

                <table>
                    <thead>
                        <tr>
                            <th>Journey</th>
                            <th>Date\Time</th>
                            <th>Vehicle</th>
                            <th>Cost</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($journeys as $ride)
                        <tr>
                            <td>Journey from {{ $ride->departure }} to  {{ $ride->destination }}</td>
                            <td>{{ $ride->getFullFormatedDate() }}</td>
                            <td>{{ $ride->vehicle }}</td>
                            <td>{{ $ride->cost + $ride->charges }}</td>
                            <td><a href="{{ route('details-ride', $ride->id) }}">More</a></td>
                        </tr>
                        @empty
                        Sorry you have not booked any rides on TravelZ, visit TravelZ for the best rides, and at your own convinience.<br><br>
                        @endforelse
                    </tbody>
                </table>

                {{ $journeys->links() }}

            </div>
        </div>
    </div>
</div>

@endsection

@section('foot')

<script type="text/javascript">

  function changePassword() {
    console.log('changing password');
    $("#reset-password-modal").modal();
}

</script>

@endsection
