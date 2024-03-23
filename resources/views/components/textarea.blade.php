@props(['disabled' => false, 'rows' => 5])

<textarea rows="{{$rows}}" {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge(['class' => 'px-2 py-2 rounded-md shadow-sm border-2 border-indigo-200 outline-indigo-500 text-indigo-700 font-bold']) }}>{{$slot}}</textarea>
