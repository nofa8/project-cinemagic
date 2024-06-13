<div {{ $attributes->merge(['class' => 'hover:text-green-600']) }}>
    <form method="POST" action="{{ $action }}" class="w-6 h-6">
        @csrf
        @method('PATCH') 
        <button type="submit" name="restore" class="w-6 h-6">
            <svg class="hover:stroke-2 w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7M13 5l7 7-7 7" />
            </svg>
        </button>
    </form>
</div>
