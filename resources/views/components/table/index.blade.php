<div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table {{ $attributes->merge(['class' => 'w-full text-left border-collapse']) }}>
            {{ $slot }}
        </table>
    </div>
</div>
