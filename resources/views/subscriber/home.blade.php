@extends('layouts.app')

@section('content')
<main class="px-4 py-8 md:p-12">
    <div class="max-w-sm">
        <div class="flex">
            <div class="w-1/2">
                <h1 class="font-bold text-2xl">@lang('subscriber.welcome')</h1>
            </div>
            <div class="w-1/2 text-right py-2">
                <span class="font-light">{{ $subscriber->number }}</span>
            </div>
        </div>

        @if(!$subscriber->subscribed)
            <p class="text-lg">
                Your subscription is <span class="font-bold">not active</span>.
            </p>
            <form action="{{ route('subscriber.enable')}}" method="POST">
                @csrf <button class="btn mt-4 text-lg" type="submit">Sign back up!</submit>
            </form>
        @else
            <p class="text-lg mb-8">
                Your subscription is <span class="font-bold">active</span>.
            </p>

            <tag-manager
                update-endpoint="{{ route('subscriber.updateTags') }}"
                v-bind:location-tags='{!! json_encode($locationTags) !!}'
                v-bind:topic-tags='{!! json_encode($topicTags) !!}'
                v-bind:current-tags='{!! json_encode($subscriber->tagIds()) !!}'>
            </tag-manager>

            <hr class="mt-6">

            <form class="text-small py-4" action="{{ route('subscriber.disable')}}" method="POST">
                @csrf <button onclick="return confirm('Are you sure?')" class="hover:underline text-red-400" type="submit">Disable your subscription.</submit>
            </form>

        @endif
    </div>
</div>

@endsection
