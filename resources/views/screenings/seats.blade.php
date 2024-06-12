@extends('layouts.main')

@section('header-title', 'Screenings Seats')


@section('content')
    <h1>Seats for Screening</h1>
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
@endsection