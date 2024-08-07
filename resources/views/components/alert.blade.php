@once
<div x-data="{message: ''}"
		@alert.window="message = $event.detail.message; $dispatch('open-modal', { id: 'alert' })">
		<x-filament::modal id="alert">
				<div class="flex gap-2 items-center">
						<x-heroicon-o-exclamation-triangle class="w-10 h-10 text-danger-600 mt-1" /> <span class="ml-2 pl-2" x-text="message"></span>
				</div>
		</x-filament::modal>
</div>
@endonce
