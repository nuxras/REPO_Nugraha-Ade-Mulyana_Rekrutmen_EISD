<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-teal-500 to-emerald-500 border border-transparent rounded-xl font-semibold text-sm text-white hover:from-teal-400 hover:to-emerald-400 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition-all duration-200 shadow-sm hover:shadow-md']) }}>
    {{ $slot }}
</button>

