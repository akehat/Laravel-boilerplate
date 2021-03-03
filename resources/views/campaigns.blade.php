@extends('backend.layouts.app')

@section('title', __('Campaigns'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
    <x-backend.card>
        <x-slot name="header">
            
        </x-slot>

        @if ($logged_in_user->hasAllAccess())
            <x-slot name="headerActions">
               
            </x-slot>
        @endif

        <x-slot name="body">
            <livewire:backend.campaigns-table />
        </x-slot>
    </x-backend.card>
@endsection
