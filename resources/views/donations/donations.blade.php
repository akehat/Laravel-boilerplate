

@extends('backend.layouts.app')

@section('title', __('Donations Managements'))

@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang('Donations Managements')
        </x-slot>

      

        <x-slot name="body">

            <livewire:donations-table />
        </x-slot>
    </x-backend.card>
@endsection
