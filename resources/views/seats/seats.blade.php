@extends('layouts.main')

@section('header-title', 'Screenings Seats')

@section('main')
    <h1>Seats for Screening</h1>
    @if ($screening->theater)
        <table>
            <thead>
                <tr>
                    <th>Seat Number</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($screening->theater->seats as $seat)
                    <tr>
                        <td>{{ $seat->number }}</td>
                        <td>{{ $seat->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No theater information available for this screening.</p>
    @endif
@endsection
