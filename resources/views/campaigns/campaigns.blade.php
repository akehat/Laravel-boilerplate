

@extends('backend.layouts.app')

@section('title', __('Campaigns Management'))

@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang('Campaigns Management')
          
        </x-slot>

       <x-slot name="headerActions">
       
             <x-utils.link
                  :href="route('admin.campaigns.index')" class="btn btn-info btn-sm"
                   :text="__('All campaigns')"
              /> 
              <x-utils.link
                   :href="route('admin.campaigns.active')" class="btn btn-info btn-sm" 
                   :text="__('Active Campaigns')"
              />

              <x-utils.link
                   class="btn btn-info btn-sm" :href="route('admin.campaigns.archive')"
                   :text="__('Archived campaigns')"
              />
               
         </x-slot>

        <x-slot name="body">
            <livewire:campaigns-table status="{{ $status }}"  />
        </x-slot>
    </x-backend.card>



@endsection
