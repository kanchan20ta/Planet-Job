@extends('layouts.app')
@section('title', $page->meta_title ?: $page->title)

@section('content')
<div class="max-w-3xl mx-auto px-4 py-14">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">{{ $page->title }}</h1>
    <div class="prose prose-sm max-w-none text-gray-600 whitespace-pre-line">{{ $page->content }}</div>
</div>
@endsection
