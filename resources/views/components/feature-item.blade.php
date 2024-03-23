@props([
    'isAlt' => false,
    'isUnchecked' => false,
])
<li class="flex items-center rounded space-x-3 p-2 text-gray-600 {{ $isAlt ? 'bg-indigo-100' : '' }}">
    <!-- Icon -->
    @if ($isUnchecked)
        <i class="w-5 h-5 fa-solid fa-close text-indigo-700 ml-1"></i>
    @else
        <svg class="flex-shrink-0 w-5 h-5 text-indigo-700" fill="currentColor" viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                clip-rule="evenodd"></path>
        </svg>
    @endif
    <span>{{ $slot }}</span>
</li>
