

@extends('backend.layouts.app')

@section('title', __('Campaigns Management'))

@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang('Campaigns Management')
            <!-- Download Csv -->
        </x-slot>

       <x-slot name="headerActions">
                <x-utils.link
                   
                    class="card-header-action"
                   :text="__('Download CSV')"
                />
         </x-slot>

        <x-slot name="body">
            <livewire:campaigns-table />
        </x-slot>
    </x-backend.card>
@endsection
