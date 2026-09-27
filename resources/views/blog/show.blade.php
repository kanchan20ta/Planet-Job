@extends('layouts.app')
@section('title', $blog->title . ' - Planet Job Portal')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-14 sm:py-16">
    <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-500 hover:text-brand-700 transition-colors duration-200">
        <i class="fa-solid fa-arrow-left text-xs"></i>
        Back to blog
    </a>

    <div class="mt-6">
        @if ($blog->category)
            <span class="inline-flex items-center rounded-full bg-brand-50 text-brand-700 text-xs font-semibold px-2.5 py-1">
                {{ $blog->category->name }}
            </span>
        @endif
        <h1 class="text-3xl sm:text-4xl font-bold tracking-tight text-gray-900 mt-3 leading-tight">{{ $blog->title }}</h1>
        <div class="flex items-center gap-2 text-sm text-gray-400 mt-4">
            @if ($blog->author)
                <span class="font-medium text-gray-600">{{ $blog->author->name }}</span>
                <span aria-hidden="true">&middot;</span>
            @endif
            @if ($blog->published_at)
                <span>{{ $blog->published_at->format('M d, Y') }}</span>
            @endif
        </div>
    </div>

    <div class="mt-10 pt-10 border-t border-gray-100 prose prose-sm sm:prose-base max-w-none text-gray-600 whitespace-pre-line leading-relaxed">{{ $blog->content }}</div>
</div>
@endsection
