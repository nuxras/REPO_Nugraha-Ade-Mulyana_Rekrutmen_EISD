@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-slate-200 bg-slate-50 focus:bg-white focus:border-teal-500 focus:ring-teal-500 rounded-xl shadow-sm transition-colors duration-200']) }}>
