<button {{ $attributes->merge(['type' => 'submit', 'class' => 'px-5 py-3 bg-indigo-800 border border-transparent rounded font-black text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
