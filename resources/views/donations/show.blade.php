
@extends('backend.layouts.app')

@section('title', __('Donations Management'))

@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang('Donations Management')
        </x-slot>

      

        <x-slot name="body">

            <livewire:donations-table cid="{{ $id }}" />
        </x-slot>
    </x-backend.card>
@endsection
