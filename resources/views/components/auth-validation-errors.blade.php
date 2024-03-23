@props(['errors'])

@if ($errors->any())
<div class="p-5 rounded border-2 border-indigo-100 bg-white mb-5">
  <div {{ $attributes }}>
    <div class="font-bold text-rose-600">
      {{ __('Whoops! Something went wrong.') }}
    </div>

    <ul class="mt-3 list-disc list-inside text-rose-600 font-semibold">
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
</div>
@endif
