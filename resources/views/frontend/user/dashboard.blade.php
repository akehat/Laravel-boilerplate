@extends('frontend.layouts.app')

@section('title', __('Dashboard'))

@section('content')
   
    <x-frontend.card>
        <x-slot name="header">
            @lang('Dashboard')
        </x-slot>

        <x-slot name="body">
            @lang('You are logged in!')
        </x-slot>
    </x-frontend.card>
      
@endsection



