<x-filament::modal id="captcha">
	<x-slot name="heading">
		温馨提示，请完成验证后再继续
	</x-slot>
	<div class="flex gap-2">
		<img src="{{ captcha_src() }}" alt="captcha" @click="$wire.reloadCaptcha">
		<x-filament::input.wrapper>
			<x-filament::input type="text" placeholder="{{$captchaTips}}" wire:model="captchaCode" />
		</x-filament::input.wrapper>
	</div>
	<x-filament::button @click.throttle="$wire.checkCaptcha">验证</x-filament::button>
</x-filament::modal>
